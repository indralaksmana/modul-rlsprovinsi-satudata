<?php
namespace Satudata\Rlsprovinsi\Http\Controllers;

use Satudata\Rlsprovinsi\Models\RlsProvinsi;
use Satudata\Rlsprovinsi\Models\MasterWilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RlsProvinsiController extends Controller
{
    public function getIndex(Request $request){
        return view('main');
    }

    public function getList(Request $request)
    {
        $default_order = 'rlsprovinsiid';
        $order_field = array(
            'rlsprovinsiid',
            'rlsprovinsivalue',
            'rlsprovinsikotakode'
        );
        $order_key 	= (!$request->input('iSortCol_0'))?0:$request->input('iSortCol_0');
        $order 		= (!$request->input('iSortCol_0'))?$default_order:$order_field[$order_key];
        $sort 		= (!$request->input('sSortDir_0'))?'desc':$request->input('sSortDir_0');
        $search 	= (!$request->input('sSearch'))?'':strtoupper($request->input('sSearch'));

        $limit 		= (!$request->input('iDisplayLength'))?10:$request->input('iDisplayLength');
        $start 		= (!$request->input('iDisplayStart'))?0:$request->input('iDisplayStart');

        $sEcho 			= (!$request->input('callback'))?0:$request->input('callback');
        $iTotalRecords 	= count(RlsProvinsi::kotakode()->get());

        $year = RlsProvinsi::year()->get();
        $kota = RlsProvinsi::kotakode()->get();

        $a=0;
        $b=0;
        $datas = array();
        foreach ($kota as $kotas){
            foreach ($year as $years){
                $query = DB::table('rlsprovinsi');
                $query = $query->select(DB::raw("rlsprovinsikotakode, kota_nama, SUM(rlsprovinsivalue) as rlsprovinsivalue, EXTRACT(YEAR FROM rlsprovinsitgl) as tahun"));
                $query = $query->join('master_kota','master_kota.kota_kode','=','rlsprovinsi.rlsprovinsikotakode');
                $query = $query->whereBetween('rlsprovinsitgl', array($years->tahun.'-01-01', $years->tahun.'-12-31'));
                $query = $query->where('rlsprovinsikotakode', $kotas->rlsprovinsikotakode);
                $query = $query->groupBy(array('rlsprovinsikotakode', 'kota_nama', 'tahun'));
                $haragaberlaku = $query->orderBy('tahun')->get();

                if(!$haragaberlaku->isEmpty()){
                    foreach ($haragaberlaku as $harga){
                        $datas[$a]['kode'] = $harga->rlsprovinsikotakode;
                        $datas[$a]['kota'] = $harga->kota_nama;
                        $datas[$a][$years->tahun] = $harga->rlsprovinsivalue;
                    }
                }else{
                    $datas[$a][$years->tahun] = '-';
                }
                $b++;
            }
            $a++;
        }

        return response()->json($datas);
    }

    public function createRlsProvinsi()
    {
        $header = '<div class="block-header">';
        $header .= '<h2 style="display: inline;">Harapan Lama Sekolah (RLS) Provinsi Banten</h2>';
        $header .= '</div>';

        $provinsi = MasterWilayah::provinsi()->get();
        
        return view('backend.laporan.rlsprovinsi.create')
            ->with('header', $header)
            ->with('provinsis', $provinsi);
    }

    public function createRlsProvinsiSave(Request $request)
    {
        $rlsprovinsi = new RlsProvinsi();
        $rlsprovinsi->rlsprovinsivalue            = $request->input('rlsprovinsiValue');
        $rlsprovinsi->rlsprovinsitgl              = $request->input('rlsprovinsiTgl');
        $rlsprovinsi->rlsprovinsiprovincekode     = $request->input('rlsprovinsiProvinceKode');
        $rlsprovinsi->rlsprovinsikotakode         = $request->input('rlsprovinsiKotaKode');
        $rlsprovinsi->rlsprovinsicreatedate       = date('Y-m-d H:i:s');
        $rlsprovinsi->rlsprovinsicreateby         = 1;
        $rlsprovinsi->rlsprovinsistatus           = 1;

        if($rlsprovinsi->save())
        {
            $responses = array('message' => 'Penambahan telah disimpan.');
        }else{
            $responses = array('message' => 'Terjadi kesalaahan. Penambahan gagal disimpan.');
        }
        return response()->json($responses);
    }

    public function detailRlsProvinsi($id)
    {
        $header = '<div class="block-header">';
        $header .= '<h2 style="display: inline;">Organisasi</h2>';
        $header .= '</div>';

        $rlsprovinsi = RlsProvinsi::rlsprovinsiById($id)->get();

        return view('backend.laporan.rlsprovinsi.detail')
            ->with('header', $header)
            ->with('rlsprovinsi', $rlsprovinsi);
    }

    public function export($type){
        $year = RlsProvinsi::year()->get();
        $kota = RlsProvinsi::kotakode()->get();

        $a=0;
        $b=0;
        $datas = array();
        foreach ($kota as $kotas){
            foreach ($year as $years){
                $query = DB::table('rlsprovinsi');
                $query = $query->select(DB::raw("rlsprovinsikotakode, kota_nama, SUM(rlsprovinsivalue) as rlsprovinsivalue, EXTRACT(YEAR FROM rlsprovinsitgl) as tahun"));
                $query = $query->join('master_kota','master_kota.kota_kode','=','rlsprovinsi.rlsprovinsikotakode');

                $query = $query->whereBetween('rlsprovinsitgl', array($years->tahun.'-01-01', $years->tahun.'-12-31'));
                $query = $query->where('rlsprovinsikotakode', $kotas->rlsprovinsikotakode);
                $query = $query->groupBy(array('rlsprovinsikotakode', 'kota_nama', 'tahun'));
                $haragaberlaku = $query->get();

                $datas[$a]['Kota/Kabupaten'] = $kotas->kota_nama;

                if(!$haragaberlaku->isEmpty()){
                    foreach ($haragaberlaku as $harga){
                        $datas[$a][$years->tahun] = $harga->rlsprovinsivalue;
                    }
                }else{
                    $datas[$a][$years->tahun] = '-';
                }
                $b++;
            }
            $a++;
        }
        return Excel::create('Harapan Lama Sekolah Provinsi Banten', function($excel) use ($datas) {
            $excel->sheet('mySheet', function($sheet) use ($datas)
            {
                $sheet->fromArray($datas);
            });
        })->download($type);
    }

    public function getKota($id)
    {
        $kota = MasterWilayah::kotaByKode($id)->get();
        return response()->json($kota->toArray());
    }

    public function getProvinsi(){
        $provinsi = MasterWilayah::provinsi()->get();
        return response()->json($provinsi);
    }

    public function getColumns()
    {
        $data1 = array(
            array(
                'label' => 'Kode',
                'field' => 'kode',
                'numeric' => false,
                'html' => false
            ),
            array(
                'label' => 'Kota',
                'field' => 'kota',
                'numeric' => false,
                'html' => false
            ),
        );

        $year = RlsProvinsi::year()->orderBy('tahun','ASC')->get();
        $data2 = array();
        $i=0;
        foreach($year as $y){
            $data2[$i]['label'] = $y->tahun;
            $data2[$i]['field'] = $y->tahun;
            $data2[$i]['numeric'] = true;
            $data2[$i]['html'] = false;
            $i++;
        }
        $datas = array_merge($data1, $data2);
        return response()->json($datas);
    }
}
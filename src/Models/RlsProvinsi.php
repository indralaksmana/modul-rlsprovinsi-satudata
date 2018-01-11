<?php

namespace Satudata\Rlsprovinsi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RlsProvinsi extends Model
{
    protected $table = 'rlsprovinsi';
    protected $primaryKey = 'rlsprovinsiid';
    public $timestamps = false;

    public static function rlsprovinsiById($id)
    {
        return DB::table('rlsprovinsi')
            ->select(DB::raw('*'))
            ->where('rlsprovinsistatus',$id)
            ->where('rlsprovinsistatus',1)
            ->where('rlsprovinsilogid')
            ->orderBy('rlsprovinsiid', 'ASC');
    }

    public static function year()
    {
        $nYear = Date('Y');
        $sYear = $nYear - 5;

        return DB::table('rlsprovinsi')
            ->select(DB::raw(' EXTRACT(YEAR FROM rlsprovinsitgl) as tahun'))
            ->whereBetween('rlsprovinsitgl', array($sYear.'-01-01', $nYear.'-12-31'))
            ->groupBy('tahun');
    }

    public static function kotakode()
    {
        return DB::table('rlsprovinsi')
            ->select(DB::raw('rlsprovinsikotakode, kota_nama'))
            ->join('master_kota','master_kota.kota_kode','=','rlsprovinsi.rlsprovinsikotakode')
            ->groupBy(array('rlsprovinsikotakode', 'kota_nama'));
    }
}

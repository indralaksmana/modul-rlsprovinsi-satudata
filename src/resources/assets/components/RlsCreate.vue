<template>
    <div class="row">
        <div class="col-lg-12">
            <b-card class="mb-2 bg-default-card" header="Tambah Harapan Lama Sekolah (RLS) Provinsi Banten" header-tag="h4">
                <div>
                    <vue-form :state="formstate" @submit.prevent="onSubmit">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="rlsprovinsiProvinceKode"> Provinsi</label>
                                        <select name="rlsprovinsiProvinceKode" class="form-control" id="rlsprovinsiProvinceKode" v-model="rlsprovinsiProvinceKode" @change="getKota()" required checkbox>
                                            <option value="0" selected disabled>Pilih Provinsi</option>
                                            <option :value="province.provinsi_kode" v-for="province in provinces">
                                                {{ province.provinsi_nama }}
                                            </option>
                                        </select>
                                        <field-messages name="rlsprovinsiProvinceKode" show="$invalid && $submitted" class="text-danger">
                                            <div slot="checkbox">Provinsi dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="rlsprovinsiKotaKode"> Kota</label>
                                        <select name="rlsprovinsiKotaKode" class="form-control" id="rlsprovinsiKotaKode" v-model="rlsprovinsiKotaKode" required checkbox>
                                            <option value="0" selected disabled>Pilih Kota</option>
                                            <option :value="city.kota_kode" v-for="city in cities">
                                                {{ city.kota_nama }}
                                            </option>
                                        </select>
                                        <field-messages name="rlsprovinsiKotaKode" show="$invalid && $submitted" class="text-danger">
                                            <div slot="checkbox">Kota dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="rlsprovinsiTgl"> Tanggal</label>
                                        <input type="date" name="rlsprovinsiTgl" class="form-control input-sm" id="rlsprovinsiTgl" value="yyyy-mm-dd" aria-selected="true" v-model="rlsprovinsiTgl" required>
                                        <field-messages name="rlsprovinsiTgl" show="$invalid && $submitted" class="text-danger">
                                            <div slot="required">Tanggal dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <validate tag="div">
                                        <label for="rlsprovinsiValue"> Jumlah</label>
                                        <input type="number" name="rlsprovinsiValue" class="form-control input-sm" id="rlsprovinsiValue" placeholder="Masukkan Jumlah" v-model="rlsprovinsiValue" required>
                                        <field-messages name="rlsprovinsiValue" show="$invalid && $submitted" class="text-danger">
                                            <div slot="required">Jumlah dibutuhkan.</div>
                                        </field-messages>
                                    </validate>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <b-button type="submit" size="md" variant="primary">
                                        <i class="ti-save"></i> Simpan
                                    </b-button>
                                    <router-link to="/" class="btn btn-danger"><i class="ti-arrow-left"></i> KEMBALI</router-link>
                                </div>
                            </div>
                        </div>
                    </vue-form>
                </div>
            </b-card>
        </div>
    </div>
</template>
<script>
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
export default {
    name: "lpecreate",
    data() {
        return {
            provinces: [],
            cities: [],
            rlsprovinsiProvinceKode: 0,
            rlsprovinsiKotaKode: 0,
            rlsprovinsiTgl: "",
            rlsprovinsiValue: 0,
            formstate: {}
        }
    },
    methods: {
        onSubmit: function() {
            if (this.formstate.$invalid) {
                return;
            } else {
                axios.post('/create', {
                    rlsprovinsiProvinceKode: this.rlsprovinsiProvinceKode,
                    rlsprovinsiKotaKode: this.rlsprovinsiKotaKode,
                    rlsprovinsiTgl: this.rlsprovinsiTgl,
                    rlsprovinsiValue: this.rlsprovinsiValue
                })
                .then(response => {
                    this.$router.push({ name: 'list'})
                })
                .catch(function(error) {});
            }

        },
        getKota: function () {
            var val = this.rlsprovinsiProvinceKode;
            axios.get("/getKota/"+val)
                .then(response => {
                    this.cities = response.data;
                })
                .catch(function(error) {});
        }
    },
    mounted: function() {
        axios.get("/getProvinsi")
            .then(response => {
                this.provinces = response.data;
            })
            .catch(function(error) {});
    },
    destroyed: function() {

    }
}
</script>
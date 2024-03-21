<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read Collection<DataKegiatanWarga> $kegiatan
 */
class DataWarga extends Model
{
    use HasFactory;
    protected $table = "data_warga";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // protected $fillable = [
    //     'id_desa',
    //     'id_kecamatan',
    //     'id_dasawisma',
    //     'no_registrasi',
    //     'no_ktp',
    //     'nama',
    //     'jabatan',
    //     'jenis_kelamin',
    //     'tempat_lahir',
    //     'tgl_lahir',
    //     'umur',
    //     'status_perkawinan',
    //     'status_keluarga',
    //     'agama',
    //     'alamat',
    //     'kabupaten',
    //     'provinsi',
    //     'pendidikan',
    //     'pekerjaan',
    //     'akseptor_kb',
    //     'aktif_posyandu',
    //     'ikut_bkb',
    //     'memiliki_tabungan',
    //     'ikut_kelompok_belajar',
    //     'ikut_paud_sejenis',
    //     'ikut_koperasi',
    //     'pasangan_usia_subur',
    //     'ibu_hamil',
    //     'ibu_menyusui',
    //     'tiga_buta',
    //     'periode',
    //     // 'id_user'
    // ];


    public function desa(){
        return $this->belongsTo(Data_Desa::class, 'id_desa');
    }
    public function kecamatan(){
        return $this->belongsTo(DataKecamatan::class, 'id_kecamatan');
    }

    // data_kegiatan_warga
    public function kegiatan(){
        return $this->hasMany(DataKegiatanWarga::class, 'id_warga');
    }

    // data_kategori_kegiatan
    // public function kategori_kegiatan(){
    //     return $this->hasMany(KategoriKegiatan::class, 'id_kegiatan');
    // }

    // data_keterangan_kegiatan
    public function keterangan_kegiatan(){
        return $this->hasMany(KeteranganKegiatan::class, 'id_keterangan');
    }

    // public function kepalaKeluarga()
    // {
    //     return $this->belongsTo(DataWarga::class, 'nik_kepala_keluarga', 'no_ktp');
    // }

    // data_keluarga
     public function keluarga(){
        // return $this->belongsTo(DataKeluarga::class, 'id_keluarga');
    }

    public function user(){
        // return $this->belongsTo(User::class, 'id_user');
    }

    public function dasawisma(){
        return $this->belongsTo(DataKelompokDasawisma::class, 'id_dasawisma');
    }
}

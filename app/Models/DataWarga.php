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



    public function desa(){
        return $this->belongsTo(Data_Desa::class, 'id_desa');
    }
    public function kecamatan(){
        return $this->belongsTo(DataKecamatan::class, 'id_kecamatan');
    }

    // data_kegiatan_warga
    public function kegiatan(){
        return $this->hasMany(DataKegiatanWarga::class, 'warga_id', 'id');
    }


    public function user(){
        // return $this->belongsTo(User::class, 'id_user');
    }

    public function dasawisma(){
        return $this->belongsTo(DataKelompokDasawisma::class, 'id_dasawisma');
    }

    public function kepalaKeluarga()
    {
        return $this->hasMany(Keluargahaswarga::class, 'warga_id');
    }

    public function industri()
    {
        return $this->hasMany(DataIndustriRumah::class, 'warga_id');
    }

    public function pemanfaatan()
    {
        return $this->hasMany(DataPemanfaatanPekarangan::class, 'warga_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DataKeluarga extends Model
{
    use HasFactory;

    protected $table = "data_keluarga";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    
    public function getDasaWismaIdAttribute()
    {
        return join('-', [
            $this->id_kecamatan,
            $this->id_desa,
            $this->dusun,
            $this->rw,
            $this->rt,
            $this->dasawisma ? $this->dasawisma->nama_dasawisma : '',
        ]);
    }

    public function getHaveKegiatanAttribute()
    {
        $have = 0;

        if ($kepalaKeluarga = $this->kepalaKeluarga) {
            if ($kepalaKeluarga->kegiatan->count() > 0) {
                $have = 1;
            }
        }

        return $have;
    }

    public function getHaveIndustriAttribute()
    {
        $have = 0;

        if ($this->industri->count() > 0) {
            $have = 1;
        }

        return $have;
    }

    public function getHavePemanfaatanAttribute()
    {
        $have = 0;

        if ($this->industri->count() > 0) {
            $have = 1;
        }

        return $have;
    }

    public function getKepalaKeluargaKegiatans()
    {
        /** @var Collection<DataKegiatanWarga> */
        $kegiatans = new Collection();

        if ($kepalaKeluarga = $this->kepalaKeluarga) {
            $kegiatans = $kepalaKeluarga->kegiatan;
        }

        return $kegiatans;
    }

    public function anggota()
    {
        return $this->hasMany(Keluargahaswarga::class,'keluarga_id');

    }

    public function kecamatan(){
        return $this->belongsTo(DataKecamatan::class, 'id_kecamatan');
    }

    public function kepalaKeluarga()
    {
        return $this->belongsTo(DataWarga::class, 'nik_kepala_keluarga', 'no_ktp');
    }

    public function desa(){
        return $this->belongsTo(Data_Desa::class, 'id_desa');
    }

    // public function warga(){
    //     return $this->belongsTo(DataWarga::class, 'id_warga');
    // }

    public function warga(){
        return $this->hasMany(DataWarga::class, 'id_keluarga');
    }

    // data_pemanfaatan
    public function pemanfaatan(){
        return $this->hasMany(DataPemanfaatanPekarangan::class, 'id_keluarga');
    }

     // data_pemanfaatan
     public function industri(){
        return $this->hasMany(DataIndustriRumah::class, 'id_keluarga');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function dasawisma(){
        return $this->belongsTo(DataKelompokDasawisma::class, 'id_dasawisma');
    }
}

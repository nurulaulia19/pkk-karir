<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKegiatanWarga extends Model
{
    use HasFactory;
    protected $table = "data_kegiatan_warga";
    protected $primaryKey = 'id';

    protected $guarded = ['id'];



    public function kegiatan(){
        return $this->belongsTo(DataKegiatan::class, 'data_kegiatan_id');
    }
    public function warga(){
        return $this->belongsTo(DataWarga::class, 'warga_id');
    }

}

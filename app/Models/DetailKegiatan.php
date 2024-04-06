<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKegiatan extends Model
{
    use HasFactory;
    protected $table = "detail_kegiatan";
    protected $primaryKey = 'id';

    protected $guarded = ['id'];


    public function kegiatan(){
        return $this->belongsTo(DataKegiatan::class, 'id_kegiatan');
    }

    public function data_kegiatan_warga(){
        return $this->hasMany(DataKegiatanWarga::class);
    }



}

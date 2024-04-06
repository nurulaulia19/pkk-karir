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



    public function detail_kegiatan(){
        return $this->belongsTo(DetailKegiatan::class, 'detail_kegiatan_id');
    }

}

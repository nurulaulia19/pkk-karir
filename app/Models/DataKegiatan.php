<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKegiatan extends Model
{
    use HasFactory;
    protected $table = "data_kegiatan";
    protected $primaryKey = 'id';

    protected $guarded = ['id'];



    public function detail_kegiatan(){
        return $this->hasMany(DetailKegiatan::class, 'kegiatan_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DasaWisma extends Model
{
    use HasFactory;
    protected $table = "data_dasawisma";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function rt(){
        return $this->belongsTo(Rt::class, 'id_rt');
    }

    public function rw(){
        return $this->belongsTo(Rw::class, 'id_rw');
    }
    public function rumahtangga(){
        return $this->hasMany(RumahTangga::class, 'id_dasawisma');
    }


    public function desa(){
        return $this->belongsTo(Data_Desa::class, 'id_desa');
    }

}

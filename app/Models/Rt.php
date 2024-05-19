<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function rw(){
        return $this->belongsTo(Rw::class, 'rw_id');
    }

    public function dasawisma(){
        return $this->hasMany(DasaWisma::class, 'id_rt');
    }

    public function dusun(){
        return $this->belongsTo(Dusun::class, 'dusun_id');
    }

}

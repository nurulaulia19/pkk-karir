<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function rw(){
        return $this->hasMany(Rw::class, 'dusun_id');
    }
    public function rt(){
        return $this->hasMany(Rt::class, 'dusun_id');
    }

}

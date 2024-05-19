<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function rt(){
        return $this->hasMany(Rt::class, 'rw_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'rw_id');
    }

    public function dasawisma(){
        return $this->hasMany(DasaWisma::class, 'id_rw');
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKabupaten extends Model
{
    use HasFactory;
    protected $table = "data_kabupaten";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function provinsi(){
        return $this->belongsTo(DataProvinsi::class, 'provinsi_id');
    }

    public function kecamatan(){
        return $this->hasMany(DataKecamatan::class, 'kabupaten_id')->onDelete('cascade');
    }

}

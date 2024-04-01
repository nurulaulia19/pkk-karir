<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataProvinsi extends Model
{
    use HasFactory;
    protected $table = "data_provinsi";
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function kabupaten(){
        return $this->hasMany(DataKabupaten::class, 'provinsi_id')->onDelete('cascade');
    }
}

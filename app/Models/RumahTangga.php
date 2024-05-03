<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahTangga extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    // public function keluarga(){
    //     return $this->belongsTo(DataKeluarga::class, 'id');
    // }

    public function anggotaRT()
    {
        return $this->hasMany(RumahTanggaHasKeluarga::class, 'rumahtangga_id');

    }

    public function dasawisma(){
        return $this->belongsTo(DasaWisma::class, 'id_dasawisma');
    }
    public function pemanfaatanlahan(){
        return $this->hasMany(DataPemanfaatanPekarangan::class, 'rumah_tangga_id');
    }
}

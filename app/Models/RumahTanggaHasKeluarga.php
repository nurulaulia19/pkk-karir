<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahTanggaHasKeluarga extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function keluarga()
    {
        return $this->belongsTo(DataKeluarga::class,'keluarga_id');

    }

    public function rumah_tangga()
    {
        return $this->belongsTo(RumahTangga::class,'rumahtangga_id');

    }
}

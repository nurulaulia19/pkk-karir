<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keluargahaswarga extends Model
{
    use HasFactory;
    protected $table = "keluarga_has_warga";
    protected $primaryKey = 'id';

    protected $fillable = [
       'id',
       'keluarga_id',
       'warga_id',
       'status'
    ];

    public function warga()
    {
        return $this->belongsTo(DataWarga::class,'warga_id');

    }
}

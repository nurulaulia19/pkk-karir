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
}

<?php

namespace App\Http\Controllers;

use App\Models\Keluargahaswarga;
use Illuminate\Http\Request;

class KeluargaHasWargaController extends Controller
{
    public function getDataKeluargaHasWarga()
    {
        $data = Keluargahaswarga::all();
        // dd($data);
        return response()->json(['data' => $data]);
    }
}

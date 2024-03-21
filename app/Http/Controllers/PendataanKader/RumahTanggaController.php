<?php

namespace App\Http\Controllers\PendataanKader;

use App\Http\Controllers\Controller;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use App\Models\RumahTanggaHasWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RumahTanggaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keluarga = DataKeluarga::with('anggota.warga')->get();
        $krt = RumahTangga::get();
        // dd($keluarga);
        $user = Auth::user();

        //halaman form data keluarga
        // $keluarga = DataKeluarga::all()->where('id_user', $user->id);
        // $dasawisma = DataKelompokDasawisma::all();
        return view('kader.data_rumah_tangga.index', compact('krt','keluarga'));
    }

    public function create()
    {
    // nama desa yang login
    $desas = DB::table('data_desa')
    ->where('id', auth()->user()->id_desa)
    ->get();

    $kec = DB::table('data_kecamatan')
    ->where('id', auth()->user()->id_kecamatan)
    ->get();

    $kad = DB::table('users')
    ->where('id', auth()->user()->id)
    ->get();
    $kader = DB::table('users')
    ->where('id', auth()->user()->id)
    ->first();

     $keg = DataKeluarga::where('is_rumah_tangga', false)->get();;
    //  dd($keg);
     $warga = DataWarga::all();
     $dasawisma = DataKelompokDasawisma::all();
     return view('kader.data_rumah_tangga.create', compact('warga','keg', 'kec', 'desas', 'kad', 'dasawisma', 'kader'));

    }

    public function store(Request $request)
    {
        // dd($request->keluarga[0]);

        $keluargaKetua = DataKeluarga::find($request->keluarga[0]);
        // dd($keluargaKetua);
        $keluarga = RumahTangga::create([
            'name' => $keluargaKetua->nama_kepala_rumah_tangga,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'punya_tempat_sampah' => $request->punya_tempat_sampah,
            'kriteria_rumah_sehat'=>  $request->kriteria_rumah_sehat,
            'tempel_stiker'=>  $request->tempel_stiker,
            'saluran_pembuangan_air_limbah'=>  $request->saluran_pembuangan_air_limbah,
        ]);
        // dd($keluarga);
        for ($i = 0; $i < count($request->keluarga); $i++) {
            $updateKeluarga = DataKeluarga::find($request->keluarga[$i]);
            $updateKeluarga->is_rumah_tangga = true;
            $updateKeluarga->save();

            RumahTanggaHasKeluarga::create([
                'rumahtangga_id' =>  $keluarga->id,
                'keluarga_id' =>  $request->keluarga[$i],
                'status' =>  $request->status[$i],


            ]);
            // $wargaId =
            // Lakukan sesuatu dengan setiap ID warga
        }

        dd('berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $krt = RumahTangga::get();
        $desas = DB::table('data_desa')
        ->where('id', auth()->user()->id_desa)
        ->get();

        $kec = DB::table('data_kecamatan')
        ->where('id', auth()->user()->id_kecamatan)
        ->get();

        $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();
        $kader = DB::table('users')
        ->where('id', auth()->user()->id)
        ->first();

         $keg = DataKeluarga::where('is_rumah_tangga', false)->get();;
        //  dd($keg);
         $warga = DataWarga::all();
         $dasawisma = DataKelompokDasawisma::all();
         $data_rumah_tangga = RumahTangga::findOrFail($id);
         dd($data_rumah_tangga);
         return view('kader.data_rumah_tangga.edit', compact('data_rumah_tangga','warga','keg', 'kec', 'desas', 'kad', 'dasawisma', 'kader','krt'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function keluarga(){
        $warga = DataKeluarga::all();
        return response()->json([
            'keluarga' => $warga
        ]);
    }
}

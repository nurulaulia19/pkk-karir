<?php

namespace App\Http\Controllers\PendataanKader;

use App\Http\Controllers\Controller;
use App\Models\DataKabupaten;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataProvinsi;
use App\Models\DataWarga;
use App\Models\Periode;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use App\Models\RumahTanggaHasWarga;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


function isUnique($arr)
{
    return count($arr) === count(array_unique($arr));
}
class RumahTanggaController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->periode;
        $user = Auth::user();
        if ($periode) {
            $keluarga =
            DataKeluarga::with('anggota.warga')->where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', $periode)
            ->get();
            $krt = RumahTangga::with('dasawisma.rw.rt')
            ->where('periode', $periode)
            ->where('id_dasawisma', $user->id_dasawisma)->get();
        } else {
            $keluarga =
            DataKeluarga::with('anggota.warga')->where('id_dasawisma', $user->id_dasawisma)
            ->where('periode', now()->year)
            ->get();
            $krt = RumahTangga::with('dasawisma.rw.rt')
            ->where('periode', now()->year)
            ->where('id_dasawisma', $user->id_dasawisma)->get();
        }
        $dataPeriode = Periode::all();


        // dd($krt);
        //halaman form data keluarga
        // $keluarga = DataKeluarga::all()->where('id_user', $user->id);
        // $dasawisma = DataKelompokDasawisma::all();
        return view('kader.data_rumah_tangga.index', compact('krt', 'keluarga','dataPeriode'));
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
        $kader = User::with('dasawisma.rt.rw')
            ->where('id', auth()->user()->id)
            ->first();

        $user = Auth::user();
        // $kk = DataKeluarga::where('is_rumah_tangga', false)->get();
        $kk = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
        ->where('is_valid', '!=', 0)
        ->where('periode', now()->year)
        ->where('is_rumah_tangga', false)->get();
        //  dd($kk);
        $warga = DataWarga::all();
        $dasawisma = DataKelompokDasawisma::all();

        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();
        return view('kader.data_rumah_tangga.create', compact('warga', 'kk', 'kec', 'desas', 'kad', 'dasawisma', 'kader', 'kabupaten', 'provinsi'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'punya_jamban' => 'required|boolean',
            'punya_tempat_sampah' => 'required|boolean',
            'saluran_pembuangan_air_limbah' => 'required|boolean',
        ]);

        $keluargaKetua = DataKeluarga::find($request->keluarga[0]);
        // dd($keluargaKetua);
        if (!isUnique($request->keluarga)) {
            // dd($request->keluarga);
            return redirect()
                ->back()
                ->withErrors(['keluarga' => 'Nama kepala keluarga tidak boleh sama']);
            }

        $kriteria_rumah_sehat = true;

        // Periksa kondisi untuk menentukan kriteria rumah sehat
        if (!$validatedData['punya_jamban'] || !$validatedData['punya_tempat_sampah'] || !$validatedData['saluran_pembuangan_air_limbah']) {
            $kriteria_rumah_sehat = false;
        }


        $keluarga = RumahTangga::create([
            'nama_kepala_rumah_tangga' => $keluargaKetua->nama_kepala_keluarga,
            'id_dasawisma' => $request->id_dasawisma,
            'dusun' => $request->dusun,
            // 'punya_jamban' => $request->punya_jamban,
            // 'punya_tempat_sampah' => $request->punya_tempat_sampah,
            // // 'kriteria_rumah_sehat' => $request->kriteria_rumah_sehat,
            'punya_jamban' => $validatedData['punya_jamban'],
            'punya_tempat_sampah' => $validatedData['punya_tempat_sampah'],
            'saluran_pembuangan_air_limbah' => $validatedData['saluran_pembuangan_air_limbah'],
            'kriteria_rumah_sehat' => $kriteria_rumah_sehat,
            'tempel_stiker' => $request->tempel_stiker,
            // 'saluran_pembuangan_air_limbah' => $request->saluran_pembuangan_air_limbah,
            'periode' => $request->periode,
            'sumber_air_pdam' => $request->has('sumber_air_pdam') ? 1 : 0,
            'sumber_air_sumur' => $request->has('sumber_air_sumur') ? 1 : 0,
            'sumber_air_lainnya' => $request->has('sumber_air_lainnya') ? 1 : 0,
            'is_valid' => now(),

        ]);
        // dd($keluarga->nama_kepala_rumah_tangga);
        // dd($keluarga);
        for ($i = 0; $i < count($request->keluarga); $i++) {
            $updateKeluarga = DataKeluarga::find($request->keluarga[$i]);
            $updateKeluarga->is_rumah_tangga = true;
            $updateKeluarga->save();

            RumahTanggaHasKeluarga::create([
                'rumahtangga_id' => $keluarga->id,
                'keluarga_id' => $request->keluarga[$i],
                'status' => $request->status[$i],
            ]);
            // $wargaId =
            // Lakukan sesuatu dengan setiap ID warga
        }

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect('/data_rumah_tangga');
    }



    public function edit($id)
    {
        // $krt = RumahTangga::get();
        $krt = RumahTangga::with('anggotaRT.keluarga')->findOrFail($id);
        $krt->anggotaRT = $krt->anggotaRT
            ->sortByDesc(function ($anggota) {
                return $anggota->status === 'kepala-rumah-tangga' ? 1 : 0;
            })
            ->values()
            ->all();
        $dataKepalaKeluarga = $krt->anggotaRT;
        // dd($dataKepalaKeluarga);

        $desas = DB::table('data_desa')
            ->where('id', auth()->user()->id_desa)
            ->get();

        $kec = DB::table('data_kecamatan')
            ->where('id', auth()->user()->id_kecamatan)
            ->get();

        $kad = DB::table('users')
            ->where('id', auth()->user()->id)
            ->get();
        $kader = User::with('dasawisma.rt.rw')
            ->where('id', auth()->user()->id)
            ->first();

        $kk = DataKeluarga::where('is_rumah_tangga', true)->get();
        //  dd($kk);
        $warga = DataWarga::all();
        $dasawisma = DataKelompokDasawisma::all();
        $data_rumah_tangga = RumahTangga::findOrFail($id);
        //  dd($data_rumah_tangga);

        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();
        return view('kader.data_rumah_tangga.edit', compact('data_rumah_tangga', 'warga', 'kk', 'kec', 'desas', 'kad', 'dasawisma', 'kader', 'krt', 'kabupaten', 'provinsi'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'punya_jamban' => 'required|boolean',
            'punya_tempat_sampah' => 'required|boolean',
            'saluran_pembuangan_air_limbah' => 'required|boolean',
        ]);

        // Tentukan nilai kriteria rumah sehat berdasarkan kondisi
        $kriteria_rumah_sehat = true;

        if (!$validatedData['punya_jamban'] || !$validatedData['punya_tempat_sampah'] || !$validatedData['saluran_pembuangan_air_limbah']) {
            $kriteria_rumah_sehat = false;
        }

        if (!isUnique($request->keluarga)) {
            return redirect()
                ->back()
                ->withErrors(['keluarga' => 'Keluarga tidak boleh sama']);
        }
        // dd($request->all());

        $rumahTangga = RumahTangga::with('anggotaRT.keluarga')->findOrFail($id);

        $kepalaRumah = DataKeluarga::find($request->keluarga[0]);

        $rumahTangga->update([
            'nama_kepala_rumah_tangga' => $kepalaRumah->nama_kepala_keluarga,
            'id_dasawisma' => $request->id_dasawisma,
            'dusun' => $request->dusun,
            'punya_jamban' => $validatedData['punya_jamban'],
            'punya_tempat_sampah' => $validatedData['punya_tempat_sampah'],
            'saluran_pembuangan_air_limbah' => $validatedData['saluran_pembuangan_air_limbah'],
            'kriteria_rumah_sehat' => $kriteria_rumah_sehat,
            // 'punya_jamban' => $request->punya_jamban,
            // 'punya_tempat_sampah' => $request->punya_tempat_sampah,
            // 'kriteria_rumah_sehat' => $request->kriteria_rumah_sehat,
            'tempel_stiker' => $request->tempel_stiker,
            // 'saluran_pembuangan_air_limbah' => $request->saluran_pembuangan_air_limbah,
            'periode' => $request->periode,
            'sumber_air_pdam' => $request->has('sumber_air_pdam') ? 1 : 0,
            'sumber_air_sumur' => $request->has('sumber_air_sumur') ? 1 : 0,
            'sumber_air_lainnya' => $request->has('sumber_air_lainnya') ? 1 : 0,
            'is_valid' => now(),
        ]);

        foreach ($request->keluarga as $key => $keluargaId) {
            if ($key == 0) {
                $kepalaBaru = RumahTanggaHasKeluarga::where('rumahtangga_id', $rumahTangga->id)
                    ->where('keluarga_id', $keluargaId)
                    ->first();
                $kepalaBaru->status = 'kepala-rumah-tangga';
                $kepalaBaru->save();
                // dd($keluargaId);
                continue; // Skip kepala keluarga
            }

            $datawarga = DataKeluarga::find($keluargaId);
            $datawarga->is_rumah_tangga = true;
            $datawarga->save();

            // Mencari status dari request
            $status = $request->status[$key] ?? null;

            // Mencari entry Keluargahaswarga yang sudah ada untuk warga ini
            $keluargaHasWarga = RumahTanggaHasKeluarga::where('rumahtangga_id', $rumahTangga->id)
            ->where('keluarga_id', $keluargaId)
            ->first();

            if ($keluargaHasWarga) {
                $keluargaHasWarga->update(['status' => $status]);
            } else {
                // Buat entry baru jika belum ada
                RumahTanggaHasKeluarga::create([
                    'rumahtangga_id' => $rumahTangga->id,
                    'keluarga_id' => $keluargaId,
                    'status' => $status,
                ]);
            }
        }

        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect('/data_rumah_tangga');
    }

    public function deleteKeluargaInRT($id){

        $hasKeluarga = RumahTanggaHasKeluarga::find($id);
        $dataKeluarga = DataKeluarga::find($hasKeluarga->keluarga_id);
        $rumahTanggaId = $hasKeluarga->rumahtangga_id;
        // dd($dataKeluarga);

        if (!$hasKeluarga) {
            abort(404, 'Not Found');
        }

        $dataKeluarga->is_rumah_tangga = false;
        $dataKeluarga->update();

        // Hapus data keluarga has warga

        $hasKeluarga->delete();

        $anyKeluargaInRumah = RumahTanggaHasKeluarga::where('rumahtangga_id',$rumahTanggaId)->first();
        if(!$anyKeluargaInRumah){
            $rumahTangga = RumahTangga::find($rumahTanggaId);
            $rumahTangga->delete();
        }


        return response()->json([
            'message' => 'success',
            'data' => $dataKeluarga,
        ]);
    }

    public function destroy($id)
    {
        $krt = RumahTangga::with('anggotaRT.keluarga')->findOrFail($id);
        foreach ($krt->anggotaRT as $anggota) {
            $kepala = DataKeluarga::find($anggota->keluarga_id);
            $kepala->is_rumah_tangga = 0;
            $kepala->save();
        }
        // dd($krt);
        $krt->delete();

        Alert::success('Berhasil', 'Data berhasil di Hapus');
        return redirect()->back();
    }

    public function keluarga()
    {
        $user = Auth::user();
        $warga = DataKeluarga::where('id_dasawisma', $user->id_dasawisma)
        ->where('is_valid', '!=', 0)
        ->where('periode', now()->year)
        ->where('is_rumah_tangga', false)->get();
        return response()->json([
            'keluarga' => $warga,
        ]);
    }
}

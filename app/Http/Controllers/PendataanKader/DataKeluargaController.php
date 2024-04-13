<?php

namespace App\Http\Controllers\PendataanKader;

use App\Http\Controllers\Controller;
use App\Models\DasaWisma;
use App\Models\DataDasaWisma;
use App\Models\DataKabupaten;
use App\Models\DataKegiatan;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataProvinsi;
use App\Models\DataWarga;
use App\Models\User;
use App\Models\Keluargahaswarga;
use App\Models\NotifDataKeluarga;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

function isUnique($arr)
{
    return count($arr) === count(array_unique($arr));
}

class DataKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keluarga = DataKeluarga::with('anggota.warga')->get();
        // dd($keluarga);
        $user = Auth::user();

        //halaman form data keluarga
        // $keluarga = DataKeluarga::all()->where('id_user', $user->id);
        // $dasawisma = DataKelompokDasawisma::all();
        return view('kader.data_keluarga.index', compact('keluarga'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $keg = DataKeluarga::all();
        $warga = DataWarga::where('is_keluarga', false)->get();
        $dasawisma = DataKelompokDasawisma::all();
        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();
        return view('kader.data_keluarga.create', compact('warga', 'kec', 'desas', 'kad', 'dasawisma', 'kader', 'kabupaten', 'provinsi'));
    }



    // public function store(Request $request)
    // {
    //     if (!isUnique($request->warga)) {
    //         return redirect()
    //             ->back()
    //             ->withErrors(['warga' => 'Nama warga tidak boleh sama']);
    //     }

    //     $kepalaKeluarga = DataWarga::find($request->warga[0]);


    //     $keluarga = DataKeluarga::create([
    //         'nama_kepala_keluarga' => $kepalaKeluarga->nama,
    //         // 'punya_jamban' => $request->punya_jamban,
    //         'rt' => $request->rt,
    //         'rw' => $request->rw,
    //         'dusun' => $request->dusun,
    //         'provinsi' => $request->provinsi,
    //         'id_dasawisma' => $request->id_dasawisma,
    //         'periode' => $request->periode,
    //     ]);

    //     // Mengatur is_keluarga menjadi true untuk kepala keluarga
    //     $kepalaKeluarga->is_keluarga = true;
    //     $kepalaKeluarga->save();

    //     for ($i = 0; $i < count($request->warga); $i++) {
    //         $datawarga = DataWarga::find($request->warga[$i]);
    //         $datawarga->is_keluarga = true;
    //         $datawarga->save();

    //         Keluargahaswarga::create([
    //             'keluarga_id' => $keluarga->id,
    //             'warga_id' => $request->warga[$i],
    //             'status' => $request->status[$i],
    //         ]);
    //     }

    //     // Pernyataan akhir setelah penyimpanan berhasil
    //     Alert::success('Berhasil', 'Data berhasil di tambahkan');
    //     return redirect('/data_keluarga');
    // }

    public function store(Request $request)
    {
        // Mendapatkan kepala keluarga dari data warga pertama
        $kepalaKeluarga = DataWarga::find($request->warga[0]);
        // dd($kepalaKeluarga);

        $existingKeluargaCount = DataKeluarga::count();

        // Batas maksimal jumlah data keluarga yang diperbolehkan adalah 2
        $maxAllowed = 20;

        // Jika sudah mencapai atau melebihi batas maksimal, tampilkan pesan error
        if ($existingKeluargaCount >= $maxAllowed) {
            return redirect()
                ->back()
                ->withErrors(['warga' => "Data keluarga sudah berjumlah $existingKeluargaCount keluarga. Maksimal penambahan data keluarga adalah $maxAllowed"]);
        }

        // Validasi keunikan nama warga sebelum menyimpan data
        if (!isUnique($request->warga)) {
            return redirect()
                ->back()
                ->withErrors(['warga' => 'Nama warga tidak boleh sama']);
        }

        // Buat data keluarga baru
        $keluarga = DataKeluarga::create([
            'nama_kepala_keluarga' => $kepalaKeluarga->nama,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'id_dasawisma' => $request->id_dasawisma,
            'periode' => $request->periode,
        ]);

        // Mengatur is_keluarga menjadi true untuk kepala keluarga
        $kepalaKeluarga->is_keluarga = true;
        $kepalaKeluarga->save();

        // Simpan data untuk setiap warga yang ditambahkan ke keluarga baru
        for ($i = 0; $i < count($request->warga); $i++) {
            $datawarga = DataWarga::find($request->warga[$i]);
            $datawarga->is_keluarga = true;
            $datawarga->save();

            // Buat relasi antara keluarga dan warga
            Keluargahaswarga::create([
                'keluarga_id' => $keluarga->id,
                'warga_id' => $request->warga[$i],
                'status' => $request->status[$i],
            ]);
        }

        // Pernyataan akhir setelah penyimpanan berhasil
        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect('/data_keluarga');
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

    public function edit($id)
    {
        // Menggunakan find($id) untuk mencari data berdasarkan ID
        $data_keluarga = DataKeluarga::with('anggota.warga')->find($id);

        $data_keluarga->anggota = $data_keluarga->anggota
            ->sortByDesc(function ($anggota) {
                return $anggota->status === 'kepala-keluarga' ? 1 : 0;
            })
            ->values()
            ->all();

        // Sekarang anggota keluarga sudah diurutkan, dengan kepala keluarga di bagian atas

        // dd($data_keluarga);
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
        //halaman edit data keluarga
        $data_warga = DataWarga::all();
        // dd($warga);
        $kel = DataKeluarga::all();
        $dasawisma = DataKelompokDasawisma::all();

        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();

        return view('kader.data_keluarga.edit', compact('data_keluarga', 'data_warga', 'kel', 'desas', 'kec', 'kad', 'dasawisma', 'kader', 'kabupaten', 'provinsi'));
    }

    // public function update(Request $request, DataKeluarga $data_keluarga)
    // {
    //     // proses mengubah untuk data keluarga
    //     // dd($request->all());

    //     $request->validate([
    //         'punya_jamban' => 'required',
    //         // 'periode' => 'required',

    //     ], [
    //         'punya_jamban.required' => 'Pilih Mempunyai Jamban dan Jumlah Yang Mempunyai Jamban',
    //         // 'periode.required' => 'Pilih Periode',

    //     ]);
    //         $data_keluarga->update($request->all());
    //         Alert::success('Berhasil', 'Data berhasil di ubah');
    //         return redirect('/data_keluarga');

    // }

    public function update(Request $request, DataKeluarga $data_keluarga)
    {
        // dd($request->all());
        // if(!isUnique($request->warga)){
        //     dd('harus usernya beda');
        // }
        if (!isUnique($request->warga)) {
            return redirect()
                ->back()
                ->withErrors(['warga' => 'Nama warga tidak boleh sama']);
        }

        $request->validate(
            [
                // 'punya_jamban' => 'required',
                'status.*' => 'required', // Validasi untuk setiap status
            ],
            [
                // 'punya_jamban.required' => 'Pilih Mempunyai Jamban dan Jumlah Yang Mempunyai Jamban',
                'status.*.required' => 'Lengkapi setiap status',
            ],
        );

        $kepalaKeluarga = DataWarga::find($request->warga[0]);
        $kepalaKeluarga->is_keluarga = true;
        $kepalaKeluarga->save();

        // Mengupdate data keluarga
        $data_keluarga->update([
            // 'punya_jamban' => $request->punya_jamban,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'id_dasawisma' => $request->id_dasawisma,
            'nama_kepala_keluarga' => $kepalaKeluarga->nama,
            'periode' => $request->periode,
            // tambahkan atribut lainnya sesuai kebutuhan
        ]);

        // Memperbarui status is_keluarga untuk anggota keluarga yang terkait
        foreach ($request->warga as $key => $wargaId) {
            if ($key == 0) {
                $kepalaBaru = Keluargahaswarga::where('keluarga_id', $data_keluarga->id)
                    ->where('warga_id', $wargaId)
                    ->first();
                $kepalaBaru->status = 'kepala-keluarga';
                $kepalaBaru->save();
                continue; // Skip kepala keluarga
            }

            $datawarga = DataWarga::find($wargaId);
            $datawarga->is_keluarga = true;
            $datawarga->save();

            // Mencari status dari request
            $status = $request->status[$key] ?? null;

            // Mencari entry Keluargahaswarga yang sudah ada untuk warga ini
            $keluargaHasWarga = Keluargahaswarga::where('keluarga_id', $data_keluarga->id)
                ->where('warga_id', $wargaId)
                ->first();

            if ($keluargaHasWarga) {
                $keluargaHasWarga->update(['status' => $status]);
            } else {
                // Buat entry baru jika belum ada
                Keluargahaswarga::create([
                    'keluarga_id' => $data_keluarga->id,
                    'warga_id' => $wargaId,
                    'status' => $status,
                ]);
            }
        }
        // Pernyataan akhir setelah update berhasil
        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect('/data_keluarga');
    }

    public function destroy($id)
    {
        $kel = DataKeluarga::with('anggota.warga')->find($id);
        foreach ($kel->anggota as $anggota) {
            $warga = DataWarga::find($anggota->warga_id);
            $warga->is_keluarga = 0;
            $warga->save();
        }
        $kel->delete();

        Alert::success('Berhasil', 'Data berhasil di Hapus');
        return redirect()->back();
    }


    public function detail($id)
    {
        $userKader = Auth::user();

         // Ambil data keluarga berdasarkan ID
        $keluarga = DataKeluarga::findOrFail($id);

        // Cari RumahTanggaHasKeluarga berdasarkan ID keluarga
        $rumahTanggaHasKeluarga = RumahTanggaHasKeluarga::where('keluarga_id', $keluarga->id)->first();
        //  dd($rumahTanggaHasKeluarga);
        // Jika tidak ditemukan, tangani sesuai kebutuhan aplikasi Anda
        if (!$rumahTanggaHasKeluarga) {
            // return abort(404)->with('alert', 'Isi keluarga pada data rumah tangga terlebih dahulu.');
            Alert::error('Gagal', 'Isi keluarga pada data rumah tangga terlebih dahulu.');
            return redirect()->back();
            // return redirect()->back()->with('alert', 'Isi keluarga pada data rumah tangga terlebih dahulu.');

        }

        // Lakukan operasi pada data rumah tangga has keluarga jika ditemukan
        // Contoh: Mendapatkan informasi tambahan dari rumah tangga
        $idRumahTangga = $rumahTanggaHasKeluarga->rumahtangga_id;
        $rumahTangga = RumahTangga::findOrFail($idRumahTangga);
        // dd($rumahTangga);

        // Lakukan operasi lain sesuai kebutuhan
        $dasawismaId = $keluarga->anggota->first()->warga->id_dasawisma;
        $dasawisma = DasaWisma::find($dasawismaId);
        $dataKegiatan = DataKegiatan::where('desa_id', $userKader->id_desa)->get();

        // Kirim data ke view 'kader.data_catatan_keluarga.index'
        return view('kader.data_catatan_keluarga.index', compact('keluarga', 'rumahTangga', 'dasawisma', 'dataKegiatan'));
    }

    public function deleteWargaInKeluarga($id)
    {
        $hasWarga = Keluargahaswarga::with('warga')->find($id);
        $dataKeluarga = DataKeluarga::find($hasWarga->keluarga_id);

        if (!$hasWarga) {
            abort(404, 'Not Found');
        }

        $warga = DataWarga::find($hasWarga->warga_id);

        // Update status is_keluarga
        $warga->is_keluarga = false;
        $warga->update();

        // Hapus data keluarga has warga
        $hasWarga->delete();

        // Periksa apakah keluarga memiliki warga terkait
        $countWarga = Keluargahaswarga::where('keluarga_id', $hasWarga->keluarga_id)->count();

        if ($countWarga === 0) {
            // Hapus data keluarga jika tidak ada warga terkait lagi
            DataKeluarga::find($hasWarga->keluarga_id)->delete();
        }

        Alert::success('Berhasil', 'Anggota keluarga berhasil dihapus');
        return redirect()->back();
    }
}

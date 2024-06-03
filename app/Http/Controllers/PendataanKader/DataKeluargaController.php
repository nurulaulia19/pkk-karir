<?php

namespace App\Http\Controllers\PendataanKader;

use Illuminate\Validation\Rule;
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
use App\Models\Periode;
use App\Models\RumahTangga;
use App\Models\RumahTanggaHasKeluarga;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $periode = $request->periode;
        // dd($periode);
        // $warga=DataWarga::with('kepalaKeluarga')->where('id_dasawisma', $user->id_dasawisma)->get();
        if ($periode) {
        $keluarga = DataKeluarga::with('anggota.warga')->where('id_dasawisma', $user->id_dasawisma)
        ->where('periode', $periode)
        ->get();

        } else {
            $keluarga = DataKeluarga::with('anggota.warga')->where('id_dasawisma', $user->id_dasawisma)
        ->where('periode', now()->year)
        ->get();
        }
        $dataPeriode = Periode::all();
        // dd($keluarga);


        //halaman form data keluarga
        // $keluarga = DataKeluarga::all()->where('id_user', $user->id);
        // $dasawisma = DataKelompokDasawisma::all();
        return view('kader.data_keluarga.index', compact('keluarga','dataPeriode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $warga = DataWarga::where('is_keluarga', false)
            ->where('id_dasawisma', $user->id_dasawisma)
            ->where('is_valid', '!=', false)
            ->where('periode', now()->year)
            ->get();

        $user = Auth::user();
        $dasawisma = DataKelompokDasawisma::where('id', $user->id_dasawisma)->get();
        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();
        return view('kader.data_keluarga.create', compact('warga', 'kec', 'desas', 'kad', 'dasawisma', 'kader', 'kabupaten', 'provinsi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga' => 'required|unique:data_keluarga,nama_kepala_keluarga', // Replace table_name and column_name with your actual table and column names
        ], [
            'warga.required' => 'Lengkapi Nama Kepala Keluarga Yang Didata',
            'warga.unique' => 'Nama Kepala Keluarga sudah ada',
        ]);

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
            'nik_kepala_keluarga' => $kepalaKeluarga->no_ktp,
            'rt' => $request->rt,
            'rw' => $request->rw,
            // 'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'id_dasawisma' => $request->id_dasawisma,
            'periode' => $request->periode,
            'is_valid' => Carbon::now(),
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

        // dd($keluarga);
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
        $user = Auth::user();
        $dasawisma = DataKelompokDasawisma::where('id', $user->id_dasawisma)->get();

        $kabupaten = DataKabupaten::first();
        $provinsi = DataProvinsi::first();

        return view('kader.data_keluarga.edit', compact('data_keluarga', 'data_warga', 'kel', 'desas', 'kec', 'kad', 'dasawisma', 'kader', 'kabupaten', 'provinsi'));
    }

    public function update(Request $request, DataKeluarga $data_keluarga)
    {
        $request->validate([
            'nama_kepala_keluarga' => [
                Rule::unique('data_keluarga', 'nama_kepala_keluarga')->ignore($data_keluarga)
            ],
        ], [
            'nama_kepala_keluarga.unique' => 'Nama Kepala Keluarga sudah ada',
        ]);

        foreach ($request->warga as $wargaId) {
            $wargaValid = DataWarga::where('id', $wargaId)
                ->value('is_valid');

            if (!$wargaValid) {
                return redirect()
                    ->back()
                    ->withErrors(['warga' => 'Salah satu nama warga tidak valid atau belum disetujui.'])
                    ->withInput();
            }
        }

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
            'is_valid' => Carbon::now(),
            // 'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'id_dasawisma' => $request->id_dasawisma,
            'nama_kepala_keluarga' => $kepalaKeluarga->nama,
            'nik_kepala_keluarga' => $kepalaKeluarga->no_ktp,
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

    // ini bener
    // public function destroy($id)
    // {
    //     $kel = DataKeluarga::with('anggota.warga')->find($id);
    //     foreach ($kel->anggota as $anggota) {
    //         $warga = DataWarga::find($anggota->warga_id);
    //         $warga->is_keluarga = 0;
    //         $warga->save();
    //     }
    //     $kel->delete();

    //     Alert::success('Berhasil', 'Data berhasil di Hapus');
    //     return redirect()->back();
    // }

    // redirect
    // public function destroy($id)
    // {
    //     // Find the family (keluarga) with its associated members
    //     $keluarga = DataKeluarga::with('anggota.warga')->find($id);

    //     // Check if the family is marked as a household
    //     if ($keluarga->is_rumah_tangga != 0) {
    //         // If the family is marked as a household, prevent deletion and show an error message
    //         Alert::error('Gagal', 'Keluarga terkait dengan rumah tangga dan tidak bisa dihapus');
    //         return redirect()->back();
    //     }

    //     // If no restriction applies, proceed with the deletion
    //     foreach ($keluarga->anggota as $anggota) {
    //         $warga = DataWarga::find($anggota->warga_id);
    //         $warga->is_keluarga = 0;
    //         $warga->save();
    //     }

    //     $keluarga->delete();

    //     Alert::success('Berhasil', 'Data berhasil dihapus');
    //     return redirect()->back();
    // }


    // public function destroy($id)
    // {
    //     // Temukan keluarga bersama dengan anggotanya dan rumah tangga terkait
    //     $keluarga = DataKeluarga::with('anggota.warga', 'rumah_tangga')->find($id);

    //     if (!$keluarga) {
    //         return redirect()->back()->withErrors(['error' => 'Data keluarga tidak ditemukan']);
    //     }

    //     // Simpan nama kepala keluarga sebelum penghapusan
    //     $namaKepalaKeluarga = $keluarga->nama_kepala_keluarga;

    //     // Set is_keluarga ke 0 untuk setiap anggota keluarga
    //     foreach ($keluarga->anggota as $anggota) {
    //         $warga = DataWarga::find($anggota->warga_id);
    //         if ($warga) {
    //             $warga->is_keluarga = 0;
    //             $warga->save();
    //         }
    //     }

    //     // Periksa apakah rumah tangga hanya memiliki satu anggota dan kepala rumah tangga adalah kepala keluarga yang dihapus
    //     $rumahTanggaSingle = RumahTangga::where('nama_kepala_rumah_tangga', $namaKepalaKeluarga)
    //                                     ->where('nik_kepala_rumah_tangga', $keluarga->nik_kepala_keluarga)
    //                                     ->where('periode', now()->year)
    //                                     ->whereDoesntHave('anggotaRT', function ($query) use ($keluarga) {
    //                                         $query->where('keluarga_id', '!=', $keluarga->id)
    //                                             ->where('status', 'kepala-keluarga');
    //                                     })
    //                                     ->first();

    //     if ($rumahTanggaSingle) {
    //         // Hapus rumah tangga terkait
    //         $rumahTanggaSingle->delete();
    //     } else {
    //         // Temukan anggota keluarga pertama yang bukan bagian dari keluarga yang akan dihapus
    //         $newKepalaKeluarga = $keluarga->rumah_tangga->filter(function ($rumah_tangga) use ($keluarga) {
    //             return $rumah_tangga->keluarga_id != $keluarga->id;
    //         })->first();
    //         dd($newKepalaKeluarga);

    //         if ($newKepalaKeluarga) {
    //             $newKepalaKeluarga->status = 'kepala-rumah-tangga';
    //             $newKepalaKeluarga->save();

    //             // Perbarui nama kepala rumah tangga ke nama kepala keluarga yang baru
    //             if ($newKepalaKeluarga->rumahTangga) {
    //                 $rumahTangga = $newKepalaKeluarga->rumahTangga;
    //                 $rumahTangga->nama_kepala_rumah_tangga = $newKepalaKeluarga->nama;
    //                 $rumahTangga->nik_kepala_rumah_tangga = $newKepalaKeluarga->nik;
    //                 $rumahTangga->save();
    //             }
    //         }
    //     }

    //     // Hapus keluarga
    //     $keluarga->delete();

    //     Alert::success('Berhasil', 'Data berhasil dihapus');
    //     return redirect()->back();
    // }

    // aul
    // public function destroy($id)
    // {
    //     // Temukan keluarga bersama dengan anggotanya dan rumah tangga terkait
    //     $keluarga = DataKeluarga::with('anggota.warga', 'rumah_tangga')->find($id);

    //     if (!$keluarga) {
    //         return redirect()->back()->withErrors(['error' => 'Data keluarga tidak ditemukan']);
    //     }

    //     foreach ($keluarga->anggota as $anggota) {
    //         $warga = DataWarga::find($anggota->warga_id);
    //         $warga->is_keluarga = 0;
    //         $warga->save();
    //     }
    //     // Simpan nama kepala keluarga sebelum penghapusan
    //     $namaKepalaKeluarga = $keluarga->nama_kepala_keluarga;
    //     $nikKepalaKeluarga = $keluarga->nik_kepala_keluarga;

    //     // Periksa apakah rumah tangga hanya memiliki satu anggota dan kepala rumah tangga adalah kepala keluarga yang dihapus
    //     $rumahTanggaSingle = RumahTangga::where('nama_kepala_rumah_tangga', $namaKepalaKeluarga)
    //                                     ->where('nik_kepala_rumah_tangga', $nikKepalaKeluarga)
    //                                     ->where('periode', now()->year)
    //                                     ->whereDoesntHave('anggotaRT', function ($query) use ($keluarga) {
    //                                         $query->where('keluarga_id', '!=', $keluarga->id)
    //                                             ->where('status', 'kepala-keluarga');
    //                                     })
    //                                     ->first();

    //     if ($rumahTanggaSingle) {
    //         // Hapus rumah tangga terkait
    //         $rumahTanggaSingle->delete();
    //     } else {
    //         $rumahTangga = RumahTangga::with('anggotaRT')->where('nama_kepala_rumah_tangga', $keluarga->nama_kepala_keluarga)
    //                     ->where('periode', now()->year)
    //                     ->where('nik_kepala_rumah_tangga', $keluarga->nik_kepala_keluarga)
    //                     ->first();

    //         // Temukan anggota keluarga pertama yang bukan bagian dari keluarga yang akan dihapus
    //         $newKepalaKeluargaRelation = RumahTanggaHasKeluarga::where('rumahtangga_id', $rumahTangga->id)
    //                                                         ->where('keluarga_id', '!=', $keluarga->id)
    //                                                         ->first();
    //                                                         // dd($newKepalaKeluargaRelation);

    //         if ($newKepalaKeluargaRelation) {
    //             $newKepalaKeluarga = DataKeluarga::find($newKepalaKeluargaRelation->keluarga_id);

    //             if ($newKepalaKeluarga) {
    //                 // $newKepalaKeluarga->status = 'kepala-rumah-tangga';
    //                 // $newKepalaKeluarga->save();

    //                 // Perbarui nama kepala rumah tangga ke nama kepala keluarga yang baru
    //                 $rumahTangga->nama_kepala_rumah_tangga = $newKepalaKeluarga->nama_kepala_keluarga;
    //                 $rumahTangga->nik_kepala_rumah_tangga = $newKepalaKeluarga->nik_kepala_keluarga;
    //                 $rumahTangga->save();

    //                 $rumahTanggaHasKeluarga = RumahTanggaHasKeluarga::where('keluarga_id', $newKepalaKeluarga->id)
    //                                                                 ->where('rumahtangga_id', $rumahTangga->id)
    //                                                                 ->first();

    //                 if ($rumahTanggaHasKeluarga) {
    //                     $rumahTanggaHasKeluarga->status = 'kepala-rumah-tangga';
    //                     $rumahTanggaHasKeluarga->save();
    //                 }
    //             }
    //         }
    //     }

    //     // Hapus keluarga
    //     $keluarga->delete();

    //     Alert::success('Berhasil', 'Data berhasil dihapus');
    //     return redirect()->back();
    // }

    // bener
    public function destroy($id)
    {
        // Temukan keluarga bersama dengan anggotanya dan rumah tangga terkait
        $keluarga = DataKeluarga::with('anggota.warga', 'rumah_tangga')->find($id);

        if (!$keluarga) {
            return redirect()->back()->withErrors(['error' => 'Data keluarga tidak ditemukan']);
        }

        // Ubah status is_keluarga pada semua warga anggota keluarga
        foreach ($keluarga->anggota as $anggota) {
            $warga = DataWarga::find($anggota->warga_id);
            $warga->is_keluarga = 0;
            $warga->save();
        }

        // Simpan nama kepala keluarga sebelum penghapusan
        $namaKepalaKeluarga = $keluarga->nama_kepala_keluarga;
        $nikKepalaKeluarga = $keluarga->nik_kepala_keluarga;

        // Periksa apakah keluarga terkait dengan rumah tangga
        $rumahTangga = RumahTangga::with('anggotaRT')
            ->where('nama_kepala_rumah_tangga', $namaKepalaKeluarga)
            ->where('nik_kepala_rumah_tangga', $nikKepalaKeluarga)
            ->where('periode', now()->year)
            ->first();

        if ($rumahTangga) {
            // Periksa apakah rumah tangga hanya memiliki satu anggota dan kepala rumah tangga adalah kepala keluarga yang dihapus
            $rumahTanggaSingle = RumahTangga::where('nama_kepala_rumah_tangga', $namaKepalaKeluarga)
                ->where('nik_kepala_rumah_tangga', $nikKepalaKeluarga)
                ->where('periode', now()->year)
                ->whereDoesntHave('anggotaRT', function ($query) use ($keluarga) {
                    $query->where('keluarga_id', '!=', $keluarga->id)
                        ->where('status', 'kepala-keluarga');
                })
                ->first();

            if ($rumahTanggaSingle) {
                // Hapus rumah tangga terkait
                $rumahTanggaSingle->delete();
            } else {
                // Temukan anggota keluarga pertama yang bukan bagian dari keluarga yang akan dihapus
                $newKepalaKeluargaRelation = RumahTanggaHasKeluarga::where('rumahtangga_id', $rumahTangga->id)
                    ->where('keluarga_id', '!=', $keluarga->id)
                    ->first();

                if ($newKepalaKeluargaRelation) {
                    $newKepalaKeluarga = DataKeluarga::find($newKepalaKeluargaRelation->keluarga_id);

                    if ($newKepalaKeluarga) {
                        // Perbarui nama kepala rumah tangga ke nama kepala keluarga yang baru
                        $rumahTangga->nama_kepala_rumah_tangga = $newKepalaKeluarga->nama_kepala_keluarga;
                        $rumahTangga->nik_kepala_rumah_tangga = $newKepalaKeluarga->nik_kepala_keluarga;
                        $rumahTangga->save();

                        $rumahTanggaHasKeluarga = RumahTanggaHasKeluarga::where('keluarga_id', $newKepalaKeluarga->id)
                            ->where('rumahtangga_id', $rumahTangga->id)
                            ->first();

                        if ($rumahTanggaHasKeluarga) {
                            $rumahTanggaHasKeluarga->status = 'kepala-rumah-tangga';
                            $rumahTanggaHasKeluarga->save();
                        }
                    }
                }
            }
        }

        // Hapus keluarga
        $keluarga->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
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

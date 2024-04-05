<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\DataKabupaten;
use App\Models\DataKelompokDasawisma;
use App\Models\DataKeluarga;
use App\Models\DataProvinsi;
use App\Models\DataWarga;
use App\Models\User;
use App\Models\Keluargahaswarga;
use App\Models\NotifDataKeluarga;
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
    //     // dd('ayam geprek');
    //     // proses penyimpanan untuk tambah data keluarga
    //     // dd($request->all());
    //     $kepalaKeluarga = DataWarga::find($request->warga[0]);

    //     // dd($kepalaKeluarga);
    //     $keluarga = DataKeluarga::create([
    //         'nama_kepala_keluarga' => $kepalaKeluarga->nama,
    //         'punya_jamban' => $request->punya_jamban,
    //         'rt' => $request->rt,
    //         'rw' => $request->rw,
    //         'dusun' => $request->dusun,
    //         'provinsi' => $request->provinsi,
    //         'id_dasawisma' => $request->id_dasawisma
    //     ]);
    //     // dd($keluarga);
    //     for ($i = 0; $i < count($request->warga); $i++) {
    //         $datawarga = DataWarga::find($request->warga[$i]);
    //         // dd($datawarga);
    //         $datawarga->is_keluarga = true;
    //         Keluargahaswarga::create([
    //             'keluarga_id' =>  $keluarga->id,
    //             'warga_id' =>  $request->warga[$i],
    //             'status' =>  $request->status[$i],

    //         ]);
    //         // $wargaId =
    //         // Lakukan sesuatu dengan setiap ID warga
    //     }

    //     dd('berhasil');

    //     // $request->validate([
    //     //     'id_desa' => 'required',
    //     //     'id_kecamatan' => 'required',
    //     //     'nama_kepala_rumah_tangga' => 'required',
    //     //     // 'dasa_wisma' => 'required',
    //     //     'id_dasawisma' => 'required',
    //     //     'nik_kepala_keluarga' => 'required|min:16',
    //     //     'rt' => 'required',
    //     //     'rw' => 'required',
    //     //     'kabupaten' => 'required',
    //     //     'provinsi' => 'required',
    //     //     'dusun' => 'required',
    //     //     // 'perempuan' => 'required',
    //     //     'jumlah_KK' => 'required',
    //     //     // 'jumlah_balita' => 'required',
    //     //     'jumlah_anggota_keluarga' => 'required',
    //     //     // 'jumlah_WUS' => 'required',
    //     //     // 'jumlah_3_buta' => 'required',
    //     //     // 'jumlah_ibu_hamil' => 'required',
    //     //     // 'jumlah_ibu_menyusui' => 'required',
    //     //     // 'jumlah_lansia' => 'required',
    //     //     // 'jumlah_kebutuhan' => 'required',
    //     //     'makanan_pokok' => 'required',
    //     //     'punya_jamban' => 'required',
    //     //     // 'jumlah_PUS' => 'required',
    //     //     'sumber_air' => 'required',
    //     //     'punya_tempat_sampah' => 'required',
    //     //     'punya_saluran_air' => 'required',
    //     //     'tempel_stiker' => 'required',
    //     //     'kriteria_rumah' => 'required',
    //     //     'aktivitas_UP2K' => 'required',
    //     //     'aktivitas_kegiatan_usaha' => 'required',
    //     //     'periode' => 'required',

    //     // ], [
    //     //     'id_desa.required' => 'Lengkapi Alamat Desa Kegiatan Warga',
    //     //     'id_kecamatan' => 'Lengkapi Alamat Kecamatan Kegiatan Warga',
    //     //     'nama_kepala_rumah_tangga.required' => 'Lengkapi Nama Warga Kepala Rumah Tangga',
    //     //     'id_dasawisma.required' => 'Lengkapi Nama Dasawisma Yang Diikuti',
    //     //     'nik_kepala_keluarga.required' => 'Lengkapi NIK Kepala Rumah Tangga',
    //     //     'jumlah_anggota_keluarga.required' => 'Lengkapi Jumlah Anggota Keluarga',
    //     //     'rt.required' => 'Lengkapi RT',
    //     //     'rw.required' => 'Lengkapi RW',
    //     //     'dusun.required' => 'Lengkapi Nama Dusun',
    //     //     // 'perempuan.required' => 'Lengkapi Jumlah Perempuan',
    //     //     'jumlah_KK.required' => 'Lengkapi Jumlah KK',
    //     //     // 'jumlah_PUS.required' => 'Lengkapi Jumlah PUS (Pasangan Usia Subur) dalam Keluarga',
    //     //     // 'jumlah_WUS.required' => 'Lengkapi Jumlah WUS (Wanita Usia Subur) dalam Keluarga',
    //     //     // 'jumlah_3_buta.required' => 'Lengkapi Jumlah 3 Buta (Buta Tulis, Buta Baca, Buta Hitung) dalam Keluarga',
    //     //     // 'jumlah_ibu_hamil.required' => 'Lengkapi Jumlah Ibu Hamil dalam Keluarga',
    //     //     // 'jumlah_ibu_menyusui.required' => 'Lengkapi Jumlah Ibu Menyusui dalam Keluarga',
    //     //     // 'jumlah_lansia.required' => 'Lengkapi Jumlah Lansia dalam Keluarga',
    //     //     // 'jumlah_kebutuhan.required' => 'Lengkapi Jumlah Berkebutuhan Khusus dalam Keluarga',
    //     //     'makanan_pokok.required' => 'Lengkapi Makanan Pokok',
    //     //     // 'jumlah_balita.required' => 'Lengkapi Jumlah Balita dalam Keluarga',
    //     //     'punya_jamban.required' => 'Pilih Mempunyai Jamban dan Jumlah Yang Mempunyai Jamban',
    //     //     'sumber_air.required' => 'Pilih Sumber Air dalam Keluarga',
    //     //     'punya_tempat_sampah.required' => 'Pilih Yang Mempunyai Tempat Sampah',
    //     //     'punya_saluran_air.required' => 'Pilih Yang Mempunyai Saluran Air',
    //     //     'tempel_stiker.required' => 'Pilih Rumah Yang Mempunyai Stiker P4K',
    //     //     'kriteria_rumah.required' => 'Pilih Kriteria Rumah',
    //     //     'aktivitas_UP2K.required' => 'Pilih Aktivitas UP2K',
    //     //     'aktivitas_kegiatan_usaha.required' => 'Pilih Aktivitas Kegiatan Usaha',
    //     //     'periode.required' => 'Pilih Periode',

    //     // ]);
    //     // $insert=DB::table('data_keluarga')->where('nik_kepala_keluarga', $request->nik_kepala_keluarga)->first();
    //     // if ($insert != null) {
    //     //     Alert::error('Gagal', 'Data Tidak Berhasil Di Tambah. No.KTP Sudah Ada ');

    //     //     return redirect('/data_keluarga');
    //     // }
    //     // else {
    //     // //cara 1

    //     //     $wargas = new DataKeluarga;
    //     //     $wargas->id_desa = $request->id_desa;
    //     //     $wargas->id_kecamatan = $request->id_kecamatan;
    //     //     $wargas->nama_kepala_rumah_tangga = $request->nama_kepala_rumah_tangga;
    //     //     $wargas->id_dasawisma = $request->id_dasawisma;
    //     //     $wargas->nik_kepala_keluarga = $request->nik_kepala_keluarga;
    //     //     $wargas->kabupaten = $request->kabupaten;
    //     //     $wargas->provinsi = $request->provinsi;
    //     //     $wargas->id_user = $request->id_user;
    //     //     $wargas->dusun = $request->dusun;

    //     //     $wargas->jumlah_anggota_keluarga = $request->jumlah_anggota_keluarga;
    //     //     $wargas->rt = $request->rt;
    //     //     $wargas->rw = $request->rw;
    //     //     $wargas->jumlah_laki = $request->jumlah_laki;
    //     //     $wargas->jumlah_perempuan = $request->jumlah_perempuan;
    //     //     $wargas->jumlah_KK = $request->jumlah_KK;
    //     //     $wargas->jumlah_balita = $request->jumlah_balita;
    //     //     $wargas->jumlah_balita_laki = $request->jumlah_balita_laki;
    //     //     $wargas->jumlah_balita_perempuan = $request->jumlah_balita_perempuan;
    //     //     $wargas->jumlah_PUS = $request->jumlah_PUS;
    //     //     $wargas->jumlah_WUS = $request->jumlah_WUS;
    //     //     $wargas->jumlah_3_buta = $request->jumlah_3_buta;
    //     //     $wargas->jumlah_3_buta_laki = $request->jumlah_3_buta_laki;
    //     //     $wargas->jumlah_3_buta_perempuan = $request->jumlah_3_buta_perempuan;
    //     //     $wargas->jumlah_ibu_hamil = $request->jumlah_ibu_hamil;
    //     //     $wargas->jumlah_ibu_menyusui = $request->jumlah_ibu_menyusui;
    //     //     $wargas->jumlah_lansia = $request->jumlah_lansia;
    //     //     $wargas->jumlah_kebutuhan_khusus = $request->jumlah_kebutuhan_khusus;
    //     //     $wargas->makanan_pokok = $request->makanan_pokok;
    //     //     $wargas->punya_jamban = $request->punya_jamban;
    //     //     $wargas->jumlah_jamban = $request->jumlah_jamban;
    //     //     $wargas->sumber_air = $request->sumber_air;
    //     //     $wargas->punya_tempat_sampah = $request->punya_tempat_sampah;
    //     //     $wargas->punya_saluran_air = $request->punya_saluran_air;
    //     //     $wargas->tempel_stiker = $request->tempel_stiker;
    //     //     $wargas->kriteria_rumah = $request->kriteria_rumah;
    //     //     $wargas->aktivitas_UP2K = $request->aktivitas_UP2K;
    //     //     $wargas->aktivitas_kegiatan_usaha = $request->aktivitas_kegiatan_usaha;
    //     //     $wargas->periode = $request->periode;
    //     //     $wargas->save();
    //     //     // desa

    //     //     // $notifDesa = NotifDataKeluarga::create([
    //     //     //     'dilihat' => false,

    //     //     // ]);
    //     //     Alert::success('Berhasil', 'Data berhasil di tambahkan');

    //     //     return redirect('/data_keluarga');
    //     // }
    // }

    public function store(Request $request)
    {
        if (!isUnique($request->warga)) {
            return redirect()
                ->back()
                ->withErrors(['warga' => 'Nama warga tidak boleh sama']);
        }

        $kepalaKeluarga = DataWarga::find($request->warga[0]);

        $keluarga = DataKeluarga::create([
            'nama_kepala_keluarga' => $kepalaKeluarga->nama,
            'punya_jamban' => $request->punya_jamban,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'id_dasawisma' => $request->id_dasawisma,
        ]);

        // Mengatur is_keluarga menjadi true untuk kepala keluarga
        $kepalaKeluarga->is_keluarga = true;
        $kepalaKeluarga->save();

        for ($i = 0; $i < count($request->warga); $i++) {
            $datawarga = DataWarga::find($request->warga[$i]);
            $datawarga->is_keluarga = true;
            $datawarga->save();

            Keluargahaswarga::create([
                'keluarga_id' => $keluarga->id,
                'warga_id' => $request->warga[$i],
                'status' => $request->status[$i],
            ]);
        }

        // Pernyataan akhir setelah penyimpanan berhasil
        Alert::success('Berhasil', 'Data berhasil di tambahkan');
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
                'punya_jamban' => 'required',
                'status.*' => 'required', // Validasi untuk setiap status
            ],
            [
                'punya_jamban.required' => 'Pilih Mempunyai Jamban dan Jumlah Yang Mempunyai Jamban',
                'status.*.required' => 'Lengkapi setiap status',
            ],
        );

        $kepalaKeluarga = DataWarga::find($request->warga[0]);
        $kepalaKeluarga->is_keluarga = true;
        $kepalaKeluarga->save();

        // Mengupdate data keluarga
        $data_keluarga->update([
            'punya_jamban' => $request->punya_jamban,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'dusun' => $request->dusun,
            'provinsi' => $request->provinsi,
            'id_dasawisma' => $request->id_dasawisma,
            'nama_kepala_keluarga' => $kepalaKeluarga->nama,
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
        $keluarga = DataKeluarga::with('anggota.warga', 'dasawisma')->find($id);
        // dd($keluarga);
        return view('kader.catatan_keluarga', compact('keluarga'));
    }

    // public function deleteWargaInKeluarga($id)
    // {
    //     $HasWarga = Keluargahaswarga::with('warga')->find($id);
    //     if(!$HasWarga){
    //         abort(404, 'Not Found');
    //     }
    //     $warga = DataWarga::find($HasWarga->warga_id);
    //     // dd($HasWarga);
    //     $warga->is_keluarga = false;
    //     $warga->update();

    //     $HasWarga->delete();
    //     dd('berhasil');
    // }
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

        return response()->json([
            'message' => 'success',
            'data' => $dataKeluarga,
        ]);
    }
}

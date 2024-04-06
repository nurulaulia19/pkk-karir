<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataKegiatan;
use App\Models\DataKegiatanWarga;
use App\Models\DataKeluarga;
use App\Models\DataWarga;
use App\Models\DetailKegiatan;
use App\Models\KategoriKegiatan;
use App\Models\KeteranganKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DataKegiatanWargaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // halaman data kegiatan
        $kegiatan=DataKegiatanWarga::all()->where('id_user', $user->id);
        return view('kader.data_kegiatan.data_kegiatan', compact('kegiatan'));
    }
    public function create()
    {
        $kegiatan = DataKegiatan::with('detail_kegiatan')->get();
        // dd($kegiatan);
        $keg = $kegiatan;
        $desas = DB::table('data_desa')
        ->where('id', auth()->user()->id_desa)
        ->get();
        $kec = DB::table('data_kecamatan')
        ->where('id', auth()->user()->id_kecamatan)
        ->get();

        $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();

        $kel = DataKeluarga::all();
        $warga = DataWarga::all();
        // $keg = KategoriKegiatan::all();
        return view('kader.data_kegiatan.form.create_data_kegiatan', compact('keg', 'warga', 'desas', 'kec', 'kad', 'kel'));

    }
    public function store(Request $request)
    {
        // proses penyimpanan untuk tambah data data kegiatan warga
        // dd($request->all());
        // validasi data
        $request->validate([
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
            'id_warga' => 'required',
            'id_kategori' => 'required',
            'aktivitas' => 'required',
            'id_keterangan' => 'required',
            'periode' => 'required',

        ], [
            'id_desa.required' => 'Lengkapi Alamat Desa Kegiatan Warga Yang Didata',
            'id_kecamatan.required' => 'Lengkapi Alamat Kecamatan Kegiatan Warga Yang Didata',
            'id_warga.required' => 'Lengkapi Nama Warga Yang Didata',
            // 'nama_kegiatan.required' => 'Lengkapi Kegiatan Yang Diikuti Warga',
            'id_kategori.required' => 'Lengkapi Kegiatan Yang Diikuti Warga',
            'aktivitas.required' => 'Pilih Aktivitas Kegiatan Yang Diikuti Warga',
            // 'keterangan.required' => 'Lengkapi Keterangan Kegiatan Yang Diikuti Warga',
            'id_keterangan.required' => 'Lengkapi Keterangan Kegiatan Yang Diikuti Warga',
            'periode.required' => 'Pilih Periode',

        ]);

        // pengkondisian tabel
            $kegiatans = new DataKegiatanWarga;
            $kegiatans->id_desa = $request->id_desa;
            $kegiatans->id_kecamatan = $request->id_kecamatan;
            $kegiatans->id_warga = $request->id_warga;
            // $kegiatans->nama_kegiatan = $request->nama_kegiatan;
            $kegiatans->id_kategori = $request->id_kategori;
            $kegiatans->id_user = $request->id_user;

            $kegiatans->aktivitas = $request->aktivitas;
            // $kegiatans->keterangan = $request->keterangan;
            $kegiatans->id_keterangan = $request->id_keterangan;
            $kegiatans->periode = $request->periode;

            // simpan data
            $kegiatans->save();

            Alert::success('Berhasil', 'Data berhasil di tambahkan');

            return redirect('/data_kegiatan');
    }


    public function show($id)
    {

    }


    public function edit(DataKegiatanWarga $data_kegiatan)
    {
        //halaman form edit data kegiatan
        $keg = DataWarga::all();
        // $kat = KategoriKegiatan::all();

        $desas = DB::table('data_desa')
        ->where('id', auth()->user()->id_desa)
        ->get();
        // $kec = DB::table('data_kecamatan')->get();
        $kec = DB::table('data_kecamatan')
        ->where('id', auth()->user()->id_kecamatan)
        ->get();

        $kad = DB::table('users')
        ->where('id', auth()->user()->id)
        ->get();

        $kel = DataKeluarga::all();
        $warga = DataWarga::all(); // pemanggilan tabel data warga
        // $keg = KategoriKegiatan::all(); // pemanggilan tabel data kategori kegiatan
        // $ket = KeteranganKegiatan::all(); // pemanggilan tabel data kategori kegiatan

        // $data['kategori'] = [
        //     'Penghayatan dan Pengamalan Pancasila' => 'Penghayatan dan Pengamalan Pancasila',
        //     'Kerja Bakti' => 'Kerja Bakti',
        //     'Rukun Kematian' => 'Rukun Kematian',
        //     'Kegiatan Keagamaan' => 'Kegiatan Keagamaan',
        //     'Jimpitan' => 'Jimpitan',
        //     'Arisan' => 'Arisan',
        //     'Lain-lain' => 'Lain-lain',
        // ];

        // $data['keterangan'] = [
        //     'Keagamaan' => 'Keagamaan',
        //     'Pola Asuh' => 'Pola Asuh',
        //     'PKBN' => ' PKBN',
        //     'Pencegahan KDRT' => 'Pencegahan KDRT',
        //     'Pencegahan Traffocking' => 'Pencegahan Traffocking',
        //     'Narkoba' => 'Narkoba',
        //     'Pencegahan Kejahatan Seksual' => 'Pencegahan Kejahatan Seksual',
        //     'Kerja Bakti' => 'Kerja Bakti',
        //     'Jimpitan' => 'Jimpitan',
        //     'Arisan' => 'Arisan',
        //     'Rukun Kematian' => 'Rukun Kematian',
        //     'Bakti Sosial ' => 'Bakti Sosial',
        //     'BKB (Bina Keluarga Balita)' => 'BKB (Bina Keluarga Balita)',
        //     'PAUD Sejenis' => 'PAUD Sejenis',
        //     'Paket A' => 'Paket A',
        //     'Paket B' => 'Paket B',
        //     'Paket C' => 'Paket C',
        //     'KF (Keaksaraan Fungsinal) ' => 'KF (Keaksaraan Fungsional) ',
        //     'UP2K (Usaha Peningkatan Pendapatan Keluarga)' => 'UP2K (Usaha Peningkatan Pendapatan Keluarga)',
        //     'Koperasi' => 'Koperasi',

        // ];

        // dd($keg);

        return view('kader.data_kegiatan.form.edit_data_kegiatan', compact('data_kegiatan','keg', 'kec', 'desas','kad','kel', 'ket', 'warga'));

    }

    public function update(Request $request, DataKegiatanWarga $data_kegiatan)
    {
        // proses mengubah untuk tambah data pendidikan
        // dd($request->all());
        // validasi data
        $request->validate([
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
            'id_warga' => 'required',
            'id_kategori' => 'required',
            'aktivitas' => 'required',
            'id_keterangan' => 'required',
            'periode' => 'required',

        ]);
        // update data
            $data_kegiatan->update($request->all());
            Alert::success('Berhasil', 'Data berhasil di ubah');
            return redirect('/data_kegiatan');

    }

    public function destroy($data_kegiatan, DataKegiatanWarga $warg)
    {
        //temukan id data kegiatan warga
        $warg::find($data_kegiatan)->delete();
        Alert::success('Berhasil', 'Data berhasil di Hapus');

        return redirect('/data_kegiatan');



    }


    public function kegiatanDesa($id){
        $kegiatan = DataKegiatan::where('desa_id', $id)->get();

        return response()->json([
            'message' => 'success',
            'data' => $kegiatan
        ]);
    }
    public function detailKegiatan($id){
        $kegiatan = DetailKegiatan::where('kegiatan_id', $id)->get();

        return response()->json([
            'message' => 'success',
            'data' => $kegiatan
        ]);
    }
}

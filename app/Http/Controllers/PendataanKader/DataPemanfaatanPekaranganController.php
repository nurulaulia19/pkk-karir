<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\DataKeluarga;
use App\Models\DataPemanfaatanPekarangan;
use App\Models\DataWarga;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\KategoriPemanfaatanLahan;
use App\Models\RumahTangga;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataPemanfaatanPekaranganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $user = Auth::user();
        //halaman form data pemanfaatan tanah pekarangan
        $user = Auth::user();
        // $pemanfaatan = DataPemanfaatanPekarangan::with('warga')->where('id', $user->id_dasawisma)->get();
        $pemanfaatan = DataPemanfaatanPekarangan::with('rumahtangga','pemanfaatan')->get();
        // dd($pemanfaatan);
        // $pemanfaatan = DataPemanfaatanPekarangan::all()->where('id_user', $user->id);
        return view('kader.data_pemanfaatan_pekarangan.index', compact('pemanfaatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // halaman form tambah data pemanfaatan tanah
     // nama desa yang login
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

    $kategoriPemanfaatan = KategoriPemanfaatanLahan::all();

     $kel = DataKeluarga::all(); // pemanggilan tabel data warga pekarangan
    //  jika brdasarkan warga
     $user = Auth::user();
    //  $warga = DataWarga::where('id_dasawisma', $user->id_dasawisma)
    //  ->where('is_pemanfaatan_lahan_pekarangan', false)
    //  ->get();

        $warga = RumahTangga::all();
    //  $kat = KategoriPemanfaatanLahan::all(); // pemanggilan tabel kategori pemanfaatan tanah

    return view('kader.data_pemanfaatan_pekarangan.create', compact('kategoriPemanfaatan','kec', 'kel', 'desas', 'kad', 'warga'));

 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
    // public function store(Request $request)
    // {
    //     // proses penyimpanan untuk tambah data pemanfaatan tanah
    //     // dd($request->all());
    //     // validasi data
    //     $request->validate([
    //         'id_desa' => 'required',
    //         'id_kecamatan' => 'required',
    //         'warga_id' => 'required',
    //         'nama_kategori' => 'required',
    //         'komoditi' => 'required',
    //         'jumlah' => 'required',
    //         'periode' => 'required',

    //     ], [
    //         'id_desa.required' => 'Pilih Alamat Desa Pemanfaatan Tanah Pekarangan Warga',
    //         'id_kecamatan' => 'Pilih Alamat Kecamatan Pemanfaatan Tanah Pekarangan Warga',

    //         'warga_id.required' => 'Pilih Nama Warga',
    //         'nama_kategori.required' => 'Pilih Alamat Kategori Pemanfaatan Tanah Pekarangan',
    //         'komoditi.required' => 'Lengkapi Komoditi Pemanfaatan Tanah Pekarangan',
    //         'jumlah.required' => 'Lengkapi Jumlah Komoditi Tanah Pekarangan',
    //         'periode.required' => 'Pilih Periode',

    //     ]);

    //     // pengkondisian tabel
    //     $insert=DB::table('data_pemanfaatan_pekarangan')->where('warga_id', $request->warga_id)->first();
    //     if ($insert != null) {
    //         Alert::error('Gagal', 'Data Tidak Berhasil Di Tambah. Keluarga Sudah Ada ');

    //         return redirect('/data_pemanfaatan');
    //     }
    //     else {

    //         $kegiatans = new DataPemanfaatanPekarangan;
    //         $kegiatans->id_desa = $request->id_desa;
    //         $kegiatans->id_kecamatan = $request->id_kecamatan;
    //         $kegiatans->warga_id = $request->warga_id;
    //         // $kegiatans->id_user = $request->id_user;
    //         $kegiatans->nama_kategori = $request->nama_kategori;
    //         $kegiatans->komoditi = $request->komoditi;
    //         $kegiatans->jumlah = $request->jumlah;
    //         $kegiatans->periode = $request->periode;

    //         // simpan data
    //         $kegiatans->save();

    //         Alert::success('Berhasil', 'Data berhasil di tambahkan');

    //         return redirect('/data_pemanfaatan');
    //         }
    // }

    public function store(Request $request)
    {
        $request->validate([
            'rumah_tangga_id' => 'required|exists:rumah_tanggas,id',
            'periode' => 'required',
            'nama_pemanfaatan' => 'required',

        ], [
            'rumah_tangga_id.required' => 'Lengkapi Warga Yang Didata',
            'nama_pemanfaatan.required' => 'Pilih Kegiatan',
            'periode.required' => 'Pilih Periode',

        ]);
        // dd($request->all());

         foreach ($request->nama_pemanfaatan as $key => $item) {
            // dd($item);
            if ($item !== null && $item !== '') {
                DataPemanfaatanPekarangan::create([
                    'id_desa' =>1,
                    'id_kecamatan' =>1 ,
                    'rumah_tangga_id' => $request->rumah_tangga_id,
                    'kategori_id' => $item,
                    'periode' => $request->periode,
                ]);
            }
         }

         // Set is_kegiatan menjadi true untuk data warga yang terkait
            // $dataWarga = DataWarga::find($request->id_warga);
            // if ($dataWarga) {
            //     $dataWarga->is_kegiatan = true;
            //     $dataWarga->save();
            // }

         Alert::success('Berhasil', 'Data berhasil di tambahkan');
         return redirect('/data_pemanfaatan');



        // proses penyimpanan untuk tambah data data kegiatan warga
        // dd($request->all());
        // validasi data


        // // pengkondisian tabel
        //     $kegiatans = new DataPemanfaatanPekarangan();
        //     $kegiatans->id_desa = $request->id_desa;
        //     $kegiatans->id_kecamatan = $request->id_kecamatan;
        //     $kegiatans->id_warga = $request->id_warga;
        //     // $kegiatans->nama_pemanfaatan = $request->nama_pemanfaatan;
        //     $kegiatans->id_kategori = $request->id_kategori;
        //     $kegiatans->id_user = $request->id_user;

        //     $kegiatans->aktivitas = $request->aktivitas;
        //     // $kegiatans->keterangan = $request->keterangan;
        //     $kegiatans->id_keterangan = $request->id_keterangan;
        //     $kegiatans->periode = $request->periode;

        //     // simpan data
        //     $kegiatans->save();

            Alert::success('Berhasil', 'Data berhasil di tambahkan');

            return redirect('/data_kegiatan');
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
        //halaman form edit data pemanfaatan tanah pekarangan
        // $kel = DataKeluarga::all();
        $data_pemanfaatan = DataPemanfaatanPekarangan::with('warga')->find($id);
        // dd($data_pemanfaatan);


        $desas = DB::table('data_desa')
       ->where('id', auth()->user()->id_desa)
       ->get();
       // $kec = DB::table('data_kecamatan')->get();
       $kec = DB::table('data_kecamatan')
       ->where('id', auth()->user()->id_desa)
       ->get();

        $kad = DB::table('users')
            ->where('id', auth()->user()->id)
            ->get();
    //    $data['kategori'] = [
    //     'Peternakan' => 'Peternakan',
    //     'Perikanan' => 'Perikanan',
    //     'Warung Hidup' => 'Warung Hidup',
    //     'TOGA (Tanaman Obat Keluarga)' => 'TOGA (Tanaman Obat Keluarga)',
    //     'Tanaman Keras' => 'Tanaman Keras',
    //     'Lainnya' => 'Lainnya',
    // ];

        return view('kader.data_pemanfaatan_pekarangan.edit', compact('data_pemanfaatan', 'desas', 'kec', 'kad'));

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
        // Validasi data
        $request->validate([
            'id_desa' => 'required',
            'warga_id' => 'required',
            'nama_kategori' => 'required',
            'komoditi' => 'required',
            'jumlah' => 'required|numeric|min:1', // Contoh validasi jumlah harus numeric dan minimal 1
            'periode' => 'required|integer|min:2000|max:3000', // Contoh validasi periode harus integer antara 2000-3000
        ], [
            'required' => 'Kolom :attribute harus diisi.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'min' => 'Kolom :attribute minimal :min.',
            'max' => 'Kolom :attribute maksimal :max.',
            'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
        ]);

        // Mengambil data pemanfaatan berdasarkan ID
        $data_pemanfaatan = DataPemanfaatanPekarangan::find($id);

        if (!$data_pemanfaatan) {
            // Jika data tidak ditemukan
            Alert::error('Error', 'Data tidak ditemukan.');
            return Redirect::back()->withInput();
        }

        // Memperbarui data pemanfaatan berdasarkan input request
        $data_pemanfaatan->update($request->all());

        // Menampilkan notifikasi sukses
        Alert::success('Berhasil', 'Data berhasil diubah.');

        // Redirect ke halaman data_pemanfaatan setelah berhasil diubah
        return redirect()->route('data_pemanfaatan.index');
    }

    /**
     * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //temukan id pemanfaatan tanah pekarangan
        $pemanfaatan = DataPemanfaatanPekarangan::with('warga')->find($id);
        $warga = DataWarga::find($pemanfaatan->warga->id);
        $warga->is_pemanfaatan_lahan_pekarangan = 0;
        $warga->save();
        $pemanfaatan->delete();

        Alert::success('Berhasil', 'Data berhasil di Hapus');
        return redirect('/data_pemanfaatan');



    }
}

<?php

namespace App\Http\Controllers\AdminKab;
use App\Http\Controllers\Controller;
use App\Models\DataKabupaten;
use App\Models\DataKecamatan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DataKecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // halaman data Kecamatan
        $kecamatan = DataKecamatan::all();
        return view('admin_kab.data_kecamatan.index', compact('kecamatan'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = DataKecamatan::all();
        $kabupaten = DataKabupaten::all();
        return view('admin_kab.data_kecamatan.create', compact('kecamatan', 'kabupaten'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // proses penyimpanan untuk tambah data kecamatan
        $request->validate([
            'kabupaten_id' => 'required',
            'kode_kecamatan' => 'required',
            'nama_kecamatan' => 'required',

        ], [
                'kabupaten_id.required' => 'Lengkapi Nama Kabupaten',
                'kode_kecamatan.required' => 'Lengkapi Kode Kecamatan',
                'nama_kecamatan.required' => 'Lengkapi Nama Kecamatan',

        ]);

        // cara 1
        $kecamatan = new DataKecamatan();
        $kecamatan->kabupaten_id = $request->kabupaten_id;
        $kecamatan->kode_kecamatan = $request->kode_kecamatan;
        $kecamatan->nama_kecamatan = $request->nama_kecamatan;
        $kecamatan->save();


        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/data_kecamatan');

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
        $kecamatan = DataKecamatan::findOrFail($id);
        // dd($kabupaten);
        $kabupaten = DataKabupaten::all();
        return view('admin_kab.data_kecamatan.edit', compact('kecamatan','kabupaten'));

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
        //halaman proses edit data
        $request->validate([
            'kabupaten_id' => 'required',
            'kode_kecamatan' => 'required',
            'nama_kecamatan' => 'required',
        ]);

        // Mengambil data kecamatan berdasarkan ID
        $kecamatan = DataKecamatan::findOrFail($id);

        // Update data kecamatan
        $kecamatan->kabupaten_id = $request->kabupaten_id;
        $kecamatan->kode_kecamatan = $request->kode_kecamatan;
        $kecamatan->nama_kecamatan = $request->nama_kecamatan;
        $kecamatan->save();
        Alert::success('Berhasil', 'Data berhasil di ubah');

        return redirect('/data_kecamatan');
        // return view('admin_kab.data_kecamatan', compact('data_kecamatan'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Menghapus data provinsi berdasarkan ID
        $kecamatan = DataKecamatan::findOrFail($id);
        $kecamatan->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return redirect('/data_kecamatan');
    }
}

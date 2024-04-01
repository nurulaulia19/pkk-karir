<?php

namespace App\Http\Controllers\AdminKab;

use App\Http\Controllers\Controller;
use App\Models\DataProvinsi;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class DataProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = DataProvinsi::all();
        return view('admin_kab.data_provinsi.index', compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinsi = DataProvinsi::all();
        // Mengirim data provinsi ke view
        return view('admin_kab.data_provinsi.create', compact('provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // proses penyimpanan untuk tambah data wilayah/desa
        $request->validate([
            'kode_provinsi' => 'required',
            'name' => 'required'

        ], [
            'kode_provinsi.required' => 'Isi Kode Provinsi',
            'name.required' => 'Isi Nama Provinsi'

        ]);

        // cara 1
        $provinsi = new DataProvinsi();
        $provinsi->kode_provinsi = $request->kode_provinsi;
        $provinsi->name = $request->name;
        $provinsi->save();


        Alert::success('Berhasil', 'Data berhasil di tambahkan');

        return redirect('/data_provinsi');


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
        $provinsi = DataProvinsi::findOrFail($id);
        // Mengirim data provinsi ke view untuk diedit
        return view('admin_kab.data_provinsi.edit', compact('provinsi'));
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
            'kode_provinsi' => 'required',
            'name' => 'required'

        ], [
            'kode_provinsi.required' => 'Isi Kode Provinsi',
            'name.required' => 'Isi Nama Provinsi'

        ]);

        // Mengambil data provinsi berdasarkan ID
        $provinsi = DataProvinsi::findOrFail($id);

        // Update data provinsi
        $provinsi->name = $request->name;
        $provinsi->kode_provinsi = $request->kode_provinsi;
        $provinsi->save();

        Alert::success('Berhasil', 'Data berhasil diperbarui');

        return redirect('/data_provinsi');
    }

    public function destroy($id)
    {
        // Menghapus data provinsi berdasarkan ID
        $provinsi = DataProvinsi::findOrFail($id);
        $provinsi->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return redirect('/data_provinsi');
    }
}

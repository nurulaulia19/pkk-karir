<?php

namespace App\Http\Controllers\AdminKab;

use App\Http\Controllers\Controller;
use App\Models\DataKabupaten;
use App\Models\DataProvinsi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DataKabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kabupaten = DataKabupaten::with('provinsi')->get();
        return view('admin_kab.data_kabupaten.index', compact('kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kabupaten = DataKabupaten::all();
        $provinsi = DataProvinsi::all();
        // Mengirim data kabupaten ke view
        return view('admin_kab.data_kabupaten.create', compact('kabupaten','provinsi'));

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
            'provinsi_id' => 'required',
            'kode_kabupaten' => 'required',
            'name' => 'required',

        ], [
                'provinsi_id.required' => 'Lengkapi Data Provinsi',
                'kode_kabupaten.required' => 'Lengkapi Kode Kabupaten',
                'name.required' => 'Lengkapi Nama Kabupaten',
        ]);

        // cara 1
        $kabupaten = new DataKabupaten();
        $kabupaten->provinsi_id = $request->provinsi_id;
        $kabupaten->kode_kabupaten = $request->kode_kabupaten;
        $kabupaten->name = $request->name;
        $kabupaten->save();

        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/data_kabupaten');


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
        $kabupaten = DataKabupaten::findOrFail($id);
        // dd($kabupaten);
        $provinsi = DataProvinsi::all();

        return view('admin_kab.data_kabupaten.edit', compact('kabupaten', 'provinsi'));
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
            'provinsi_id' => 'required',
            'kode_kabupaten' => 'required',
            'name' => 'required'

        ], [
            'provinsi_id.required' => 'Pilih Provinsi',
            'kode_kabupaten.required' => 'Isi Kode Kabupaten',
            'name.required' => 'Isi Nama Kabupaten'

        ]);

        // Mengambil data kabupaten berdasarkan ID
        $kabupaten = DataKabupaten::findOrFail($id);

        // Update data kabupaten
        $kabupaten->provinsi_id = $request->provinsi_id;
        $kabupaten->name = $request->name;
        $kabupaten->kode_kabupaten = $request->kode_kabupaten;
        $kabupaten->save();

        Alert::success('Berhasil', 'Data berhasil diperbarui');

        return redirect('/data_kabupaten');
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
        $kabupaten = DataKabupaten::findOrFail($id);
        $kabupaten->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return redirect('/data_kabupaten');
    }
}

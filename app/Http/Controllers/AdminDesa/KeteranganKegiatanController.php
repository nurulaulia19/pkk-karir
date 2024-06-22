<?php

namespace App\Http\Controllers\AdminDesa;
use App\Http\Controllers\Controller;
use App\Models\DataKegiatan;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeteranganKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //halaman form keterangan kegiatan
        $kegiatan = DataKegiatan::all();
        return view('admin_desa.kegiatan.index', compact('kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // halaman create keterangan kegiatan
        $kegiatan = DataKegiatan::all();

        return view('admin_desa.kegiatan.create', compact('kegiatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:data_kegiatan', // 'kegiatans' adalah nama tabel
        ], [
            'name.required' => 'Masukkan Nama Kegiatan',
            'name.unique' => 'Nama Kegiatan sudah ada, silakan masukkan yang lain',
        ]);

        $kegiatan = new DataKegiatan();
        // $kegiatan->desa_id = $user->id_desa;
        $kegiatan->name = $request->name;

        $kegiatan->save();
        // dd($kat);
        Alert::success('Berhasil', 'Data berhasil di tambahkan');

        return redirect('/kegiatan');
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
    public function edit(Request $request, $id)
    {
        // halaman edit keterangan kegiatan
        $kegiatan = DataKegiatan::find($id);

        return view('admin_desa.kegiatan.edit', compact('kegiatan'));

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
        $request->validate([
            'name' => [
                'required',
                Rule::unique('data_kegiatan')->ignore($id),
            ],
        ], [
            'name.required' => 'Masukkan Nama Kegiatan',
            'name.unique' => 'Nama Kegiatan sudah ada, silakan masukkan yang lain',
        ]);

        $kegiatan = DataKegiatan::find($id);
        $kegiatan->name = $request->name;
        $kegiatan->update();
        Alert::success('Berhasil', 'Data berhasil di Ubah');

        return redirect('/kegiatan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DataKegiatan::find($id)->delete();
        Alert::success('Berhasil', 'Data berhasil di Hapus');

        return redirect('/kegiatan')->with('status', 'sukses');
    }
}

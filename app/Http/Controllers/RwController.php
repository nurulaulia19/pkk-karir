<?php

namespace App\Http\Controllers;

use App\Models\DataKelompokDasawisma;
use App\Models\KategoriKegiatan;
use App\Models\Rw;
use App\Models\User;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RwController extends Controller
{
    public function index()
    {
        $kategori = Rw::all();

        return view('admin_desa.rw.index', compact('kategori'));
    }
    public function show($id)
    {
        $kategori = Rw::with('rt')->find($id);
        if(!$kategori){
            dd('nyasar bos');
        }

        return view('admin_desa.rw.rt.index', compact('kategori'));
    }

    public function create(Request $request)
    {
        // halaman create kategori kegiatan
        return view('admin_desa.rw.create');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        // dd($user)
;        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Masukkan Nama RW',
        ]);

        Rw::create([
            'name' => $request->name,
             'desa_id' => $user->id_desa
        ]);
        // dd($kat);
        Alert::success('Berhasil', 'RW berhasil di tambahkan');

        return redirect('/rw');
    }

    public function edit(KategoriKegiatan $kategori_kegiatan)
    {
        //
        return view('admin_desa.rw.edit', compact('kategori_kegiatan'));

    }

    public function update(Request $request, KategoriKegiatan $kategori_kegiatan)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
        ], [
            'nama_kegiatan.required' => 'Masukkan Nama Kategori Kegiatan',
        ]);

        $kategori_kegiatan->nama_kegiatan = $request->nama_kegiatan;
        $kategori_kegiatan->update();
        Alert::success('Berhasil', 'Data berhasil di Ubah');

        return redirect('/kategori_kegiatan');
    }
    public function destroy($kategori_kegiatan, KategoriKegiatan $kat)
    {
        //temukan id kat
        $kat::find($kategori_kegiatan)->delete();
        Alert::success('Berhasil', 'Data berhasil di Hapus');

        return redirect('/kategori_kegiatan')->with('status', 'sukses');
    }
}

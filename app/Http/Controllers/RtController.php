<?php

namespace App\Http\Controllers;

use App\Models\KategoriKegiatan;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RtController extends Controller
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

        return view('admin_desa.rw.show_rt', compact('kategori'));
    }

    public function create(Request $request)
    {
        $rwQuery = $request->input('rw');
        if(!$rwQuery){
            dd('nyasar');
        }
        $rwData = Rw::find($rwQuery);
        if(!$rwData){
            dd('nyasar');
        }
        $rw = $rwData->name;

        // dd('selamat datang');
        // halaman create kategori kegiatan
        return view('admin_desa.rw.rt.create',compact('rw'));
    }
    public function store(Request $request)
    {
        $rwQuery = $request->input('rw');
        if(!$rwQuery){
            dd('nyasar');
        }
        $rw = Rw::where('name',$rwQuery)->first();
        // dd($rwQuery);
        // dd($rw);
        if(!$rw){
            dd('gada rw');
        }
        // dd($request->all());
        $user = Auth::user();
        // dd($user)
;        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Masukkan Nama RW',
        ]);

        Rt::create([
            'name' => $request->name,
             'rw_id' => $rw->id
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

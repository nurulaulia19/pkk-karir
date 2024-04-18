<?php

namespace App\Http\Controllers;

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
        $user = Auth::user();
        $rw = Rw::where('desa_id', $user->id_desa)->get();
        // dd($rw);

        return view('admin_desa.rw.index', compact('rw'));
    }
    public function show($id)
    {
        $rt = Rw::with('rt')->find($id);
        if(!$rt){
            dd('tidak ada rw');
        }

        return view('admin_desa.rw.rt.index', compact('rt'));
    }

    public function create(Request $request)
    {
        // halaman create rw
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

    public function edit(RW $rw)
    {
        //
        return view('admin_desa.rw.edit', compact('rw'));

    }

    public function update(Request $request, RW $rw)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Masukkan Nama RW',
        ]);

        $rw->name = $request->name;
        $rw->update();
        Alert::success('Berhasil', 'Data berhasil di Ubah');

        return redirect('/rw');
    }

    public function destroy($rwId, RW $dataRw)
    {
        // Temukan data RW berdasarkan ID
        $rw = $dataRw::findOrFail($rwId);

        // Simpan ID RW
        $rwId = $rw->id;

        // Hapus data RT yang terkait dengan RW
        $rw->rt()->delete();

        // Hapus data RW
        $rw->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return redirect('/rw')->with('status', 'sukses');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Dusun;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class KategoriDusunController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dusun = Dusun::where('desa_id', $user->id_desa)->orderBy('id', 'DESC')->get();
        // dd($dusun);

        return view('admin_desa.data_dusun.index', compact('dusun'));
    }

    public function create()
    {

        return view('admin_desa.data_dusun.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|unique:dusuns,name',
        ], [
            'name.required' => 'Lengkapi Nama Dusun',
            'name.unique' => 'Nama Dusun Sudah Ada',
        ]);


        $dusun = new Dusun();
        $dusun->name = $request->name;
        $dusun->desa_id = $user->id_desa;
        $dusun->save();


        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/data_dusun');
    }

    public function edit($id)
    {
        $dusun = Dusun::findOrFail($id);
        return view('admin_desa.data_dusun.edit', compact('dusun'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'name' => [
                'required',
                Rule::unique('dusuns')->ignore($id),
            ],
        ], [
            'name.required' => 'Lengkapi Nama Dusun',
            'name.unique' => 'Nama Dusun Sudah Ada',
        ]);

        $dusun = Dusun::find($id);

        if (!$dusun) {
            // Produk dengan 'id_produk' yang dimaksud tidak ditemukan
            // Lakukan tindakan error handling atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $dusun->name = $request->name;
        $dusun->desa_id = $user->id_desa;
        $dusun->save();

        Alert::success('Berhasil', 'Data berhasil di ubah');

        return redirect('/data_dusun');
    }

    public function destroy($id)
    {
        $data = Dusun::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Data berhasil di hapus');

        return redirect('/data_dusun');
    }
}

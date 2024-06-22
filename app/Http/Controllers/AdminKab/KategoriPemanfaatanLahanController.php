<?php

namespace App\Http\Controllers\Adminkab;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\KategoriPemanfaatanLahan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriPemanfaatanLahanController extends Controller
{
    public function index(Request $request)
    {
        // halaman data pemanfaatan rumah tangga
        // $user = Auth::user();
        $pemanfaatan = KategoriPemanfaatanLahan::orderBy('id', 'DESC')->get();
        return view('admin_kab.kategori_pemanfaatan_lahan.index', compact('pemanfaatan'));
    }

    public function create()
    {
        // $user = Auth::user();
        // dd($user);
        return view('admin_kab.kategori_pemanfaatan_lahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_pemanfaatan_lahan,nama_kategori',
        ], [
            'nama_kategori.required' => 'Lengkapi Nama Kategori Pemanfaatan',
            'nama_kategori.unique' => 'Nama Kategori Pemanfaatan Sudah Ada',
        ]);


        $pemanfaatan = new KategoriPemanfaatanLahan();
        $pemanfaatan->nama_kategori = $request->nama_kategori;
        $pemanfaatan->save();


        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/data_kategori_pemanfaatan_lahan');
    }

    public function edit($id)
    {
        $pemanfaatan = KategoriPemanfaatanLahan::findOrFail($id);
        return view('admin_kab.kategori_pemanfaatan_lahan.edit', compact('pemanfaatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                Rule::unique('kategori_pemanfaatan_lahan')->ignore($id),
            ],
        ], [
            'nama_kategori.required' => 'Lengkapi Nama Kategori Pemanfaatan',
            'nama_kategori.unique' => 'Nama Kategori Sudah Ada',
        ]);

        $pemanfaatan = KategoriPemanfaatanLahan::find($id);

        if (!$pemanfaatan) {
            // Produk dengan 'id_produk' yang dimaksud tidak ditemukan
            // Lakukan tindakan error handling atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data pemanfaatan tidak ditemukan.');
        }

        $pemanfaatan->nama_kategori = $request->nama_kategori;
        $pemanfaatan->save();

        Alert::success('Berhasil', 'Data berhasil di ubah');

        return redirect('/data_kategori_pemanfaatan_lahan');
    }

    public function destroy($id)
    {
        $data = KategoriPemanfaatanLahan::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Data berhasil di hapus');

        return redirect('/data_kategori_pemanfaatan_lahan');
    }
}

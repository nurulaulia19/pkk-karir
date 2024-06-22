<?php

namespace App\Http\Controllers\Adminkab;

use App\Http\Controllers\Controller;
use App\Models\KategoriIndustriRumah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;


class KategoriIndustriRumahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $industri = KategoriIndustriRumah::orderBy('id', 'DESC')->get();
        return view('admin_kab.kategori_industri_rumah.index', compact('industri'));
    }

    public function create()
    {
        return view('admin_kab.kategori_industri_rumah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:kategori_industri_rumah,nama_kategori',
        ], [
            'nama_kategori.required' => 'Lengkapi Nama Kategori Industri',
            'nama_kategori.unique' => 'Nama Kategori Industri Sudah Ada',
        ]);


        $industri = new KategoriIndustriRumah();
        $industri->nama_kategori = $request->nama_kategori;
        $industri->save();


        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/data_kategori_industri');
    }

    public function edit($id)
    {
        $industri = KategoriIndustriRumah::findOrFail($id);
        return view('admin_kab.kategori_industri_rumah.edit', compact('industri'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                Rule::unique('kategori_industri_rumah')->ignore($id),
            ],
        ], [
            'nama_kategori.required' => 'Lengkapi Nama Kategori Industri',
            'nama_kategori.unique' => 'Nama Kategori Sudah Ada',
        ]);

        $industri = KategoriIndustriRumah::find($id);

        if (!$industri) {
            // Produk dengan 'id_produk' yang dimaksud tidak ditemukan
            // Lakukan tindakan error handling atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data industri tidak ditemukan.');
        }

        $industri->nama_kategori = $request->nama_kategori;
        $industri->save();

        Alert::success('Berhasil', 'Data berhasil di ubah');

        return redirect('/data_kategori_industri');
    }

    public function destroy($id)
    {
        $data = KategoriIndustriRumah::findOrFail($id);
        $data->delete();

        Alert::success('Berhasil', 'Data berhasil di hapus');

        return redirect('/data_kategori_industri');
    }

}

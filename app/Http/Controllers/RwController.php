<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\User;
use Carbon\Carbon;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class RwController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rw = Rw::where('desa_id', $user->id_desa)->with('dusun')->get();
        // dd($rw);

        return view('admin_desa.rw.index', compact('rw'));
    }
    public function show($id)
    {
        $rt = Rw::with('rt')->find($id);
        // dd($rt);
        if(!$rt){
            // dd('tidak ada rw');
            Alert::error('Gagal', 'Tidak Ada RW');
            return redirect()->back();
        }

        return view('admin_desa.rw.rt.index', compact('rt'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $dusun = Dusun::where('desa_id', $user->id_desa)->get();
        return view('admin_desa.rw.create', compact('dusun'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            // 'name' => 'required|unique:rws', // 'kegiatans' adalah nama tabel
            'name' => [
                'required',
                Rule::unique('rws')->where(function ($query) use ($user) {
                    return $query->where('desa_id', $user->id_desa);
                }),
            ],
        ], [
            'name.required' => 'Masukkan Nama RW',
            'name.unique' => 'Nama RW sudah ada, silakan masukkan yang lain',
        ]);

        $user = Auth::user();
        $tahun = Carbon::now()->year;

        Rw::create([
            'name' => $request->name,
             'desa_id' => $user->id_desa,
             'dusun_id' => $request->dusun_id,
            //  'periode' => $tahun,
        ]);
        // dd($kat);
        Alert::success('Berhasil', 'RW berhasil di tambahkan');

        return redirect('/rw');
    }

    public function edit(RW $rw)
    {
        $user = Auth::user();
        $dusun = Dusun::where('desa_id', $user->id_desa)->get();
        return view('admin_desa.rw.edit', compact('rw', 'dusun'));

    }

    public function update(Request $request, RW $rw)
    {
        $user = Auth::user();
        $request->validate([
            'name' => [
                'required',
                // Rule::unique('rws')->ignore($rw),
                Rule::unique('rws')->where(function ($query) use ($user, $rw) {
                    return $query->where('desa_id', $user->id_desa)->where('id', '!=', $rw->id);
                }),
            ],
        ], [
            'name.required' => 'Masukkan Nama RW',
            'name.unique' => 'Nama RW sudah ada, silakan masukkan yang lain',
        ]);

        $rw->name = $request->name;
        $rw->dusun_id = $request->dusun_id;
        // $rw->periode = $request->periode;
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

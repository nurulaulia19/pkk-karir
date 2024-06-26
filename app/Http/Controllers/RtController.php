<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\KategoriKegiatan;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class RtController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rw = Rw::where('desa_id', $user->id_desa)->with('rt','dusun')->get();

        return view('admin_desa.rw.index', compact('rw'));
    }
    public function show($id)
    {
        $rt = Rw::with('rt')->find($id);

        if(!$rt){
            dd('Tidak ada RT');
        }
        // dd($rt);

        return view('admin_desa.rw.show_rt', compact('rt'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $rwQuery = $request->input('rw');

        if(!$rwQuery){
            dd('Tidak ada RW');
        }

        $rwData = Rw::find($rwQuery);

        if(!$rwData){
            dd('Tidak ada RW');
        }

        $rw = $rwData->name; // Simpan nama RW yang dipilih
        $rw_id = $rwData->id; // Mengambil id dari objek Rw yang ditemukan

        $dusun = Dusun::where('desa_id', $user->id_desa)->get();

        return view('admin_desa.rw.rt.create',compact('rw', 'dusun', 'rw_id'));
    }

    public function store(Request $request)
    {
        $rwQuery = $request->input('rw');
        if(!$rwQuery){
            Alert::error('Gagal', 'Tidak Ada RW');
            return redirect()->back();
        }
        $rw = Rw::where('name',$rwQuery)->first();

        if(!$rw){
            Alert::error('Gagal', 'Tidak Ada RW');
            return redirect()->back();
        }

        $user = Auth::user();
        $request->validate([
            'name' => [
                'required',
                Rule::unique('rts')->where(function ($query) use ($rw) {
                    return $query->where('rw_id', $rw->id);
                }),
            ],
        ], [
            'name.required' => 'Masukkan Nama RT',
            'name.unique' => 'Nama RT sudah ada dalam RW ini, silakan masukkan yang lain',
        ]);
        // dd($rw->id);

        Rt::create([
            'name' => $request->name,
             'rw_id' => $rw->id,
             'dusun_id' => $request->dusun_id,
        ]);
        // dd($kat);
        Alert::success('Berhasil', 'RW berhasil di tambahkan');

        // return redirect('/rw');
        return redirect()->route('rw.show', $rw->id);

    }

    public function edit(RT $rt)
    {
        $user = Auth::user();
        $dusun = Dusun::where('desa_id', $user->id_desa)->get();

        // Mengambil data Rw terkait dengan $rt
        $rwData = Rw::find($rt->rw_id);

        // Pastikan $rwData ditemukan
        if (!$rwData) {
            return redirect()->back()->with('error', 'Data RW tidak ditemukan');
        }

        // Mengakses properti name dari $rwData
        $rw = $rwData->name;
        $rw_id = $rwData->id;
        return view('admin_desa.rw.rt.edit', compact('rt', 'dusun', 'rw', 'rw_id'));

    }

    public function update(Request $request, RT $rt)
    {
        $rwQuery = $request->input('rw');
        if(!$rwQuery){
            Alert::error('Gagal', 'Tidak Ada RW');
            return redirect()->back();
        }
        $rw = Rw::where('name',$rwQuery)->first();

        if(!$rw){
            Alert::error('Gagal', 'Tidak Ada RW');
            return redirect()->back();
        }

        $request->validate([
            'name' => [
                'required',
            Rule::unique('rts')->where(function ($query) use ($rw) {
            return $query->where('rw_id', $rw->id);
        })->ignore($rt), // Mengabaikan RT yang sedang diperbarui
            ],
        ], [
            'name.required' => 'Masukkan Nama RT',
            'name.unique' => 'Nama RT sudah ada dalam RW ini, silakan masukkan yang lain',
        ]);
        // dd($rw->id);

        $rt->name = $request->name;
        // $rt->rw = $request->rw_id;
        $rt->dusun_id = $request->dusun_id;
        $rt->update();
        Alert::success('Berhasil', 'Data berhasil di Ubah');

        return redirect('rw/'.$rt->rw_id);
    }

    public function destroy($rt, RT $dataRT)
    {
        // Temukan data RT berdasarkan ID
        $rtData = $dataRT::findOrFail($rt);
        $rwId = $rtData->rw_id;
        $rtData->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        // Redirect ke halaman RW dengan ID RW yang terkait
        return redirect('rw/'.$rwId)->with('status', 'sukses');
    }

    public function getRTByRW(Request $request)
    {
        $rwId = $request->rw_id;

        // Ambil data RT berdasarkan RW yang dipilih
        $rts = Rt::where('rw_id', $rwId)->pluck('name', 'id');

        return response()->json($rts);
    }

}

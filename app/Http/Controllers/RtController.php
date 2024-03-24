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
        $rw = Rw::all();

        return view('admin_desa.rw.index', compact('rw'));
    }
    public function show($id)
    {
        $rt = Rw::with('rt')->find($id);
        if(!$rt){
            dd('Tidak ada RT');
        }

        return view('admin_desa.rw.show_rt', compact('rt'));
    }

    public function create(Request $request)
    {
        $rwQuery = $request->input('rw');
        if(!$rwQuery){
            dd('Tidak ada RW');
        }
        $rwData = Rw::find($rwQuery);
        if(!$rwData){
            dd('Tidak ada RW');
        }
        $rw = $rwData->name;

        return view('admin_desa.rw.rt.create',compact('rw'));
    }
    public function store(Request $request)
    {
        $rwQuery = $request->input('rw');
        if(!$rwQuery){
            dd('Tidak ada RW');
        }
        $rw = Rw::where('name',$rwQuery)->first();

        if(!$rw){
            dd('Tidak ada RW');
        }

        $user = Auth::user();

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

        // return redirect('/rw');
        return redirect()->route('rw.show', $rw->id);

    }

    public function edit(RT $rt)
    {
        //
        return view('admin_desa.rw.rt.edit', compact('rt'));

    }

    public function update(Request $request, RT $rt)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Masukkan Nama RT',
        ]);

        $rt->name = $request->name;
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

}

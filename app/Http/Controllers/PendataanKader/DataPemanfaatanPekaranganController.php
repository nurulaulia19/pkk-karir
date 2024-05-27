<?php

namespace App\Http\Controllers\PendataanKader;
use App\Http\Controllers\Controller;
use App\Models\DataKeluarga;
use App\Models\DataPemanfaatanPekarangan;
use App\Models\DataWarga;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\KategoriPemanfaatanLahan;
use App\Models\Periode;
use App\Models\RumahTangga;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


function isUnique($arr)
{
    return count($arr) === count(array_unique($arr));
}
class DataPemanfaatanPekaranganController extends Controller
{
    public function deleted_all($id){
        $rumahTanggaId = RumahTangga::find($id);
        if ($rumahTanggaId) {
            $rumahTanggaId->is_pemanfaatan_lahan = 0;
            $rumahTanggaId->save();

            // Menghapus semua data pemanfaatan yang terkait dengan rumah tangga ini
            DataPemanfaatanPekarangan::where('rumah_tangga_id', $rumahTanggaId->id)->delete();
        }
        Alert::success('Berhasil', 'Data berhasil di hapus');
        return redirect()->route('data_pemanfaatan.index');

    }

    public function index(Request $request)
    {
        // $user = Auth::user();
        //halaman form data pemanfaatan tanah pekarangan
        $user = Auth::user();
        $periode = $request->periode;

        // $pemanfaatan = DataPemanfaatanPekarangan::with('warga')->where('id', $user->id_dasawisma)->get();
        if ($periode) {
            $pemanfaatan = RumahTangga::with('pemanfaatanlahan.rumahtangga','pemanfaatanlahan.pemanfaatan')->
            where('periode', $periode)->
            where('is_pemanfaatan_lahan',1)
            ->orderBy('id', 'DESC')
            ->get();
        } else {
            $pemanfaatan = RumahTangga::with('pemanfaatanlahan.rumahtangga','pemanfaatanlahan.pemanfaatan')->
            where('periode', now()->year)->
            where('is_pemanfaatan_lahan',1)
            ->orderBy('id', 'DESC')
            ->get();
        }
        $dataPeriode = Periode::all();

        // dd($pemanfaatan);
        // $pemanfaatan = DataPemanfaatanPekarangan::all()->where('id_user', $user->id);
        return view('kader.data_pemanfaatan_pekarangan.index', compact('pemanfaatan','dataPeriode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // halaman form tambah data pemanfaatan tanah
     // nama desa yang login
     $desas = DB::table('data_desa')
     ->where('id', auth()->user()->id_desa)
     ->get();
     // $kec = DB::table('data_kecamatan')->get();
     $kec = DB::table('data_kecamatan')
     ->where('id', auth()->user()->id_kecamatan)
     ->get();

     $kad = DB::table('users')
    ->where('id', auth()->user()->id)
    ->get();

    $kategoriPemanfaatan = KategoriPemanfaatanLahan::all();

    $kel = DataKeluarga::all(); // pemanggilan tabel data warga pekarangan
    $user = Auth::user();

    // $krt = RumahTangga::where('is_pemanfaatan_lahan',false)->get();
    $krt = RumahTangga::where('id_dasawisma', $user->id_dasawisma)
    ->where('is_valid', '!=', 0)
    ->where('periode', now()->year)
    ->where('is_pemanfaatan_lahan', false)->get();
    // $krt = RumahTangga::with(['anggotaRT.keluarga', 'anggotaRT.keluarga.warga'])->get();
    // dd($krt);
    //  $kat = KategoriPemanfaatanLahan::all(); // pemanggilan tabel kategori pemanfaatan tanah

    return view('kader.data_pemanfaatan_pekarangan.create', compact('kategoriPemanfaatan','kec', 'kel', 'desas', 'kad', 'krt'));

 }



    public function store(Request $request)
    {
        $request->validate([
            'rumah_tangga_id' => 'required|exists:rumah_tanggas,id',
            'periode' => 'required',
            'kategori_id' => 'required',

        ], [
            'rumah_tangga_id.required' => 'Lengkapi Kepala Rumah Tangga Yang Didata',
            'kategori_id.required' => 'Pilih Kegiatan',
            'periode.required' => 'Pilih Periode',

        ]);

        if (!isUnique($request->kategori_id)) {
            return redirect()
                ->back()
                ->withErrors(['data' => 'nama pemanfaatan tidak boleh sama']);
        }

         foreach ($request->kategori_id as $key => $item) {
            // dd($item);
            if ($item !== null && $item !== '') {
                $checkDataAavilable = DataPemanfaatanPekarangan::where('rumah_tangga_id', $request->rumah_tangga_id)->
                where('kategori_id', $item)->first();

                if(!$checkDataAavilable){
                    DataPemanfaatanPekarangan::create([
                        'id_desa' =>1,
                        'id_kecamatan' =>1 ,
                        'rumah_tangga_id' => $request->rumah_tangga_id,
                        'kategori_id' => $item,
                        'periode' => $request->periode,
                        'is_valid' => now()
                    ]);
                }

            }
         }

         // Set is_kegiatan menjadi true untuk data warga yang terkait
            $dataWarga = RumahTangga::find($request->rumah_tangga_id);
            if ($dataWarga) {
                $dataWarga->is_pemanfaatan_lahan = true;
                $dataWarga->is_valid_pemanfaatan_lahan = now();
                $dataWarga->save();
            }

         Alert::success('Berhasil', 'Data berhasil di tambahkan');
         return redirect('/data_pemanfaatan');



        // proses penyimpanan untuk tambah data data kegiatan warga
        // dd($request->all());
        // validasi data


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
    public function edit($id)
    {
        //halaman form edit data pemanfaatan tanah pekarangan
        // $kel = DataKeluarga::all();
        $data_pemanfaatan = DataPemanfaatanPekarangan::with('warga')->find($id);
        // dd($data_pemanfaatan);


        $desas = DB::table('data_desa')
       ->where('id', auth()->user()->id_desa)
       ->get();
       // $kec = DB::table('data_kecamatan')->get();
       $kec = DB::table('data_kecamatan')
       ->where('id', auth()->user()->id_desa)
       ->get();

        $kad = DB::table('users')
            ->where('id', auth()->user()->id)
            ->get();
        $warga = RumahTangga::with('pemanfaatanlahan.rumahtangga','pemanfaatanlahan.pemanfaatan')->find($id);
        $kategoriPemanfaatan  = KategoriPemanfaatanLahan::all();


        return view('kader.data_pemanfaatan_pekarangan.edit', compact('warga','kategoriPemanfaatan','data_pemanfaatan', 'desas', 'kec', 'kad'));

    }

    // public function update(Request $request, $id)
    // {
    //     // dd($id);
    //     $request->validate([
    //         'rumah_tangga_id' => 'required|exists:rumah_tanggas,id',
    //         'periode' => 'required',
    //         'kategori_id' => 'required',

    //     ], [
    //         'rumah_tangga_id.required' => 'Lengkapi Warga Yang Didata',
    //         'kategori_id.required' => 'Pilih Kegiatan',
    //         'periode.required' => 'Pilih Periode',

    //     ]);
    //     if (!isUnique($request->kategori_id)) {
    //         return redirect()
    //             ->back()
    //             ->withErrors(['data' => ' tidak boleh sama']);
    //     }


    //     foreach ($request->kategori_id as $key => $item) {
    //         // dd($item);
    //         if ($item !== null && $item !== '') {
    //             $checkDataAavilable = DataPemanfaatanPekarangan::where('rumah_tangga_id', $request->rumah_tangga_id)->
    //             where('kategori_id', $item)->first();

    //             if(!$checkDataAavilable){
    //                 DataPemanfaatanPekarangan::create([
    //                     'id_desa' =>1,
    //                     'id_kecamatan' =>1 ,
    //                     'rumah_tangga_id' => $request->rumah_tangga_id,
    //                     'kategori_id' => $item,
    //                     'periode' => $request->periode,
    //                 ]);
    //             }

    //         }
    //      }

    //      Alert::success('Berhasil', 'Data berhasil di tambahkan');
    //      return redirect('/data_pemanfaatan');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rumah_tangga_id' => 'required|exists:rumah_tanggas,id',
            'periode' => 'required',
            'kategori_id' => 'required',

        ], [
            'rumah_tangga_id.required' => 'Lengkapi Warga Yang Didata',
            'kategori_id.required' => 'Pilih Kegiatan',
            'periode.required' => 'Pilih Periode',

        ]);

        if (!isUnique($request->kategori_id)) {
            return redirect()
                ->back()
                ->withErrors(['data' => 'nama pemanfaatan tidak boleh sama']);
        }

        $rumah = RumahTangga::find($request->rumah_tangga_id);
        if (!$rumah->is_valid) {
            return redirect()
                ->back()
                ->withErrors(['rumah_tangga_id' => 'Data rumah tangga belum divalidasi.'])
                ->withInput();
        }
        // isi denan tanggal
        $rumah->is_valid_pemanfaatan_lahan = now();
        $rumah->update();

        // Delete existing data for the given rumah_tangga_id and periode
        DataPemanfaatanPekarangan::where('rumah_tangga_id', $request->rumah_tangga_id)
            ->where('periode', $request->periode)
            ->delete();

        // Create new data for each kategori_id value
        foreach ($request->kategori_id as $key => $item) {
            if ($item !== null && $item !== '') {
                $checkDataAavilable = DataPemanfaatanPekarangan::where('rumah_tangga_id', $request->rumah_tangga_id)->
                where('kategori_id', $request->kategori_id)->first();
                if(!$checkDataAavilable){

                DataPemanfaatanPekarangan::create([
                    'id_desa' => 1,
                    'id_kecamatan' => 1,
                    'rumah_tangga_id' => $request->rumah_tangga_id,
                    'kategori_id' => $item,
                    'periode' => $request->periode,
                    'is_valid' => now()
                ]);
            }

            }
        }

        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/data_pemanfaatan');
    }

    /**
     * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $hasKeluarga = DataPemanfaatanPekarangan::find($id);
        $dataKeluarga = RumahTangga::find($hasKeluarga->rumah_tangga_id);
        $rumahTanggaId = $dataKeluarga->id;
        // dd($dataKeluarga);

        if (!$hasKeluarga) {
            abort(404, 'Not Found');
        }

        $hasKeluarga->delete();


        $countPemanfaatan = DataPemanfaatanPekarangan::where('rumah_tangga_id', $rumahTanggaId)->count();

        // $anyKeluargaInRumah = RumahTanggaHasKeluarga::where('rumahtangga_id',$rumahTanggaId)->first();
        if($countPemanfaatan == 0){
            $dataKeluarga->is_pemanfaatan_lahan = false;
            $dataKeluarga->update();


            return redirect()->route('data_pemanfaatan.index');

        }


        return redirect()->route('data_pemanfaatan.edit', ['id' => $rumahTanggaId]);

    }
}

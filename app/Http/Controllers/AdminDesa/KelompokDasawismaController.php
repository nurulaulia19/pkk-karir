<?php

namespace App\Http\Controllers\AdminDesa;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataKecamatan;
use App\Models\DataKelompokDasawisma;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelompokDasawismaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //halaman form data dasawisma
    //     $dasawisma = DataKelompokDasawisma::all();

    //     return view('admin_desa.data_kelompok_dasawisma', compact('dasawisma'));
    // }
    public function index()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the user's ID
        $userId = $user->id;

        // Get the desa ID associated with the user
        $desaId = $user->id_desa;

        // Get all records from DataKelompokDasawisma table where id_desa matches the logged-in user's desa ID
        $dasawisma = DataKelompokDasawisma::where('id_desa', $desaId)->get();
        // dd($dasawisma);

        // Pass the variables to the view
        return view('admin_desa.data_kelompok_dasawisma', compact('dasawisma'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // halaman create dasawisma
        $desa = Data_Desa::all();
        $kec = DataKecamatan::all();
        return view('admin_desa.form.create_dasawisma', compact('desa', 'kec'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     //
    //     $request->validate([
    //         'nama_dasawisma' => 'required',
    //         'alamat_dasawisma' => 'required',
    //         'dusun' => 'required',
    //         'status' => 'required',
    //         'id_desa' => 'required',
    //         'id_kecamatan' => 'required',
    //         'rt' => 'required',
    //         'rw' => 'required'
    //     ], [
    //         'nama_dasawisma.required' => 'Masukkan Nama Dasawisma',
    //         'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
    //         'dusun.required' => 'Masukkan Dusun Dasawisma',
    //         'status.required' => 'Pilih Status',
    //     ]);

    //     $dawis = new DataKelompokDasawisma;
    //     $dawis->nama_dasawisma = $request->nama_dasawisma;
    //     $dawis->alamat_dasawisma = $request->alamat_dasawisma;
    //     $dawis->dusun = $request->dusun;
    //     $dawis->status = $request->status;
    //     $dawis->rt = $request->rt;
    //     $dawis->rw = $request->rw;
    //     $dawis->id_desa = auth()->user()->id_desa;
    //     $dawis->id_kecamatan = auth()->user()->id_kecamatan;
    //     $dawis->periode = $request->periode;


    //     $dawis->save();
    //     // dd($dawis);
    //     Alert::success('Berhasil', 'Data berhasil di tambahkan');

    //     return redirect('/data_dasawisma');
    // }

    public function store(Request $request)
    {
        $request->validate([
            // Validation rules for Dasawisma data
            'nama_dasawisma' => 'required',
            'alamat_dasawisma' => 'required',
            'dusun' => 'required',
            'status' => 'required',
            'rt' => 'required',
            'rw' => 'required',

            // Validation rules for Kader data
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'user_type' => 'required',
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
        ], [
            // Validation messages for Dasawisma data
            'nama_dasawisma.required' => 'Masukkan Nama Dasawisma',
            'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
            'dusun.required' => 'Masukkan Dusun Dasawisma',
            'status.required' => 'Pilih Status',

            // Validation messages for Kader data
            'name.required' => 'Masukkan Nama Pengguna',
            'email.required' => 'Masukkan Email Pengguna',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Masukkan Password Pengguna',
            'user_type.required' => 'Lengkapi Deskripsi Berita yang ingin dipublish',
        ]);

        // Store Dasawisma data
        $dasawisma = new DataKelompokDasawisma;
        $dasawisma->nama_dasawisma = $request->nama_dasawisma;
        $dasawisma->alamat_dasawisma = $request->alamat_dasawisma;
        $dasawisma->dusun = $request->dusun;
        $dasawisma->status = $request->status;
        $dasawisma->rt = $request->rt;
        $dasawisma->rw = $request->rw;
        $dasawisma->id_desa = auth()->user()->id_desa;
        $dasawisma->id_kecamatan = auth()->user()->id_kecamatan;
        $dasawisma->periode = $request->periode;
        $dasawisma->save();

        // Store Kader data
        $kader = new User;
        $kader->name = $request->name;
        $kader->email = $request->email;
        $kader->password = Hash::make($request->password);
        $kader->user_type = $request->user_type;
        $kader->id_desa = auth()->user()->id_desa;
        $kader->id_kecamatan = auth()->user()->id_kecamatan;
        $kader->id_dasawisma = $dasawisma->id; // Assign Dasawisma ID to Kader

        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->storeAs('public/foto', $profileImage); // Store the file
            $kader->foto = 'foto/' . $profileImage; // Save the file path
        }

        // dd($kader->foto);

        $kader->save();

        // Logging in the newly created Kader
        Auth::guard('kader')->login($kader);

        // Redirect with success message
        Alert::success('Berhasil', 'Data berhasil ditambahkan');
        return redirect('/data_kader');
    }

//     public function store(Request $request)
// {
//     $request->validate([
//         // Validation rules for Dasawisma data
//         'nama_dasawisma' => 'required',
//         'alamat_dasawisma' => 'required',
//         'dusun' => 'required',
//         'status' => 'required',
//         'rt' => 'required',
//         'rw' => 'required',

//         // Validation rules for Kader data
//         'name' => 'required',
//         'email' => 'required|unique:users',
//         'password' => 'required|min:8',
//         'user_type' => 'required',
//         'id_desa' => 'required',
//         'id_kecamatan' => 'required',
//     ], [
//         // Validation messages for Dasawisma data
//         'nama_dasawisma.required' => 'Masukkan Nama Dasawisma',
//         'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
//         'dusun.required' => 'Masukkan Dusun Dasawisma',
//         'status.required' => 'Pilih Status',

//         // Validation messages for Kader data
//         'name.required' => 'Masukkan Nama Pengguna',
//         'email.required' => 'Masukkan Email Pengguna',
//         'email.unique' => 'Email sudah digunakan',
//         'password.required' => 'Masukkan Password Pengguna',
//         'user_type.required' => 'Lengkapi Deskripsi Berita yang ingin dipublish',
//     ]);

//     // Store Dasawisma data
//     $dasawisma = new DataKelompokDasawisma;
//     $dasawisma->nama_dasawisma = $request->nama_dasawisma;
//     $dasawisma->alamat_dasawisma = $request->alamat_dasawisma;
//     $dasawisma->dusun = $request->dusun;
//     $dasawisma->status = $request->status;
//     $dasawisma->rt = $request->rt;
//     $dasawisma->rw = $request->rw;
//     $dasawisma->id_desa = auth()->user()->id_desa;
//     $dasawisma->id_kecamatan = auth()->user()->id_kecamatan;
//     $dasawisma->periode = $request->periode;
//     $dasawisma->save();

//     // Store Kader data
//     $kader = new User;
//     $kader->name = $request->name;
//     $kader->email = $request->email;
//     $kader->password = Hash::make($request->password);
//     $kader->user_type = $request->user_type;
//     $kader->id_desa = auth()->user()->id_desa;
//     $kader->id_kecamatan = auth()->user()->id_kecamatan;
//     $kader->id_dasawisma = $dasawisma->id; // Assign Dasawisma ID to Kader

//     if ($request->hasFile('foto')) {
//         $image = $request->file('foto');
//         $profileImage = date('YmdHis') . "_" . uniqid() . "." . $image->getClientOriginalExtension(); // Unique filename
//         $image->storeAs('public/foto', $profileImage); // Store the file
//         $kader->foto = 'foto/' . $profileImage; // Save the file path
//     }

//     $kader->save();

//     // Logging in the newly created Kader
//     Auth::guard('kader')->login($kader);

//     // Redirect with success message
//     Alert::success('Berhasil', 'Data berhasil ditambahkan');
//     return redirect('/data_kader');
// }




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
    public function edit(DataKelompokDasawisma $data_dasawisma)
    {
        //
        return view('admin_desa.form.edit_dasawisma', compact('data_dasawisma'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataKelompokDasawisma $data_dasawisma)
    {
        $request->validate([
            'nama_dasawisma' => 'required',
            'alamat_dasawisma' => 'required',
            'dusun' => 'required',
            'status' => 'required',
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
            'rt' => 'required',
            'rw' => 'required'
        ], [
            'nama_dasawisma.required' => 'Masukkan Nama Dasawisma',
            'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
            'dusun.required' => 'Masukkan Dusun Dasawisma',
            'status.required' => 'Pilih Status',
        ]);

        $data_dasawisma->nama_dasawisma = $request->nama_dasawisma;
        $data_dasawisma->alamat_dasawisma = $request->alamat_dasawisma;
        $data_dasawisma->dusun = $request->dusun;
        $data_dasawisma->rt = $request->rt;
        $data_dasawisma->rw = $request->rw;
        $data_dasawisma->status = $request->status;
        $data_dasawisma->id_desa = auth()->user()->id_desa;
        $data_dasawisma->id_kecamatan = auth()->user()->id_kecamatan;

        $data_dasawisma->update();
        Alert::success('Berhasil', 'Data berhasil di Ubah');

        return redirect('/data_dasawisma');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($data_dasawisma, DataKelompokDasawisma $dawis)
    {
        //temukan id dawis
        $dawis::find($data_dasawisma)->delete();
        Alert::success('Berhasil', 'Data berhasil di Hapus');

        return redirect('/data_dasawisma')->with('status', 'sukses');
    }
}

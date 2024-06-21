<?php

namespace App\Http\Controllers\AdminDesa;
use App\Http\Controllers\Controller;
use App\Models\Data_Desa;
use App\Models\DataKecamatan;
use App\Models\Rw;
use App\Models\Dusun;
use App\Models\Rt;
use App\Models\DataKelompokDasawisma;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Periode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelompokDasawismaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $desaId = $user->id_desa;

        $query = DataKelompokDasawisma::where('id_desa', $desaId)->with(['rw', 'rt', 'dusunData','kader']);

        if ($request->has('periode')) {
            $periode = $request->input('periode');
            $query->where('periode', '=', $periode); // Sesuaikan dengan kolom periode_id pada tabel DataKelompokDasawisma
        }

        $dasawisma = $query->get();
        $periodes = Periode::all(); // Mengambil semua data periode

        return view('admin_desa.dasawisma.index', compact('dasawisma', 'periodes'));
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
        $user = Auth::user();
        $rws = Rw::where('desa_id', $user->id_desa)->get();
        // $dusun = Dusun::where('desa_id',Auth::user()->id_desa)->get();
        // dd(Auth::user()->id_desa);
        return view('admin_desa.dasawisma.create', compact('desa', 'kec','rws'));
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
        // $request->validate([
        //     // Validation rules for Dasawisma data
        //     'nama_dasawisma' => 'required',
        //     'alamat_dasawisma' => 'required',
        //     'dusun' => 'required',
        //     'status' => 'required',
        //     'id_rt' => 'required',
        //     'id_rw' => 'required',

        //     // Validation rules for Kader data
        //     'name' => 'required',
        //     'email' => 'required|unique:users',
        //     'password' => 'required|min:8',
        //     'user_type' => 'required',
        //     'id_desa' => 'required',
        //     'id_kecamatan' => 'required',
        // ], [
        //     // Validation messages for Dasawisma data
        //     'nama_dasawisma.required' => 'Masukkan Nama Dasawisma',
        //     'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
        //     'dusun.required' => 'Masukkan Dusun Dasawisma',
        //     'status.required' => 'Pilih Status',

        //     // Validation messages for Kader data
        //     'name.required' => 'Masukkan Nama Pengguna',
        //     'email.required' => 'Masukkan Email Pengguna',
        //     'email.unique' => 'Email sudah digunakan',
        //     'password.required' => 'Masukkan Password Pengguna',
        //     'user_type.required' => 'Lengkapi Deskripsi Berita yang ingin dipublish',
        // ]);
        $request->validate([
            // Validation rules for Dasawisma data
            'nama_dasawisma' => 'required|unique:data_dasawisma',
            'alamat_dasawisma' => 'required',
            // 'dusun' => 'required',
            'status' => 'required',
            'id_rt' => 'required',
            'id_rw' => 'required',

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
            'nama_dasawisma.unique' => 'Nama Dasawisma sudah ada, harap isi nama yang lain',
            'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
            // 'dusun.required' => 'Masukkan Dusun Dasawisma',
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
        // $dasawisma->dusun = $request->dusun;
        $dasawisma->status = $request->status;
        $dasawisma->id_rt = $request->id_rt;
        $dasawisma->id_rw = $request->id_rw;
        $dasawisma->id_desa = auth()->user()->id_desa;
        $dasawisma->id_kecamatan = auth()->user()->id_kecamatan;
        $dasawisma->periode = $request->periode;
        $dasawisma->save();
        // dd($dasawisma);

        // Store Kader data
        $kader = new User;
        $kader->name = $request->name;
        $kader->email = $request->email;
        $kader->password = Hash::make($request->password);
        $kader->user_type = $request->user_type;
        $kader->id_desa = auth()->user()->id_desa;
        $kader->id_kecamatan = auth()->user()->id_kecamatan;
        $kader->id_dasawisma = $dasawisma->id; // Assign Dasawisma ID to Kader
        $kader->save();
        // dd($kader);

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
        return redirect('/data_dasawisma');
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
    // public function edit(DataKelompokDasawisma $data_dasawisma)
    // {
    //     //
    //     return view('admin_desa.form.edit_dasawisma', compact('data_dasawisma'));

    // }

    public function edit(DataKelompokDasawisma $data_dasawisma)
    {
        // Ambil data kader yang terkait dengan Data Kelompok Dasawisma
        $kader = User::where('id_dasawisma', $data_dasawisma->id)->first();
        $rws = Rw::all();
        $rts = Rt::all();
        // $dusun = Dusun::where('desa_id',Auth::user()->id_desa)->get();

        // Kirim kedua data tersebut ke tampilan untuk diedit
        return view('admin_desa.dasawisma.edit', compact('data_dasawisma', 'kader','rws','rts'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, DataKelompokDasawisma $data_dasawisma)
    // {
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

    //     $data_dasawisma->nama_dasawisma = $request->nama_dasawisma;
    //     $data_dasawisma->alamat_dasawisma = $request->alamat_dasawisma;
    //     $data_dasawisma->dusun = $request->dusun;
    //     $data_dasawisma->rt = $request->rt;
    //     $data_dasawisma->rw = $request->rw;
    //     $data_dasawisma->status = $request->status;
    //     $data_dasawisma->id_desa = auth()->user()->id_desa;
    //     $data_dasawisma->id_kecamatan = auth()->user()->id_kecamatan;

    //     $data_dasawisma->update();
    //     Alert::success('Berhasil', 'Data berhasil di Ubah');

    //     return redirect('/data_dasawisma');
    // }

    public function update(Request $request, DataKelompokDasawisma $data_dasawisma)
    {
        $kader = User::where('id_dasawisma', $data_dasawisma->id)->first();
        // dd($kader);


        $request->validate([
            // Aturan validasi untuk Dasawisma data
            'nama_dasawisma' =>  [
                'required',
                Rule::unique('data_dasawisma')->ignore($data_dasawisma),
            ],
            'alamat_dasawisma' => 'required',
            // 'dusun' => 'required',
            'status' => 'required',
            'id_rt' => 'required',
            'id_rw' => 'required',

            // Aturan validasi untuk data Kader
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($kader->id),
            ],
            'password' => 'nullable|min:8',
            'user_type' => 'required',
            'id_desa' => 'required',
            'id_kecamatan' => 'required',
        ], [
            // Pesan validasi untuk Dasawisma data
            'nama_dasawisma.required' => 'Masukkan Nama Dasawisma',
            'nama_dasawisma.unique' => 'Nama Dasawisma sudah ada, harap isi nama yang lain',
            'alamat_dasawisma.required' => 'Masukkan Alamat Dasawisma',
            // 'dusun.required' => 'Masukkan Dusun Dasawisma',
            'status.required' => 'Pilih Status',

            // Pesan validasi untuk data Kader
            'name.required' => 'Masukkan Nama Pengguna',
            'email.required' => 'Masukkan Email Pengguna',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal harus 8 karakter',
            'user_type.required' => 'Lengkapi Deskripsi Berita yang ingin dipublish',
        ]);

        // Lakukan pembaruan Data Dasawisma
        $data_dasawisma->update([
            'nama_dasawisma' => $request->nama_dasawisma,
            'alamat_dasawisma' => $request->alamat_dasawisma,
            // 'dusun' => $request->dusun,
            'status' => $request->status,
            'id_rt' => $request->id_rt,
            'id_rw' => $request->id_rw,
            'periode' => $request->periode,
        ]);

        // Lakukan pembaruan data Kader
        $kader->update([
            'name' => $request->name,
            'user_type' => $request->user_type,
            'id_desa' => Auth::user()->id_desa,
            'id_kecamatan' => Auth::user()->id_kecamatan,
        ]);
        // dd($kader);

         // Jika email diisi dan berbeda dengan email yang ada, lakukan pembaruan email Kader
        if ($request->filled('email') && $request->email !== $kader->email) {
            $kader->update([
                'email' => $request->email,
            ]);
        }

        // Jika password diisi, lakukan pembaruan password Kader
        if ($request->filled('password')) {
            $kader->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Jika ada file foto yang diunggah, lakukan pembaruan foto Kader
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->storeAs('public/foto', $profileImage); // Simpan file
            $kader->update([
                'foto' => 'foto/' . $profileImage, // Simpan jalur file
            ]);
        }

        // Redirect dengan pesan keberhasilan
        Alert::success('Berhasil', 'Data berhasil diperbarui');
        return redirect('/data_dasawisma');
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($data_dasawisma, DataKelompokDasawisma $dawis)
    // {
    //     //temukan id dawis
    //     $dawis::find($data_dasawisma)->delete();
    //     Alert::success('Berhasil', 'Data berhasil di Hapus');

    //     return redirect('/data_dasawisma')->with('status', 'sukses');
    // }

    public function destroy($data_dasawisma, DataKelompokDasawisma $dawis)
    {
        // Temukan data dasawisma
        $dasawisma = $dawis->findOrFail($data_dasawisma);

        // Temukan pengguna yang terkait dengan data dasawisma
        $kader = User::where('id_dasawisma', $dasawisma->id)->first();

        // Hapus pengguna jika ditemukan
        if ($kader) {
            $kader->delete();
        }

        // Hapus data dasawisma
        $dasawisma->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect('/data_dasawisma')->with('status', 'sukses');
    }

}

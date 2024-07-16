<?php

namespace App\Http\Controllers\AdminKab;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class DataProfilController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();
        // dd($profiles);
        return view('admin_kab.data_profil.index', compact('profiles'));
    }

    public function create()
    {
        return view('admin_kab.data_profil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'masa_jabatan_mulai' => 'required',
            'masa_jabatan_akhir' => 'required',
            'jabatan' => 'required',
            'riwayat_pendidikan' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // $profile->save();
        $profile = new Profile();
        $profile->nama_lengkap = $request->nama_lengkap;
        $profile->tempat_lahir = $request->tempat_lahir;
        $profile->tanggal_lahir = $request->tanggal_lahir;
        $profile->masa_jabatan_mulai = $request->masa_jabatan_mulai;
        $profile->masa_jabatan_akhir = $request->masa_jabatan_akhir;
        $profile->jabatan = $request->jabatan;

        // Menyimpan riwayat pendidikan jika ada
        if ($request->has('riwayat_pendidikan')) {
            $profile->riwayat_pendidikan = implode(', ', $request->riwayat_pendidikan);
        }

        // Menyimpan riwayat pekerjaan jika ada
        if ($request->has('riwayat_pekerjaan')) {
            $profile->riwayat_pekerjaan = implode(', ', $request->riwayat_pekerjaan);
        }
        if ($request->hasFile('foto')) {
            $destinationPath = 'foto/';
            $image = $request->file('foto');
            $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/' . $destinationPath, $profileImage); // Simpan file dengan nama unik
            $profile->foto = $destinationPath . $profileImage; // Simpan path foto ke database
        }
        $profile->save();

        // return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
        Alert::success('Berhasil', 'Data berhasil di tambahkan');
        return redirect('/profile-pembina-ketua');
    }

    public function edit($id)
    {
        $profile = Profile::find($id);
        if (!$profile) {
            return redirect()->back()->with('error', 'Profil tidak ditemukan.');
        }
        return view('admin_kab.data_profil.edit', compact('profile'));
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_lengkap' => 'required',
    //         'tanggal_lahir' => 'required|date',
    //         'masa_jabatan' => 'required',
    //         'riwayat_pendidikan' => 'required',
    //         'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $profile = Profile::find($id);
    //     $profile->nama_lengkap = $request->nama_lengkap;
    //     $profile->tanggal_lahir = $request->tanggal_lahir;
    //     $profile->masa_jabatan = $request->masa_jabatan;
    //     $profile->riwayat_pendidikan = $request->riwayat_pendidikan;
    //     $profile->riwayat_pekerjaan = $request->riwayat_pekerjaan;

    //     if ($request->hasFile('foto')) {
    //         if ($profile->foto && Storage::disk('public')->exists($profile->foto)) {
    //             Storage::disk('public')->delete($profile->foto);
    //         }
    //         $image = $request->file('foto');
    //         $profileImage = Str::random(5) . date('YmdHis') . '.' . $image->getClientOriginalExtension();
    //         $path = $image->storeAs('public/foto', $profileImage);
    //         $profile->foto = $path;
    //     }

    //     DB::table('profiles') // Ganti 'profiles' dengan nama tabel yang sesuai jika berbeda
    //         ->where('id', $profile->id)
    //         ->update([
    //             'nama_lengkap' => $profile->nama_lengkap,
    //             'tanggal_lahir' => $profile->tanggal_lahir,
    //             'masa_jabatan' => $profile->masa_jabatan,
    //             'riwayat_pendidikan' => $profile->riwayat_pendidikan,
    //             'riwayat_pekerjaan' => $profile->riwayat_pekerjaan,
    //             'foto' => $profile->foto,
    //         ]);

    //     Alert::success('Berhasil', 'Data berhasil di ubah');
    //     return redirect('/profile-pembina-ketua');
    // }
    public function update(Request $request, $id)
{
    $request->validate([
        'nama_lengkap' => 'required',
        'tanggal_lahir' => 'required|date',
        'tempat_lahir' => 'required',
        'masa_jabatan_mulai' => 'required',
        'masa_jabatan_akhir' => 'required',
        'jabatan' => 'required',
        'riwayat_pendidikan' => 'required',
        'foto' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $profile = Profile::find($id);

    if (!$profile) {
        return redirect()->back()->with('error', 'Profil tidak ditemukan.');
    }

    $profile->nama_lengkap = $request->nama_lengkap;
    $profile->tanggal_lahir = $request->tanggal_lahir;
    $profile->tempat_lahir = $request->tempat_lahir;
    $profile->masa_jabatan_mulai = $request->masa_jabatan_mulai;
    $profile->masa_jabatan_akhir = $request->masa_jabatan_akhir;
    $profile->jabatan = $request->jabatan;

    // Menyimpan riwayat pendidikan jika ada
    if ($request->has('riwayat_pendidikan')) {
        $profile->riwayat_pendidikan = implode(', ', $request->riwayat_pendidikan);
    }

    // Menyimpan riwayat pekerjaan jika ada
    if ($request->has('riwayat_pekerjaan')) {
        $profile->riwayat_pekerjaan = implode(', ', $request->riwayat_pekerjaan);
    }

    // Mengupdate foto jika ada perubahan
    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($profile->foto) {
            Storage::delete('public/' . $profile->foto);
        }

        // Upload foto baru
        $destinationPath = 'foto/';
        $image = $request->file('foto');
        $profileImage = date('YmdHis') . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/' . $destinationPath, $profileImage); // Simpan file dengan nama unik
        $profile->foto = $destinationPath . $profileImage; // Simpan path foto ke database
    }

    $profile->save();

    Alert::success('Berhasil', 'Data berhasil di ubah');
    return redirect('/profile-pembina-ketua');
}

    public function destroy($id)
    {
        $profile = Profile::find($id);
        // dd( $profile);

        if (!$profile) {
            return redirect()->back()->with('error', 'Profil tidak ditemukan.');
        }

        // Hapus foto dari storage jika ada
        if ($profile->foto) {
            Storage::delete('public/' . $profile->foto);
        }

        $profile->delete();

        Alert::success('Berhasil', 'Data berhasil di hapus');
        return redirect('/profile-pembina-ketua');
    }
}

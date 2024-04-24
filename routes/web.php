<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\PokjaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDesa\KaderController;
use App\Http\Controllers\AdminDesa\KategoriKegiatanController;
use App\Http\Controllers\AdminDesa\KelompokDasawismaController;
use App\Http\Controllers\AdminDesa\KeteranganKegiatanController;
use App\Http\Controllers\AdminKab\BeritaController;
use App\Http\Controllers\AdminKab\DataAgendaKegiatanController;
use App\Http\Controllers\AdminKab\DataDesaController;
use App\Http\Controllers\AdminKab\DataGaleriController;
use App\Http\Controllers\AdminKab\DataKecamatanController;
use App\Http\Controllers\AdminKab\DataKabupatenController;
use App\Http\Controllers\AdminKab\DataProvinsiController;
use App\Http\Controllers\AdminKab\UserController;
use App\Http\Controllers\AdminKabController;
use App\Http\Controllers\AdminKec\DesaController;
use App\Http\Controllers\AdminKecController;
use App\Http\Controllers\DashboardSuperController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaderFormController;
use App\Http\Controllers\PendataanKader\DataIndustriRumahController;
use App\Http\Controllers\PendataanKader\DataKaderGabungController;
use App\Http\Controllers\PendataanKader\DataKegiatanWargaController;
use App\Http\Controllers\PendataanKader\DataKeluargaController;
use App\Http\Controllers\PendataanKader\DataPelatihanKaderController;
use App\Http\Controllers\PendataanKader\DataPemanfaatanPekaranganController;
use App\Http\Controllers\PendataanKader\DataWargaController;
use App\Http\Controllers\SuperAdmin\DataPokja1\GotongRoyongSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja1\JumlahKaderPokja1SuperController;
use App\Http\Controllers\SuperAdmin\DataPokja1\PenghayatanDanPengamalanSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja2\KehidupanBerkoperasiSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja2\PendidikanSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja3\JumlahIndustriRumahTanggaSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja3\JumlahKaderPokja3SuperController;
use App\Http\Controllers\SuperAdmin\DataPokja3\JumlahRumahSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja3\PanganSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja4\JumlahKaderPokja4SuperController;
use App\Http\Controllers\SuperAdmin\DataPokja4\KelestarianLingkunganHidupSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja4\KesehatanPosyanduSuperController;
use App\Http\Controllers\SuperAdmin\DataPokja4\PerencanaanSehatSuperController;
use App\Http\Controllers\SuperAdmin\DataUmum\JumlahDataUmumSuperController;
use App\Http\Controllers\SuperAdmin\DataUmum\JumlahJiwaDataUmumSuperController;
use App\Http\Controllers\SuperAdmin\DataUmum\JumlahKaderDataUmumSuperController;
use App\Http\Controllers\SuperAdmin\DataUmum\JumlahKelompokUmumSuperController;
use App\Http\Controllers\SuperAdmin\DataUmum\JumlahTenagaSekretariatDataUmumSuperController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Middleware\Authenticate;
use App\Models\BeritaKab;
use App\Models\Data_Desa;
use App\Models\DataGaleri;
use App\Models\KeteranganKegiatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\KeluargaHasWargaController;
use App\Http\Controllers\PendataanKader\RumahTanggaController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\RwController;

// use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// halaman main
// Route::get('/', [MainController::class, 'home']);
Route::get('/', function () {
    $berita = BeritaKab::all();
    $galeris = DataGaleri::all();
    return view('main.home', ['berita'=>$berita], ['galeris'=>$galeris]);
});

Route::get('/sejarah', [MainController::class, 'sejarah']);
Route::get('/program', [MainController::class, 'program_pkk']);
Route::get('/visi', [MainController::class, 'visi']);
Route::get('/arti', [MainController::class, 'arti']);
Route::get('/profil_main', [MainController::class, 'profil']);
Route::get('/struktur', [MainController::class, 'bagan_struktur_kel']);
Route::get('/pkk', [MainController::class, 'bagan_struktur_pkk']);
Route::get('/baganmekel', [MainController::class, 'bagan_mekanis_kel']);
Route::get('/baganmekpkk', [MainController::class, 'bagan_mekanis_pkk']);
Route::get('/berita/{id}', [MainController::class, 'berita']);
Route::get('/allberita', [MainController::class, 'allberita']);
Route::get('/allgaleri', [MainController::class, 'galeri']);
Route::get('/about', [MainController::class, 'about']);
Route::get('/agenda', [MainController::class, 'agenda']);
Route::get('/data-logs', [MainController::class, 'dataLogs']);

// halaman pokja
Route::get('/pokja1', [PokjaController::class, 'pokja1']);
// Route::get('/papan1', [PokjaController::class, 'papan1']);
Route::get('/pokja2', [PokjaController::class, 'pokja2']);
// Route::get('/papan2', [PokjaController::class, 'papan2']);
Route::get('/pokja3', [PokjaController::class, 'pokja3']);
// Route::get('/papan3', [PokjaController::class, 'papan3']);
Route::get('/pokja4', [PokjaController::class, 'pokja4']);
// Route::get('/papan4', [PokjaController::class, 'papan4']);
Route::get('/sekretariat', [PokjaController::class, 'sekretariat']);
// Route::get('/data_umum', [PokjaController::class, 'data_umum']);

// halaman admin desa
// Route::get('/admin_desa/login', [AdminController::class, 'login'])->name('admin_desa.login');
// Route::post('/admin_desa/login', [AdminController::class, 'loginPost']);
Route::post('/admin_desa/logout', [AdminController::class, 'logoutPost'])->name('admin_desa.logout');
Route::middleware(['user_type:admin_desa'])->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin_desa.dashboard');
    Route::resource('rw', RwController::class);
    Route::resource('rt', RtController::class);

    // data kelompok dasa wisma
    Route::get('/data_kelompok_dasa_wisma', [AdminController::class, 'data_kelompok_dasa_wisma']);

    // rekap kelompok dasa wisma
    // excel
    Route::get('/rekap_kelompok_dasa_wisma/{id}', [AdminController::class, 'rekap_kelompok_dasa_wisma']);
    Route::get('/export_rekap_dasawisma/{id}', [AdminController::class, 'export_rekap_dasawisma']);

    // data kelompok pkk rt
    Route::get('/data_kelompok_pkk_rt', [AdminController::class, 'data_rw'])->name('data_rw');

    // rekap kelompok pkk rt
    Route::get('/rekap_kelompok_pkk_rt/{id}', [AdminController::class, 'rekap_kelompok_pkk_rt']);
    Route::get('/rekap_kelompok_pkk_rt/rw/{id}', [AdminController::class, 'data_rt']);
    Route::get('/export_rekap_rt/{id}', [AdminController::class, 'export_rekap_rt']);

    // data kelompok pkk rw
    Route::get('/data_kelompok_pkk_rw', [AdminController::class, 'data_kelompok_pkk_rw']);

    // rekap kelompok pkk rw
    Route::get('/rekap_kelompok_pkk_rw/{id}', [AdminController::class, 'rekap_kelompok_pkk_rw']);
    Route::get('/export_rekap_rw/{id}', [AdminController::class, 'export_rekap_rw']);

    // data kelompok pkk dusun
    Route::get('/data_kelompok_pkk_dusun', [AdminController::class, 'data_kelompok_pkk_dusun']);

    // rekap kelompok dusun
    Route::get('/rekap_kelompok_pkk_dusun', [AdminController::class, 'rekap_kelompok_pkk_dusun']);
    Route::get('/export_rekap_dusun', [AdminController::class, 'export_rekap_dusun']);

    // data kelompok pkk desa
    Route::get('/data_kelompok_pkk_desa', [AdminController::class, 'data_kelompok_pkk_desa']);

    // rekap kelompok desa
    Route::get('/rekap_pkk_desa/{id}', [AdminController::class, 'rekap_pkk_desa']);
    Route::get('/export_rekap_desa/{id}', [AdminController::class, 'export_rekap_desa']);

    // akun kader desa
    Route::post('/data_kader/update/{id}/password', [KaderController::class, 'update_password']);
    Route::resource('/data_kader', KaderController::class);
    Route::resource('/data_dasawisma', KelompokDasawismaController::class);

    // form kategori kegiatan
    Route::resource('/kategori_kegiatan', KategoriKegiatanController::class);
    Route::resource('/keterangan_kegiatan', KeteranganKegiatanController::class);

    // form data kategori pendataan kader
    // Route::resource('/kategori_industri', KategoriIndustriRumahController::class);
    // Route::resource('/kategori_pemanfaatan', KategoriPemanfaatanLahanController::class);

    // profil admin desa
    Route::get('/profil_admin_desa', [AdminController::class, 'profilAdminDesa'])->name('profil_adminDesa');
    Route::post('/profil_admin_desa/update/{id}', [AdminController::class, 'update_profilAdminDesa'])->name('update_profil_admin_desa');
    Route::post('/profil_admin_desa/update/{id}/password', [AdminController::class, 'update_passwordAdminDesa'])->name('update_password_admin_desa');


});


// halaman admin kab
// Route::get('/admin_kabupaten/login', [AdminKabController::class, 'login'])->name('admin_kabupaten.login');
// Route::post('/admin_kabupaten/login', [AdminKabController::class, 'loginPost']);
Route::post('/admin_kabupaten/logout', [AdminKabController::class, 'logoutPost'])->name('admin_kabupaten.logout');
Route::middleware(['user_type:admin_kabupaten'])->group(function(){
    Route::get('/dashboard_kab', [AdminKabController::class, 'dashboard_kab'])->name('admin_kabupaten.dashboard');

    Route::get('/data_kelompok_pkk_kec', [AdminKabController::class, 'data_kelompok_pkk_kec']);
    Route::get('/rekap_pkk_kec/{id}', [AdminKabController::class, 'rekap_pkk_kec']);
    Route::get('/export_rekap_kec/{id}', [AdminKabController::class, 'export_rekap_kec']);

    Route::get('/data_kelompok_pkk_kab', [AdminKabController::class, 'data_kelompok_pkk_kab']);
    Route::get('/rekap_pkk_kab', [AdminKabController::class, 'rekap_pkk_kab']);
    Route::get('/export_rekap_kab', [AdminKabController::class, 'export_rekap_kab']);

    //form berita admin kabupaten
    Route::resource('/beritaKab', BeritaController::class);
    Route::resource('/galeriKeg', DataGaleriController::class);
    Route::resource('/agendaKeg', DataAgendaKegiatanController::class);
    Route::resource('/data_desa', DataDesaController::class);
    Route::resource('/data_kecamatan', DataKecamatanController::class);

    Route::post('/data_pengguna_super/update/{id}/password', [UserController::class, 'update_password']);
    Route::resource('/data_pengguna_super', UserController::class);

    // mengambil nama desa
    Route::get('getDesa/{id}', function ($id) {
        $desas = Data_Desa::where('id_kecamatan',$id)->get();
        // dd($desas);
        return response()->json($desas);
    });

    // profil admin kabupaten
    Route::get('/profil_admin_kabupaten', [AdminKabController::class, 'profilAdminKabupaten'])->name('profil_adminKabupaten');
    Route::post('/profil_admin_kabupaten/update/{id}', [AdminKabController::class, 'update_profilAdminKabupaten'])->name('update_profil_admin_kabupaten');
    Route::post('/profil_admin_kabupaten/update/{id}/password', [AdminKabController::class, 'update_passwordAdminKabupaten'])->name('update_password_admin_kabupaten');

    // Route untuk menampilkan data kabupaten
    // Route::get('/data_kabupaten', [DataKabupatenController::class, 'index'])->name('kabupaten.index');
    Route::resource('/data_kabupaten', DataKabupatenController::class);
    Route::resource('/data_provinsi', DataProvinsiController::class);
});

// halaman admin kecamatan
Route::middleware(['user_type:admin_kecamatan'])->group(function(){
    Route::get('/dashboard_kec', [DesaController::class, 'dashboard_kec'])->name('admin_kecamatan.dashboard');
    Route::get('/dashboard_kec/desa', [DesaController::class, 'desa'])->name('dashboard_kec.desa');
    Route::get('/dashboard_kec/rekapitulasi-desa/{id}', [DesaController::class, 'rekapitulasi'])->name('dashboard_kec.rekapitulasi');
    Route::get('/rekap_desa/{id}', [DesaController::class, 'rekap_desa'])->name('rekap_desa');
    Route::get('/export_rekap_desa/kecamatan/{id}', [DesaController::class, 'export'])->name('export_rekap_desa_kecamatan');
     // profil admin kecamatan
    Route::get('/profil_admin_kecamatan', [DesaController::class, 'profilAdminKec'])->name('profil_adminKec');
    Route::post('/profil_admin_kecamatan/update/{id}', [DesaController::class, 'update_profilAdminKec'])->name('update_profil_admin_kec');
    Route::post('/profil_admin_kecamatan/update/{id}/password', [DesaController::class, 'update_passwordAdminKec'])->name('update_password_admin_kec');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/super_admin', [App\Http\Controllers\HomeController::class, 'super'])->name('super_admin');

// Route::get('/super_admin', [DashboardSuperController::class, 'index'])->name('super_admin');

//  halaman kader desa
// Route::get('/kader_dasawisma/login', [KaderFormController::class, 'login'])->name('kader_dasawisma.login');
// Route::post('/kader_dasawisma/login', [KaderFormController::class, 'loginPost']);
Route::post('/kader_dasawisma/logout', [KaderFormController::class, 'logoutPost'])->name('kader_dasawisma.logout');
Route::middleware(['user_type:kader_dasawisma'])->group(function(){
        Route::get('/dashboard_kader', [KaderFormController::class, 'dashboard_kader'])->name('kader_dasawisma.dashboard');

        Route::get('getKeterangan/{id}', function ($id) {
            // $keterangan = KeteranganKegiatan::where('id_kegiatan',$id)->get();
            // dd($keterangan);
            $keterangan = "masgatgntng";
            return response()->json($keterangan);
        });


    // form data pendataan kader
    Route::resource('/data_warga', DataWargaController::class);
    Route::get('/warga', [DataWargaController::class,'warga']);
    Route::resource('/data_kegiatan', DataKegiatanWargaController::class)->except([
        'update','destroy'
    ]);
    Route::put('data_kegiatan/{id}/update', [DataKegiatanWargaController::class, 'update'])->name('data_kegiatan.updated');
    Route::delete('data_kegiatan/{id}/deleted', [DataKegiatanWargaController::class, 'destroy'])->name('data_kegiatan.destroyed');

    Route::get('/data_kegiatan/{id}/desa', [DataKegiatanWargaController::class, 'kegiatanDesa'])->name('kegiatanInDesa');

    Route::get('/kegiatan/{id}/details', [DataKegiatanWargaController::class, 'detailKegiatan'])->name('detailKegiatanInDesa');

    Route::get('/data_kegiatan_warga/{id}/data_kegiatan', [DataKegiatanWargaController::class,'deleteKegiatanWarga'])->name('data-kegiatan-warga-delete');

    Route::get('/data_keluarga/{id}/detail', [DataKeluargaController::class,'detail'])->name('keluarga-detail');
    Route::get('/data_keluarga/{id}/delete-warga', [DataKeluargaController::class,'deleteWargaInKeluarga'])->name('keluarga-delete-warga');



    Route::resource('/data_keluarga', DataKeluargaController::class);
    Route::resource('/data_rumah_tangga', RumahTanggaController::class);
    Route::get('/data_rumah_tangga/{id}/data_keluarga', [RumahTanggaController::class,'deleteKeluargaInRT'])->name('rumah-delete-keluarga');

    Route::get('/keluarga', [RumahTanggaController::class,'keluarga']);

    Route::resource('/data_pemanfaatan', DataPemanfaatanPekaranganController::class);
    Route::resource('/data_industri', DataIndustriRumahController::class);
    Route::resource('/data_pelatihan', DataPelatihanKaderController::class);
    Route::resource('/data_gabung', DataKaderGabungController::class);
    // Route::get('/rekap', [KaderFormController::class, 'rekap']);
    Route::get('/catatan_keluarga', [KaderFormController::class, 'catatan_keluarga']);

    // rekap anggota keluarga
    Route::get('/rekap_data_warga/{id}/rekap_data_warga', [KaderFormController::class, 'rekap_data_warga']);

    //print rekap anggota keluarga
    // Route::get('/print/{id}', [KaderFormController::class, 'print']);
    // Route::get('/print_pdf/{id}', [KaderFormController::class, 'print_pdf']);
    Route::get('/print_pdf/{id}',  [KaderFormController::class, 'printPDF'])->name('print.pdf');


    //print rekap anggota keluarga
    // Route::get('/print_cakel/{id}', [KaderFormController::class, 'print_cakel']);
    Route::get('/print_pdf_cakel/{id}', [KaderFormController::class, 'print_pdf_cakel']);
    Route::get('/print_excel_cakel/{id}', [KaderFormController::class, 'print_excel_cakel'])->name('print.excel');


    // rekap catatan keluarga
    Route::get('/catatan_keluarga/{id}/catatan_keluarga', [KaderFormController::class, 'catatan_keluarga']);

    // profil kader
    Route::get('/profil', [KaderFormController::class, 'profil']);
    Route::post('/profil/update/{id}', [KaderFormController::class, 'update_profil']);
    Route::post('/profil/update/{id}/password', [KaderFormController::class, 'update_password']);


    // Forgot Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    // routes/web.php

    // Route::get('/get-rt-by-rw', [RtController::class, 'getRTByRW'])->name('get.rt.by.rw');
    // Route::get('/rw/{id}', [RwController::class, 'show'])->name('rw.show');


// Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password');
// Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');




});

Route::get('/get-rt-by-rw', [RtController::class, 'getRTByRW'])->name('get.rt.by.rw');
Route::get('/rw/{id}', [RwController::class, 'show'])->name('rw.show');
Route::get('/keluarga_has_warga', [KeluargaHasWargaController::class, 'getDataKeluargaHasWarga']);

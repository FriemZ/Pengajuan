<?php

use App\Models\Pengajuan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\DokumenSuratController;
use App\Http\Controllers\PengajuanDetailController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/check-name', [AuthController::class, 'checkName'])->name('check-name');
Route::post('/check-password', [AuthController::class, 'checkPassword'])->name('check-password');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['web', 'auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('admin/dashboard', [DashboardController::class, 'index']);

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/jurusans', [JurusanController::class, 'index'])->name('jurusans.index');
    Route::post('/jurusans', [JurusanController::class, 'store'])->name('jurusans.store');
    Route::put('/jurusans/{id}', [JurusanController::class, 'update'])->name('jurusans.update');
    Route::delete('/jurusans/{id}', [JurusanController::class, 'destroy'])->name('jurusans.destroy');

    Route::get('/job', [JobController::class, 'index'])->name('job.index');
    Route::post('/job', [JobController::class, 'store'])->name('jobs.store');
    Route::put('/job/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/job/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/mahasiswas', [MahasiswaController::class, 'index'])->name('mahasiswas.index');
    Route::post('/mahasiswas', [MahasiswaController::class, 'store'])->name('mahasiswas.store');
    Route::put('/mahasiswas/{id}', [MahasiswaController::class, 'update'])->name('mahasiswas.update');
    Route::delete('/mahasiswas/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswas.destroy');

    Route::get('/rekapitulasiM', [PengajuanController::class, 'rekapMagang'])->name('rekapitulasi.rekapMagang');
    Route::get('/rekapitulasiS', [PengajuanController::class, 'rekapSkripsi'])->name('rekapitulasi.rekapSkripsi');
    Route::get('/download-surat/{filename}', [PengajuanController::class, 'downloadSurat'])->name('surat.download');

    Route::post('/surat/{pengajuanId}', [PengajuanController::class, 'buatSurat'])->name('buatSurat');
    
    Route::get('/dosens', [DosenController::class, 'index'])->name('dosens.index');
    Route::post('/dosens', [DosenController::class, 'store'])->name('dosens.store');
    Route::put('/dosens/{id}', [DosenController::class, 'update'])->name('dosens.update');
    Route::delete('/dosens/{id}', [DosenController::class, 'destroy'])->name('dosens.destroy');
    // Route untuk menetapkan koordinator
    Route::post('/koordinator/store', [DosenController::class, 'setKoordinator'])->name('koordinator.store');
    Route::post('/koordinator/hapus', [DosenController::class, 'hapusKoordinator'])->name('koordinator.hapus');

    Route::get('/verifikasi', [PengajuanController::class, 'indexVerifikasi'])->name('verifikasi');
    Route::post('/pengajuan/{id}/setuju', [PengajuanController::class, 'buatSurat'])->name('buatSurat');
    Route::put('/pengajuan/{id}/tolak', [PengajuanController::class, 'tolakPengajuan'])->name('tolakPengajuan');
    Route::put('/pengajuan/{id}/disetujui', [PengajuanController::class, 'setujuPengajuan'])->name('setujuPengajuan');
    Route::put('/pengajuan/set-dosen/{id}', [PengajuanController::class, 'setDosen'])->name('pengajuan.setDosen');
});
Route::middleware(['web', 'auth', RoleMiddleware::class . ':dosen'])->group(function () {
    Route::get('dosen/dashboard', [DashboardController::class, 'index']);
    Route::put('/dosen/{id}/update-ttd', [DashboardController::class, 'updateTtd'])->name('dosen.updateTtd');
    Route::put('/pengajuans/verifikasi/{id}', [DashboardController::class, 'verifikasi'])->name('pengajuans.verifikasi');

});
Route::middleware(['web', 'auth', RoleMiddleware::class . ':mahasiswa'])->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::get('/infopengajuan', [PengajuanController::class, 'info'])->name('pengajuan.info');
    Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

});

Route::middleware(['web', 'auth', RoleMiddleware::class . ':admin,dosen,mahasiswa'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::post('/profil/update', [ProfilController::class, 'update'])->name('profil.update');
});



// Route::middleware(['auth'])->group(function () {







//     Route::get('/cek', function () {
//         $pengajuan = Pengajuan::with([
//             'dokumenSurat',
//             'koordinator.dosen.user' // << ini penting untuk menghindari null
//         ])->first(); // Ambil data pengajuan pertama untuk demo
//         return view('surat.pdf', compact('pengajuan'));
//     });
// });

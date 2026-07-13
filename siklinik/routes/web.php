<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorBookingController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicalRecordPdfController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rekam-medis/{appointment}/pdf', [MedicalRecordPdfController::class, 'download'])->name('rekam-medis.pdf');
});

// ================================================================
// Route khusus Admin.
// ================================================================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('doctors', DoctorController::class)->except('show');
    Route::resource('schedules', ScheduleController::class)->except('show');
    Route::resource('specializations', SpecializationController::class)->except('show');
    Route::resource('patients', PatientController::class)->only(['index', 'show', 'edit', 'update']);
});

// ================================================================
// Route khusus Pasien: cari dokter, booking konsultasi, notifikasi.
// ================================================================
Route::middleware(['auth', 'role:pasien'])->group(function () {
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/riwayat', [BookingController::class, 'riwayat'])->name('riwayat');
        Route::get('/create/{schedule}', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
    });

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
});

// ================================================================
// Route khusus Dokter: kelola booking masuk & rekam medis.
// ================================================================
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/booking', [DoctorBookingController::class, 'index'])->name('booking.index');
    Route::get('/riwayat', [DoctorBookingController::class, 'riwayat'])->name('riwayat');
    Route::post('/booking/{appointment}/approve', [DoctorBookingController::class, 'approve'])->name('booking.approve');
    Route::post('/booking/{appointment}/reject', [DoctorBookingController::class, 'reject'])->name('booking.reject');

    Route::get('/rekam-medis/{appointment}', [MedicalRecordController::class, 'create'])->name('rekam-medis.create');
    Route::post('/rekam-medis/{appointment}', [MedicalRecordController::class, 'store'])->name('rekam-medis.store');
});

require __DIR__.'/auth.php';

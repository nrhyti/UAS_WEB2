<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    /**
     * Halaman daftar dokter + jadwal praktiknya, untuk dipilih pasien.
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'schedules'])->get();

        return view('booking.index', compact('doctors'));
    }

    /**
     * Form booking untuk 1 jadwal tertentu.
     */
    public function create(Schedule $schedule)
    {
        $schedule->load('doctor.user');

        return view('booking.create', compact('schedule'));
    }

    /**
     * Simpan booking baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'complaint' => 'nullable|string|max:1000',
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);

        // Pastikan tanggal yang dipilih pasien sesuai dengan hari praktik dokter.
        $chosenDate = Carbon::parse($validated['appointment_date']);
        if ($chosenDate->dayOfWeek !== (int) $schedule->day_of_week) {
            return back()->withErrors([
                'appointment_date' => 'Tanggal yang dipilih tidak sesuai dengan hari praktik dokter ('.$schedule->day_name.').',
            ])->withInput();
        }

        // Pastikan kuota di tanggal tersebut belum penuh.
        $terpakai = Appointment::where('schedule_id', $schedule->id)
            ->where('appointment_date', $chosenDate->toDateString())
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($terpakai >= $schedule->quota) {
            return back()->withErrors([
                'appointment_date' => 'Kuota untuk tanggal tersebut sudah penuh. Silakan pilih tanggal lain.',
            ])->withInput();
        }

        $patient = auth()->user()->patient;

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $schedule->doctor_id,
            'schedule_id' => $schedule->id,
            'appointment_date' => $chosenDate->toDateString(),
            'status' => 'pending',
            'complaint' => $validated['complaint'] ?? null,
        ]);

        return redirect()->route('booking.riwayat')->with('status', 'Booking berhasil diajukan. Menunggu persetujuan dokter.');
    }

    /**
     * Riwayat booking milik pasien yang sedang login.
     */
    public function riwayat()
    {
        $patient = auth()->user()->patient;

        $appointments = Appointment::with(['doctor.user', 'schedule', 'medicalRecord'])
            ->where('patient_id', $patient->id)
            ->latest('appointment_date')
            ->paginate(10);

        return view('booking.riwayat', compact('appointments'));
    }
}

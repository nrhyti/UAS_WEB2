<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Notifications\BookingStatusUpdated;
use Illuminate\Http\Request;

class DoctorBookingController extends Controller
{
    public function index()
    {
        $doctor = auth()->user()->doctor;

        $appointments = Appointment::with(['patient.user', 'schedule'])
            ->where('doctor_id', $doctor->id)
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('appointment_date')
            ->paginate(10);

        return view('dokter.booking.index', compact('appointments'));
    }

    public function riwayat()
    {
        $doctor = auth()->user()->doctor;

        $appointments = Appointment::with(['patient.user', 'medicalRecord'])
            ->where('doctor_id', $doctor->id)
            ->where('status', 'done')
            ->latest('appointment_date')
            ->paginate(10);

        return view('dokter.booking.riwayat', compact('appointments'));
    }

    public function approve(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $appointment->update(['status' => 'approved']);
        $appointment->load('doctor.user', 'patient.user');
        $appointment->patient->user->notify(new BookingStatusUpdated($appointment));

        return back()->with('status', 'Booking berhasil disetujui.');
    }

    public function reject(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment);

        $appointment->update(['status' => 'rejected']);
        $appointment->load('doctor.user', 'patient.user');
        $appointment->patient->user->notify(new BookingStatusUpdated($appointment));

        return back()->with('status', 'Booking berhasil ditolak.');
    }

    private function authorizeDoctor(Appointment $appointment): void
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Notifications\BookingStatusUpdated;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function create(Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        if ($appointment->status !== 'approved') {
            return back()->withErrors(['status' => 'Booking ini belum disetujui atau sudah selesai diproses.']);
        }

        $appointment->load('patient.user');

        return view('dokter.booking.rekam-medis', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        if ($appointment->doctor_id !== auth()->user()->doctor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'prescription' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'diagnosis' => $validated['diagnosis'],
            'prescription' => $validated['prescription'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        $appointment->update(['status' => 'done']);
        $appointment->load('doctor.user', 'patient.user');
        $appointment->patient->user->notify(new BookingStatusUpdated($appointment));

        return redirect()->route('dokter.booking.index')->with('status', 'Rekam medis berhasil disimpan. Konsultasi ditandai selesai.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Barryvdh\DomPDF\Facade\Pdf;

class MedicalRecordPdfController extends Controller
{
    public function download(Appointment $appointment)
    {
        $user = auth()->user();

        // Hanya pasien pemilik rekam medis ini, atau dokter yang menanganinya, yang boleh unduh.
        $isOwnerPatient = $user->role === 'pasien' && $user->patient && $appointment->patient_id === $user->patient->id;
        $isTreatingDoctor = $user->role === 'dokter' && $user->doctor && $appointment->doctor_id === $user->doctor->id;

        if (! $isOwnerPatient && ! $isTreatingDoctor) {
            abort(403);
        }

        if (! $appointment->medicalRecord) {
            abort(404, 'Rekam medis untuk booking ini belum tersedia.');
        }

        $appointment->load('patient.user', 'doctor.user', 'medicalRecord');

        $pdf = Pdf::loadView('pdf.rekam-medis', compact('appointment'));

        $filename = 'rekam-medis-'.\Illuminate\Support\Str::slug($appointment->patient->user->name).'-'.$appointment->appointment_date->format('Y-m-d').'.pdf';

        return $pdf->download($filename);
    }
}

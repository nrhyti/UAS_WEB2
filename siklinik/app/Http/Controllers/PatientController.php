<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Daftar pasien terdaftar, bisa dicari berdasarkan nama/email.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $patients = Patient::with('user')
            ->withCount('appointments')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', compact('patients', 'search'));
    }

    /**
     * Detail 1 pasien beserta riwayat booking-nya.
     */
    public function show(Patient $patient)
    {
        $patient->load('user');
        $patient->loadCount('appointments');

        $appointments = $patient->appointments()
            ->with(['doctor.user', 'medicalRecord'])
            ->latest('appointment_date')
            ->paginate(10);

        return view('patients.show', compact('patient', 'appointments'));
    }

    /**
     * Form edit data pasien.
     */
    public function edit(Patient $patient)
    {
        $patient->load('user');

        return view('patients.edit', compact('patient'));
    }

    /**
     * Simpan perubahan data pasien.
     */
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($patient->user_id)],
            'nik' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $patient->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $patient->update([
            'nik' => $validated['nik'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        return redirect()->route('patients.index')->with('status', 'Data pasien berhasil diperbarui.');
    }
}

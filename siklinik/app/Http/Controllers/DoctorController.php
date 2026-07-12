<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->paginate(10);

        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $specializations = Specialization::orderBy('name')->get();

        return view('doctors.create', compact('specializations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'specialization' => 'required|string|max:100',
            'license_number' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'dokter',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        return redirect()->route('doctors.index')->with('status', 'Data dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $doctor)
    {
        $doctor->load('user');
        $specializations = Specialization::orderBy('name')->get();

        return view('doctors.edit', compact('doctor', 'specializations'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($doctor->user_id)],
            'specialization' => 'required|string|max:100',
            'license_number' => 'nullable|string|max:50',
            'bio' => 'nullable|string',
        ]);

        $doctor->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $doctor->update([
            'specialization' => $validated['specialization'],
            'license_number' => $validated['license_number'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        return redirect()->route('doctors.index')->with('status', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user()->delete();

        return redirect()->route('doctors.index')->with('status', 'Data dokter berhasil dihapus.');
    }
}

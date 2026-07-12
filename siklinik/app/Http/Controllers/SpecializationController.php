<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::orderBy('name')->paginate(10);

        return view('specializations.index', compact('specializations'));
    }

    public function create()
    {
        return view('specializations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:specializations,name',
        ]);

        Specialization::create($validated);

        return redirect()->route('specializations.index')->with('status', 'Poli/spesialisasi berhasil ditambahkan.');
    }

    public function edit(Specialization $specialization)
    {
        return view('specializations.edit', compact('specialization'));
    }

    public function update(Request $request, Specialization $specialization)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('specializations', 'name')->ignore($specialization->id)],
        ]);

        $specialization->update($validated);

        return redirect()->route('specializations.index')->with('status', 'Poli/spesialisasi berhasil diperbarui.');
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();

        return redirect()->route('specializations.index')->with('status', 'Poli/spesialisasi berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('doctor.user')->latest()->paginate(10);

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->get();

        return view('schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'quota' => 'required|integer|min:1',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('status', 'Jadwal praktik berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        $doctors = Doctor::with('user')->get();

        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'quota' => 'required|integer|min:1',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('status', 'Jadwal praktik berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('status', 'Jadwal praktik berhasil dihapus.');
    }
}

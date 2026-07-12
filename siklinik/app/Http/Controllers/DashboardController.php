<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->role) {
            'admin' => $this->adminDashboard(),
            'dokter' => view('dashboard.dokter'),
            'pasien' => view('dashboard.pasien'),
            default => abort(403),
        };
    }

    private function adminDashboard()
    {
        $stats = [
            'total_dokter' => Doctor::count(),
            'total_pasien' => Patient::count(),
            'booking_hari_ini' => Appointment::whereDate('appointment_date', today())->count(),
            'booking_pending' => Appointment::where('status', 'pending')->count(),
            'booking_selesai' => Appointment::where('status', 'done')->count(),
        ];

        // Dokter dengan jumlah kunjungan (booking) terbanyak
        $topDoctors = Doctor::withCount('appointments')
            ->with('user')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'topDoctors'));
    }
}

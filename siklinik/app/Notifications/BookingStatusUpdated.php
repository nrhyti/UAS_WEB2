<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment)
    {
        //
    }

    /**
     * Simpan notifikasi ke database (in-app), bukan kirim email.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $doctorName = $this->appointment->doctor->user->name;
        $tanggal = \Illuminate\Support\Carbon::parse($this->appointment->appointment_date)->translatedFormat('d M Y');

        $pesan = match ($this->appointment->status) {
            'approved' => "Booking konsultasi kamu dengan {$doctorName} pada {$tanggal} telah DISETUJUI.",
            'rejected' => "Mohon maaf, booking konsultasi kamu dengan {$doctorName} pada {$tanggal} DITOLAK.",
            'done' => "Konsultasi kamu dengan {$doctorName} pada {$tanggal} telah selesai. Rekam medis sudah tersedia.",
            default => "Status booking kamu dengan {$doctorName} pada {$tanggal} telah diperbarui.",
        };

        return [
            'appointment_id' => $this->appointment->id,
            'status' => $this->appointment->status,
            'message' => $pesan,
        ];
    }
}

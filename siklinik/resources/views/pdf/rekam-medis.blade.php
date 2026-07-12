<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekam Medis</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; color: #222; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 2px 0; color: #555; }
        table.info { width: 100%; margin-bottom: 15px; }
        table.info td { padding: 4px 0; vertical-align: top; }
        table.info td.label { width: 150px; font-weight: bold; }
        .section { margin-top: 15px; }
        .section h3 { background: #f0f0f0; padding: 6px 10px; margin: 0 0 8px 0; font-size: 14px; }
        .section p { padding: 0 10px; white-space: pre-line; }
        .footer { margin-top: 40px; text-align: right; font-size: 12px; color: #555; }
    </style>
</head>
<body>

    <div class="header">
        <h1>SIKLINIK</h1>
        <p>Sistem Informasi Manajemen Klinik &amp; Booking Konsultasi Dokter</p>
        <p><strong>REKAM MEDIS PASIEN</strong></p>
    </div>

    <table class="info">
        <tr>
            <td class="label">Nama Pasien</td>
            <td>: {{ $appointment->patient->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Konsultasi</td>
            <td>: {{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Dokter Pemeriksa</td>
            <td>: {{ $appointment->doctor->user->name }} ({{ $appointment->doctor->specialization }})</td>
        </tr>
        <tr>
            <td class="label">Keluhan Awal</td>
            <td>: {{ $appointment->complaint ?? '-' }}</td>
        </tr>
    </table>

    <div class="section">
        <h3>Diagnosis</h3>
        <p>{{ $appointment->medicalRecord->diagnosis }}</p>
    </div>

    <div class="section">
        <h3>Resep Obat</h3>
        <p>{{ $appointment->medicalRecord->prescription ?: '-' }}</p>
    </div>

    <div class="section">
        <h3>Catatan Tambahan</h3>
        <p>{{ $appointment->medicalRecord->notes ?: '-' }}</p>
    </div>

    <div class="footer">
        Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>

</body>
</html>

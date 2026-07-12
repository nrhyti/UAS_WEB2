<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Konsultasi Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('booking.index') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Booking Baru
                </a>

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Tanggal</th>
                            <th class="border border-gray-300 p-2 text-left">Dokter</th>
                            <th class="border border-gray-300 p-2 text-left">Status</th>
                            <th class="border border-gray-300 p-2 text-left">Hasil Rekam Medis</th>
                            <th class="border border-gray-300 p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td class="border border-gray-300 p-2">
                                    {{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="border border-gray-300 p-2">{{ $appointment->doctor->user->name }}</td>
                                <td class="border border-gray-300 p-2">
                                    @php
                                        $labels = [
                                            'pending' => ['Menunggu Persetujuan', 'bg-yellow-100 text-yellow-800'],
                                            'approved' => ['Disetujui', 'bg-blue-100 text-blue-800'],
                                            'rejected' => ['Ditolak', 'bg-red-100 text-red-800'],
                                            'done' => ['Selesai', 'bg-green-100 text-green-800'],
                                        ];
                                        [$label, $class] = $labels[$appointment->status] ?? [$appointment->status, 'bg-gray-100 text-gray-800'];
                                    @endphp
                                    <span class="px-2 py-1 rounded text-xs {{ $class }}">{{ $label }}</span>
                                </td>
                                <td class="border border-gray-300 p-2">
                                    @if ($appointment->medicalRecord)
                                        <strong>Diagnosis:</strong> {{ $appointment->medicalRecord->diagnosis }}<br>
                                        @if ($appointment->medicalRecord->prescription)
                                            <strong>Resep:</strong> {{ $appointment->medicalRecord->prescription }}
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 p-2">
                                    @if ($appointment->medicalRecord)
                                        <a href="{{ route('rekam-medis.pdf', $appointment) }}" class="text-indigo-600 hover:underline text-xs">
                                            Unduh PDF
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 p-4 text-center text-gray-500">
                                    Kamu belum pernah melakukan booking konsultasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

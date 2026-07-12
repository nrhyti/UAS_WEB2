<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Pasien
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Tanggal</th>
                            <th class="border border-gray-300 p-2 text-left">Pasien</th>
                            <th class="border border-gray-300 p-2 text-left">Diagnosis</th>
                            <th class="border border-gray-300 p-2 text-left">Resep</th>
                            <th class="border border-gray-300 p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td class="border border-gray-300 p-2">
                                    {{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->translatedFormat('d M Y') }}
                                </td>
                                <td class="border border-gray-300 p-2">{{ $appointment->patient->user->name }}</td>
                                <td class="border border-gray-300 p-2">{{ $appointment->medicalRecord->diagnosis ?? '-' }}</td>
                                <td class="border border-gray-300 p-2">{{ $appointment->medicalRecord->prescription ?? '-' }}</td>
                                <td class="border border-gray-300 p-2">
                                    @if ($appointment->medicalRecord)
                                        <a href="{{ route('rekam-medis.pdf', $appointment) }}" class="text-indigo-600 hover:underline text-xs">
                                            Unduh PDF
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 p-4 text-center text-gray-500">
                                    Belum ada riwayat konsultasi yang selesai.
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

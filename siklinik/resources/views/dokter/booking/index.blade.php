<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Booking Masuk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Tanggal</th>
                            <th class="border border-gray-300 p-2 text-left">Pasien</th>
                            <th class="border border-gray-300 p-2 text-left">Keluhan</th>
                            <th class="border border-gray-300 p-2 text-left">Status</th>
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
                                <td class="border border-gray-300 p-2">{{ $appointment->complaint ?? '-' }}</td>
                                <td class="border border-gray-300 p-2">
                                    @if ($appointment->status === 'pending')
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Menunggu</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-800">Disetujui</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 p-2 space-x-2">
                                    @if ($appointment->status === 'pending')
                                        <form action="{{ route('dokter.booking.approve', $appointment) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:underline">Setujui</button>
                                        </form>
                                        <form action="{{ route('dokter.booking.reject', $appointment) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menolak booking ini?');">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:underline">Tolak</button>
                                        </form>
                                    @else
                                        <a href="{{ route('dokter.rekam-medis.create', $appointment) }}" class="text-indigo-600 hover:underline">
                                            Isi Rekam Medis
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 p-4 text-center text-gray-500">
                                    Belum ada booking yang masuk.
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

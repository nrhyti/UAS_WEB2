<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cari Dokter & Booking Konsultasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @forelse ($doctors as $doctor)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $doctor->user->name }}</h3>
                    <p class="text-gray-600 mb-3">{{ $doctor->specialization }}</p>

                    @if ($doctor->bio)
                        <p class="text-sm text-gray-500 mb-3">{{ $doctor->bio }}</p>
                    @endif

                    @if ($doctor->schedules->isEmpty())
                        <p class="text-sm text-gray-400 italic">Belum ada jadwal praktik tersedia.</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300 text-sm mt-2">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-300 p-2 text-left">Hari</th>
                                    <th class="border border-gray-300 p-2 text-left">Jam</th>
                                    <th class="border border-gray-300 p-2 text-left">Kuota</th>
                                    <th class="border border-gray-300 p-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctor->schedules as $schedule)
                                    <tr>
                                        <td class="border border-gray-300 p-2">{{ $schedule->day_name }}</td>
                                        <td class="border border-gray-300 p-2">
                                            {{ \Illuminate\Support\Carbon::parse($schedule->start_time)->format('H:i') }}
                                            -
                                            {{ \Illuminate\Support\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </td>
                                        <td class="border border-gray-300 p-2">{{ $schedule->quota }} pasien</td>
                                        <td class="border border-gray-300 p-2">
                                            <a href="{{ route('booking.create', $schedule) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-xs">
                                                Booking
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @empty
                <div class="bg-white p-6 rounded shadow-sm text-gray-500 text-center">
                    Belum ada dokter yang terdaftar.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>

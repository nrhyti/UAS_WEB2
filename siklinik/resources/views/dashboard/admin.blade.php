<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2">Selamat datang, <strong>{{ auth()->user()->name }}</strong> (Admin).</p>
                    <p class="text-gray-600 mb-4">Dari sini Admin bisa mengelola data dokter, jadwal praktik, dan memonitor booking pasien.</p>

                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ route('doctors.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Kelola Data Dokter
                        </a>
                        <a href="{{ route('schedules.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Kelola Jadwal Praktik
                        </a>
                        <a href="{{ route('specializations.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Kelola Poli/Spesialisasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Statistik Klinik</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_dokter'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Dokter</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-indigo-600">{{ $stats['total_pasien'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Total Pasien</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-yellow-600">{{ $stats['booking_pending'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Booking Menunggu</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['booking_hari_ini'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Booking Hari Ini</p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                        <p class="text-2xl font-bold text-green-600">{{ $stats['booking_selesai'] }}</p>
                        <p class="text-xs text-gray-500 mt-1">Konsultasi Selesai</p>
                    </div>
                </div>
            </div>

            <!-- Dokter paling banyak dikunjungi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Dokter Paling Banyak Dikunjungi</h3>

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Nama Dokter</th>
                            <th class="border border-gray-300 p-2 text-left">Spesialisasi</th>
                            <th class="border border-gray-300 p-2 text-left">Jumlah Booking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topDoctors as $doctor)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $doctor->user->name }}</td>
                                <td class="border border-gray-300 p-2">{{ $doctor->specialization }}</td>
                                <td class="border border-gray-300 p-2">{{ $doctor->appointments_count }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border border-gray-300 p-4 text-center text-gray-500">
                                    Belum ada data dokter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <ul class="list-disc list-inside text-gray-600 space-y-1 px-2">
                <li>Manajemen Data Pasien (segera)</li>
            </ul>
        </div>
    </div>
</x-app-layout>

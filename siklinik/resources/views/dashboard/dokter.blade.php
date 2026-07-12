<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Dokter
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2">Selamat datang, <strong>{{ auth()->user()->name }}</strong> (Dokter).</p>
                    <p class="text-gray-600 mb-4">Dari sini kamu bisa mengelola booking pasien dan mengisi rekam medis.</p>

                    <div class="flex gap-3">
                        <a href="{{ route('dokter.booking.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Booking Masuk
                        </a>
                        <a href="{{ route('dokter.riwayat') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Riwayat Pasien
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

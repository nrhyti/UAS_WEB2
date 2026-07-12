<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pasien
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-2">Selamat datang, <strong>{{ auth()->user()->name }}</strong> (Pasien).</p>
                    <p class="text-gray-600 mb-4">Dari sini kamu bisa melihat daftar dokter, booking konsultasi, dan melihat riwayat rekam medis.</p>

                    @php
                        $unreadCount = auth()->user()->unreadNotifications->count();
                    @endphp

                    <div class="flex gap-3 flex-wrap">
                        <a href="{{ route('booking.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Cari Dokter & Booking
                        </a>
                        <a href="{{ route('booking.riwayat') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Riwayat Konsultasi
                        </a>
                        <a href="{{ route('notifications.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 relative">
                            Notifikasi
                            @if ($unreadCount > 0)
                                <span class="ml-1 inline-block bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Booking Konsultasi
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4 p-4 bg-gray-50 rounded">
                    <p><strong>Dokter:</strong> {{ $schedule->doctor->user->name }} ({{ $schedule->doctor->specialization }})</p>
                    <p><strong>Hari Praktik:</strong> {{ $schedule->day_name }}</p>
                    <p><strong>Jam:</strong>
                        {{ \Illuminate\Support\Carbon::parse($schedule->start_time)->format('H:i') }}
                        -
                        {{ \Illuminate\Support\Carbon::parse($schedule->end_time)->format('H:i') }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">Pastikan tanggal yang kamu pilih di bawah jatuh pada hari {{ $schedule->day_name }}.</p>
                </div>

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Tanggal Konsultasi</label>
                        <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" min="{{ now()->toDateString() }}" class="mt-1 block w-full border-gray-300 rounded" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Keluhan Awal (opsional)</label>
                        <textarea name="complaint" rows="3" class="mt-1 block w-full border-gray-300 rounded" placeholder="Ceritakan keluhan kamu secara singkat...">{{ old('complaint') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Ajukan Booking
                        </button>
                        <a href="{{ route('booking.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

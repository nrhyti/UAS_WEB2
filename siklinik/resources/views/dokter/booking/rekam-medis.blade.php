<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Isi Rekam Medis
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
                    <p><strong>Pasien:</strong> {{ $appointment->patient->user->name }}</p>
                    <p><strong>Tanggal:</strong> {{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->translatedFormat('d M Y') }}</p>
                    <p><strong>Keluhan Awal:</strong> {{ $appointment->complaint ?? '-' }}</p>
                </div>

                <form action="{{ route('dokter.rekam-medis.store', $appointment) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Diagnosis</label>
                        <textarea name="diagnosis" rows="3" class="mt-1 block w-full border-gray-300 rounded" required>{{ old('diagnosis') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Resep Obat (opsional)</label>
                        <textarea name="prescription" rows="3" class="mt-1 block w-full border-gray-300 rounded">{{ old('prescription') }}</textarea>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Catatan Tambahan (opsional)</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full border-gray-300 rounded">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Simpan & Selesaikan Konsultasi
                        </button>
                        <a href="{{ route('dokter.booking.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

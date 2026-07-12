<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Dokter
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

                <form action="{{ route('doctors.update', $doctor) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $doctor->user->name) }}" class="mt-1 block w-full border-gray-300 rounded" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Email (untuk login)</label>
                        <input type="email" name="email" value="{{ old('email', $doctor->user->email) }}" class="mt-1 block w-full border-gray-300 rounded" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Spesialisasi</label>
                        <select name="specialization" class="mt-1 block w-full border-gray-300 rounded" required>
                            <option value="">-- Pilih Poli/Spesialisasi --</option>
                            @foreach ($specializations as $item)
                                <option value="{{ $item->name }}" {{ old('specialization', $doctor->specialization) === $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @if (!$specializations->pluck('name')->contains($doctor->specialization))
                            <p class="text-xs text-yellow-600 mt-1">
                                Catatan: spesialisasi saat ini ("{{ $doctor->specialization }}") tidak ada di daftar poli. Silakan pilih ulang.
                            </p>
                        @endif
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nomor STR/SIP (opsional)</label>
                        <input type="text" name="license_number" value="{{ old('license_number', $doctor->license_number) }}" class="mt-1 block w-full border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Bio Singkat (opsional)</label>
                        <textarea name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded">{{ old('bio', $doctor->bio) }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update
                        </button>
                        <a href="{{ route('doctors.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

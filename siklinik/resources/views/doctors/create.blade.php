<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Dokter Baru
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

                @if ($specializations->isEmpty())
                    <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded">
                        Belum ada data Poli/Spesialisasi. Silakan
                        <a href="{{ route('specializations.create') }}" class="underline font-medium">tambah poli</a>
                        terlebih dahulu.
                    </div>
                @endif

                <form action="{{ route('doctors.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Email (untuk login)</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded" required>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Password Awal</label>
                        <input type="text" name="password" class="mt-1 block w-full border-gray-300 rounded" required>
                        <p class="text-xs text-gray-500 mt-1">Beritahukan password ini ke dokter yang bersangkutan untuk login pertama kali.</p>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Spesialisasi</label>
                        <select name="specialization" class="mt-1 block w-full border-gray-300 rounded" required>
                            <option value="">-- Pilih Poli/Spesialisasi --</option>
                            @foreach ($specializations as $item)
                                <option value="{{ $item->name }}" {{ old('specialization') === $item->name ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Nomor STR/SIP (opsional)</label>
                        <input type="text" name="license_number" value="{{ old('license_number') }}" class="mt-1 block w-full border-gray-300 rounded">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Bio Singkat (opsional)</label>
                        <textarea name="bio" rows="3" class="mt-1 block w-full border-gray-300 rounded">{{ old('bio') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Simpan
                        </button>
                        <a href="{{ route('doctors.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

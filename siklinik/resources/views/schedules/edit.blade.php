<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Jadwal Praktik
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

                <form action="{{ route('schedules.update', $schedule) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Dokter</label>
                        <select name="doctor_id" class="mt-1 block w-full border-gray-300 rounded" required>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name }} ({{ $doctor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Hari Praktik</label>
                        <select name="day_of_week" class="mt-1 block w-full border-gray-300 rounded" required>
                            @foreach ([1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu', 0 => 'Minggu'] as $value => $label)
                                <option value="{{ $value }}" {{ old('day_of_week', $schedule->day_of_week) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jam Mulai</label>
                            <input type="time" name="start_time" value="{{ old('start_time', \Illuminate\Support\Carbon::parse($schedule->start_time)->format('H:i')) }}" class="mt-1 block w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Jam Selesai</label>
                            <input type="time" name="end_time" value="{{ old('end_time', \Illuminate\Support\Carbon::parse($schedule->end_time)->format('H:i')) }}" class="mt-1 block w-full border-gray-300 rounded" required>
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700">Kuota Pasien per Sesi</label>
                        <input type="number" name="quota" min="1" value="{{ old('quota', $schedule->quota) }}" class="mt-1 block w-full border-gray-300 rounded" required>
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Update
                        </button>
                        <a href="{{ route('schedules.index') }}" class="text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pasien
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">{{ $patient->user->name }}</h3>
                <table class="text-sm">
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">Email</td><td>: {{ $patient->user->email }}</td></tr>
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">NIK</td><td>: {{ $patient->nik ?? '-' }}</td></tr>
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">Tanggal Lahir</td><td>: {{ $patient->date_of_birth ? \Illuminate\Support\Carbon::parse($patient->date_of_birth)->translatedFormat('d F Y') : '-' }}</td></tr>
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">Jenis Kelamin</td><td>: {{ $patient->gender === 'L' ? 'Laki-laki' : ($patient->gender === 'P' ? 'Perempuan' : '-') }}</td></tr>
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">Telepon</td><td>: {{ $patient->phone ?? '-' }}</td></tr>
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">Alamat</td><td>: {{ $patient->address ?? '-' }}</td></tr>
                    <tr><td class="pr-4 py-1 font-medium text-gray-600">Total Booking</td><td>: {{ $patient->appointments_count }}</td></tr>
                </table>

                <div class="mt-4 flex gap-3">
                    <a href="{{ route('patients.edit', $patient) }}" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 text-sm">Edit Data</a>
                    <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-600 hover:border-teal-600 text-sm">Kembali</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Riwayat Booking</h3>

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Tanggal</th>
                            <th class="border border-gray-300 p-2 text-left">Dokter</th>
                            <th class="border border-gray-300 p-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ \Illuminate\Support\Carbon::parse($appointment->appointment_date)->translatedFormat('d M Y') }}</td>
                                <td class="border border-gray-300 p-2">{{ $appointment->doctor->user->name }}</td>
                                <td class="border border-gray-300 p-2">{{ ucfirst($appointment->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border border-gray-300 p-4 text-center text-gray-500">Belum ada riwayat booking.</td>
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

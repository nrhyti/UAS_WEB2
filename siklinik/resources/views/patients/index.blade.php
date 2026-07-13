<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Data Pasien
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="GET" action="{{ route('patients.index') }}" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email pasien..." class="flex-1 border-gray-300 rounded">
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Cari</button>
                    @if ($search)
                        <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 rounded text-gray-600 hover:border-teal-600">Reset</a>
                    @endif
                </form>

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Nama</th>
                            <th class="border border-gray-300 p-2 text-left">Email</th>
                            <th class="border border-gray-300 p-2 text-left">Telepon</th>
                            <th class="border border-gray-300 p-2 text-left">Total Booking</th>
                            <th class="border border-gray-300 p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $patient->user->name }}</td>
                                <td class="border border-gray-300 p-2">{{ $patient->user->email }}</td>
                                <td class="border border-gray-300 p-2">{{ $patient->phone ?? '-' }}</td>
                                <td class="border border-gray-300 p-2">{{ $patient->appointments_count }}</td>
                                <td class="border border-gray-300 p-2 space-x-2">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-teal-600 hover:underline">Detail</a>
                                    <a href="{{ route('patients.edit', $patient) }}" class="text-blue-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 p-4 text-center text-gray-500">
                                    {{ $search ? 'Tidak ada pasien yang cocok dengan pencarian.' : 'Belum ada pasien terdaftar.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

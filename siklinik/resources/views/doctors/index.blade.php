<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Data Dokter
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <a href="{{ route('doctors.create') }}" class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Tambah Dokter
                </a>

                <table class="w-full border-collapse border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Nama</th>
                            <th class="border border-gray-300 p-2 text-left">Email</th>
                            <th class="border border-gray-300 p-2 text-left">Spesialisasi</th>
                            <th class="border border-gray-300 p-2 text-left">No. STR</th>
                            <th class="border border-gray-300 p-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($doctors as $doctor)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $doctor->user->name }}</td>
                                <td class="border border-gray-300 p-2">{{ $doctor->user->email }}</td>
                                <td class="border border-gray-300 p-2">{{ $doctor->specialization }}</td>
                                <td class="border border-gray-300 p-2">{{ $doctor->license_number ?? '-' }}</td>
                                <td class="border border-gray-300 p-2 space-x-2">
                                    <a href="{{ route('doctors.edit', $doctor) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus dokter ini? Akun login dokter juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border border-gray-300 p-4 text-center text-gray-500">
                                    Belum ada data dokter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

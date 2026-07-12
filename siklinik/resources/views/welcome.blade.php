<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIKLINIK — Booking Konsultasi Dokter Online</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <header class="border-b border-gray-100 bg-white">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-application-logo class="h-8 w-8 text-teal-600" />
                <span class="font-bold text-lg tracking-tight">SIKLINIK</span>
            </div>

            <nav class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md bg-teal-600 text-white text-sm font-medium hover:bg-teal-700">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-teal-700">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-md bg-teal-600 text-white text-sm font-medium hover:bg-teal-700">
                                Daftar
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero -->
    <section class="max-w-6xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-block px-3 py-1 rounded-full bg-teal-100 text-teal-700 text-xs font-semibold mb-4">
                Klinik Digital
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                Konsultasi dokter,
                <span class="text-teal-600">tanpa antre.</span>
            </h1>
            <p class="mt-5 text-gray-600 text-lg">
                Booking jadwal konsultasi dengan dokter pilihanmu secara online, cek riwayat rekam medis kapan saja,
                dan pantau status konsultasimu langsung dari HP.
            </p>
            <div class="mt-8 flex gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-3 rounded-md bg-teal-600 text-white font-medium hover:bg-teal-700">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-6 py-3 rounded-md bg-teal-600 text-white font-medium hover:bg-teal-700">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-md border border-gray-300 text-gray-700 font-medium hover:border-teal-600 hover:text-teal-700">
                        Sudah Punya Akun
                    </a>
                @endauth
            </div>
        </div>

        <div class="relative">
            <div class="aspect-square max-w-sm mx-auto rounded-3xl bg-gradient-to-br from-teal-500 to-sky-600 flex items-center justify-center shadow-xl">
                <x-application-logo class="h-32 w-32 text-white/90" />
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="bg-white border-t border-gray-100">
        <div class="max-w-6xl mx-auto px-6 py-16">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-12">Semua kebutuhan konsultasimu, di satu tempat</h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 rounded-xl border border-gray-100 hover:border-teal-200 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold mb-4">1</div>
                    <h3 class="font-semibold text-lg mb-2">Cari &amp; Pilih Dokter</h3>
                    <p class="text-gray-600 text-sm">Lihat daftar dokter berdasarkan spesialisasi beserta jadwal praktiknya yang tersedia.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-100 hover:border-teal-200 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold mb-4">2</div>
                    <h3 class="font-semibold text-lg mb-2">Booking Online</h3>
                    <p class="text-gray-600 text-sm">Ajukan jadwal konsultasi dalam hitungan detik, tanpa perlu telepon atau datang langsung.</p>
                </div>
                <div class="p-6 rounded-xl border border-gray-100 hover:border-teal-200 hover:shadow-md transition">
                    <div class="h-10 w-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold mb-4">3</div>
                    <h3 class="font-semibold text-lg mb-2">Rekam Medis Digital</h3>
                    <p class="text-gray-600 text-sm">Riwayat diagnosis dan resep tersimpan rapi, bisa diunduh sebagai PDF kapan pun dibutuhkan.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-8 text-center text-sm text-gray-400">
        &copy; {{ date('Y') }} SIKLINIK — Tugas UAS Pemrograman Web 2.
    </footer>

</body>
</html>

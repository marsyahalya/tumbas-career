<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tumbas Coffee - Career Riders</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-stone-50 text-gray-800" x-data="{ mobileMenuOpen: false }">
        
        <!-- Navbar (Fixed, Glassmorphism) -->
        <nav class="fixed w-full z-50 transition-all duration-300 backdrop-blur-md bg-white/90 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="#" class="text-2xl font-extrabold text-tumbas tracking-tight">TUMBAS<span class="text-gray-900">COFFEE</span></a>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#hero" class="text-sm font-semibold text-gray-600 hover:text-tumbas transition">Beranda</a>
                        <a href="#about" class="text-sm font-semibold text-gray-600 hover:text-tumbas transition">Mengapa Bergabung?</a>
                        <a href="#testimonials" class="text-sm font-semibold text-gray-600 hover:text-tumbas transition">Kisah Rider Alumni</a>
                        
                        <div class="ml-4 flex items-center space-x-3">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-tumbas hover:underline">Masuk Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-tumbas">Masuk</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="bg-tumbas hover:bg-tumbas-dark text-white text-sm font-semibold py-2 px-5 rounded-full shadow-md transition-all">Daftar Sekarang</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-600 hover:text-tumbas focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileMenuOpen" style="display:none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div x-show="mobileMenuOpen" style="display:none;" class="md:hidden bg-white border-t border-gray-100 shadow-lg absolute w-full backdrop-blur-md bg-white/95">
                <div class="px-4 py-4 space-y-3">
                    <a href="#hero" @click="mobileMenuOpen = false" class="block text-base font-medium text-gray-700 hover:text-tumbas">Beranda</a>
                    <a href="#about" @click="mobileMenuOpen = false" class="block text-base font-medium text-gray-700 hover:text-tumbas">Mengapa Bergabung?</a>
                    <a href="#testimonials" @click="mobileMenuOpen = false" class="block text-base font-medium text-gray-700 hover:text-tumbas">Kisah Rider Alumni</a>
                    <hr>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block text-base font-bold text-tumbas">Masuk Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-base font-medium text-gray-700">Masuk (Login)</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block text-base font-bold text-tumbas mt-2">Daftar Sekarang</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="hero" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                <div class="inline-block mb-4 px-4 py-1.5 bg-orange-50 border border-orange-200 rounded-full text-tumbas text-xs font-bold tracking-widest uppercase shadow-sm">
                    Revolusi Kopi Keliling Surakarta
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-900 mb-6 drop-shadow-sm">
                    Be a <span class="text-transparent bg-clip-text bg-gradient-to-r from-tumbas to-orange-400">Tumbas Group</span>
                </h1>
                <p class="mt-4 max-w-3xl text-lg md:text-xl text-gray-600 mx-auto mb-10 leading-relaxed">
                    Berdiri di Surakarta sejak tahun 2025, Tumbas Coffee kini telah berkembang pesat dengan memiliki 20+ Riders aktif. Bergabunglah bersama kami menyajikan kebahagiaan secangkir kopi langsung ke tangan pelanggan!
                </p>
                <div class="flex justify-center flex-col sm:flex-row gap-4">
                    <a href="{{ route('register') }}" class="bg-tumbas hover:bg-tumbas-dark text-white font-bold py-4 px-8 rounded-full shadow-xl hover:shadow-2xl transition-all transform hover:-translate-y-1 text-lg flex justify-center items-center gap-2">
                        Jadi Tumbas Rider
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#about" class="bg-white hover:bg-stone-50 text-tumbas border border-stone-200 font-bold py-4 px-8 rounded-full shadow transition-all text-lg transition-all">
                        Eksplorasi Karir
                    </a>
                </div>
            </div>
            
            <!-- Dekorasi Gumpalan (Clean look) -->
            <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full max-w-5xl opacity-10 pointer-events-none -z-10">
                <div class="absolute inset-0 bg-gradient-to-br from-tumbas to-yellow-200 rounded-full w-[30rem] h-[30rem] blur-3xl mix-blend-multiply translate-x-1/4 translate-y-0"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-orange-300 to-red-200 rounded-full w-[25rem] h-[25rem] blur-3xl mix-blend-multiply -translate-x-1/2 translate-y-1/3"></div>
            </div>
        </section>

        <!-- Layanan / Apa yang Disediakan -->
        <section id="about" class="py-20 bg-stone-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-sm text-tumbas font-bold tracking-widest uppercase">Perjalanan Karir Tumbas</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Kesejahteraan Bersama Ekosistem Kopi
                    </p>
                    <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">
                        Sebagai ujung tombak bisnis Kopi Keliling, Rider adalah prioritas kami. Fasilitas penuh menanti langkah Anda bergabung ke keluarga Tumbas.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-2xl p-8 border border-stone-100 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="w-14 h-14 bg-orange-100 text-tumbas rounded-xl flex items-center justify-center mb-6 text-2xl font-bold">💎</div>
                        <h3 class="text-xl font-extrabold text-gray-900 mb-3">Pendapatan Premium</h3>
                        <p class="text-gray-600 leading-relaxed">Komisi kopi harian yang adil dan transparan tanpa batas per penjualan, sehingga waktu operasi sangat diuntungkan bagi pencari nafkah berdedikasi tinggi.</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-2xl p-8 border border-stone-100 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="w-14 h-14 bg-orange-100 text-tumbas rounded-xl flex items-center justify-center mb-6 text-2xl font-bold">🛵</div>
                        <h3 class="text-xl font-extrabold text-gray-900 mb-3">Unit Operasional</h3>
                        <p class="text-gray-600 leading-relaxed">Berhak memakai sistem dan modul armada Tumbas Coffee yang sudah disiapkan dan siap meluncur ke titik-titik lokasi berpotensi besar se-Surakarta.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-2xl p-8 border border-stone-100 hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                        <div class="w-14 h-14 bg-orange-100 text-tumbas rounded-xl flex items-center justify-center mb-6 text-2xl font-bold">🚀</div>
                        <h3 class="text-xl font-extrabold text-gray-900 mb-3">Sertifikasi & Karir (Alumni)</h3>
                        <p class="text-gray-600 leading-relaxed">Peluang menjadi Supervisor Area. Belasan dari ke-20 Rider kami perlahan dipromosikan mengelola zona operasional mereka sendiri!</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonial Alumni -->
        <section id="testimonials" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl relative inline-block">
                        Bukti Kepuasan Tumbas Rider
                        <span class="absolute -bottom-2 left-0 w-full h-1 bg-tumbas/20 rounded-full"></span>
                    </h2>
                    <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Kami tidak sekadar janji. Puluhan rider kami merajut sukses setiap harinya.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Testi 1 -->
                    <div class="bg-stone-50 p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-tumbas/30 transition-colors">
                        <div class="flex text-yellow-400 mb-6 drop-shadow-sm">
                            <!-- 5 Stars SVG -->
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed font-medium mb-6">"Surakarta itu luas, jualan kopi keliling Tumbas ini gampang banget narik pelanggan. Produk The Best, komisi jelas."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex justify-center items-center font-bold text-tumbas text-xl">W</div>
                            <div>
                                <p class="text-md font-extrabold text-gray-900">Wahyu Pratama</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Angkatan Pertama 2025</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testi 2 -->
                    <div class="bg-stone-50 p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-tumbas/30 transition-colors">
                        <div class="flex text-yellow-400 mb-6 drop-shadow-sm">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed font-medium mb-6">"Dulu mendaftar lewat web pendaftaran ini, status keterima cepat banget diproses. Sekarang rekrutmen makin modern!"</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex justify-center items-center font-bold text-red-700 text-xl">D</div>
                            <div>
                                <p class="text-md font-extrabold text-gray-900">Dimas Aditya</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Top Rider Bulan Ini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testi 3 -->
                    <div class="bg-stone-50 p-8 rounded-2xl shadow-sm border border-stone-100 hover:border-tumbas/30 transition-colors">
                        <div class="flex text-yellow-400 mb-6 drop-shadow-sm">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M... "/><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <svg class="w-5 h-5 fill-current text-gray-200" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <p class="text-gray-700 leading-relaxed font-medium mb-6">"Jadi rider kopi keliling gak cuma tentang ngebut, tapi interaksi santai sama warga dapet penghasilan lebih dari UMR lokal."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex justify-center items-center font-bold text-yellow-700 text-xl">S</div>
                            <div>
                                <p class="text-md font-extrabold text-gray-900">Suryono Setia</p>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Rider Area Kampus</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Bawah -->
        <section class="py-24 bg-stone-50 border-t border-stone-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center bg-white p-12 rounded-3xl shadow-xl border border-stone-100 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-tumbas/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-orange-300/20 rounded-full blur-2xl"></div>
                
                <h2 class="text-4xl font-extrabold text-gray-900 mb-6 relative z-10">Peluang Karir Menanti Anda</h2>
                <p class="text-lg text-gray-600 mb-8 max-w-xl mx-auto relative z-10">Pendaftaran sangat mudah. Lengkapi profil dan unggah CV terbaik Anda untuk segera mengikuti seleksi wawancara kami.</p>
                <a href="{{ route('register') }}" class="inline-block bg-tumbas hover:bg-tumbas-dark text-white font-extrabold py-4 px-10 rounded-full shadow-lg transition-transform transform hover:-translate-y-1 relative z-10 text-lg">
                    Gabung Sekarang
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6">
                <div>
                    <span class="text-2xl font-extrabold text-white tracking-tight">TUMBAS<span class="text-tumbas">COFFEE</span></span>
                    <p class="text-gray-400 mt-2 text-sm max-w-sm">Jaringan kopi keliling independen terbesar di Surakarta, menghubungkan rasa dan cerita.</p>
                </div>
                <div class="text-gray-400 text-sm font-medium">
                    &copy; 2025 Tumbas Group (Surakarta). Hak Cipta Dilindungi.
                </div>
            </div>
        </footer>

    </body>
</html>

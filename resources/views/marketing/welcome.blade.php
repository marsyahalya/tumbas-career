<x-layouts.marketing>
    <x-marketing.navbar />

    <!-- Hero Section -->
    <section id="hero" class="relative min-h-[80vh] flex items-center pt-20 overflow-hidden bg-white">
        <div class="light-rays-container">
            <div class="light-rays"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full text-center">
            <div class="max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 mb-8 px-5 py-2 bg-tumbas/5 border border-tumbas/10 rounded-full text-tumbas text-[10px] font-medium tracking-widest uppercase">
                    Solusi Kopi Praktis di Surakarta
                </div>
                
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold tracking-tighter text-gray-900 mb-8 leading-none">
                    Kopi Gerobak <span class="text-tumbas">Keliling Solo.</span>
                </h1>
                
                <p class="text-xl md:text-xl text-gray-500 mb-12 leading-relaxed max-w-2xl mx-auto font-light">
                    Menghadirkan kesegaran kopi pilihan langsung ke titik-titik favoritmu di Solo. Tanpa ribet, kualitas tetap nomor satu.
                </p>
                
                <div class="flex justify-center flex-wrap gap-4">
                    <a href="#menu" class="bg-tumbas hover:bg-tumbas-dark text-white font-medium py-4 px-12 rounded-full shadow-xl shadow-tumbas/10 transition-all transform hover:-translate-y-1 text-lg">
                        Lihat Menu
                    </a>
                    <a href="#locations" class="bg-stone-50 hover:bg-stone-100 text-gray-600 border border-stone-200 font-medium py-4 px-12 rounded-full transition-all text-lg">
                        Cari Lokasi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-32 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div class="flex justify-center items-center">
                    <img src="{{ asset('images/admin/gerobak.jpg') }}" class="w-full h-auto object-contain mix-blend-multiply" alt="Tumbas Coffee Gerobak">
                </div>
                
                <div>
                    <h2 class="text-xs text-tumbas font-semibold tracking-widest uppercase mb-4">Gerobak Keliling</h2>
                    <h3 class="text-3xl md:text-4xl font-semibold text-gray-900 mb-8 leading-tight">
                        Kopi Berkualitas, <br>Menjangkau <span class="font-light italic text-tumbas">Setiap Sudut Solo.</span>
                    </h3>
                    <p class="text-md text-gray-500 mb-10 leading-relaxed font-light">
                        Tumbas Coffee didesain untuk gaya hidup dinamis warga Solo. Dengan armada gerobak keliling yang modern, kami membawa cita rasa kopi premium dari biji pilihan langsung ke hadapan Anda.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-tumbas text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-lg shadow-tumbas/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-gray-700 font-medium">Sistem Seal Anti Tumpah (Aman Take-away)</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-tumbas text-white rounded-full flex items-center justify-center flex-shrink-0 shadow-lg shadow-tumbas/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-gray-700 font-medium">Es Batu Dipisah (Rasa Tetap Bold)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-xs text-tumbas font-semibold tracking-widest uppercase mb-4">Daftar Menu</h2>
                <h3 class="text-4xl md:text-5xl font-semibold text-gray-900 font-light">Pilihan Segar Hari Ini</h3>
                <p class="mt-4 text-gray-500 font-light">Harga mulai 7.500 - 15.000 per cup!</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                @php
                    $menuItems = [
                        ['name' => 'Coffee Latte', 'price' => '15K', 'price_liter' => '75K', 'desc' => 'Klasik espresso dengan susu lembut yang pas.'],
                        ['name' => 'Palm Sugar Latte', 'price' => '15K', 'price_liter' => '80K', 'desc' => 'Manis legit gula aren pilihan (Kopi Sadulur).'],
                        ['name' => 'Palm Coconut Latte', 'price' => '15K', 'price_liter' => '80K', 'desc' => 'Perpaduan gurih kelapa dan manis aren.'],
                        ['name' => 'Salted Caramel Latte', 'price' => '15K', 'price_liter' => '82K', 'desc' => 'Sentuhan mewah karamel gurih yang nagih.'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                    <div class="spotlight-card bg-stone-50 rounded-3xl overflow-hidden border border-stone-100 transition-all duration-500">
                        <div class="p-8 pb-0">
                            <img src="{{ asset('images/cup.png') }}" class="w-full h-auto object-contain" alt="{{ $item['name'] }}">
                        </div>
                        <div class="p-8">
                            <h4 class="text-xl font-medium text-gray-900 mb-2">{{ $item['name'] }}</h4>
                            <p class="text-xs text-gray-500 mb-6 font-light uppercase tracking-widest">Cup: {{ $item['price'] }} | 1L: {{ $item['price_liter'] }}</p>
                            <div class="h-1px w-full bg-stone-200 mb-6"></div>
                            <p class="text-sm text-gray-400 font-light italic">{{ $item['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Locations Section -->
    <section id="locations" class="py-32 bg-stone-900 text-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
                <div>
                    <h2 class="text-xs text-tumbas font-semibold tracking-widest uppercase mb-4">Temukan Kami</h2>
                    <h3 class="text-3xl md:text-4xl font-semibold mb-10 leading-tight">Mampir ke Gerobak Kami <br><span class="text-tumbas">di Wilayah Solo.</span></h3>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @forelse($areas as $area)
                            <div class="flex items-start gap-6 group p-4 rounded-3xl hover:bg-white/5 transition-all">
                                <div class="w-12 h-12 bg-white/5 rounded-2xl flex items-center justify-center border border-white/10 group-hover:bg-tumbas transition-colors">
                                    <svg class="w-6 h-6 text-tumbas group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xl font-medium mb-1 text-white/90">{{ $area->name }}</h4>
                                    <p class="text-gray-400 font-light text-sm">{{ $area->description }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 border border-white/10 rounded-3xl text-center">
                                <p class="text-gray-400 italic">Lokasi akan segera diperbarui. Pantau terus sosial media kami!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="relative">
                    <div class="bg-white/5 p-12 rounded-[3rem] border border-white/10 backdrop-blur-md">
                        <p class="text-xl font-light leading-relaxed italic mb-8 text-white/80">"Gak perlu ke cafe mahal, tinggal nunggu gerobaknya lewat atau mampir ke spot CFD. <br> Rasa kopinya bener-bener gak main-main!"</p>
                        <p class="text-tumbas font-semibold uppercase tracking-widest text-xs">- Coffee Lover Solo</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Ratings Section -->
    <section id="ratings" class="py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-xs text-tumbas font-semibold tracking-widest uppercase mb-4">Ulasan Jujur</h2>
                <h3 class="text-4xl md:text-5xl font-semibold text-gray-900 font-light">Kata Penikmat <span class="font-semibold">Tumbas</span></h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $testimonials = [
                        ['initials' => 'KP', 'handle' => '@kikycantikaputri', 'role' => 'Food Influencer', 'text' => 'Take away aman banget ada sealnya, es batunya dipisah jadi rasa gak hambar. Kopi Sadulur (Palm Sugar) manisnya cukup dan creamy!'],
                        ['initials' => 'MA', 'handle' => 'Mas Agus', 'role' => 'Penikmat Kopi', 'text' => 'Palm Coconut-nya bener-bener unik. Gurih santannya dapet, kopinya tetep kerasa. Favorit setiap mampir ke UNSA.'],
                        ['initials' => 'SN', 'handle' => 'Sari Ningsih', 'role' => 'Warga Solo', 'text' => 'Gak nyangka kopi gerobakan rasanya se-berani ini. Seal-nya kenceng, dibawa naik motor keliling Solo gak tumpah.'],
                    ];
                @endphp

                @foreach($testimonials as $testi)
                    <div class="spotlight-card bg-stone-50 p-12 rounded-[2.5rem] border border-stone-100 flex flex-col justify-between">
                        <div>
                            <div class="flex text-tumbas mb-8 opacity-60">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-gray-600 leading-relaxed italic mb-10 text-lg font-light">"{{ $testi['text'] }}"</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 @if($loop->index == 1) bg-gray-900 @elseif($loop->index == 2) bg-stone-200 @else bg-tumbas/10 @endif rounded-full flex items-center justify-center @if($loop->index == 1) text-white @else text-tumbas @endif font-medium text-xs">
                                {{ $testi['initials'] }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $testi['handle'] }}</p>
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest">{{ $testi['role'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Riders Career CTA -->
    <section id="rider-career" class="py-32 bg-tumbas text-white overflow-hidden relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-semibold mb-8">Tertarik Menjadi Bagian Dari Kami?</h2>
            <p class="text-xl text-white/80 mb-12 font-light leading-relaxed">
                Jadilah rider gerobak Tumbas Coffee dan bantu kami menyebarkan kesegaran kopi ke seluruh penjuru Solo.
            </p>
            <a href="{{ route('register') }}" class="inline-block bg-white text-tumbas font-medium py-5 px-16 rounded-full shadow-2xl transition-all transform hover:-translate-y-2 text-xl">
                Daftar Riders Career
            </a>
        </div>
    </section>

    <x-marketing.footer />
</x-layouts.marketing>


<nav class="fixed w-full z-50 transition-all duration-500" 
     :class="scrolled ? 'bg-white/95 backdrop-blur-md py-3 shadow-sm border-b border-gray-100' : 'bg-transparent py-6'">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            
            <div class="flex-shrink-0 flex items-center">
                <a href="#" class="text-2xl font-semibold tracking-tighter flex items-center gap-2">
                    <span class="bg-tumbas text-white px-2 py-0.5 rounded-lg">TUMBAS</span>
                    <span class="text-gray-900">COFFEE</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#hero" class="text-sm font-medium transition hover:text-tumbas text-gray-600">Beranda</a>
                <a href="#about" class="text-sm font-medium transition hover:text-tumbas text-gray-600">Tentang</a>
                <a href="#menu" class="text-sm font-medium transition hover:text-tumbas text-gray-600">Menu</a>
                <a href="#locations" class="text-sm font-medium transition hover:text-tumbas text-gray-600">Lokasi</a>
                <a href="#ratings" class="text-sm font-medium transition hover:text-tumbas text-gray-600">Ulasan</a>
                
                <div class="ml-4 flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-tumbas border border-tumbas/30 py-2 px-5 rounded-full hover:bg-tumbas/5 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium transition hover:text-tumbas text-gray-600">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-tumbas hover:bg-tumbas-dark text-white text-sm font-medium py-2.5 px-6 rounded-full shadow-lg shadow-tumbas/20 transition-all transform hover:scale-105">
                                    Riders Career
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" style="display:none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="md:hidden bg-white border-t border-gray-100 shadow-xl absolute w-full">
        <div class="px-4 py-6 space-y-4 font-medium">
            <a href="#hero" @click="mobileMenuOpen = false" class="block text-lg text-gray-800">Beranda</a>
            <a href="#about" @click="mobileMenuOpen = false" class="block text-lg text-gray-800">Tentang Kami</a>
            <a href="#menu" @click="mobileMenuOpen = false" class="block text-lg text-gray-800">Menu</a>
            <a href="#locations" @click="mobileMenuOpen = false" class="block text-lg text-gray-800">Lokasi</a>
            <hr>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="block text-center text-tumbas py-3 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block text-center text-gray-700 py-3">Masuk</a>
                    <a href="{{ route('register') }}" @click="mobileMenuOpen = false" class="block text-center bg-tumbas text-white py-3 rounded-xl">Riders Career</a>
                @endauth
            @endif
        </div>
    </div>
</nav>

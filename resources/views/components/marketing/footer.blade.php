<footer class="bg-white py-20 border-t border-stone-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-12 mb-16 text-center md:text-left">
            <div>
                <a href="#" class="text-3xl font-semibold tracking-tighter flex items-center justify-center md:justify-start gap-2 mb-6">
                    <span class="bg-tumbas text-white px-2 py-0.5 rounded-lg">TUMBAS</span>
                    <span class="text-gray-900">COFFEE</span>
                </a>
                <p class="text-gray-400 leading-relaxed font-light max-w-xs text-xs">
                    Kopi gerobak keliling independen terbesar di Surakarta.
                </p>
            </div>
            
            <div class="flex gap-12">
                <div>
                    <h4 class="text-gray-900 font-medium mb-6 uppercase tracking-widest text-[10px]">Navigasi</h4>
                    <ul class="space-y-4 text-gray-400 text-xs font-light">
                        <li><a href="#menu" class="hover:text-tumbas transition">Menu Kami</a></li>
                        <li><a href="#locations" class="hover:text-tumbas transition">Lokasi Solo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gray-900 font-medium mb-6 uppercase tracking-widest text-[10px]">Karir</h4>
                    <ul class="space-y-4 text-gray-400 text-xs font-light">
                        <li><a href="{{ route('register') }}" class="hover:text-tumbas transition">Daftar Rider</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="pt-12 border-t border-stone-50 flex flex-col md:flex-row justify-between items-center gap-6 text-gray-400 text-[10px] font-light">
            <p>&copy; {{ date('Y') }} Tumbas Group (Solo). All rights reserved.</p>
        </div>
    </div>
</footer>

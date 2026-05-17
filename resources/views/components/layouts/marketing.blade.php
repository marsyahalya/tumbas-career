<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title ?? 'Tumbas Coffee | Kopi Gerobak Keliling Solo' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Outfit', sans-serif; font-weight: 300; }
            
            .shiny-text {
                background: linear-gradient(120deg, rgba(255,255,255,0) 30%, rgba(255,255,255,0.8) 50%, rgba(255,255,255,0) 70%);
                background-size: 200% 100%;
                animation: shine 3s infinite;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            @keyframes shine {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }

            .spotlight-card {
                position: relative;
                overflow: hidden;
            }
            
            .spotlight-card::before {
                content: "";
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at var(--mouse-x, 50%) var(--mouse-y, 50%), rgba(255, 20, 0, 0.1), transparent 40%);
                opacity: 0;
                transition: opacity 0.3s;
                pointer-events: none;
            }

            .spotlight-card:hover::before {
                opacity: 1;
            }

            @keyframes rotate-rays {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .light-rays-container {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: -1;
                pointer-events: none;
            }

            .light-rays {
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: conic-gradient(
                    from 0deg at 50% 50%,
                    rgba(255, 20, 0, 0) 0deg,
                    rgba(255, 20, 0, 0.08) 15deg,
                    rgba(255, 20, 0, 0) 30deg,
                    rgba(255, 20, 0, 0.08) 45deg,
                    rgba(255, 20, 0, 0) 60deg,
                    rgba(255, 20, 0, 0.08) 75deg,
                    rgba(255, 20, 0, 0) 90deg,
                    rgba(255, 20, 0, 0.08) 105deg,
                    rgba(255, 20, 0, 0) 120deg,
                    rgba(255, 20, 0, 0.08) 135deg,
                    rgba(255, 20, 0, 0) 150deg,
                    rgba(255, 20, 0, 0.08) 165deg,
                    rgba(255, 20, 0, 0) 180deg,
                    rgba(255, 20, 0, 0.08) 195deg,
                    rgba(255, 20, 0, 0) 210deg,
                    rgba(255, 20, 0, 0.08) 225deg,
                    rgba(255, 20, 0, 0) 240deg,
                    rgba(255, 20, 0, 0.08) 255deg,
                    rgba(255, 20, 0, 0) 270deg,
                    rgba(255, 20, 0, 0.08) 285deg,
                    rgba(255, 20, 0, 0) 300deg,
                    rgba(255, 20, 0, 0.08) 315deg,
                    rgba(255, 20, 0, 0) 330deg,
                    rgba(255, 20, 0, 0.08) 345deg,
                    rgba(255, 20, 0, 0) 360deg
                );
                animation: rotate-rays 100s linear infinite;
                opacity: 0.8;
            }
        </style>
    </head>
    <body class="antialiased bg-white text-gray-600 font-light" 
          x-data="{ 
            mobileMenuOpen: false, 
            scrolled: false,
            handleMouseMove(e) {
                const cards = document.querySelectorAll('.spotlight-card');
                cards.forEach(card => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    card.style.setProperty('--mouse-x', `${x}px`);
                    card.style.setProperty('--mouse-y', `${y}px`);
                });
            }
          }" 
          @scroll.window="scrolled = (window.pageYOffset > 20)"
          @mousemove="handleMouseMove($event)">
        
        {{ $slot }}

    </body>
</html>

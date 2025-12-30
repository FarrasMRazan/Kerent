<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>K-Rent | Welcome</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;900&family=Inter:ital,wght@0,900;1,900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6366f1;
            --accent: #c084fc;
            --dark: #0f172a;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            overflow-x: hidden; /* Ubah ke hidden agar tidak scroll horizontal */
            background-color: #f8fafc;
        }

        .luxury-text { font-family: 'Outfit', sans-serif; }
        .logo-font { font-family: 'Inter', sans-serif; font-style: italic; }

        .mesh-gradient {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: -1;
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(251, 146, 60, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(45, 212, 191, 0.1) 0px, transparent 50%);
            animation: breathe 10s ease-in-out infinite alternate;
        }

        @keyframes breathe {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }

        .logo-sphere {
            width: 120px; height: 120px; border-radius: 35px;
            background: var(--dark); display: flex;
            align-items: center; justify-content: center;
            position: relative; overflow: hidden;
            box-shadow: 0 20px 40px -10px rgba(99, 102, 241, 0.4);
            animation: float 4s ease-in-out infinite;
        }

        .logo-sphere::before {
            content: ''; position: absolute; inset: -50%;
            background: conic-gradient(from 0deg, transparent, var(--primary), var(--accent), transparent);
            animation: spin 3s linear infinite;
        }

        .logo-sphere::after {
            content: ''; position: absolute; inset: 4px;
            background: var(--dark); border-radius: 31px;
        }

        .logo-inner-text {
            position: relative; z-index: 10;
            font-size: 4rem; font-weight: 900;
            color: #fff;
            text-shadow: 0 0 15px rgba(255,255,255,0.3);
        }

        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 48px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.08);
        }

        .reveal-up {
            animation: up 1.2s cubic-bezier(.19,1,.22,1) forwards;
            opacity: 0;
        }

        @keyframes up {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-6">
    
    <div class="mesh-gradient"></div>

    <main class="max-w-4xl w-full text-center">
        <div class="flex justify-center mb-10 reveal-up">
            <div class="logo-sphere">
                <span class="logo-inner-text logo-font">K</span>
            </div>
        </div>

        <div class="reveal-up" style="animation-delay: 0.2s">
            <h1 class="text-6xl md:text-8xl font-[900] logo-font tracking-tight text-slate-900 mb-6 uppercase">
                <span class="text-indigo-600">K</span>-Rent.
            </h1>
            <p class="text-slate-500 text-lg md:text-xl max-w-xl mx-auto mb-16 leading-relaxed font-medium">
                Pusat penyewaan kostum premium dengan kualitas <br class="hidden md:block"> standar tinggi untuk penyewaan terbaik Anda.
            </p>
        </div>

        <div class="glass-panel p-8 md:p-10 inline-block reveal-up" style="animation-delay: 0.4s">
            <div class="flex flex-col items-center gap-8">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-[2px] bg-slate-200"></div>
                    <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.4em]">Jadi Bagian K-Rent</p>
                    <div class="w-10 h-[2px] bg-slate-200"></div>
                </div>

                <div class="flex flex-col md:flex-row gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="bg-slate-900 hover:bg-indigo-600 text-white px-16 py-5 rounded-[24px] font-black luxury-text text-sm tracking-widest transition-all shadow-xl active:scale-95">
                                DASHBOARD
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="bg-slate-900 hover:bg-indigo-600 text-white px-16 py-5 rounded-[24px] font-black luxury-text text-sm tracking-widest transition-all shadow-xl active:scale-95">
                                LOGIN
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="bg-white text-slate-700 border border-slate-200 hover:border-indigo-600 px-16 py-5 rounded-[24px] font-black luxury-text text-sm tracking-widest transition-all active:scale-95">
                                    REGISTER
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-20 flex justify-center gap-12 opacity-30 reveal-up" style="animation-delay: 0.6s">
            <span class="text-[10px] font-black text-slate-800 tracking-[0.6em] uppercase">Premium</span>
            <span class="text-[10px] font-black text-slate-800 tracking-[0.6em] uppercase">Authentic</span>
            <span class="text-[10px] font-black text-slate-800 tracking-[0.6em] uppercase">Archive</span>
        </div>
    </main>
</body>
</html>
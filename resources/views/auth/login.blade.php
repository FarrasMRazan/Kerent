<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | K-Rent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            letter-spacing: -0.01em;
        }
    </style>
</head>

<body class="antialiased bg-[#f8fafc] text-slate-900">
    <div class="min-h-screen flex items-center justify-center p-6">

        <div class="w-full max-w-[480px] bg-white rounded-[40px] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] p-10 md:p-14 border border-slate-100">

            <div class="mb-12 text-center">
                <h1 class="text-5xl font-[900] text-slate-800 leading-none tracking-tight italic uppercase">
                    <span class="text-indigo-600">K</span>-Rent.
                </h1>
                <p class="text-slate-500 font-bold text-sm uppercase tracking-[0.3em] mt-6">
                    Premium Costume Rental
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 text-sm font-bold text-green-600 bg-green-50 p-4 rounded-2xl text-center border border-green-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-7">
                @csrf

                <div class="space-y-3">
                    <label for="email" class="block text-xs font-[900] text-indigo-600 uppercase tracking-widest ml-1">
                        Email Address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-semibold text-base text-slate-700 placeholder-slate-400 transition-all outline-none shadow-sm"
                        placeholder="e.g. name@email.com">
                    @if ($errors->get('email'))
                        <p class="text-xs font-bold text-red-500 mt-2 ml-1">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>

                <div class="space-y-3">
                    <label for="password" class="block text-xs font-[900] text-indigo-600 uppercase tracking-widest ml-1">
                        Password
                    </label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white rounded-2xl font-semibold text-base text-slate-700 placeholder-slate-400 transition-all outline-none shadow-sm"
                        placeholder="••••••••">
                    @if ($errors->get('password'))
                        <p class="text-xs font-bold text-red-500 mt-2 ml-1">
                            {{ $errors->first('password') }}
                        </p>
                    @endif
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember"
                                class="w-5 h-5 rounded-md border-2 border-slate-200 bg-white text-indigo-600 focus:ring-0 transition-all cursor-pointer">
                        </div>
                        <span class="ml-3 text-sm font-bold text-slate-500 group-hover:text-indigo-600 transition-all">
                            Keep me logged in
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-all underline decoration-transparent hover:decoration-indigo-200 underline-offset-4">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-5 bg-slate-900 hover:bg-indigo-600 text-white rounded-2xl font-black uppercase text-sm tracking-[0.2em] shadow-xl shadow-slate-200 transition-all active:scale-[0.98] transform">
                        Sign In to Account
                    </button>
                </div>
            </form>

            <div class="mt-12 text-center border-t border-slate-100 pt-10">
                <p class="text-sm text-slate-500 font-medium">
                    New to K-Rent? 
                    <a href="{{ route('register') }}"
                        class="text-indigo-600 hover:text-slate-900 font-black ml-1 transition-all underline underline-offset-4 decoration-indigo-200 hover:decoration-slate-900">
                        Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
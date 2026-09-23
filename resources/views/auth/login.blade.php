<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Library System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Decorative animated blobs */
        .blob {
            position: absolute;
            filter: blur(80px);
            z-index: 0;
            opacity: 0.6;
            animation: pulse 8s infinite alternate;
        }
        @keyframes pulse {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.1) translate(20px, -20px); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased relative min-h-screen flex items-center justify-center overflow-hidden">
    
    <!-- Background Decor (Animated Gradient Blobs) -->
    <div class="blob bg-green-200 w-96 h-96 rounded-full top-[-10%] left-[-10%]"></div>
    <div class="blob bg-emerald-200 w-96 h-96 rounded-full bottom-[-10%] right-[-10%]" style="animation-delay: 2s;"></div>
    <div class="blob bg-teal-100 w-80 h-80 rounded-full top-[20%] right-[10%]" style="animation-delay: 4s;"></div>

    <div class="w-full max-w-md px-6 z-10 relative">
        <!-- Premium Glassmorphism Card -->
        <div class="bg-white/85 backdrop-blur-2xl border border-white/50 shadow-[0_20px_50px_rgba(8,112,50,0.1)] rounded-3xl p-8 sm:p-10 w-full relative overflow-hidden">
            
            <!-- Top highlight line -->
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-green-400 to-emerald-600"></div>

            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-green-50 text-emerald-600 mb-5 shadow-sm border border-green-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">SIMPER</h2>
                <p class="text-sm text-gray-500 font-medium">Sistem Informasi Perpustakaan</p>
            </div>

            <x-auth-session-status class="mb-5 text-emerald-700 bg-emerald-50 p-3 rounded-xl text-sm font-medium border border-emerald-200 shadow-sm" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                               class="block w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all sm:text-sm shadow-sm placeholder-gray-400" placeholder="admin@example.com">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs font-medium" />
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password" 
                               class="block w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 focus:bg-white transition-all sm:text-sm shadow-sm placeholder-gray-400" placeholder="••••••••">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-emerald-600 focus:outline-none transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eyeSlashIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs font-medium" />
                </div>

    

                <!-- Submit Button -->
                <div class="pt-4 pb-2">
                    <button type="submit" class="group w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transform hover:-translate-y-0.5 transition-all duration-200">
                        Login
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 font-medium tracking-wide">
                &copy;copyright 2026 &mdash; Muhammad Arief Tri Faturachman.
            </p>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');
        const eyeSlashIcon = document.querySelector('#eyeSlashIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            // toggle the eye / eye slash icon
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>
</body>
</html>

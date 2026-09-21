<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام إدارة المستشفى</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        .login-bg {
            background: linear-gradient(135deg, #2563eb 0%, #60a5fa 42%, #dbeafe 100%);
        }

        .floating-orb {
            position: absolute;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.10);
            filter: blur(2px);
            animation: floatOrb 12s ease-in-out infinite alternate;
        }

        .floating-orb.one {
            width: 22rem;
            height: 22rem;
            top: -6rem;
            left: -6rem;
        }

        .floating-orb.two {
            width: 28rem;
            height: 28rem;
            right: -10rem;
            bottom: -10rem;
            animation-delay: 1.5s;
        }

        .login-card {
            animation: floatCard 6s ease-in-out infinite;
        }

        .icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.25rem;
            height: 1.25rem;
            color: currentColor;
            line-height: 1;
        }

        .icon-wrap svg,
        .icon-svg {
            display: block;
            width: 100%;
            height: 100%;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.9;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        @keyframes floatOrb {
            0% { transform: translate3d(0, 0, 0) scale(1); }
            100% { transform: translate3d(20px, -20px, 0) scale(1.08); }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
    </style>
</head>
<body class="login-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <div class="floating-orb one"></div>
    <div class="floating-orb two"></div>

    <div class="w-full max-w-md relative z-10" data-aos="fade-up" data-aos-duration="700">
        <div class="bg-white/95 rounded-3xl shadow-2xl p-8 relative backdrop-blur-sm login-card" data-aos="zoom-in" data-aos-delay="120">
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-700 to-blue-900 rounded-2xl flex items-center justify-center shadow-xl mb-4 ring-4 ring-white/60" data-aos="pulse" data-aos-delay="200">
                    <span class="icon-wrap text-white">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                            <path d="M4 15.5C4 9.7 8.5 5 13.8 5c2.5 0 4.8 1 6.6 2.7M20 8.5V5h-3.5"/>
                            <path d="M20 8.5c0 5.8-4.5 10.5-10.2 10.5-2.5 0-4.8-1-6.6-2.7M4 15.5V19h3.5"/>
                            <path d="M10 12h4"/>
                            <path d="M12 10v4"/>
                        </svg>
                    </span>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800" data-aos="fade-down" data-aos-delay="140">نظام إدارة المستشفى</h1>
                <p class="text-sm text-gray-500 mt-2" data-aos="fade-down" data-aos-delay="180">ليس لديك حساب؟ جرّب الحساب التجريبي</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm" data-aos="shake" data-aos-duration="500">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2">
                            <span class="icon-wrap">
                                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 8v4"></path>
                                    <path d="M12 16h.01"></path>
                                </svg>
                            </span>
                            {{ $error }}
                        </p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5" data-aos="fade-up" data-aos-delay="220">
                @csrf

                <div data-aos="fade-left" data-aos-delay="240">
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                    <div class="relative">
                        <span class="icon-wrap text-gray-400 absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                <path d="M4 6h16v12H4z"></path>
                                <path d="M4 7l8 6 8-6"></path>
                            </svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition"
                               placeholder="admin@hospital.com">
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-delay="260">
                    <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور</label>
                    <div class="relative">
                        <span class="icon-wrap text-gray-400 absolute right-3 top-1/2 -translate-y-1/2">
                            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                            </svg>
                        </span>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="280">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        تذكرني
                    </label>
                </div>

                <button type="submit" data-button-glow
                        class="w-full py-3 bg-gradient-to-l from-blue-600 to-blue-800 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2"
                        data-aos="zoom-in" data-aos-delay="300">
                    <span class="icon-wrap">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                            <path d="M15 7l5 5-5 5"></path>
                            <path d="M20 12H9"></path>
                            <path d="M13 5V3"></path>
                            <path d="M13 21v-2"></path>
                        </svg>
                    </span>
                    تسجيل الدخول
                </button>
            </form>

            <div class="mt-8 p-4 bg-blue-50 border border-blue-100 rounded-xl" data-aos="fade-up" data-aos-delay="340">
                <p class="text-xs text-blue-700 font-medium mb-2 flex items-center gap-1">
                    <span class="icon-wrap">
                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 11v5"></path>
                            <path d="M12 7h.01"></path>
                        </svg>
                    </span>
                    حسابات تجريبية:
                </p>
                <div class="space-y-1 text-xs text-blue-600">
                    <p><span class="font-bold">المدير:</span> admin@hospital.com</p>
                    <p><span class="font-bold">كلمة المرور:</span> password</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
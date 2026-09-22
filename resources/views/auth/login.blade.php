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

        /* ---------- Background (decor only, always behind content) ---------- */
        .login-bg {
            background: linear-gradient(140deg, #1e3a8a 0%, #1d4ed8 48%, #3b82f6 100%);
        }

        .bg-pattern {
            background-image:
                radial-gradient(rgba(255, 255, 255, 0.12) 1.5px, transparent 1.5px),
                radial-gradient(rgba(255, 255, 255, 0.06) 1.5px, transparent 1.5px);
            background-size: 38px 38px, 19px 19px;
            background-position: 0 0, 9px 9px;
            mask-image: linear-gradient(135deg, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.3));
        }

        .bg-orb {
            position: absolute;
            border-radius: 9999px;
            background: radial-gradient(closest-side, rgba(255, 255, 255, 0.16), rgba(255, 255, 255, 0) 72%);
            animation: drift 14s ease-in-out infinite alternate;
            pointer-events: none;
        }

        .orb-a {
            width: 26rem;
            height: 26rem;
            top: -8rem;
            inset-inline-end: -8rem;
        }

        .orb-b {
            width: 22rem;
            height: 22rem;
            bottom: -7rem;
            inset-inline-start: -7rem;
            animation-delay: 2s;
        }

        .med-cross {
            position: absolute;
            width: 34rem;
            height: 34rem;
            top: 50%;
            inset-inline-end: -14rem;
            transform: translateY(-50%);
            opacity: 0.06;
            pointer-events: none;
        }

        @keyframes drift {
            0% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            100% {
                transform: translate3d(-18px, 14px, 0) scale(1.06);
            }
        }

        /* ---------- Login card ---------- */
        .login-card {
            background: rgba(255, 255, 255, 0.965);
            backdrop-filter: blur(10px);
        }

        /* ---------- Form fields ---------- */
        .field-group {
            position: relative;
        }

        .field-group input {
            width: 100%;
            height: 3rem;
            padding: 0.6rem 2.75rem 0.6rem 2.9rem;
            font-size: 0.9rem;
            color: #1e293b;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.8rem;
            transition: border-color 200ms ease, box-shadow 200ms ease, background 200ms ease;
        }

        .field-group input::placeholder {
            color: #cbd5e1;
        }

        .field-group input:hover:not(:focus) {
            border-color: #cbd5e1;
        }

        .field-group input:focus {
            outline: none;
            background: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .field-group .field-icon {
            position: absolute;
            inset-inline-start: 0.95rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
            transition: color 200ms ease;
        }

        .field-group input:focus ~ .field-icon {
            color: #2563eb;
        }

        .field-group .password-toggle {
            position: absolute;
            inset-inline-end: 0.7rem;
            top: 50%;
            transform: translateY(-50%);
            width: 2.25rem;
            height: 2.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            border-radius: 0.6rem;
            transition: color 200ms ease, background 200ms ease;
        }

        .field-group .password-toggle:hover {
            color: #2563eb;
            background: rgba(37, 99, 235, 0.08);
        }

        /* ---------- Submit button ---------- */
        .login-submit {
            background: linear-gradient(90deg, #1d4ed8 0%, #2563eb 100%);
            transition: transform 200ms ease, box-shadow 200ms ease, filter 200ms ease;
            box-shadow: 0 10px 24px -8px rgba(37, 99, 235, 0.55);
        }

        .login-submit:hover {
            filter: brightness(1.06);
            box-shadow: 0 14px 30px -8px rgba(37, 99, 235, 0.65);
        }

        .login-submit:active {
            transform: scale(0.985);
        }

        .login-submit:disabled {
            cursor: not-allowed;
            filter: saturate(0.6) brightness(0.95);
            box-shadow: none;
        }

        /* ---------- Demo account box ---------- */
        .demo-chip {
            cursor: pointer;
            transition: transform 200ms ease, border-color 200ms ease, background 200ms ease;
        }

        .demo-chip:hover {
            transform: translateY(-1px);
            border-color: #93c5fd;
            background: #eff6ff;
        }

        .demo-chip:active {
            transform: translateY(0);
        }

        /* ---------- Feature rows ---------- */
        .feature-row {
            transition: transform 200ms ease;
        }

        .feature-row:hover {
            transform: translateX(-4px);
        }

        @media (prefers-reduced-motion: reduce) {
            .feature-row:hover {
                transform: none;
            }

            .bg-orb {
                animation: none;
            }
        }

        /* ---------- Icons (proportional sizes) ---------- */
        .icon-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.15rem;
            height: 1.15rem;
            color: currentColor;
            line-height: 1;
            flex-shrink: 0;
        }

        .icon-md {
            width: 1.35rem;
            height: 1.35rem;
        }

        .icon-lg {
            width: 1.55rem;
            height: 1.55rem;
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

        /* ---------- Subtle ECG footer (decor only) ---------- */
        .ecg-bar {
            position: absolute;
            inset-inline: 0;
            bottom: 0;
            height: 4rem;
            overflow: hidden;
            pointer-events: none;
            opacity: 0.4;
        }

        .ecg-bar svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .ecg-base {
            stroke: rgba(255, 255, 255, 0.3);
        }

        .ecg-line {
            stroke: rgba(255, 255, 255, 0.85);
            stroke-dasharray: 1000;
            stroke-dashoffset: 1000;
            animation: ecgDraw 7s linear infinite;
        }

        @keyframes ecgDraw {
            to {
                stroke-dashoffset: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .ecg-line {
                stroke-dashoffset: 0;
                animation: none;
            }
        }
    </style>
</head>
<body class="login-bg min-h-screen relative overflow-hidden">

    <!-- Background decorations: always behind content (grid is z-10) -->
    <div class="bg-pattern absolute inset-0 pointer-events-none"></div>
    <svg class="med-cross" viewBox="0 0 100 100" aria-hidden="true">
        <rect x="38" y="8" width="24" height="84" fill="#ffffff"/>
        <rect x="8" y="38" width="84" height="24" fill="#ffffff"/>
    </svg>
    <div class="bg-orb orb-a"></div>
    <div class="bg-orb orb-b"></div>

    <div class="w-full max-w-6xl mx-auto lg:grid lg:grid-cols-2 lg:min-h-screen relative z-10">

        <!-- ============ Hospital branding panel (desktop) ============ -->
        <div class="hidden lg:flex flex-col justify-between py-16 ps-12 pe-8 xl:ps-20 text-white">

            <div>
                <div class="flex items-center gap-4" data-aos="fade-down" data-aos-delay="60">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 ring-1 ring-white/30 backdrop-blur-sm flex items-center justify-center">
                        <span class="icon-wrap icon-lg text-white">
                            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                <path d="M4 15.5C4 9.7 8.5 5 13.8 5c2.5 0 4.8 1 6.6 2.7M20 8.5V5h-3.5"/>
                                <path d="M20 8.5c0 5.8-4.5 10.5-10.2 10.5-2.5 0-4.8-1-6.6-2.7M4 15.5V19h3.5"/>
                                <path d="M10 12h4"/>
                                <path d="M12 10v4"/>
                            </svg>
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight">نظام إدارة المستشفى</h1>
                        <p class="text-blue-100/90 text-sm mt-0.5">منصة متكاملة لإدارة المستشفيات</p>
                    </div>
                </div>

                <div class="mt-14 space-y-7">
                    <div class="feature-row flex items-start gap-4" data-aos="fade-right" data-aos-delay="120">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm flex items-center justify-center">
                            <span class="icon-wrap text-white">
                                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                    <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                                    <path d="M16 2v4M8 2v4M3 10h18"></path>
                                </svg>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm">إدارة المواعيد والمرضى</h3>
                            <p class="text-blue-100/80 text-xs mt-1 leading-relaxed">حجز ومتابعة المواعيد وملفات المرضى بسهولة تامة.</p>
                        </div>
                    </div>

                    <div class="feature-row flex items-start gap-4" data-aos="fade-right" data-aos-delay="180">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm flex items-center justify-center">
                            <span class="icon-wrap text-white">
                                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <path d="M14 2v6h6"></path>
                                    <path d="M9 13h6M9 17h6"></path>
                                </svg>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm">سجلات طبية ووصفات إلكترونية</h3>
                            <p class="text-blue-100/80 text-xs mt-1 leading-relaxed">توثيق الحالات والوصفات والتحاليل آليًا ودون أوراق.</p>
                        </div>
                    </div>

                    <div class="feature-row flex items-start gap-4" data-aos="fade-right" data-aos-delay="240">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm flex items-center justify-center">
                            <span class="icon-wrap text-white">
                                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                    <path d="M3 3v18h18"></path>
                                    <path d="M7 13l4-4 3 3 5-6"></path>
                                </svg>
                            </span>
                        </div>
                        <div>
                            <h3 class="font-bold text-white text-sm">تقارير وإحصائيات لحظية</h3>
                            <p class="text-blue-100/80 text-xs mt-1 leading-relaxed">تابع الأداء والإيرادات في لوحة واحدة واضحة.</p>
                        </div>
                    </div>
                </div>
            </div>

            <p class="text-blue-100/70 text-xs mt-12" data-aos="fade-up" data-aos-delay="300">© 2026 نظام إدارة المستشفى</p>
        </div>

        <!-- ============ Login panel ============ -->
        <div class="flex items-center justify-center py-10 px-4 sm:px-8 lg:py-16">

            <div class="w-full max-w-md" data-aos="fade-up" data-aos-duration="650">

                <!-- Compact brand for mobile/tablet -->
                <div class="lg:hidden flex flex-col items-center gap-3 mb-6 text-white text-center">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 ring-1 ring-white/30 backdrop-blur-sm flex items-center justify-center">
                        <span class="icon-wrap icon-lg text-white">
                            <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                <path d="M4 15.5C4 9.7 8.5 5 13.8 5c2.5 0 4.8 1 6.6 2.7M20 8.5V5h-3.5"/>
                                <path d="M20 8.5c0 5.8-4.5 10.5-10.2 10.5-2.5 0-4.8-1-6.6-2.7M4 15.5V19h3.5"/>
                                <path d="M10 12h4"/>
                                <path d="M12 10v4"/>
                            </svg>
                        </span>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold">نظام إدارة المستشفى</h1>
                        <p class="text-blue-100 text-xs mt-1">منصة متكاملة لإدارة المستشفيات</p>
                    </div>
                </div>

                <div class="login-card rounded-3xl shadow-2xl shadow-blue-900/20 p-8 sm:p-9">

                    <div class="mb-8">
                        <p class="text-xs font-semibold text-blue-600 tracking-wide">مرحبًا بك</p>
                        <h2 class="text-xl font-extrabold text-slate-800 mt-1">تسجيل الدخول إلى النظام</h2>
                        <p class="text-sm text-slate-500 mt-1.5">أدخل بياناتك للوصول إلى لوحة التحكم</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 p-3.5 rounded-xl border border-red-200 bg-red-50 text-red-700 text-sm" role="alert" data-aos="shake" data-aos-duration="500">
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

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <div class="field-group" data-aos="fade-left" data-aos-delay="120">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">البريد الإلكتروني</label>
                            <div class="relative">
                                <input type="email" id="email" name="email" value="{{ old('email') }}"
                                       required autofocus autocomplete="email"
                                       placeholder="admin@hospital.com">
                                <span class="field-icon">
                                    <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                        <path d="M4 6h16v12H4z"></path>
                                        <path d="M4 7l8 6 8-6"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="field-group" data-aos="fade-left" data-aos-delay="160">
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">كلمة المرور</label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                       required autocomplete="current-password" placeholder="••••••••">
                                <span class="field-icon">
                                    <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                        <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                        <path d="M8 11V8a4 4 0 0 1 8 0v3"></path>
                                    </svg>
                                </span>
                                <button type="button" id="password-toggle" class="password-toggle"
                                        tabindex="-1" aria-label="إظهار كلمة المرور" title="إظهار كلمة المرور">
                                    <span id="icon-eye" class="icon-wrap hidden">
                                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </span>
                                    <span id="icon-eye-off" class="icon-wrap hidden">
                                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                            <path d="M17.9 17.9A10.4 10.4 0 0 1 12 20c-6.5 0-10-8-10-8a18.8 18.8 0 0 1 5.3-5.6M9.9 4.2A9.9 9.9 0 0 1 12 4c6.5 0 10 8 10 8a18.9 18.9 0 0 1-2.9 4.3"></path>
                                            <path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path>
                                            <path d="M3 3l18 18"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center justify-between" data-aos="fade-right" data-aos-delay="200">
                            <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                                <input type="checkbox" name="remember"
                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 w-4 h-4">
                                تذكرني
                            </label>
                        </div>

                        <button type="submit" data-button-glow data-loading-text="جارٍ تسجيل الدخول..."
                                class="login-submit w-full h-12 rounded-xl text-white font-bold text-sm flex items-center justify-center gap-2"
                                data-aos="zoom-in" data-aos-delay="240">
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

                    <div class="mt-8 p-4 rounded-2xl border border-blue-100 bg-blue-50/70" data-aos="fade-up" data-aos-delay="280">
                        <p class="text-xs font-bold text-blue-700 flex items-center gap-1.5 mb-2.5">
                            <span class="icon-wrap">
                                <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                    <circle cx="12" cy="12" r="9"></circle>
                                    <path d="M12 11v5"></path>
                                    <path d="M12 7h.01"></path>
                                </svg>
                            </span>
                            حسابات تجريبية — اضغط للتعبئة تلقائيًا
                        </p>
                        <button type="button" class="demo-chip w-full text-right p-3 rounded-xl bg-white border border-blue-100 text-xs"
                                onclick="fillDemo('admin@hospital.com', 'password')"
                                aria-label="تعبئة حساب المدير">
                            <span class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                                    <span class="icon-wrap">
                                        <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                            <circle cx="12" cy="8" r="4"></circle>
                                            <path d="M4 20c1.5-3.5 4.5-5 8-5s6.5 1.5 8 5"></path>
                                        </svg>
                                    </span>
                                </span>
                                <span class="flex-1">
                                    <span class="block text-slate-800 font-bold">المدير</span>
                                    <span class="block text-slate-500 mt-0.5" dir="ltr">admin@hospital.com</span>
                                </span>
                                <span class="icon-wrap text-blue-400">
                                    <svg class="icon-svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none">
                                        <path d="M5 12h14"></path>
                                        <path d="M13 6l6 6-6 6"></path>
                                    </svg>
                                </span>
                            </span>
                        </button>
                    </div>
                </div>

                <p class="text-center text-blue-100/80 text-xs mt-6 lg:hidden">© 2026 نظام إدارة المستشفى</p>
            </div>
        </div>
    </div>

    <!-- Subtle ECG footer (decor only, behind content) -->
    <div class="ecg-bar" aria-hidden="true">
        <svg viewBox="0 0 1200 64" preserveAspectRatio="none">
            <path class="ecg-base" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                  d="M0,36 H190 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H470 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H750 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H1030 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H1200"/>
            <path class="ecg-line" pathLength="1000" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                  d="M0,36 H190 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H470 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H750 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H1030 l12,-14 l10,26 l14,-36 l12,48 l10,-24 H1200"/>
        </svg>
    </div>

    <script>
        const emailInput = document.getElementById('email');
        const passInput = document.getElementById('password');
        const toggleBtn = document.getElementById('password-toggle');
        const iconEye = document.getElementById('icon-eye');
        const iconEyeOff = document.getElementById('icon-eye-off');

        iconEyeOff.classList.remove('hidden');

        toggleBtn.addEventListener('click', () => {
            const show = passInput.type === 'password';
            passInput.type = show ? 'text' : 'password';
            iconEye.classList.toggle('hidden', !show);
            iconEyeOff.classList.toggle('hidden', show);
        });

        function fillDemo(email, password) {
            emailInput.value = email;
            passInput.value = password;
            emailInput.focus();
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نظام إدارة المستشفى')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'tajawal': ['Tajawal', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        medical: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Tajawal', sans-serif; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { transform: translateX(-4px); }
        .sidebar-link.active { background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
        .glass { background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 font-tajawal">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('layouts.header')

            <main class="page-shell flex-1 overflow-y-auto p-6" data-aos="fade-up" data-aos-delay="50">
                @if(session('success'))
                    <div class="alert-box mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded-xl flex items-center gap-2" data-aos="fade-down" data-aos-delay="80">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-box mb-4 p-4 bg-red-100 border border-red-300 text-red-800 rounded-xl" data-aos="fade-down" data-aos-delay="80">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-6" data-aos="fade-up" data-aos-delay="120">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>

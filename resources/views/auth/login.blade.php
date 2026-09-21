<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - نظام إدارة المستشفى</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-96 h-96 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-white/5 rounded-full translate-x-1/3 translate-y-1/3"></div>

    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl p-8 relative">
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-700 to-blue-900 rounded-2xl flex items-center justify-center shadow-xl mb-4">
                    <i data-lucide="heart-pulse" class="w-10 h-10 text-white"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-gray-800">نظام إدارة المستشفى</h1>
                <p class="text-sm text-gray-500 mt-2">ليس لديك حساب؟ جرّب الحساب التجريبي</p>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                    @foreach($errors->all() as $error)
                        <p class="flex items-center gap-2"><i data-lucide="alert-circle" class="w-4 h-4"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition"
                               placeholder="admin@hospital.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">كلمة المرور</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2"></i>
                        <input type="password" name="password" required
                               class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        تذكرني
                    </label>
                </div>

                <button type="submit"
                        class="w-full py-3 bg-gradient-to-l from-blue-600 to-blue-800 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-900 transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2">
                    <i data-lucide="log-in" class="w-5 h-5"></i>
                    تسجيل الدخول
                </button>
            </form>

            <div class="mt-8 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                <p class="text-xs text-blue-700 font-medium mb-2 flex items-center gap-1"><i data-lucide="info" class="w-4 h-4"></i> حسابات تجريبية:</p>
                <div class="space-y-1 text-xs text-blue-600">
                    <p><span class="font-bold">المدير:</span> admin@hospital.com</p>
                    <p><span class="font-bold">كلمة المرور:</span> password</p>
                </div>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
</body>
</html>
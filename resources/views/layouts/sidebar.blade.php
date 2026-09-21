<aside class="w-72 bg-white border-l border-gray-200 flex flex-col shadow-lg">
    <div class="p-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-blue-800 rounded-xl flex items-center justify-center shadow-lg">
                <i data-lucide="heart-pulse" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-gray-800">نظام المستشفى</h1>
                <p class="text-xs text-gray-500">Hospital Management</p>
            </div>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="font-medium">لوحة التحكم</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">الإدارة</div>

        <a href="{{ route('patients.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('patients.*') ? 'active' : '' }}">
            <i data-lucide="users" class="w-5 h-5"></i>
            <span class="font-medium">المرضى</span>
        </a>

        <a href="{{ route('doctors.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
            <i data-lucide="stethoscope" class="w-5 h-5"></i>
            <span class="font-medium">الأطباء</span>
        </a>

        <a href="{{ route('departments.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <i data-lucide="building-2" class="w-5 h-5"></i>
            <span class="font-medium">الأقسام</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">الطبي</div>

        <a href="{{ route('appointments.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('appointments.*') ? 'active' : '' }}">
            <i data-lucide="calendar-check" class="w-5 h-5"></i>
            <span class="font-medium">المواعيد</span>
        </a>

        <a href="{{ route('medical-records.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('medical-records.*') ? 'active' : '' }}">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span class="font-medium">السجلات الطبية</span>
        </a>

        <a href="{{ route('prescriptions.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('prescriptions.*') ? 'active' : '' }}">
            <i data-lucide="pill" class="w-5 h-5"></i>
            <span class="font-medium">الوصفات الطبية</span>
        </a>

        <a href="{{ route('lab-tests.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('lab-tests.*') ? 'active' : '' }}">
            <i data-lucide="flask-conical" class="w-5 h-5"></i>
            <span class="font-medium">التحاليل المخبرية</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">الإقامة</div>

        <a href="{{ route('rooms.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <i data-lucide="door-open" class="w-5 h-5"></i>
            <span class="font-medium">الغرف</span>
        </a>

        <a href="{{ route('beds.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('beds.*') ? 'active' : '' }}">
            <i data-lucide="bed-double" class="w-5 h-5"></i>
            <span class="font-medium">إدارة الأسرّة</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">المالية</div>

        <a href="{{ route('invoices.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            <i data-lucide="receipt" class="w-5 h-5"></i>
            <span class="font-medium">الفواتير</span>
        </a>

        <a href="{{ route('inventory.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
            <i data-lucide="package" class="w-5 h-5"></i>
            <span class="font-medium">المخزون</span>
        </a>

        <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">التقارير</div>

        <a href="{{ route('reports.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
            <span class="font-medium">التقارير</span>
        </a>

        @if(auth()->user()->isAdmin())
        <div class="pt-4 pb-2 px-4 text-xs font-bold text-gray-400 uppercase tracking-wider">النظام</div>

        <a href="{{ route('users.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i data-lucide="settings" class="w-5 h-5"></i>
            <span class="font-medium">المستخدمين</span>
        </a>

        <a href="{{ route('audit-logs.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-blue-50 {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
            <i data-lucide="scroll-text" class="w-5 h-5"></i>
            <span class="font-medium">سجل المراجعة</span>
        </a>
        @endif
    </nav>

    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center gap-3 px-4 py-2">
            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

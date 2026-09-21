@extends('layouts.app')

@section('title', 'المستخدمون')
@section('page-title', 'إدارة المستخدمين')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <div class="flex flex-col md:flex-row gap-4 justify-between items-center">
            <form method="GET" class="flex flex-col md:flex-row gap-3 flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم أو البريد..."
                       class="flex-1 px-4 py-2.5 border border-gray-300 rounded-xl">
                <select name="role" class="px-4 py-2.5 border border-gray-300 rounded-xl">
                    <option value="">كل الأدوار</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                    <option value="doctor" {{ request('role') == 'doctor' ? 'selected' : '' }}>طبيب</option>
                    <option value="receptionist" {{ request('role') == 'receptionist' ? 'selected' : '' }}>استقبال</option>
                    <option value="accountant" {{ request('role') == 'accountant' ? 'selected' : '' }}>محاسب</option>
                    <option value="lab_technician" {{ request('role') == 'lab_technician' ? 'selected' : '' }}>فني مختبر</option>
                    <option value="pharmacist" {{ request('role') == 'pharmacist' ? 'selected' : '' }}>صيدلي</option>
                    <option value="nurse" {{ request('role') == 'nurse' ? 'selected' : '' }}>ممرض</option>
                    <option value="staff" {{ request('role') == 'staff' ? 'selected' : '' }}>موظف</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                    بحث
                </button>
            </form>
            <a href="{{ route('users.create') }}" class="px-6 py-2.5 bg-gradient-to-l from-green-600 to-green-700 text-white rounded-xl font-semibold hover:from-green-700 hover:to-green-800 transition flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5"></i>
                إضافة مستخدم
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المستخدم</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">البريد</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الدور</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">آخر دخول</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الحالة</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600" dir="ltr">{{ $user->email }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($user->role == 'admin') bg-purple-100 text-purple-600
                                    @elseif($user->role == 'doctor') bg-blue-100 text-blue-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ match($user->role) { 'admin' => 'مدير', 'doctor' => 'طبيب', 'receptionist' => 'استقبال', 'accountant' => 'محاسب', 'lab_technician' => 'فني مختبر', 'pharmacist' => 'صيدلي', 'nurse' => 'ممرض', 'staff' => 'موظف' } }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y h:i A') : '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $user->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ $user->is_active ? 'نشط' : 'معطل' }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('حذف هذا المستخدم؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-16 text-center text-gray-400">لا يوجد مستخدمون</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
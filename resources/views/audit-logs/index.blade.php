@extends('layouts.app')

@section('title', 'سجل المراجعة')
@section('page-title', 'سجل المراجعة والنشاطات')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5" data-aos="fade-down" data-aos-delay="80">
        <form method="GET" class="flex flex-col md:flex-row gap-3" data-aos="fade-left" data-aos-delay="120">
            <input type="text" name="user_id" value="{{ request('user_id') }}" placeholder="معرف المستخدم"
                   class="px-4 py-2.5 border border-gray-300 rounded-xl">
            <input type="text" name="action" value="{{ request('action') }}" placeholder="الفعل"
                   class="px-4 py-2.5 border border-gray-300 rounded-xl">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2.5 border border-gray-300 rounded-xl">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-4 py-2.5 border border-gray-300 rounded-xl">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition">
                تصفية
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" data-aos="fade-up" data-aos-delay="170">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">المستخدم</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الفعل</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">الوقت</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">عنوان IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50" data-aos="fade-up" data-aos-delay="{{ 180 + $loop->index * 25 }}">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 text-white flex items-center justify-center text-xs font-bold">
                                        {{ strtoupper(substr($log->user->name ?? 'X', 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $log->user->name ?? 'مستخدم محذوف' }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($log->action == 'create') bg-green-100 text-green-600
                                    @elseif($log->action == 'delete') bg-red-100 text-red-600
                                    @elseif($log->action == 'update') bg-yellow-100 text-yellow-600
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-sm text-gray-600">{{ $log->created_at->format('d/m/Y h:i:s A') }}</td>
                            <td class="px-5 py-3 text-sm font-mono text-gray-600" dir="ltr">{{ $log->ip_address ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-16 text-center text-gray-400">لا توجد سجلات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-center" data-aos="fade-up" data-aos-delay="220">
        {{ $logs->links() }}
    </div>
</div>
@endsection
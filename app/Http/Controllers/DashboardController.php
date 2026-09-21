<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BedAdmission;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::where('status', 'active')->count(),
            'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            'pending_appointments' => Appointment::whereIn('status', ['scheduled', 'confirmed'])->count(),
            'total_revenue' => Invoice::where('status', 'paid')->sum('total_amount'),
            'monthly_revenue' => Invoice::where('status', 'paid')
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('total_amount'),
            'pending_payments' => Invoice::whereIn('status', ['pending', 'partial', 'overdue'])->sum('total_amount'),
            'admitted_patients' => BedAdmission::where('status', 'active')->count(),
            'critical_patients' => Patient::where('status', 'critical')->count(),
        ];

        $recentAppointments = Appointment::with(['patient', 'doctor'])
            ->latest()
            ->take(10)
            ->get();

        $recentPatients = Patient::latest()->take(5)->get();

        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->get();

        $monthlyRevenue = Invoice::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('total_amount');

        $weeklyData = $this->getWeeklyData();

        return view('dashboard', compact(
            'stats',
            'recentAppointments',
            'recentPatients',
            'todayAppointments',
            'monthlyRevenue',
            'weeklyData'
        ));
    }

    private function getWeeklyData(): array
    {
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = [
                'day' => $date->format('D'),
                'appointments' => Appointment::whereDate('appointment_date', $date)->count(),
                'revenue' => Invoice::where('status', 'paid')
                    ->whereDate('created_at', $date)
                    ->sum('total_amount'),
            ];
        }
        return $days;
    }
}

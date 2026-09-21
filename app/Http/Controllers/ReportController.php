<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Patient;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function patients()
    {
        $totalPatients = Patient::count();
        $newPatientsThisMonth = Patient::whereMonth('created_at', Carbon::now()->month)->count();
        $genderDistribution = Patient::selectRaw('gender, count(*) as count')->groupBy('gender')->get();
        $ageGroups = $this->getAgeGroups();
        $bloodTypes = Patient::selectRaw('blood_type, count(*) as count')->whereNotNull('blood_type')->groupBy('blood_type')->get();

        return view('reports.patients', compact(
            'totalPatients',
            'newPatientsThisMonth',
            'genderDistribution',
            'ageGroups',
            'bloodTypes'
        ));
    }

    public function appointments()
    {
        $totalAppointments = \App\Models\Appointment::count();
        $todayAppointments = \App\Models\Appointment::whereDate('appointment_date', Carbon::today())->count();
        $statusDistribution = \App\Models\Appointment::selectRaw('status, count(*) as count')->groupBy('status')->get();
        $monthlyTrend = $this->getMonthlyAppointmentTrend();
        $topDoctors = Doctor::withCount('appointments')->orderByDesc('appointments_count')->take(5)->get();

        return view('reports.appointments', compact(
            'totalAppointments',
            'todayAppointments',
            'statusDistribution',
            'monthlyTrend',
            'topDoctors'
        ));
    }

    public function revenue()
    {
        $totalRevenue = Invoice::where('status', 'paid')->sum('total_amount');
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');
        $pendingAmount = Invoice::whereIn('status', ['pending', 'partial', 'overdue'])->sum('total_amount');
        $monthlyTrend = $this->getMonthlyRevenueTrend();
        $paymentMethods = Invoice::where('status', 'paid')
            ->selectRaw('payment_method, count(*) as count, sum(total_amount) as total')
            ->groupBy('payment_method')
            ->get();

        return view('reports.revenue', compact(
            'totalRevenue',
            'monthlyRevenue',
            'pendingAmount',
            'monthlyTrend',
            'paymentMethods'
        ));
    }

    private function getAgeGroups(): array
    {
        return [
            '0-12' => Patient::whereBetween('date_of_birth', [Carbon::now()->subYears(12), Carbon::now()])->count(),
            '13-25' => Patient::whereBetween('date_of_birth', [Carbon::now()->subYears(25), Carbon::now()->subYears(13)])->count(),
            '26-40' => Patient::whereBetween('date_of_birth', [Carbon::now()->subYears(40), Carbon::now()->subYears(26)])->count(),
            '41-60' => Patient::whereBetween('date_of_birth', [Carbon::now()->subYears(60), Carbon::now()->subYears(41)])->count(),
            '60+' => Patient::where('date_of_birth', '<', Carbon::now()->subYears(60))->count(),
        ];
    }

    private function getMonthlyAppointmentTrend(): array
    {
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $trend[] = [
                'month' => $month->format('M Y'),
                'count' => \App\Models\Appointment::whereMonth('created_at', $month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        }
        return $trend;
    }

    private function getMonthlyRevenueTrend(): array
    {
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $trend[] = [
                'month' => $month->format('M Y'),
                'revenue' => Invoice::where('status', 'paid')
                    ->whereMonth('created_at', $month)
                    ->whereYear('created_at', $month->year)
                    ->sum('total_amount'),
            ];
        }
        return $trend;
    }
}

<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();

        // Today's Statistics
        $todayConsultations = Consultation::where('doctor_id', $doctorId)
            ->whereDate('consultation_date', today())
            ->where('status', 'completed')
            ->count();

        $todayAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('start_time', today())
            ->whereIn('status', ['pending', 'approved', 'checked_in'])
            ->count();

        // This Week's Revenue
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();
        
        $weekRevenue = Billing::whereHas('consultation', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->whereBetween('billing_date', [$weekStart, $weekEnd])
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // This Month's Revenue
        $monthRevenue = Billing::whereHas('consultation', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->whereMonth('billing_date', now()->month)
            ->whereYear('billing_date', now()->year)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // Patient Statistics
        $totalPatients = Patient::whereHas('consultations', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->count();

        $activePatients = Patient::where('status', 'active')
            ->whereHas('consultations', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->count();

        // Pending Appointments
        $pendingAppointments = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->count();

        // Recent Activity - Last 5 consultations
        $recentConsultations = Consultation::where('doctor_id', $doctorId)
            ->with(['patient', 'appointment'])
            ->where('status', 'completed')
            ->latest('consultation_date')
            ->take(5)
            ->get();

        // Upcoming Appointments - Next 5
        $upcomingAppointments = Appointment::where('doctor_id', $doctorId)
            ->with('patient')
            ->whereIn('status', ['approved', 'pending'])
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Monthly Consultation Trend (last 6 months)
        $monthlyTrend = Consultation::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->where('consultation_date', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(consultation_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Monthly Revenue Trend (last 6 months)
        $revenueTrend = Billing::whereHas('consultation', function ($query) use ($doctorId) {
                $query->where('doctor_id', $doctorId);
            })
            ->where('billing_date', '>=', now()->subMonths(6))
            ->where('payment_status', 'paid')
            ->select(
                DB::raw('DATE_FORMAT(billing_date, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('doctor.dashboard', compact(
            'todayConsultations',
            'todayAppointments',
            'weekRevenue',
            'monthRevenue',
            'totalPatients',
            'activePatients',
            'pendingAppointments',
            'recentConsultations',
            'upcomingAppointments',
            'monthlyTrend',
            'revenueTrend'
        ));
    }
}

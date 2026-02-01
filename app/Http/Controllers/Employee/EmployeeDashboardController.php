<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $employee = $user->employee;
        $shop = $employee->shop;

        // Get repair stats
        $repairs = $shop->repairs()->count();
        $activeRepairs = $shop->repairs()->whereIn('status', ['pending', 'working'])->count();
        $pendingRepairs = $shop->repairs()->where('status', 'pending')->count();

        // Calculate current month stats
        $completedThisMonth = $shop->repairs()
            ->whereIn('status', ['finished', 'pickedup'])
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        return view('employee.dashboard', compact(
            'shop',
            'repairs',
            'activeRepairs',
            'pendingRepairs',
            'completedThisMonth'
        ));
    }
}

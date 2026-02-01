<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class EmployeeRepairsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $shop = $user->employee->shop;
        $plan = $shop->shopPlan?->plan;

        return view('employee.repairs', compact('shop', 'plan'));
    }
}

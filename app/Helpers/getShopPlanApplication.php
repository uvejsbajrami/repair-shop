<?php

use App\Models\PlanApplication;


function getPendingApplicationNeedingProof()
{
    return PlanApplication::where('user_id', auth()->id())
        ->where('status', 'pending')
        ->where('payment_status', 'awaiting_proof')
        ->whereNull('payment_proof_path')
        ->latest()
        ->first();
}
<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class PlanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'shop_id',
        'shop_name',
        'applicant_name',
        'applicant_email',
        'applicant_phone',
        'billing_cycle',
        'duration_months',
        'language_code',
        'currency_code',
        'message',
        'status',
        'type',
        'payment_proof_path',
        'payment_status',
        'payment_proof_uploaded_at',
        'payment_notes',
    ];

    protected $casts = [
        'payment_proof_uploaded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function isRenewal(): bool
    {
        return $this->type === 'renewal';
    }

    public function hasPaymentProof(): bool
    {
        return !empty($this->payment_proof_path);
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if (!$this->payment_proof_path) {
            return null;
        }
        return Storage::disk('local')->url($this->payment_proof_path);
    }

    public function isAwaitingProof(): bool
    {
        return $this->payment_status === 'awaiting_proof';
    }

    public function isProofSubmitted(): bool
    {
        return $this->payment_status === 'proof_submitted';
    }
}

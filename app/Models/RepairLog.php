<?php

namespace App\Models;

use App\Models\User;
use App\Models\Repair;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_id',
        'old_status',
        'new_status',
        'changed_by',
    ];
    
    public function repair()
    {
        return $this->belongsTo(Repair::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}

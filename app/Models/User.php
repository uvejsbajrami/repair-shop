<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Shop;
use App\Models\Employee;
use App\Models\RepairLog;
use App\Models\PlanApplication;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'invitation_token',
        'invitation_sent_at',
        'invitation_accepted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function isOwner()
    {
        return $this->role === 'owner' || $this->shop()->exists();
    }
     public function shop()
    {
        return $this->hasOne(Shop::class, 'owner_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function planApplications()
    {
        return $this->hasMany(PlanApplication::class);
    }

    public function repairLogs()
    {
        return $this->hasMany(RepairLog::class, 'changed_by');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'invitation_sent_at' => 'datetime',
            'invitation_accepted_at' => 'datetime',
        ];
    }
}

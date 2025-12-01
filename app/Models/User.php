<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The accessors to append to the model's array form.
     * This ensures the role_names property is always available.
     *
     * @var array<int, string>
     */
    protected $appends = ['role_names'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        ];
    }

    /**
     * Accessor to get all user role names as a comma-separated string.
     * This uses the getRoleNames() method provided by the Spatie\Permission package.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function roleNames(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getRoleNames()->implode(', ')
        );
    }

    /**
     * Get the activity log options for the model.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Check if user has admin role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('Admin');
    }

    /**
     * Check if user has doctor role.
     *
     * @return bool
     */
    public function isDoctor(): bool
    {
        return $this->hasRole('Doctor');
    }

    /**
     * Check if user has receptionist role.
     *
     * @return bool
     */
    public function isReceptionist(): bool
    {
        return $this->hasRole('Receptionist');
    }

    /**
     * Check if user has nurse role.
     *
     * @return bool
     */
    public function isNurse(): bool
    {
        return $this->hasRole('Nurse');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

class Doctor extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $fillable = [
        'name',
        'specialty',
        'phone',
        'email'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'specialty', 'phone', 'email'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Doctor was {$eventName}");
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'specialty' => $this->specialty,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }

    public function scopeSortBy($query, $column, $order = 'asc')
    {
        $allowedColumns = ['id', 'name', 'specialty', 'phone', 'email'];
        $column = in_array($column, $allowedColumns) ? $column : 'id';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

        return $query->orderBy($column, $order);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'doctor_patient')
            ->withPivot('assignment_date', 'notes')
            ->withTimestamps();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

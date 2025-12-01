<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

class Appointment extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'doctor_id', 'appointment_date', 'appointment_time', 'reason', 'status', 'notes'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Appointment was {$eventName}");
    }

    public function toSearchableArray()
    {
        return [
            'reason' => $this->reason,
            'status' => $this->status,
            'notes' => $this->notes,
        ];
    }

    public function scopeSortBy($query, $column, $order = 'asc')
    {
        $allowedColumns = ['id', 'appointment_date', 'appointment_time', 'status', 'reason'];
        $column = in_array($column, $allowedColumns) ? $column : 'appointment_date';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

        return $query->orderBy($column, $order);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date', 'asc');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}

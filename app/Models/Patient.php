<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

class Patient extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $fillable = [
        'name',
        'age',
        'sex',
        'blood_type',
        'phone'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'age', 'sex', 'blood_type', 'phone'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Patient was {$eventName}");
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'blood_type' => $this->blood_type,
            'phone' => $this->phone,
            'age' => $this->age,
        ];
    }

    public function scopeSortBy($query, $column, $order = 'asc')
    {
        $allowedColumns = ['id', 'name', 'age', 'sex', 'blood_type', 'phone'];
        $column = in_array($column, $allowedColumns) ? $column : 'id';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

        return $query->orderBy($column, $order);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_patient')
            ->withPivot('assignment_date', 'notes')
            ->withTimestamps();
    }

    public function medications()
    {
        return $this->belongsToMany(Medication::class, 'medication_patient')
            ->withPivot('frequency', 'start_date', 'end_date', 'instructions')
            ->withTimestamps();
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}

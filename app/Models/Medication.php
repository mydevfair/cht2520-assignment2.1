<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

class Medication extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $fillable = [
        'name',
        'type',
        'manufacturer',
        'description'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'type', 'manufacturer', 'description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Medication was {$eventName}");
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'manufacturer' => $this->manufacturer,
            'description' => $this->description,
        ];
    }

    public function scopeSortBy($query, $column, $order = 'asc')
    {
        $allowedColumns = ['id', 'name', 'type', 'manufacturer'];
        $column = in_array($column, $allowedColumns) ? $column : 'id';
        $order = in_array($order, ['asc', 'desc']) ? $order : 'asc';

        return $query->orderBy($column, $order);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'medication_patient')
            ->withPivot('frequency', 'start_date', 'end_date', 'instructions')
            ->withTimestamps();
    }
}

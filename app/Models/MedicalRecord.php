<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Laravel\Scout\Searchable;

class MedicalRecord extends Model
{
    use HasFactory, LogsActivity, Searchable;

    protected $fillable = [
        'patient_id',
        'filename',
        'mime_type',
        'size',
        'description'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['patient_id', 'filename', 'description'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Medical record was {$eventName}");
    }

    public function toSearchableArray()
    {
        return [
            'filename' => $this->filename,
            'description' => $this->description,
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}

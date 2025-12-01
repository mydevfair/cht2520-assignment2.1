<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['causer', 'subject'])
            ->orderBy('created_at', 'desc')
            ->get();

        $modelTypes = Activity::select('subject_type')
            ->distinct()
            ->whereNotNull('subject_type')
            ->pluck('subject_type')
            ->map(fn($type) => class_basename($type))
            ->sort()
            ->values();

        $users = User::orderBy('name')->get();

        return view('activity-log.index', compact('activities', 'modelTypes', 'users'));
    }
}

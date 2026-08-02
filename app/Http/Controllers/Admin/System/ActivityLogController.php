<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', ActivityLog::class);

        $logs = ActivityLog::query()
            ->with('user')
            ->when($request->filled('log_name'), fn ($query) => $query->where('log_name', $request->string('log_name')))
            ->when($request->filled('event'), fn ($query) => $query->where('event', $request->string('event')))
            ->when($request->filled('search'), fn ($query) => $query->where('description', 'like', '%'.$request->string('search').'%'))
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        $logNames = ActivityLog::query()->distinct()->orderBy('log_name')->pluck('log_name');

        return view('admin.system.activity-log.index', compact('logs', 'logNames'));
    }
}

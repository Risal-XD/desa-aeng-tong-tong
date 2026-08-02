<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboard,
    ) {}

    public function index(): View
    {
        $stats = $this->dashboard->getStats();
        $charts = $this->dashboard->getCharts();
        $recentActivity = $this->dashboard->recentActivity();
        $recentMessages = $this->dashboard->recentMessages();

        return view('admin.dashboard.index', compact('stats', 'charts', 'recentActivity', 'recentMessages'));
    }
}

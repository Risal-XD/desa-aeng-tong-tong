<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}

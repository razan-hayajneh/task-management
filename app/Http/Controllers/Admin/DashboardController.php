<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use Inertia\Inertia;

class DashboardController extends AppBaseController
{
    public function index()
    {
        return Inertia::render('Dashboard');
    }
}

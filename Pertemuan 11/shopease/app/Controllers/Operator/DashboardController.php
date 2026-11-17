<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('panel/operator_dashboard', [
            'title'   => 'Dashboard Operator',
            'heading' => 'Dashboard',
        ]);
    }
}

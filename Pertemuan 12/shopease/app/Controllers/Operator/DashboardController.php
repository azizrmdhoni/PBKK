<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $products = model(ProductModel::class);

        return view('panel/operator_dashboard', [
            'title'        => 'Dashboard Operator',
            'heading'      => 'Dashboard',
            'lowStock'     => $products->lowStock(5),
            'outStock'     => $products->outOfStock(5),
            'lowThreshold' => ProductModel::LOW_STOCK_THRESHOLD,
        ]);
    }
}

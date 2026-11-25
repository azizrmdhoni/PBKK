<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $users    = model(UserModel::class);
        $products = model(ProductModel::class);

        return view('panel/admin_dashboard', [
            'title'        => 'Dashboard Admin',
            'heading'      => 'Dashboard',
            'customers'    => $users->countByRole(UserModel::ROLE_CUSTOMER),
            'newCustomers' => $users->countNewSince(UserModel::ROLE_CUSTOMER, date('Y-m-d H:i:s', strtotime('-7 days'))),
            'staff'        => $users->countByRole(UserModel::ROLE_ADMIN) + $users->countByRole(UserModel::ROLE_OPERATOR),
            'latest'       => $users->latestByRole(UserModel::ROLE_CUSTOMER, 5),

            // Product Management (M2)
            'stats'         => $products->summary(),
            'categoryCount' => model(CategoryModel::class)->countAllResults(),
            'lowStock'      => $products->lowStock(5),
            'outStock'      => $products->outOfStock(5),
            'lowThreshold'  => ProductModel::LOW_STOCK_THRESHOLD,
        ]);
    }
}

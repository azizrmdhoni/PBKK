<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Pemakaian di Routes:
 *   'filter' => 'auth'                  -> cukup sudah login
 *   'filter' => 'auth:admin'            -> hanya admin
 *   'filter' => 'auth:admin,operator'   -> admin atau operator
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login untuk melanjutkan.');
        }

        $role = $session->get('role');

        if (! empty($arguments) && ! in_array($role, $arguments, true)) {
            return redirect()->to(UserModel::homePathFor($role))
                ->with('error', 'Anda tidak punya akses ke halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Halaman privat tidak boleh disimpan cache browser (tombol Back setelah logout)
        return $response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}

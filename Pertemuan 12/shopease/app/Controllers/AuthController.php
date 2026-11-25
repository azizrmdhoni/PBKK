<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    private const MAX_LOGIN_ATTEMPTS = 5; // per menit, per kombinasi IP + email

    /* ------------------------------------------------------------------
     * Registrasi
     * ----------------------------------------------------------------*/

    public function registerForm()
    {
        return view('auth/register', ['title' => 'Buat akun']);
    }

    public function register()
    {
        $rules = [
            'name' => [
                'label'  => 'Nama',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                ],
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|max_length[100]|is_unique[users.email]',
                'errors' => [
                    'required'    => 'Email wajib diisi.',
                    'valid_email' => 'Format email belum benar.',
                    'is_unique'   => 'Email ini sudah terdaftar. Coba login.',
                ],
            ],
            'phone' => [
                'label'  => 'Nomor telepon',
                'rules'  => 'permit_empty|regex_match[/^(\+62|62|0)8[0-9]{7,12}$/]',
                'errors' => ['regex_match' => 'Gunakan nomor Indonesia, misalnya 081234567890.'],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[8]|max_length[72]|regex_match[/^(?=.*[A-Za-z])(?=.*\d).+$/]',
                'errors' => [
                    'required'    => 'Password wajib diisi.',
                    'min_length'  => 'Password minimal 8 karakter.',
                    'max_length'  => 'Password maksimal 72 karakter.',
                    'regex_match' => 'Password harus mengandung huruf dan angka.',
                ],
            ],
            'password_confirm' => [
                'label'  => 'Konfirmasi password',
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Ulangi password Anda.',
                    'matches'  => 'Konfirmasi tidak sama dengan password.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        try {
            model(UserModel::class)->createCustomer([
                'name'     => trim((string) $this->request->getPost('name')),
                'email'    => strtolower(trim((string) $this->request->getPost('email'))),
                'phone'    => trim((string) $this->request->getPost('phone')),
                'password' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            ]);
        } catch (\Throwable $e) {
            // Mis. dua request dengan email sama masuk bersamaan; unique key MySQL menolak salah satunya.
            log_message('error', 'Registrasi gagal: ' . $e->getMessage());

            return redirect()->back()->withInput()
                ->with('error', 'Akun belum bisa dibuat. Periksa data Anda atau coba lagi sebentar lagi.');
        }

        return redirect()->to('/login')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    /* ------------------------------------------------------------------
     * Login
     * ----------------------------------------------------------------*/

    public function loginForm()
    {
        return view('auth/login', ['title' => 'Masuk']);
    }

    public function login()
    {
        $rules = [
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email',
                'errors' => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email belum benar.'],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => ['required' => 'Password wajib diisi.'],
            ],
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email    = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        // Batasi percobaan login (rate limiting)
        $throttler = service('throttler');
        $key       = 'login_' . md5($this->request->getIPAddress() . '|' . $email);

        if ($throttler->check($key, self::MAX_LOGIN_ATTEMPTS, MINUTE) === false) {
            return redirect()->back()->withInput()->with(
                'error',
                'Terlalu banyak percobaan. Coba lagi dalam ' . max(1, (int) $throttler->getTokenTime()) . ' detik.'
            );
        }

        $user = model(UserModel::class)->findByEmail($email);

        // password_verify selalu dijalankan agar waktu respons tidak membocorkan
        // apakah email terdaftar. Pesan error juga disamakan (PRD bagian 13).
        $hash  = $user['password'] ?? password_hash('placeholder-password', PASSWORD_DEFAULT);
        $valid = password_verify($password, $hash) && $user !== null;

        if (! $valid) {
            return redirect()->back()->withInput()
                ->with('error', 'Email atau password tidak cocok.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->withInput()
                ->with('error', 'Akun ini dinonaktifkan. Hubungi admin toko.');
        }

        // Perbarui hash bila algoritma default PHP sudah berubah
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            model(UserModel::class)->update($user['id_user'], [
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);
        }

        // Cegah session fixation
        session()->regenerate(true);
        session()->set([
            'isLoggedIn' => true,
            'user_id'    => (int) $user['id_user'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'role'       => $user['role'],
        ]);

        return redirect()->to(UserModel::homePathFor($user['role']))
            ->with('success', 'Selamat datang, ' . $user['name'] . '.');
    }

    /* ------------------------------------------------------------------
     * Logout (POST + CSRF)
     * ----------------------------------------------------------------*/

    public function logout()
    {
        $session = session();
        $session->remove(['isLoggedIn', 'user_id', 'name', 'email', 'role']);
        $session->regenerate(true);

        return redirect()->to('/login')->with('success', 'Anda sudah keluar.');
    }
}

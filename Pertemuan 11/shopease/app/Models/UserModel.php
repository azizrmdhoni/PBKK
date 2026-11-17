<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_ADMIN    = 'admin';
    public const ROLE_OPERATOR = 'operator';

    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // 'role' dan 'is_active' sengaja tidak ada di sini supaya tidak bisa
    // terisi dari input form (mass assignment). Registrasi publik selalu
    // memakai default database: role 'customer', is_active 1.
    protected $allowedFields = [
        'name', 'email', 'password', 'phone', 'address',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /** Cari pengguna lewat email. */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', strtolower(trim($email)))->first();
    }

    /** Buat akun customer. $data['password'] harus sudah berupa hash. */
    public function createCustomer(array $data)
    {
        return $this->insert([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'phone'    => $data['phone'] !== '' ? $data['phone'] : null,
        ]);
    }

    /** Jumlah akun aktif berdasarkan role (untuk dashboard). */
    public function countByRole(string $role): int
    {
        return $this->where('role', $role)->where('is_active', 1)->countAllResults();
    }

    /** Jumlah akun aktif per role yang dibuat sejak waktu tertentu. */
    public function countNewSince(string $role, string $since): int
    {
        return $this->where('role', $role)
            ->where('is_active', 1)
            ->where('created_at >=', $since)
            ->countAllResults();
    }

    /** Akun terbaru per role. Kolom password tidak diambil. */
    public function latestByRole(string $role, int $limit = 5): array
    {
        return $this->select('id_user, name, email, is_active, created_at')
            ->where('role', $role)
            ->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }

    /** Halaman tujuan setelah login berdasarkan role. */
    public static function homePathFor(?string $role): string
    {
        return match ($role) {
            self::ROLE_ADMIN    => '/admin',
            self::ROLE_OPERATOR => '/operator',
            default             => '/',
        };
    }
}

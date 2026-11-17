<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Akun uji untuk tiga role. Jalankan:  php spark db:seed UserSeeder
 * Seeder ini idempoten: kalau email sudah ada, role, nama, status aktif, dan
 * password akan dikembalikan ke nilai di bawah (berguna untuk reset akun uji).
 *
 * Ganti password sebelum aplikasi dipublikasikan.
 */
class UserSeeder extends Seeder
{
    public const DEFAULT_PASSWORD = 'Shopease123';

    public const ACCOUNTS = [
        ['name' => 'Admin ShopEase',    'email' => 'admin@shopease.test',    'role' => 'admin'],
        ['name' => 'Operator ShopEase', 'email' => 'operator@shopease.test', 'role' => 'operator'],
        ['name' => 'Pelanggan Contoh',  'email' => 'customer@shopease.test', 'role' => 'customer'],
    ];

    public function run()
    {
        $now  = date('Y-m-d H:i:s');
        $hash = password_hash(self::DEFAULT_PASSWORD, PASSWORD_DEFAULT);

        foreach (self::ACCOUNTS as $account) {
            $builder = $this->db->table('users');
            $exists  = $builder->where('email', $account['email'])->countAllResults();

            $data = $account + [
                'password'   => $hash,
                'is_active'  => 1,
                'updated_at' => $now,
            ];

            if ($exists) {
                $this->db->table('users')->where('email', $account['email'])->update($data);
            } else {
                $data['created_at'] = $now;
                $this->db->table('users')->insert($data);
            }
        }
    }
}

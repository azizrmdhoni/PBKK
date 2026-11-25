<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table         = 'product_images';
    protected $primaryKey    = 'id_image';
    protected $returnType    = 'array';
    protected $allowedFields = ['id_product', 'image', 'is_primary'];

    // Tabel ini hanya punya created_at.
    protected $useTimestamps = true;
    protected $updatedField  = '';

    /** Semua gambar sebuah produk; gambar utama paling depan. */
    public function forProduct(int $productId): array
    {
        return $this->where('id_product', $productId)
            ->orderBy('is_primary', 'DESC')
            ->orderBy('id_image', 'ASC')
            ->findAll();
    }

    public function countForProduct(int $productId): int
    {
        return $this->where('id_product', $productId)->countAllResults();
    }

    public function hasPrimary(int $productId): bool
    {
        return $this->where('id_product', $productId)
            ->where('is_primary', 1)
            ->countAllResults() > 0;
    }

    /** Jadikan satu gambar sebagai utama; gambar lain milik produk itu dilepas. */
    public function makePrimary(int $productId, int $imageId): void
    {
        $this->builder()->where('id_product', $productId)->update(['is_primary' => 0]);
        $this->builder()->where('id_image', $imageId)->where('id_product', $productId)->update(['is_primary' => 1]);
    }

    /** Pastikan produk punya gambar utama: bila belum, angkat gambar tertua. */
    public function ensurePrimary(int $productId): void
    {
        if ($this->hasPrimary($productId)) {
            return;
        }

        $first = $this->where('id_product', $productId)->orderBy('id_image', 'ASC')->first();
        if ($first) {
            $this->makePrimary($productId, (int) $first['id_image']);
        }
    }
}

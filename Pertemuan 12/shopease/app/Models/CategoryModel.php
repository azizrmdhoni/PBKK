<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    use GeneratesSlug;

    protected $table         = 'categories';
    protected $primaryKey    = 'id_category';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'slug', 'description'];
    protected $useTimestamps = true;

    /** Slug unik untuk nama kategori (abaikan baris $ignoreId saat edit). */
    public function slugFor(string $name, ?int $ignoreId = null): string
    {
        return $this->uniqueSlug($name, $ignoreId, 100);
    }

    /** Semua kategori beserta jumlah produknya, urut abjad. */
    public function withProductCount(): array
    {
        return $this->select('categories.*, COUNT(products.id_product) AS product_count', false)
            ->join('products', 'products.id_category = categories.id_category', 'left')
            ->groupBy('categories.id_category')
            ->orderBy('categories.name', 'ASC')
            ->findAll();
    }
}

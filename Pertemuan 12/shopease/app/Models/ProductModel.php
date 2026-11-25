<?php

namespace App\Models;

use App\Models\Concerns\GeneratesSlug;
use CodeIgniter\Model;

class ProductModel extends Model
{
    use GeneratesSlug;

    /** Stok <= nilai ini (dan > 0) dianggap menipis. */
    public const LOW_STOCK_THRESHOLD = 5;

    public const STATUSES = [
        'tersedia'       => 'Tersedia',
        'tidak_tersedia' => 'Tidak Tersedia',
    ];

    protected $table      = 'products';
    protected $primaryKey = 'id_product';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_category', 'name', 'slug', 'description',
        'price', 'stock', 'status',
    ];
    protected $useTimestamps = true;

    /** Kolom untuk daftar produk: data produk, nama kategori, gambar utama, jumlah gambar. */
    private const LIST_COLUMNS = 'products.*, categories.name AS category_name, '
        . '(SELECT pi.image FROM product_images pi WHERE pi.id_product = products.id_product '
        . 'ORDER BY pi.is_primary DESC, pi.id_image ASC LIMIT 1) AS thumbnail, '
        . '(SELECT COUNT(*) FROM product_images pc WHERE pc.id_product = products.id_product) AS image_count';

    public function slugFor(string $name, ?int $ignoreId = null): string
    {
        return $this->uniqueSlug($name, $ignoreId, 150);
    }

    /**
     * Query daftar produk + filter. Panggil ->paginate() atau ->findAll() sesudahnya.
     *
     * @param array{q?: string, category?: int, status?: string, stock?: string} $filters
     */
    public function listing(array $filters = []): self
    {
        $this->select(self::LIST_COLUMNS, false)
            ->join('categories', 'categories.id_category = products.id_category');

        $q = trim((string) ($filters['q'] ?? ''));
        if ($q !== '') {
            $this->like('products.name', $q);
        }

        $category = (int) ($filters['category'] ?? 0);
        if ($category > 0) {
            $this->where('products.id_category', $category);
        }

        $status = (string) ($filters['status'] ?? '');
        if (isset(self::STATUSES[$status])) {
            $this->where('products.status', $status);
        }

        $stock = (string) ($filters['stock'] ?? '');
        if ($stock === 'low') {
            $this->where('products.stock >', 0)
                ->where('products.stock <=', self::LOW_STOCK_THRESHOLD);
        } elseif ($stock === 'out') {
            $this->where('products.stock', 0);
        }

        return $this->orderBy('products.id_product', 'DESC');
    }

    /**
     * Ringkasan katalog untuk dashboard dan kartu statistik.
     *
     * @return array{total: int, available: int, unavailable: int, low_stock: int, out_of_stock: int}
     */
    public function summary(): array
    {
        $low = (int) self::LOW_STOCK_THRESHOLD;

        $row = $this->db->table($this->table)
            ->select(
                "COUNT(*) AS total, "
                . "COALESCE(SUM(status = 'tersedia'), 0) AS available, "
                . "COALESCE(SUM(status = 'tidak_tersedia'), 0) AS unavailable, "
                . "COALESCE(SUM(stock > 0 AND stock <= {$low}), 0) AS low_stock, "
                . "COALESCE(SUM(stock = 0), 0) AS out_of_stock",
                false
            )
            ->get()
            ->getRowArray() ?? [];

        return [
            'total'        => (int) ($row['total'] ?? 0),
            'available'    => (int) ($row['available'] ?? 0),
            'unavailable'  => (int) ($row['unavailable'] ?? 0),
            'low_stock'    => (int) ($row['low_stock'] ?? 0),
            'out_of_stock' => (int) ($row['out_of_stock'] ?? 0),
        ];
    }

    /** Produk dengan stok menipis (1..ambang), stok paling sedikit lebih dulu. */
    public function lowStock(int $limit = 5): array
    {
        return $this->select('id_product, name, stock, status')
            ->where('stock >', 0)
            ->where('stock <=', self::LOW_STOCK_THRESHOLD)
            ->orderBy('stock', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll($limit);
    }

    /** Produk yang stoknya habis (0). */
    public function outOfStock(int $limit = 5): array
    {
        return $this->select('id_product, name, stock, status')
            ->where('stock', 0)
            ->orderBy('name', 'ASC')
            ->findAll($limit);
    }
}

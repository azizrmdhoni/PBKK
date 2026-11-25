<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\ProductImageUploader;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * CRUD produk, upload gambar, galeri, pencarian/filter, dan update stok.
 * Diakses Administrator dan Operator (filter auth:admin,operator).
 */
class ProductController extends BaseController
{
    private const PER_PAGE = 10;

    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;
    protected ProductImageModel $imageModel;
    protected ProductImageUploader $uploader;
    protected $db;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->imageModel    = new ProductImageModel();
        $this->uploader      = new ProductImageUploader();
        $this->db            = db_connect();
    }

    // ------------------------------------------------------------------
    // Read
    // ------------------------------------------------------------------

    public function index()
    {
        $filters = [
            'q'        => $this->queryParam('q'),
            'category' => (int) $this->queryParam('category'),
            'status'   => $this->queryParam('status'),
            'stock'    => $this->queryParam('stock'),
        ];

        $products = $this->productModel->listing($filters)->paginate(self::PER_PAGE);

        return view('admin/products/index', [
            'title'      => 'Produk',
            'heading'    => 'Produk',
            'crumb'      => 'Produk',
            'products'   => $products,
            'pager'      => $this->productModel->pager,
            'filters'    => $filters,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'summary'    => $this->productModel->summary(),
        ]);
    }

    // ------------------------------------------------------------------
    // Create
    // ------------------------------------------------------------------

    public function create()
    {
        return view('admin/products/create', [
            'title'      => 'Tambah Produk',
            'heading'    => 'Tambah Produk',
            'crumb'      => 'Tambah Produk',
            'product'    => null,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'maxImages'  => ProductImageUploader::MAX_PER_PRODUCT,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return $this->backWithErrors();
        }

        [$files, $uploadErrors] = $this->uploader->inspect(
            $this->request->getFileMultiple('images'),
            ProductImageUploader::MAX_PER_PRODUCT
        );

        $moved = [];

        // Produk dan baris gambar disimpan dalam satu transaksi.
        $this->db->transBegin();
        try {
            $id = $this->productModel->insert($this->payload(null));
            if (! $id) {
                throw new \RuntimeException('Produk gagal disimpan.');
            }

            foreach ($files as $i => $file) {
                $filename = $this->uploader->store($file);
                $moved[]  = $filename;

                $this->imageModel->insert([
                    'id_product' => $id,
                    'image'      => $filename,
                    'is_primary' => $i === 0 ? 1 : 0,
                ]);
            }

            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            $this->uploader->deleteMany($moved);
            log_message('error', '[ProductController::store] {message}', ['message' => $e->getMessage()]);

            return redirect()->back()->withInput()
                ->with('error', 'Produk gagal disimpan. Silakan coba lagi.');
        }

        return $this->redirectWithUploadNotice('/admin/products', 'Produk berhasil ditambahkan.', $uploadErrors);
    }

    // ------------------------------------------------------------------
    // Update
    // ------------------------------------------------------------------

    public function edit($id)
    {
        $product = $this->findOrFail($id);
        $images  = $this->imageModel->forProduct((int) $id);

        return view('admin/products/edit', [
            'title'      => 'Edit Produk',
            'heading'    => 'Edit Produk',
            'crumb'      => 'Edit Produk',
            'product'    => $product,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'images'     => $images,
            'maxImages'  => ProductImageUploader::MAX_PER_PRODUCT,
            'slotsLeft'  => max(0, ProductImageUploader::MAX_PER_PRODUCT - count($images)),
        ]);
    }

    public function update($id)
    {
        $product = $this->findOrFail($id);
        $id      = (int) $id;

        if (! $this->validate($this->rules(), $this->messages())) {
            return $this->backWithErrors();
        }

        $slotsLeft = max(0, ProductImageUploader::MAX_PER_PRODUCT - $this->imageModel->countForProduct($id));

        [$files, $uploadErrors] = $this->uploader->inspect(
            $this->request->getFileMultiple('images'),
            $slotsLeft
        );

        $moved = [];

        $this->db->transBegin();
        try {
            $this->productModel->update($id, $this->payload($product, $id));

            foreach ($files as $file) {
                $filename = $this->uploader->store($file);
                $moved[]  = $filename;

                $this->imageModel->insert([
                    'id_product' => $id,
                    'image'      => $filename,
                    'is_primary' => 0,
                ]);
            }

            // Produk yang belum punya gambar utama otomatis memakai gambar tertuanya.
            $this->imageModel->ensurePrimary($id);

            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            $this->uploader->deleteMany($moved);
            log_message('error', '[ProductController::update] {message}', ['message' => $e->getMessage()]);

            return redirect()->back()->withInput()
                ->with('error', 'Produk gagal diperbarui. Silakan coba lagi.');
        }

        return $this->redirectWithUploadNotice('/admin/products', 'Produk berhasil diperbarui.', $uploadErrors);
    }

    /** Update stok cepat dari tabel daftar produk (Tugas 3 - Inventory Management). */
    public function updateStock($id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $valid = $this->validate([
            'stock' => 'required|is_natural|less_than[2147483647]',
        ], [
            'stock' => [
                'required'   => 'Stok wajib diisi.',
                'is_natural' => 'Stok harus berupa bilangan bulat 0 atau lebih.',
                'less_than'  => 'Stok terlalu besar.',
            ],
        ]);

        if (! $valid) {
            return redirect()->back()
                ->with('error', 'Stok "' . $product['name'] . '" tidak diubah: ' . implode(' ', $this->validator->getErrors()));
        }

        $stock = (int) $this->request->getPost('stock');
        $this->productModel->update($id, ['stock' => $stock]);

        return redirect()->back()
            ->with('success', 'Stok "' . $product['name'] . '" diperbarui menjadi ' . $stock . '.');
    }

    // ------------------------------------------------------------------
    // Delete
    // ------------------------------------------------------------------

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')
                ->with('error', 'Produk tidak ditemukan.');
        }

        $images = $this->imageModel->where('id_product', $id)->findAll();

        $this->db->transBegin();
        try {
            // Baris product_images ikut terhapus lewat ON DELETE CASCADE.
            $this->productModel->delete($id);
            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', '[ProductController::delete] {message}', ['message' => $e->getMessage()]);

            return redirect()->to('/admin/products')
                ->with('error', 'Produk tidak dapat dihapus karena masih dipakai data lain.');
        }

        // File fisik dihapus setelah transaksi berhasil, supaya tidak ada file hilang bila rollback.
        $this->uploader->deleteMany(array_column($images, 'image'));

        return redirect()->to('/admin/products')
            ->with('success', 'Produk berhasil dihapus.');
    }

    // ------------------------------------------------------------------
    // Galeri gambar (Tugas 2)
    // ------------------------------------------------------------------

    public function setPrimaryImage($imageId)
    {
        $image = $this->imageModel->find($imageId);
        if (! $image) {
            return redirect()->to('/admin/products')->with('error', 'Gambar tidak ditemukan.');
        }

        $this->imageModel->makePrimary((int) $image['id_product'], (int) $image['id_image']);

        return redirect()->to('/admin/products/edit/' . $image['id_product'])
            ->with('success', 'Gambar utama diperbarui.');
    }

    public function deleteImage($imageId)
    {
        $image = $this->imageModel->find($imageId);
        if (! $image) {
            return redirect()->to('/admin/products')->with('error', 'Gambar tidak ditemukan.');
        }

        $productId = (int) $image['id_product'];

        $this->db->transBegin();
        try {
            $this->imageModel->delete($imageId);

            // Bila yang dihapus gambar utama, angkat gambar berikutnya.
            if ((int) $image['is_primary'] === 1) {
                $this->imageModel->ensurePrimary($productId);
            }

            $this->db->transCommit();
        } catch (\Throwable $e) {
            $this->db->transRollback();
            log_message('error', '[ProductController::deleteImage] {message}', ['message' => $e->getMessage()]);

            return redirect()->to('/admin/products/edit/' . $productId)
                ->with('error', 'Gambar gagal dihapus. Silakan coba lagi.');
        }

        $this->uploader->delete($image['image']);

        return redirect()->to('/admin/products/edit/' . $productId)
            ->with('success', 'Gambar berhasil dihapus.');
    }

    // ------------------------------------------------------------------
    // Helper privat
    // ------------------------------------------------------------------

    private function findOrFail($id): array
    {
        $product = $this->productModel->find($id);
        if (! $product) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $product;
    }

    /** Nilai query string sebagai string bersih (abaikan bila berupa array). */
    private function queryParam(string $key): string
    {
        $value = $this->request->getGet($key);

        return is_string($value) ? trim($value) : '';
    }

    private function rules(): array
    {
        return [
            // is_not_unique memastikan id_category benar-benar ada di tabel categories.
            'id_category' => 'required|is_natural_no_zero|is_not_unique[categories.id_category]',
            'name'        => 'required|min_length[3]|max_length[150]',
            'description' => 'permit_empty|max_length[5000]',
            'price'       => 'required|numeric|greater_than_equal_to[0]|less_than[10000000000]',
            'stock'       => 'required|is_natural|less_than[2147483647]',
            'status'      => 'required|in_list[tersedia,tidak_tersedia]',
        ];
    }

    private function messages(): array
    {
        return [
            'id_category' => [
                'required'           => 'Kategori wajib dipilih.',
                'is_natural_no_zero' => 'Kategori tidak valid.',
                'is_not_unique'      => 'Kategori yang dipilih tidak ditemukan.',
            ],
            'name' => [
                'required'   => 'Nama produk wajib diisi.',
                'min_length' => 'Nama produk minimal 3 karakter.',
                'max_length' => 'Nama produk maksimal 150 karakter.',
            ],
            'description' => [
                'max_length' => 'Deskripsi maksimal 5000 karakter.',
            ],
            'price' => [
                'required'               => 'Harga wajib diisi.',
                'numeric'                => 'Harga harus berupa angka.',
                'greater_than_equal_to'  => 'Harga tidak boleh negatif.',
                'less_than'              => 'Harga terlalu besar.',
            ],
            'stock' => [
                'required'   => 'Stok wajib diisi (isi 0 bila kosong).',
                'is_natural' => 'Stok harus berupa bilangan bulat 0 atau lebih.',
                'less_than'  => 'Stok terlalu besar.',
            ],
            'status' => [
                'required' => 'Status produk wajib dipilih.',
                'in_list'  => 'Status produk tidak valid.',
            ],
        ];
    }

    /**
     * Data yang disimpan ke tabel products.
     * Slug dibuat ulang hanya bila nama berubah (URL produk stabil).
     */
    private function payload(?array $current, ?int $id = null): array
    {
        $name        = trim((string) $this->request->getPost('name'));
        $description = trim((string) $this->request->getPost('description'));

        $slug = ($current !== null && $current['name'] === $name)
            ? $current['slug']
            : $this->productModel->slugFor($name, $id);

        return [
            'id_category' => (int) $this->request->getPost('id_category'),
            'name'        => $name,
            'slug'        => $slug,
            'description' => $description === '' ? null : $description,
            'price'       => round((float) $this->request->getPost('price'), 2),
            'stock'       => (int) $this->request->getPost('stock'),
            'status'      => (string) $this->request->getPost('status'),
        ];
    }

    private function backWithErrors()
    {
        return redirect()->back()->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    /** Redirect sukses; file yang ditolak dilaporkan sebagai peringatan, bukan kegagalan. */
    private function redirectWithUploadNotice(string $to, string $message, array $uploadErrors)
    {
        $redirect = redirect()->to($to)->with('success', $message);

        if ($uploadErrors !== []) {
            $redirect->with('warning', $uploadErrors);
        }

        return $redirect;
    }
}

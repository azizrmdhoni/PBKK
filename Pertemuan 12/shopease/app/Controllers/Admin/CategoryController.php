<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * CRUD kategori produk. Diakses Administrator dan Operator (filter auth:admin,operator).
 */
class CategoryController extends BaseController
{
    protected CategoryModel $categoryModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel  = new ProductModel();
    }

    public function index()
    {
        return view('admin/categories/index', [
            'title'      => 'Kategori',
            'heading'    => 'Kategori',
            'crumb'      => 'Kategori',
            'categories' => $this->categoryModel->withProductCount(),
        ]);
    }

    public function create()
    {
        return view('admin/categories/create', [
            'title'    => 'Tambah Kategori',
            'heading'  => 'Tambah Kategori',
            'crumb'    => 'Tambah Kategori',
            'category' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->rules(), $this->messages())) {
            return $this->backWithErrors();
        }

        $name = trim((string) $this->request->getPost('name'));

        $this->categoryModel->insert([
            'name'        => $name,
            'slug'        => $this->categoryModel->slugFor($name),
            'description' => $this->description(),
        ]);

        return redirect()->to('/admin/categories')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->findOrFail($id);

        return view('admin/categories/edit', [
            'title'    => 'Edit Kategori',
            'heading'  => 'Edit Kategori',
            'crumb'    => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update($id)
    {
        $category = $this->findOrFail($id);

        if (! $this->validate($this->rules((int) $id), $this->messages())) {
            return $this->backWithErrors();
        }

        $name = trim((string) $this->request->getPost('name'));

        // Slug hanya dibuat ulang bila nama berubah, supaya URL lama tidak berubah tanpa alasan.
        $slug = $category['name'] === $name
            ? $category['slug']
            : $this->categoryModel->slugFor($name, (int) $id);

        $this->categoryModel->update($id, [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->description(),
        ]);

        return redirect()->to('/admin/categories')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        if (! $category) {
            return redirect()->to('/admin/categories')
                ->with('error', 'Kategori tidak ditemukan.');
        }

        $total = $this->productModel->where('id_category', $id)->countAllResults();
        if ($total > 0) {
            return redirect()->to('/admin/categories')
                ->with('error', 'Kategori "' . $category['name'] . '" masih memiliki ' . $total . ' produk. Pindahkan atau hapus produknya terlebih dahulu.');
        }

        try {
            $this->categoryModel->delete($id);
        } catch (\Throwable $e) {
            log_message('error', '[CategoryController::delete] {message}', ['message' => $e->getMessage()]);

            return redirect()->to('/admin/categories')
                ->with('error', 'Kategori tidak dapat dihapus karena masih dipakai data lain.');
        }

        return redirect()->to('/admin/categories')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    // ------------------------------------------------------------------

    private function findOrFail($id): array
    {
        $category = $this->categoryModel->find($id);
        if (! $category) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $category;
    }

    private function rules(?int $ignoreId = null): array
    {
        $unique = $ignoreId === null
            ? 'is_unique[categories.name]'
            : 'is_unique[categories.name,id_category,' . $ignoreId . ']';

        return [
            'name'        => 'required|min_length[3]|max_length[100]|' . $unique,
            'description' => 'permit_empty|max_length[1000]',
        ];
    }

    private function messages(): array
    {
        return [
            'name' => [
                'required'   => 'Nama kategori wajib diisi.',
                'min_length' => 'Nama kategori minimal 3 karakter.',
                'max_length' => 'Nama kategori maksimal 100 karakter.',
                'is_unique'  => 'Nama kategori sudah dipakai.',
            ],
            'description' => [
                'max_length' => 'Deskripsi maksimal 1000 karakter.',
            ],
        ];
    }

    private function description(): ?string
    {
        $text = trim((string) $this->request->getPost('description'));

        return $text === '' ? null : $text;
    }

    private function backWithErrors()
    {
        return redirect()->back()->withInput()
            ->with('errors', $this->validator->getErrors());
    }
}

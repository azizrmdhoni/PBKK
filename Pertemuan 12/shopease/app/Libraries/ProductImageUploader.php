<?php

namespace App\Libraries;

use CodeIgniter\HTTP\Files\UploadedFile;

/**
 * Validasi dan penyimpanan file gambar produk.
 *
 * Pemeriksaan dilakukan di server, tidak hanya mengandalkan atribut `accept`:
 *   1. upload sukses tanpa error PHP,
 *   2. ukuran <= 2 MB,
 *   3. MIME type hasil deteksi server dan ekstensi termasuk daftar putih,
 *   4. isi file benar-benar gambar (getimagesize),
 *   5. jumlah gambar per produk dibatasi.
 * File disimpan dengan nama acak di public/uploads/products/.
 */
class ProductImageUploader
{
    public const MAX_PER_PRODUCT = 8;
    public const MAX_BYTES       = 2 * 1024 * 1024;

    private const MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    private const EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp'];

    public function directory(): string
    {
        return FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR;
    }

    /**
     * Pisahkan file yang layak simpan dari yang ditolak.
     *
     * @param UploadedFile[]|null $files     hasil $request->getFileMultiple('images')
     * @param int                 $slotsLeft sisa kuota gambar produk
     *
     * @return array{0: UploadedFile[], 1: string[]} [diterima, daftar pesan penolakan]
     */
    public function inspect(?array $files, int $slotsLeft): array
    {
        $accepted = [];
        $errors   = [];

        foreach ($files ?? [] as $file) {
            if (! $file instanceof UploadedFile || $file->getError() === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            $label = $file->getClientName();

            if (! $file->isValid() || $file->hasMoved()) {
                $errors[] = $label . ': gagal diunggah (' . $this->uploadErrorText($file->getError()) . ').';
                continue;
            }

            if ($file->getSize() > self::MAX_BYTES) {
                $errors[] = $label . ': ukuran melebihi 2 MB.';
                continue;
            }

            $ext = strtolower($file->getClientExtension());
            if (! in_array($file->getMimeType(), self::MIME_TYPES, true) || ! in_array($ext, self::EXTENSIONS, true)) {
                $errors[] = $label . ': format harus JPG, PNG, atau WEBP.';
                continue;
            }

            $info = @getimagesize($file->getTempName());
            if ($info === false || ! in_array($info['mime'] ?? '', self::MIME_TYPES, true)) {
                $errors[] = $label . ': isi file bukan gambar yang valid.';
                continue;
            }

            if (count($accepted) >= $slotsLeft) {
                $errors[] = $label . ': dilewati, batas ' . self::MAX_PER_PRODUCT . ' gambar per produk.';
                continue;
            }

            $accepted[] = $file;
        }

        return [$accepted, $errors];
    }

    /** Pindahkan file ke folder upload dengan nama acak. Mengembalikan nama file. */
    public function store(UploadedFile $file): string
    {
        $dir = $this->directory();
        if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            throw new \RuntimeException('Folder upload tidak dapat dibuat.');
        }

        $name = $file->getRandomName();
        $file->move($dir, $name);

        return $name;
    }

    public function delete(string $filename): void
    {
        $path = $this->directory() . basename($filename);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    /** @param string[] $filenames */
    public function deleteMany(array $filenames): void
    {
        foreach ($filenames as $filename) {
            $this->delete($filename);
        }
    }

    private function uploadErrorText(int $code): string
    {
        return match ($code) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'melebihi batas ukuran server',
            UPLOAD_ERR_PARTIAL                        => 'file terunggah sebagian',
            UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'server tidak dapat menyimpan file',
            default                                   => 'kesalahan tidak dikenal',
        };
    }
}

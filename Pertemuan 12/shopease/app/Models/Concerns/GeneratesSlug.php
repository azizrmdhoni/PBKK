<?php

namespace App\Models\Concerns;

/**
 * Membuat slug unik dari sebuah nama.
 * "Sepatu Sneakers" -> "sepatu-sneakers", lalu "sepatu-sneakers-2" bila sudah dipakai.
 * Dipakai oleh model yang punya kolom `slug` UNIQUE.
 */
trait GeneratesSlug
{
    protected function uniqueSlug(string $name, ?int $ignoreId = null, int $maxLength = 100): string
    {
        helper('url');

        $base = url_title(trim($name), '-', true);
        $base = trim(mb_substr($base, 0, $maxLength), '-');
        if ($base === '') {
            $base = 'item';
        }

        $slug = $base;
        $n    = 2;
        while ($this->slugExists($slug, $ignoreId)) {
            $slug = $base . '-' . $n++;
        }

        return $slug;
    }

    private function slugExists(string $slug, ?int $ignoreId): bool
    {
        $builder = $this->db->table($this->table)->where('slug', $slug);
        if ($ignoreId !== null) {
            $builder->where($this->primaryKey . ' !=', $ignoreId);
        }

        return $builder->countAllResults() > 0;
    }
}

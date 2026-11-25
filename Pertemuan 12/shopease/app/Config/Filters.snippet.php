<?php
// Ubah app/Config/Filters.php

// 1) Tambahkan alias di $aliases:
public array $aliases = [
    // ...alias bawaan CI4 tetap dipertahankan...
    'auth'  => \App\Filters\AuthFilter::class,
    'guest' => \App\Filters\GuestFilter::class,
];

// 2) Aktifkan CSRF global di $globals['before'] (hapus tanda komentar bila perlu):
public array $globals = [
    'before' => [
        'csrf',
    ],
    'after' => [
        'toolbar',
    ],
];

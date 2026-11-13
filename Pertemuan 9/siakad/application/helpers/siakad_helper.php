<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('inisial')) {
    function inisial($nama) {
        $p = preg_split('/\s+/', trim($nama));
        $i = strtoupper(substr($p[0], 0, 1));
        if (isset($p[1])) $i .= strtoupper(substr($p[1], 0, 1));
        return $i;
    }
}
// kelas warna untuk huruf mutu
if (!function_exists('grade_class')) {
    function grade_class($h) {
        if ($h == 'A') return '';
        if ($h == 'B+' || $h == 'B') return 'b';
        if ($h == 'C+' || $h == 'C') return 'c';
        return 'd';
    }
}

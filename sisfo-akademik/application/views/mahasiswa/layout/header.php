<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= html_escape($title) ?> - Portal Mahasiswa</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>@media print{.no-print{display:none}}</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-primary no-print">
  <span class="navbar-brand">Portal Mahasiswa</span>
  <ul class="navbar-nav mr-auto">
    <li class="nav-item"><a class="nav-link" href="<?= site_url('portal') ?>">Beranda</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= site_url('portal/khs') ?>">KHS</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= site_url('portal/password') ?>">Ganti Password</a></li>
  </ul>
  <a class="btn btn-light btn-sm" href="<?= site_url('auth/logout') ?>">Logout</a>
</nav>
<div class="container py-4">
  <h4 class="mb-3"><?= html_escape($title) ?></h4>
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
  <?php endif; ?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= html_escape($title) ?> - Admin Akademik</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>
  body{background:#f4f6f9}
  .sidebar{min-height:100vh;background:#2c3e50}
  .sidebar a{color:#cfd8dc;display:block;padding:.6rem 1rem}
  .sidebar a:hover,.sidebar a.active{background:#1a252f;color:#fff;text-decoration:none}
  .sidebar .brand{color:#fff;font-weight:600;padding:1rem}
</style>
</head>
<body>
<?php $seg = $this->uri->segment(2); ?>
<div class="container-fluid">
<div class="row">
  <nav class="col-md-2 sidebar p-0">
    <div class="brand">SISFO AKADEMIK</div>
    <a href="<?= site_url('admin/dashboard') ?>" class="<?= $seg=='dashboard'?'active':'' ?>">Dashboard</a>
    <a href="<?= site_url('admin/jurusan') ?>" class="<?= $seg=='jurusan'?'active':'' ?>">Jurusan</a>
    <a href="<?= site_url('admin/mahasiswa') ?>" class="<?= $seg=='mahasiswa'?'active':'' ?>">Mahasiswa</a>
    <a href="<?= site_url('admin/dosen') ?>" class="<?= $seg=='dosen'?'active':'' ?>">Dosen</a>
    <a href="<?= site_url('admin/matakuliah') ?>" class="<?= $seg=='matakuliah'?'active':'' ?>">Mata Kuliah</a>
    <a href="<?= site_url('admin/krs') ?>" class="<?= $seg=='krs'?'active':'' ?>">KRS &amp; Nilai</a>
    <a href="<?= site_url('auth/logout') ?>">Logout</a>
  </nav>
  <main class="col-md-10 p-4">
    <h4 class="mb-3"><?= html_escape($title) ?></h4>
    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

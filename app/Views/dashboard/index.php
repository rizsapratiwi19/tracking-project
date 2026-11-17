<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Dashboard</h2>
    <p>Selamat datang, <strong><?= esc(session()->get('nama')) ?></strong>.</p>
<?= $this->endSection() ?>
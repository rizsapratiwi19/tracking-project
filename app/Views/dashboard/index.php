<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 30px;">
    <h2>Login berhasil</h2>
    <p>Nama: <strong><?= esc(session()->get('nama')) ?></strong></p>
    <p>Peran: <strong><?= esc(session()->get('peran')) ?></strong></p>
    <p><a href="<?= site_url('logout') ?>">Keluar</a></p>
</body>
</html>
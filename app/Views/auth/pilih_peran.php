<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tracking Perizinan</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f4f7; display: flex; justify-content: center; padding: 40px 16px; }
        .box { background: #fff; padding: 28px; border-radius: 10px; width: 100%; max-width: 380px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h2 { margin-top: 0; }
        a.peran { display: block; padding: 12px 14px; margin-bottom: 10px; background: #1f6feb; color: #fff; text-decoration: none; border-radius: 6px; text-align: center; }
        a.peran:hover { background: #1558c0; }
        a.admin { position: fixed; left: 16px; bottom: 16px; z-index: 10; font-size: 13px; color: #667085; text-decoration: none; }
        a.admin:hover { text-decoration: underline; }
    </style>
</head>
<a class="admin" href="<?= site_url('login/admin') ?>">Login Admin</a>
<body>
<div class="box">
    <h2>Masuk sebagai</h2>
    <?php foreach ($daftarPeran as $kode => $label): ?>
        <a class="peran" href="<?= site_url('login/' . $kode) ?>"><?= esc($label) ?></a>
    <?php endforeach; ?>
</div>
<a class="admin" href="<?= site_url('login/admin') ?>">Login Admin</a>
</body>
</html>
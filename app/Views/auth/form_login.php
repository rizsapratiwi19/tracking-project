<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login <?= esc($labelPeran) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f4f7; display: flex; justify-content: center; padding: 40px 16px; }
        .box { background: #fff; padding: 28px; border-radius: 10px; width: 100%; max-width: 380px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h2 { margin-top: 0; }
        label { display: block; margin: 14px 0 6px; font-weight: bold; }
        select, input[type=password] { width: 100%; padding: 10px; box-sizing: border-box; }
        button { width: 100%; margin-top: 18px; padding: 12px; background: #1f6feb; color: #fff; border: 0; border-radius: 6px; cursor: pointer; }
        .error { background: #fde8e8; color: #b42318; padding: 10px; border-radius: 6px; margin-bottom: 10px; }
        .kembali { display: block; margin-top: 14px; text-align: center; }
    </style>
</head>
<body>
<div class="box">
    <h2>Login: <?= esc($labelPeran) ?></h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="error"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (empty($pengguna)): ?>
        <p>Belum ada akun aktif untuk peran ini.</p>
    <?php else: ?>
        <form action="<?= site_url('login/proses') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="peran" value="<?= esc($peran) ?>">

            <label for="pengguna_id">Nama</label>
            <select name="pengguna_id" id="pengguna_id" required>
                <?php foreach ($pengguna as $p): ?>
                    <option value="<?= esc($p['id']) ?>"><?= esc($p['nama']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="password">Kata sandi</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Masuk</button>
        </form>
    <?php endif; ?>

    <a class="kembali" href="<?= site_url('login') ?>">&larr; Pilih peran lain</a>
</div>
</body>
</html>
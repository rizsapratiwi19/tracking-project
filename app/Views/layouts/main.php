<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($judul ?? 'Tracking Perizinan') ?></title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f2f4f7; display: flex; min-height: 100vh; }
        .sidebar { width: 230px; background: #1b2a41; color: #fff; padding: 18px 0; display: flex; flex-direction: column; }
        .brand { padding: 0 18px 16px; font-weight: bold; font-size: 17px; border-bottom: 1px solid #33445f; }
        .sidebar nav { flex: 1; padding-top: 10px; }
        .sidebar a { display: block; padding: 10px 18px; color: #dbe4f0; text-decoration: none; }
        .sidebar a:hover { background: #26395a; }
        .grup { padding: 14px 18px 4px; font-size: 12px; text-transform: uppercase; color: #8fa3bf; }
        .user { padding: 14px 18px; border-top: 1px solid #33445f; font-size: 14px; }
        .user small { color: #8fa3bf; display: block; margin-bottom: 8px; }
        .isi { flex: 1; padding: 26px; min-width: 0; }
        .notif { padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; }
        .notif.sukses { background: #e6f6ec; color: #17653a; }
        .notif.error { background: #fde8e8; color: #b42318; }

        h2 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #e4e7ec; }
        th { background: #eef1f6; }
        .btn { display: inline-block; padding: 8px 14px; background: #1f6feb; color: #fff; border: 0; border-radius: 6px; text-decoration: none; cursor: pointer; font-size: 14px; }
        .btn.kecil { padding: 5px 10px; font-size: 13px; }
        .btn.abu { background: #667085; }
        .btn.merah { background: #d92d20; }
        .form-baris { margin-bottom: 14px; }
        .form-baris label { display: block; font-weight: bold; margin-bottom: 6px; }
        .form-baris input[type=text], .form-baris input[type=number] { width: 100%; max-width: 380px; padding: 9px; }
        .tabel-geser { overflow-x: auto; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { width: 100%; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="brand">Tracking Perizinan</div>
        <nav>
            <a href="<?= site_url('dashboard') ?>">Dashboard</a>

            <?php if (session()->get('peran') === 'admin'): ?>
                <div class="grup">Master Data</div>
                <a href="<?= site_url('admin/jenis-izin') ?>">Jenis Izin</a>
            <?php endif; ?>
        </nav>
        <div class="user">
            <?= esc(session()->get('nama')) ?>
            <small><?= esc(session()->get('peran')) ?></small>
            <a href="<?= site_url('logout') ?>" style="padding:0;">Keluar</a>
        </div>
    </aside>

    <main class="isi">
        <?php if (session()->getFlashdata('sukses')): ?>
            <div class="notif sukses"><?= esc(session()->getFlashdata('sukses')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="notif error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </main>
</body>
</html>
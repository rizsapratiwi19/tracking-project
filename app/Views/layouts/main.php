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
        .form-baris input[type=text], .form-baris input[type=number], .form-baris input[type=date] { width: 100%; max-width: 380px; padding: 9px; }
        .form-baris textarea { width: 100%; max-width: 480px; padding: 9px; font-family: inherit; }
        .form-baris label.pilihan { display: inline-block; font-weight: normal; margin-right: 16px; }
        .tab-baris { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
        .tab-baris.sub { margin-top: -4px; }
        .tab { padding: 8px 14px; background: #e4e7ec; color: #1b2a41; text-decoration: none; border-radius: 6px; font-size: 14px; }
        .tab.aktif { background: #1f6feb; color: #fff; }
        .filter { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-bottom: 16px; }
        .filter select { padding: 8px; }
        .kartu-baris { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 16px; }
        .kartu { background: #fff; padding: 14px 18px; border-radius: 8px; min-width: 150px; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
        .kartu .angka { font-size: 26px; font-weight: bold; }
        .kartu .label { color: #667085; font-size: 13px; }
        .tabel-geser { overflow-x: auto; }

        .info td { padding: 6px 10px 6px 0; border: 0; vertical-align: top; }
        .info td:first-child { width: 190px; color: #667085; }
        .info { background: transparent; width: auto; }
        .baris-aktif td { background: #fff8e1; }
        .badge { padding: 3px 8px; border-radius: 10px; font-size: 12px; background: #e4e7ec; }
        .badge.hijau { background: #e6f6ec; color: #17653a; }
        .badge.kuning { background: #fff1c2; color: #7a5b00; }

        .form-baris select { width: 100%; max-width: 380px; padding: 9px; }

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
            <a href="<?= site_url('tugas') ?>">Tugas Saya</a>

            <?php if (in_array(session()->get('peran'), ['front_office', 'admin'], true)): ?>
                <div class="grup">Perizinan</div>
                <a href="<?= site_url('permohonan') ?>">Daftar Berkas</a>
            <?php endif; ?>

            <?php if (session()->get('peran') === 'admin'): ?>
                <div class="grup">Master Data</div>
                <a href="<?= site_url('admin/jenis-izin') ?>">Jenis Izin</a>
                <a href="<?= site_url('admin/pengguna') ?>">Pengguna</a>
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
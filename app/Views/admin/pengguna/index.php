<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Pengguna</h2>
    <p><a class="btn" href="<?= site_url('admin/pengguna/tambah') ?>">+ Tambah Pengguna</a></p>

    <div class="tabel-geser">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Peran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($daftar as $row): ?>
            <tr>
                <td><?= esc($row['nama']) ?></td>
                <td><?= esc($row['username']) ?></td>
                <td><?= esc($daftarPeran[$row['peran']] ?? $row['peran']) ?></td>
                <td><?= $row['aktif'] ? 'Aktif' : 'Nonaktif' ?></td>
                <td>
                    <a class="btn kecil" href="<?= site_url('admin/pengguna/ubah/' . $row['id']) ?>">Ubah</a>

                    <form action="<?= site_url('admin/pengguna/status/' . $row['id']) ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button class="btn kecil abu" type="submit"><?= $row['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?= $this->endSection() ?>
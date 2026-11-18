<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Jenis Izin</h2>
    <p><a class="btn" href="<?= site_url('admin/jenis-izin/tambah') ?>">+ Tambah Jenis Izin</a></p>

    <div class="tabel-geser">
    <table>
        <thead>
            <tr>
                <th>Urutan</th>
                <th>Nama</th>
                <th>Kode</th>
                <th>Ada pencabutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($daftar as $row): ?>
            <tr>
                <td><?= esc($row['urutan']) ?></td>
                <td><?= esc($row['nama']) ?></td>
                <td><?= esc($row['kode']) ?></td>
                <td><?= $row['punya_pencabutan'] ? 'Ya' : 'Tidak' ?></td>
                <td><?= $row['aktif'] ? 'Aktif' : 'Nonaktif' ?></td>
                <td>
                    <a class="btn kecil" href="<?= site_url('admin/jenis-izin/ubah/' . $row['id']) ?>">Ubah</a>

                    <form action="<?= site_url('admin/jenis-izin/status/' . $row['id']) ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button class="btn kecil abu" type="submit"><?= $row['aktif'] ? 'Nonaktifkan' : 'Aktifkan' ?></button>
                    </form>

                    <form action="<?= site_url('admin/jenis-izin/hapus/' . $row['id']) ?>" method="post" style="display:inline;"
                          onsubmit="return confirm('Hapus jenis izin ini?');">
                        <?= csrf_field() ?>
                        <button class="btn kecil merah" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?= $this->endSection() ?>
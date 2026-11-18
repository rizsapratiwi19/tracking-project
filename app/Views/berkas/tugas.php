<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Tugas Saya</h2>
    <p><?= $semua ? 'Semua berkas yang sedang diproses.' : 'Berkas yang sedang menunggu tindakan Anda.' ?></p>

    <div class="tabel-geser">
    <table>
        <thead>
            <tr>
                <th>No. Register</th>
                <th>Jenis Izin</th>
                <th>Pemohon</th>
                <th>Tanggal Terima</th>
                <th>Tahap Sekarang</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($daftar)): ?>
            <tr><td colspan="6">Tidak ada tugas saat ini.</td></tr>
        <?php endif; ?>
        <?php foreach ($daftar as $row): ?>
            <tr>
                <td><?= esc($row['nomor_register']) ?></td>
                <td><?= esc($row['nama_jenis']) ?></td>
                <td><?= esc($row['nama_pemohon']) ?></td>
                <td><?= esc(date('d-m-Y', strtotime($row['tanggal_terima']))) ?></td>
                <td><?= esc($row['nama_tahap']) ?></td>
                <td><a class="btn kecil" href="<?= site_url('berkas/' . $row['id']) ?>">Buka</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?= $this->endSection() ?>
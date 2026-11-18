<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Daftar Berkas Perizinan</h2>

    <?php if (empty($daftarJenis)): ?>
        <p>Belum ada jenis izin aktif. Admin bisa menambahkannya lewat menu Master Data.</p>
    <?php else: ?>

        <div class="tab-baris">
            <?php foreach ($daftarJenis as $j): ?>
                <a class="tab <?= (int) $j['id'] === (int) $jenis['id'] ? 'aktif' : '' ?>"
                   href="<?= site_url('permohonan') . '?jenis=' . $j['id'] . '&bulan=' . $bulan . '&tahun=' . $tahun ?>">
                    <?= esc($j['nama']) ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($jenis['punya_pencabutan']): ?>
            <div class="tab-baris sub">
                <a class="tab <?= $proses === 'permohonan' ? 'aktif' : '' ?>"
                   href="<?= site_url('permohonan') . '?jenis=' . $jenis['id'] . '&proses=permohonan&bulan=' . $bulan . '&tahun=' . $tahun ?>">Register Masuk</a>
                <a class="tab <?= $proses === 'pencabutan' ? 'aktif' : '' ?>"
                   href="<?= site_url('permohonan') . '?jenis=' . $jenis['id'] . '&proses=pencabutan&bulan=' . $bulan . '&tahun=' . $tahun ?>">Register Pencabutan</a>
            </div>
        <?php endif; ?>

        <form method="get" action="<?= site_url('permohonan') ?>" class="filter">
            <input type="hidden" name="jenis" value="<?= esc($jenis['id']) ?>">
            <input type="hidden" name="proses" value="<?= esc($proses) ?>">

            <select name="bulan">
                <option value="0" <?= $bulan === 0 ? 'selected' : '' ?>>Semua bulan</option>
                <?php foreach ($namaBulan as $no => $nama): ?>
                    <option value="<?= $no ?>" <?= $bulan === $no ? 'selected' : '' ?>><?= $nama ?></option>
                <?php endforeach; ?>
            </select>

            <select name="tahun">
                <?php for ($t = (int) date('Y') + 1; $t >= (int) date('Y') - 5; $t--): ?>
                    <option value="<?= $t ?>" <?= $tahun === $t ? 'selected' : '' ?>><?= $t ?></option>
                <?php endfor; ?>
            </select>

            <button class="btn kecil" type="submit">Tampilkan</button>
        </form>

        <div class="kartu-baris">
            <div class="kartu"><div class="angka"><?= $ringkasan['total'] ?></div><div class="label">Berkas masuk</div></div>
            <div class="kartu"><div class="angka"><?= $ringkasan['proses'] ?></div><div class="label">Sedang diproses</div></div>
            <div class="kartu"><div class="angka"><?= $ringkasan['selesai'] ?></div><div class="label">Selesai</div></div>
        </div>

        <p>
            <a class="btn" href="<?= site_url('permohonan/tambah') . '?jenis=' . $jenis['id'] . '&proses=' . $proses ?>">+ Register Berkas Baru</a>
        </p>

        <div class="tabel-geser">
        <table>
            <thead>
                <tr>
                    <th>No. Register</th>
                    <th>Tanggal Terima</th>
                    <th>Pemohon</th>
                    <th>Uraian</th>
                    <th>Tahap Sekarang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($daftar)): ?>
                <tr><td colspan="6">Belum ada berkas pada periode ini.</td></tr>
            <?php endif; ?>
            <?php foreach ($daftar as $row): ?>
                <tr>
                    <td><a href="<?= site_url('berkas/' . $row['id']) ?>"><?= esc($row['nomor_register']) ?></a></td>
                    <td><?= esc(date('d-m-Y', strtotime($row['tanggal_terima']))) ?></td>
                    <td><?= esc($row['nama_pemohon']) ?></td>
                    <td><?= esc(mb_strimwidth((string) $row['uraian_permohonan'], 0, 60, '...')) ?></td>
                    <td><?= esc($row['nama_tahap'] ?? '-') ?></td>
                    <td><?= $row['status'] === 'selesai' ? 'Selesai' : 'Diproses' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>

    <?php endif; ?>
<?= $this->endSection() ?>
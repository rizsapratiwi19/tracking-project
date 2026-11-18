<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2>Berkas <?= esc($p['nomor_register']) ?></h2>

    <table class="info">
        <tr><td>Jenis izin</td><td><?= esc($p['nama_jenis']) ?><?= $p['jenis_proses'] === 'pencabutan' ? ' (Pencabutan)' : '' ?></td></tr>
        <tr><td>Uraian permohonan</td><td><?= nl2br(esc((string) $p['uraian_permohonan'])) ?: '-' ?></td></tr>
        <tr><td>Nama pemohon</td><td><?= esc($p['nama_pemohon']) ?></td></tr>
        <tr><td>Kuasa pemohon</td><td><?= esc($p['nama_kuasa'] ?: '-') ?></td></tr>
        <tr><td>Lokasi</td><td><?= nl2br(esc((string) $p['lokasi'])) ?: '-' ?></td></tr>
        <tr><td>No HP</td><td><?= esc($p['no_hp'] ?: '-') ?></td></tr>
        <tr><td>Kelengkapan berkas</td><td><?= $p['kelengkapan'] === 'lengkap' ? 'Lengkap' : 'Tidak lengkap' ?></td></tr>
        <tr><td>Tanggal terima</td><td><?= esc(date('d-m-Y', strtotime($p['tanggal_terima']))) ?></td></tr>
        <tr>
            <td>Status</td>
            <td>
                <?php if ($p['status'] === 'selesai'): ?>
                    <span class="badge hijau">Selesai</span>
                <?php else: ?>
                    <span class="badge kuning">Diproses</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <h3>Kartu Kendali</h3>
    <div class="tabel-geser">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kegiatan</th>
                <th>Peran</th>
                <th>Tanggal</th>
                <th>Pemroses</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tahapan as $t): ?>
            <?php
                $r     = $riwayat[$t['id']] ?? null;
                $aktif = $tahapSekarang && (int) $t['id'] === (int) $tahapSekarang['id'];
            ?>
            <tr class="<?= $aktif ? 'baris-aktif' : '' ?>">
                <td><?= esc($t['urutan']) ?></td>
                <td><?= esc($t['nama_tahap']) ?><?= $aktif ? ' <span class="badge kuning">sedang di sini</span>' : '' ?></td>
                <td><?= esc($t['peran']) ?></td>
                <td><?= $r ? esc(date('d-m-Y H:i', strtotime($r['tanggal']))) : '' ?></td>
                <td><?= $r ? esc($r['nama_pengguna'] ?? '-') : '' ?></td>
                <td><?= $r ? esc((string) $r['catatan']) : '' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <?php if ($bisaProses): ?>
        <h3>Tindakan</h3>
        <form action="<?= site_url('berkas/' . $p['id'] . '/teruskan') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="tahapan_id" value="<?= esc($tahapSekarang['id']) ?>">

            <div class="form-baris">
                <label for="catatan">Catatan (boleh dikosongkan)</label>
                <textarea name="catatan" id="catatan" rows="3"></textarea>
            </div>

            <button class="btn" type="submit"
                    onclick="return confirm('Selesaikan tahap ini dan teruskan?');">
                <?= $terakhir ? 'Selesaikan Tahap Terakhir' : 'Selesaikan dan Teruskan' ?>
            </button>
        </form>
    <?php endif; ?>

    <p style="margin-top:20px;">
        <a class="btn abu" href="<?= site_url('tugas') ?>">Kembali</a>
    </p>
<?= $this->endSection() ?>
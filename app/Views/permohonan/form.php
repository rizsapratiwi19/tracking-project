<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2><?= esc($judul) ?></h2>
    <p>
        Jenis izin: <strong><?= esc($jenis['nama']) ?></strong>
        <?= $proses === 'pencabutan' ? '(Register Pencabutan)' : '' ?>
    </p>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="notif error">
            <?php foreach (session()->getFlashdata('errors') as $pesan): ?>
                <div><?= esc($pesan) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('permohonan/simpan') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="jenis_izin_id" value="<?= esc($jenis['id']) ?>">
        <input type="hidden" name="jenis_proses" value="<?= esc($proses) ?>">

        <div class="form-baris">
            <label for="tanggal_terima">Tanggal terima</label>
            <input type="date" name="tanggal_terima" id="tanggal_terima" value="<?= esc(old('tanggal_terima', date('Y-m-d'))) ?>" required>
        </div>

        <div class="form-baris">
            <label for="uraian_permohonan">Uraian permohonan</label>
            <textarea name="uraian_permohonan" id="uraian_permohonan" rows="3"><?= esc(old('uraian_permohonan')) ?></textarea>
        </div>

        <div class="form-baris">
            <label for="nama_pemohon">Nama pemohon</label>
            <input type="text" name="nama_pemohon" id="nama_pemohon" value="<?= esc(old('nama_pemohon')) ?>" required>
        </div>

        <div class="form-baris">
            <label for="nama_kuasa">Kuasa pemohon (jika ada)</label>
            <input type="text" name="nama_kuasa" id="nama_kuasa" value="<?= esc(old('nama_kuasa')) ?>">
        </div>

        <div class="form-baris">
            <label for="lokasi">Lokasi yang dimohon</label>
            <textarea name="lokasi" id="lokasi" rows="2"><?= esc(old('lokasi')) ?></textarea>
        </div>

        <div class="form-baris">
            <label for="no_hp">No HP</label>
            <input type="text" name="no_hp" id="no_hp" value="<?= esc(old('no_hp')) ?>">
        </div>

        <div class="form-baris">
            <label>Kelengkapan berkas</label>
            <label class="pilihan">
                <input type="radio" name="kelengkapan" value="lengkap" <?= old('kelengkapan', 'lengkap') === 'lengkap' ? 'checked' : '' ?>> Lengkap
            </label>
            <label class="pilihan">
                <input type="radio" name="kelengkapan" value="tidak_lengkap" <?= old('kelengkapan') === 'tidak_lengkap' ? 'checked' : '' ?>> Tidak lengkap
            </label>
        </div>

        <button class="btn" type="submit">Simpan</button>
        <a class="btn abu" href="<?= site_url('permohonan') . '?jenis=' . $jenis['id'] . '&proses=' . $proses ?>">Batal</a>
    </form>
<?= $this->endSection() ?>
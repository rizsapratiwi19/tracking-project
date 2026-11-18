<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h2><?= esc($judul) ?></h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="notif error">
            <?php foreach (session()->getFlashdata('errors') as $pesan): ?>
                <div><?= esc($pesan) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= $aksi ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-baris">
            <label for="nama">Nama jenis izin</label>
            <input type="text" name="nama" id="nama" value="<?= esc(old('nama', $item['nama'] ?? '')) ?>" required>
        </div>

        <div class="form-baris">
            <label for="kode">Kode singkat</label>
            <input type="text" name="kode" id="kode" value="<?= esc(old('kode', $item['kode'] ?? '')) ?>" required>
        </div>

        <div class="form-baris">
            <label for="urutan">Urutan tampil</label>
            <input type="number" name="urutan" id="urutan" value="<?= esc(old('urutan', $item['urutan'] ?? 0)) ?>">
        </div>

        <div class="form-baris">
            <label>
                <input type="checkbox" name="punya_pencabutan" value="1"
                    <?= old('punya_pencabutan', $item['punya_pencabutan'] ?? 0) ? 'checked' : '' ?>>
                Punya register pencabutan (seperti Izin Kesehatan)
            </label>
        </div>

        <button class="btn" type="submit">Simpan</button>
        <a class="btn abu" href="<?= site_url('admin/jenis-izin') ?>">Batal</a>
    </form>
<?= $this->endSection() ?>
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
            <label for="nama">Nama pegawai</label>
            <input type="text" name="nama" id="nama" value="<?= esc(old('nama', $item['nama'] ?? '')) ?>" required>
        </div>

        <div class="form-baris">
            <label for="username">Username (huruf dan angka, tanpa spasi)</label>
            <input type="text" name="username" id="username" value="<?= esc(old('username', $item['username'] ?? '')) ?>" required>
        </div>

        <div class="form-baris">
            <label for="peran">Peran</label>
            <select name="peran" id="peran" required>
                <?php $dipilih = old('peran', $item['peran'] ?? ''); ?>
                <?php foreach ($daftarPeran as $kode => $label): ?>
                    <option value="<?= esc($kode) ?>" <?= $dipilih === $kode ? 'selected' : '' ?>><?= esc($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-baris">
            <label for="password"><?= $item ? 'Kata sandi baru (kosongkan jika tidak diubah)' : 'Kata sandi sementara (minimal 8 karakter)' ?></label>
            <input type="text" name="password" id="password" autocomplete="off" <?= $item ? '' : 'required' ?>>
        </div>

        <button class="btn" type="submit">Simpan</button>
        <a class="btn abu" href="<?= site_url('admin/pengguna') ?>">Batal</a>
    </form>
<?= $this->endSection() ?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Tambah Transfer</h4>

    <form action="<?= base_url('transfer/store') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label>Peruntukan</label>
            <select name="peruntukan" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="bekal">Bekal</option>
                <option value="biaya sekolah">Biaya Sekolah</option>
                <option value="biaya pesantren">Biaya Pesantren</option>
                <option value="biaya lainnya">Biaya Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Jumlah Transfer</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Bukti Transfer (wajib)</label>
            <input type="file" name="bukti_transfer" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label>Keterangan (opsional)</label>
            <textarea name="keterangan_transfer" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
        <a href="<?= base_url('transfer') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection(); ?>
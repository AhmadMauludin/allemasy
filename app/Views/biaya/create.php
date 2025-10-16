<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container mt-4">
    <h4>Tambah Biaya</h4>

    <form action="<?= base_url('biaya/store') ?>" method="POST">
        <div class="mb-3">
            <label>Jenis Biaya</label>
            <select name="jenis_biaya" class="form-select" required>
                <option value="">Pilih jenis</option>
                <option value="sekolah">Sekolah</option>
                <option value="pesantren">Pesantren</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Peruntukan</label>
            <input type="text" name="peruntukan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Tingkat</label>
            <select name="tingkat" class="form-select" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="Semua">Semua</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Biaya</label>
            <input type="number" name="biaya" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Status Biaya</label>
            <select name="status_biaya" class="form-select">
                <option value="aktif" selected>Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan_biaya" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?= $this->endSection(); ?>
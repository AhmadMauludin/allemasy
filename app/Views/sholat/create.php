<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <h2 class="mb-4"><?= esc($title) ?></h2>

    <form action="<?= base_url('sholat/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row mb-3">
            <div class="col-md-2">
                <label for="hari" class="form-label">Hari</label>
                <select name="hari" id="hari" class="form-select" required>
                    <option value="">-- Pilih Hari --</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="sholat" class="form-label">Jenis Sholat</label>
                <select name="sholat" id="sholat" class="form-select" required>
                    <option value="">-- Pilih Sholat --</option>
                    <option value="Shubuh">Shubuh</option>
                    <option value="Dhuhur">Dhuhur</option>
                    <option value="Ashar">Ashar</option>
                    <option value="Maghrib">Maghrib</option>
                    <option value="Isya">Isya</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="ket_sholat" class="form-label">Keterangan</label>
            <textarea name="ket_sholat" id="ket_sholat" rows="3" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Jadwal Sholat</button>
        <a href="<?= base_url('sholat') ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main'); ?>
<?= $this->section('content'); ?>
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">Tambah Ujikom</div>
    <div class="card-body">
        <form action="<?= base_url('ujikom/store'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_kompetensi_pesdik" value="<?= $id_kompetensi_pesdik; ?>">

            <div class="mb-3">
                <label>Waktu</label>
                <input type="datetime-local" name="waktu" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="dijadwalkan">Dijadwalkan</option>
                    <option value="selesai">Selesai</option>
                    <option value="ulang">Ulang</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Rincian</label>
                <textarea name="rincian" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label>Foto (opsional)</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= base_url('ujikom/index/' . $id_kompetensi_pesdik); ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>
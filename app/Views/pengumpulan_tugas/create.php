<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <p class="mb-0">Kumpulkan Tugas</p>
        </div>
        <div class="card-body">

            <form action="<?= base_url('pengumpulan_tugas/store') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_tugas" value="<?= $id_tugas ?>">

                <div class="mb-3">
                    <label>Lampiran (PDF / DOC / Gambar)</label>
                    <input type="file" name="lampiran" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Instruksi / Catatan</label>
                    <input type="text" name="intruksi" class="form-control" rows="3">
                </div>

                <button type="submit" class="btn btn-success">Kirim Tugas</button>
                <a href="javascript:history.back()" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
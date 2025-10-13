<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h3>Kumpulkan Tugas</h3>

<form action="<?= base_url('pengumpulan_tugas/store') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id_tugas" value="<?= $id_tugas ?>">

    <div class="mb-3">
        <label>Lampiran (PDF / DOC / Gambar)</label>
        <input type="file" name="lampiran" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Instruksi / Catatan</label>
        <textarea name="intruksi" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Kirim Tugas</button>
    <a href="javascript:history.back()" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
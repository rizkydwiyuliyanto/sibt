<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-map-marker-path"></i>
                </span> Tujuan Kunjungan
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tujuan Kunjungan</li>
                </ol>
            </nav>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Tujuan Kunjungan</h4>
                        <button type="button" class="btn btn-gradient-primary btn-sm mb-3" data-bs-toggle="modal"
                            data-bs-target="#tambahTujuanModal">
                            <i class="mdi mdi-plus"></i> Tambah Tujuan
                        </button>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tujuan</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dataTujuan)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data tujuan kunjungan.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($dataTujuan as $tujuan): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($tujuan['nama_tujuan']); ?></td>
                                    <td><?= esc($tujuan['deskripsi'] ?: '-'); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-gradient-info btn-sm btn-edit-tujuan"
                                            data-bs-toggle="modal" data-bs-target="#editTujuanModal"
                                            data-id="<?= $tujuan['id_tujuan']; ?>"
                                            data-nama="<?= esc($tujuan['nama_tujuan']); ?>"
                                            data-deskripsi="<?= esc($tujuan['deskripsi']); ?>">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <a href="<?= base_url('admin/tujuan-kunjungan/hapus/' . $tujuan['id_tujuan']); ?>"
                                            class="btn btn-gradient-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus tujuan ini? Kunjungan yang terkait akan kehilangan tujuan spesifiknya.')">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahTujuanModal" tabindex="-1" aria-labelledby="tambahTujuanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTujuanModalLabel">Tambah Tujuan Kunjungan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/tujuan-kunjungan/tambah'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="nama_tujuan" class="form-label">Nama Tujuan:</label>
                        <input type="text" class="form-control" id="nama_tujuan" name="nama_tujuan"
                            value="<?= old('nama_tujuan'); ?>" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_tujuan'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['nama_tujuan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi (Opsional):</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"
                            rows="3"><?= old('deskripsi'); ?></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Simpan Tujuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTujuanModal" tabindex="-1" aria-labelledby="editTujuanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTujuanModalLabel">Edit Tujuan Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/tujuan-kunjungan/edit'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_tujuan" id="edit_id_tujuan">
                    <div class="mb-3">
                        <label for="edit_nama_tujuan" class="form-label">Nama Tujuan:</label>
                        <input type="text" class="form-control" id="edit_nama_tujuan" name="nama_tujuan" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_tujuan'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['nama_tujuan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_deskripsi" class="form-label">Deskripsi (Opsional):</label>
                        <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Perbarui Tujuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editTujuanModal = document.getElementById('editTujuanModal');
    editTujuanModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        var deskripsi = button.getAttribute('data-deskripsi');

        var modalTitle = editTujuanModal.querySelector('.modal-title');
        var modalBodyInputId = editTujuanModal.querySelector('#edit_id_tujuan');
        var modalBodyInputNama = editTujuanModal.querySelector('#edit_nama_tujuan');
        var modalBodyTextareaDeskripsi = editTujuanModal.querySelector('#edit_deskripsi');

        modalTitle.textContent = 'Edit Tujuan: ' + nama;
        modalBodyInputId.value = id;
        modalBodyInputNama.value = nama;
        modalBodyTextareaDeskripsi.value = deskripsi;
    });

    // Tampilkan modal jika ada error validasi
    <?php if (session()->getFlashdata('errors')): ?>
    var errors = <?= json_encode(session()->getFlashdata('errors')); ?>;
    var hasAddError = (errors['nama_tujuan'] && !old('id_tujuan')); // Check for add form errors
    var hasEditError = (errors['nama_tujuan'] && old('id_tujuan')); // Check for edit form errors

    if (hasAddError) {
        var tambahTujuanModal = new bootstrap.Modal(document.getElementById('tambahTujuanModal'));
        tambahTujuanModal.show();
    } else if (hasEditError) {
        var editTujuanModal = new bootstrap.Modal(document.getElementById('editTujuanModal'));
        // Repopulate edit form with old data if it failed validation
        document.getElementById('edit_id_tujuan').value = '<?= old('id_tujuan'); ?>';
        document.getElementById('edit_nama_tujuan').value = '<?= old('nama_tujuan'); ?>';
        document.getElementById('edit_deskripsi').value = '<?= old('deskripsi'); ?>';
        editTujuanModal.show();
    }
    <?php endif; ?>
});
</script>
<?= $this->endSection(); ?>
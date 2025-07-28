<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-history"></i>
                </span> Riwayat Kunjungan
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Riwayat Kunjungan</li>
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
        <?php if (session()->getFlashdata('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('info'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Riwayat Kunjungan</h4>
                        <button type="button" class="btn btn-gradient-primary btn-sm mb-3" data-bs-toggle="modal"
                            data-bs-target="#tambahKunjunganModal">
                            <i class="mdi mdi-plus"></i> Catat Kunjungan Baru
                        </button>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Tamu</th>
                                    <th>Tanggal</th>
                                    <th>Waktu Masuk</th>
                                    <th>Waktu Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($riwayatKunjungan)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada riwayat kunjungan.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($riwayatKunjungan as $kunjungan): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($kunjungan['nama_lengkap'] ?? '-'); ?></td>
                                    <td><?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?></td>
                                    <td><?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?></td>
                                    <td>
                                        <?php if ($kunjungan['waktu_keluar']): ?>
                                        <?= date('H:i', strtotime(esc($kunjungan['waktu_keluar']))); ?>
                                        <?php else: ?>
                                        <span class="badge bg-warning text-dark">Belum keluar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button"
                                            class="btn btn-gradient-secondary btn-sm mb-1 btn-detail-kunjungan"
                                            data-bs-toggle="modal" data-bs-target="#detailKunjunganModal"
                                            data-id_kunjungan="<?= $kunjungan['id_kunjungan']; ?>"
                                            data-nama_tamu="<?= esc($kunjungan['nama_lengkap'] ?? '-'); ?>"
                                            data-asal_instansi="<?= esc($kunjungan['asal_instansi'] ?? '-'); ?>"
                                            data-tanggal="<?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?>"
                                            data-masuk="<?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?>"
                                            data-keluar="<?= $kunjungan['waktu_keluar'] ? date('H:i', strtotime(esc($kunjungan['waktu_keluar']))) : 'Belum keluar'; ?>"
                                            data-tujuan="<?= esc($kunjungan['nama_tujuan'] ?? '-'); ?>"
                                            data-keperluan="<?= esc($kunjungan['keperluan']); ?>"
                                            data-catatan="<?= esc($kunjungan['catatan'] ?? '-'); ?>">
                                            <i class="mdi mdi-eye"></i> Detail
                                        </button>

                                        <?php if (empty($kunjungan['waktu_keluar'])): ?>
                                        <a href="<?= base_url('admin/riwayat-kunjungan/update-waktu-keluar/' . $kunjungan['id_kunjungan']); ?>"
                                            class="btn btn-gradient-warning btn-sm mb-1"
                                            onclick="return confirm('Catat waktu keluar sekarang?')">
                                            <i class="mdi mdi-clock-end"></i> Keluar
                                        </a>
                                        <?php endif; ?>
                                        <button type="button"
                                            class="btn btn-gradient-info btn-sm btn-edit-kunjungan mb-1"
                                            data-bs-toggle="modal" data-bs-target="#editKunjunganModal"
                                            data-id="<?= $kunjungan['id_kunjungan']; ?>"
                                            data-id_tamu="<?= $kunjungan['id_tamu']; ?>"
                                            data-id_tujuan="<?= $kunjungan['id_tujuan']; ?>"
                                            data-tanggal="<?= esc($kunjungan['tanggal_kunjungan']); ?>"
                                            data-waktu_masuk="<?= esc($kunjungan['waktu_masuk']); ?>"
                                            data-waktu_keluar="<?= esc($kunjungan['waktu_keluar']); ?>"
                                            data-keperluan="<?= esc($kunjungan['keperluan']); ?>"
                                            data-catatan="<?= esc($kunjungan['catatan']); ?>">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <a href="<?= base_url('admin/riwayat-kunjungan/hapus/' . $kunjungan['id_kunjungan']); ?>"
                                            class="btn btn-gradient-danger btn-sm mb-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat kunjungan ini?')">
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

<div class="modal fade" id="tambahKunjunganModal" tabindex="-1" aria-labelledby="tambahKunjunganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKunjunganModalLabel">Catat Kunjungan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/riwayat-kunjungan/tambah'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="id_tamu" class="form-label">Pilih Tamu:</label>
                        <select class="form-control" id="id_tamu" name="id_tamu" required>
                            <option value="">-- Pilih Tamu --</option>
                            <?php foreach ($daftarTamu as $tamu): ?>
                            <option value="<?= $tamu['id_tamu']; ?>"
                                <?= old('id_tamu') == $tamu['id_tamu'] ? 'selected' : ''; ?>>
                                <?= esc($tamu['nama_lengkap']); ?> (<?= esc($tamu['asal_instansi'] ?? 'Perorangan'); ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_tamu'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['id_tamu']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan:</label>
                        <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan"
                            value="<?= old('tanggal_kunjungan', date('Y-m-d')); ?>" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['tanggal_kunjungan'])): ?>
                        <small
                            class="text-danger"><?= session()->getFlashdata('errors')['tanggal_kunjungan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="waktu_masuk" class="form-label">Waktu Masuk:</label>
                        <input type="time" class="form-control" id="waktu_masuk" name="waktu_masuk"
                            value="<?= old('waktu_masuk', date('H:i')); ?>" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['waktu_masuk'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['waktu_masuk']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="id_tujuan" class="form-label">Tujuan Kunjungan (Opsional):</label>
                        <select class="form-control" id="id_tujuan" name="id_tujuan">
                            <option value="">-- Pilih Tujuan --</option>
                            <?php foreach ($daftarTujuan as $tujuan): ?>
                            <option value="<?= $tujuan['id_tujuan']; ?>"
                                <?= old('id_tujuan') == $tujuan['id_tujuan'] ? 'selected' : ''; ?>>
                                <?= esc($tujuan['nama_tujuan']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_tujuan'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['id_tujuan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan:</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" rows="3"
                            required><?= old('keperluan'); ?></textarea>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['keperluan'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['keperluan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional):</label>
                        <textarea class="form-control" id="catatan" name="catatan"
                            rows="3"><?= old('catatan'); ?></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Simpan Kunjungan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editKunjunganModal" tabindex="-1" aria-labelledby="editKunjunganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKunjunganModalLabel">Edit Data Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/riwayat-kunjungan/edit'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_kunjungan" id="edit_id_kunjungan">
                    <div class="mb-3">
                        <label for="edit_id_tamu" class="form-label">Tamu:</label>
                        <select class="form-control" id="edit_id_tamu" name="id_tamu" required>
                            <option value="">-- Pilih Tamu --</option>
                            <?php foreach ($daftarTamu as $tamu): ?>
                            <option value="<?= $tamu['id_tamu']; ?>"><?= esc($tamu['nama_lengkap']); ?>
                                (<?= esc($tamu['asal_instansi'] ?? 'Perorangan'); ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_tamu'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['id_tamu']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tanggal_kunjungan" class="form-label">Tanggal Kunjungan:</label>
                        <input type="date" class="form-control" id="edit_tanggal_kunjungan" name="tanggal_kunjungan"
                            required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['tanggal_kunjungan'])): ?>
                        <small
                            class="text-danger"><?= session()->getFlashdata('errors')['tanggal_kunjungan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_masuk" class="form-label">Waktu Masuk:</label>
                        <input type="time" class="form-control" id="edit_waktu_masuk" name="waktu_masuk" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['waktu_masuk'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['waktu_masuk']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_waktu_keluar" class="form-label">Waktu Keluar:</label>
                        <input type="time" class="form-control" id="edit_waktu_keluar" name="waktu_keluar">
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_tujuan" class="form-label">Tujuan Kunjungan (Opsional):</label>
                        <select class="form-control" id="edit_id_tujuan" name="id_tujuan">
                            <option value="">-- Pilih Tujuan --</option>
                            <?php foreach ($daftarTujuan as $tujuan): ?>
                            <option value="<?= $tujuan['id_tujuan']; ?>"><?= esc($tujuan['nama_tujuan']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_tujuan'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['id_tujuan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_keperluan" class="form-label">Keperluan:</label>
                        <textarea class="form-control" id="edit_keperluan" name="keperluan" rows="3"
                            required></textarea>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['keperluan'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['keperluan']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_catatan" class="form-label">Catatan (Opsional):</label>
                        <textarea class="form-control" id="edit_catatan" name="catatan" rows="3"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Perbarui Kunjungan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailKunjunganModal" tabindex="-1" aria-labelledby="detailKunjunganModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKunjunganModalLabel">Detail Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Tamu:</strong> <span id="detail_nama_tamu"></span></p>
                <p><strong>Asal Instansi:</strong> <span id="detail_asal_instansi"></span></p>
                <p><strong>Tanggal Kunjungan:</strong> <span id="detail_tanggal"></span></p>
                <p><strong>Waktu Masuk:</strong> <span id="detail_waktu_masuk"></span></p>
                <p><strong>Waktu Keluar:</strong> <span id="detail_waktu_keluar"></span></p>
                <p><strong>Tujuan Kunjungan:</strong> <span id="detail_tujuan"></span></p>
                <p><strong>Keperluan:</strong> <span id="detail_keperluan"></span></p>
                <p><strong>Catatan:</strong> <span id="detail_catatan"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editKunjunganModal = document.getElementById('editKunjunganModal');
    if (editKunjunganModal) { // Pastikan modal ditemukan
        editKunjunganModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var id = button.getAttribute('data-id');
            var id_tamu = button.getAttribute('data-id_tamu');
            var id_tujuan = button.getAttribute('data-id_tujuan');
            var tanggal = button.getAttribute('data-tanggal');
            var waktu_masuk = button.getAttribute('data-waktu_masuk');
            var waktu_keluar = button.getAttribute('data-waktu_keluar');
            var keperluan = button.getAttribute('data-keperluan');
            var catatan = button.getAttribute('data-catatan');

            var modalTitle = editKunjunganModal.querySelector('.modal-title');
            var modalBodyInputId = editKunjunganModal.querySelector('#edit_id_kunjungan');
            var modalBodySelectTamu = editKunjunganModal.querySelector('#edit_id_tamu');
            var modalBodySelectTujuan = editKunjunganModal.querySelector('#edit_id_tujuan');
            var modalBodyInputTanggal = editKunjunganModal.querySelector('#edit_tanggal_kunjungan');
            var modalBodyInputWaktuMasuk = editKunjunganModal.querySelector('#edit_waktu_masuk');
            var modalBodyInputWaktuKeluar = editKunjunganModal.querySelector('#edit_waktu_keluar');
            var modalBodyTextareaKeperluan = editKunjunganModal.querySelector('#edit_keperluan');
            var modalBodyTextareaCatatan = editKunjunganModal.querySelector('#edit_catatan');

            modalTitle.textContent = 'Edit Data Kunjungan ID: ' + id;
            modalBodyInputId.value = id;
            modalBodySelectTamu.value = id_tamu;
            modalBodySelectTujuan.value = id_tujuan;
            modalBodyInputTanggal.value = tanggal;
            modalBodyInputWaktuMasuk.value = waktu_masuk;
            modalBodyInputWaktuKeluar.value = waktu_keluar;
            modalBodyTextareaKeperluan.value = keperluan;
            modalBodyTextareaCatatan.value = catatan;
        });
    }


    // JavaScript untuk Modal Detail
    var detailKunjunganModal = document.getElementById('detailKunjunganModal');
    if (detailKunjunganModal) { // Pastikan modal ditemukan
        detailKunjunganModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button yang memicu modal

            // Ambil data dari atribut data- pada tombol
            var nama_tamu = button.getAttribute('data-nama_tamu');
            var asal_instansi = button.getAttribute('data-asal_instansi'); // Ambil asal_instansi
            var tanggal = button.getAttribute('data-tanggal');
            var masuk = button.getAttribute('data-masuk');
            var keluar = button.getAttribute('data-keluar');
            var tujuan = button.getAttribute('data-tujuan');
            var keperluan = button.getAttribute('data-keperluan');
            var catatan = button.getAttribute('data-catatan');

            // Isi elemen di modal detail
            detailKunjunganModal.querySelector('#detail_nama_tamu').textContent = nama_tamu;
            detailKunjunganModal.querySelector('#detail_asal_instansi').textContent =
                asal_instansi; // Isi asal_instansi
            detailKunjunganModal.querySelector('#detail_tanggal').textContent = tanggal;
            detailKunjunganModal.querySelector('#detail_waktu_masuk').textContent = masuk;
            detailKunjunganModal.querySelector('#detail_waktu_keluar').textContent = keluar;
            detailKunjunganModal.querySelector('#detail_tujuan').textContent = tujuan;
            detailKunjunganModal.querySelector('#detail_keperluan').textContent = keperluan;
            detailKunjunganModal.querySelector('#detail_catatan').textContent = catatan;
        });
    } else {
        console.error("Elemen modal #detailKunjunganModal tidak ditemukan.");
    }


    // Tampilkan modal jika ada error validasi
    <?php if (session()->getFlashdata('errors')): ?>
    var errors = <?= json_encode(session()->getFlashdata('errors')); ?>;
    var addModalErrors = ['id_tamu', 'tanggal_kunjungan', 'waktu_masuk', 'keperluan'];

    let isAddFormError = false;
    for (let key in addModalErrors) {
        if (errors[addModalErrors[key]]) {
            isAddFormError = true;
            break;
        }
    }

    if (isAddFormError) {
        var tambahKunjunganModal = new bootstrap.Modal(document.getElementById('tambahKunjunganModal'));
        tambahKunjunganModal.show();
    } else if (old('id_kunjungan')) { // If old data suggests edit form and validation errors exist
        var editKunjunganModal = new bootstrap.Modal(document.getElementById('editKunjunganModal'));
        // Repopulate edit form with old data if it failed validation
        document.getElementById('edit_id_kunjungan').value = '<?= old('id_kunjungan'); ?>';
        document.getElementById('edit_id_tamu').value = '<?= old('id_tamu'); ?>';
        document.getElementById('edit_tanggal_kunjungan').value = '<?= old('tanggal_kunjungan'); ?>';
        document.getElementById('edit_waktu_masuk').value = '<?= old('waktu_masuk'); ?>';
        document.getElementById('edit_waktu_keluar').value = '<?= old('waktu_keluar'); ?>';
        document.getElementById('edit_id_tujuan').value = '<?= old('id_tujuan'); ?>';
        document.getElementById('edit_keperluan').value = '<?= old('keperluan'); ?>';
        document.getElementById('edit_catatan').value = '<?= old('catatan'); ?>';
        editKunjunganModal.show();
    }
    <?php endif; ?>
});
</script>
<?= $this->endSection(); ?>
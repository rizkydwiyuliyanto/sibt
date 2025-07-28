<?= $this->extend('kepala_bagian/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-check-circle-outline"></i>
                </span> Persetujuan Kunjungan
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('kepala-bagian/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Persetujuan Kunjungan</li>
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
                        <h4 class="card-title">Daftar Kunjungan Menunggu Persetujuan</h4>
                        <div class="table-responsive table-responsive-custom">
                            <table class="table table-hover table-striped table-break-word">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tamu</th>
                                        <th>Asal Instansi</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Waktu Masuk</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($kunjunganMenunggu)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada kunjungan yang menunggu
                                            persetujuan.</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php $no = 1; foreach ($kunjunganMenunggu as $kunjungan): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($kunjungan['nama_lengkap'] ?? '-'); ?></td>
                                        <td><?= esc($kunjungan['asal_instansi'] ?? '-'); ?></td>
                                        <td><?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?></td>
                                        <td><?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?></td>
                                        <td><?= esc($kunjungan['nama_tujuan'] ?? '-'); ?></td>
                                        <td><?= esc($kunjungan['keperluan']); ?></td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-gradient-primary btn-sm mb-1 btn-proses-persetujuan"
                                                data-bs-toggle="modal" data-bs-target="#prosesPersetujuanModal"
                                                data-id="<?= $kunjungan['id_kunjungan']; ?>"
                                                data-nama_tamu="<?= esc($kunjungan['nama_lengkap'] ?? '-'); ?>"
                                                data-instansi="<?= esc($kunjungan['asal_instansi'] ?? '-'); ?>"
                                                data-tanggal="<?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?>"
                                                data-keperluan="<?= esc($kunjungan['keperluan']); ?>"
                                                data-catatan_tamu="<?= esc($kunjungan['catatan'] ?? '-'); ?>">
                                                <i class="mdi mdi-check"></i> Proses
                                            </button>
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
</div>

<div class="modal fade" id="prosesPersetujuanModal" tabindex="-1" aria-labelledby="prosesPersetujuanModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prosesPersetujuanModalLabel">Proses Persetujuan Kunjungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('kepala-bagian/proses-persetujuan'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_kunjungan" id="proses_id_kunjungan">

                    <p><strong>Nama Tamu:</strong> <span id="proses_nama_tamu"></span></p>
                    <p><strong>Asal Instansi:</strong> <span id="proses_instansi"></span></p>
                    <p><strong>Tanggal Kunjungan:</strong> <span id="proses_tanggal"></span></p>
                    <p><strong>Keperluan:</strong> <span id="proses_keperluan"></span></p>
                    <p><strong>Catatan Tamu:</strong> <span id="proses_catatan_tamu"></span></p>
                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Status Persetujuan:</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_persetujuan"
                                    id="statusDisetujui" value="disetujui" required>
                                <label class="form-check-label" for="statusDisetujui">Disetujui</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status_persetujuan"
                                    id="statusDitolak" value="ditolak">
                                <label class="form-check-label" for="statusDitolak">Ditolak</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan_persetujuan" class="form-label">Catatan Persetujuan (Opsional):</label>
                        <textarea class="form-control" id="catatan_persetujuan" name="catatan_persetujuan"
                            rows="3"></textarea>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-gradient-primary">Simpan Persetujuan</button>
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
    // JavaScript untuk Modal Proses Persetujuan
    var prosesPersetujuanModal = document.getElementById('prosesPersetujuanModal');
    if (prosesPersetujuanModal) {
        prosesPersetujuanModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button yang memicu modal

            var id_kunjungan = button.getAttribute('data-id');
            var nama_tamu = button.getAttribute('data-nama_tamu');
            var instansi = button.getAttribute('data-instansi');
            var tanggal = button.getAttribute('data-tanggal');
            var keperluan = button.getAttribute('data-keperluan');
            var catatan_tamu = button.getAttribute('data-catatan_tamu');

            prosesPersetujuanModal.querySelector('#proses_id_kunjungan').value = id_kunjungan;
            prosesPersetujuanModal.querySelector('#proses_nama_tamu').textContent = nama_tamu;
            prosesPersetujuanModal.querySelector('#proses_instansi').textContent = instansi;
            prosesPersetujuanModal.querySelector('#proses_tanggal').textContent = tanggal;
            prosesPersetujuanModal.querySelector('#proses_keperluan').textContent = keperluan;
            prosesPersetujuanModal.querySelector('#proses_catatan_tamu').textContent = catatan_tamu;

            // Reset form di modal setiap kali dibuka
            prosesPersetujuanModal.querySelector('form').reset();
        });
    } else {
        console.error("Elemen modal #prosesPersetujuanModal tidak ditemukan.");
    }
});
</script>
<?= $this->endSection(); ?>
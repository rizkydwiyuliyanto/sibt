<?= $this->extend('masyarakat/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-format-list-numbered"></i>
                </span> Riwayat Kunjungan Saya
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('masyarakat/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Riwayat Kunjungan Saya</li>
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
                        <h4 class="card-title">Daftar Kunjungan Anda</h4>
                        <p class="card-description">Berikut adalah riwayat kunjungan yang Anda catat.</p>
                        <div class="table-responsive table-responsive-custom">
                            <table class="table table-hover table-striped table-break-word">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Tujuan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($riwayatKunjungan)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Anda belum memiliki riwayat kunjungan.</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php $no = 1; foreach ($riwayatKunjungan as $kunjungan): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?></td>
                                        <td><?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?></td>
                                        <td>
                                            <?php if ($kunjungan['waktu_keluar']): ?>
                                            <?= date('H:i', strtotime(esc($kunjungan['waktu_keluar']))); ?>
                                            <?php else: ?>
                                            <span class="badge bg-warning text-dark">Belum keluar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($kunjungan['nama_tujuan'] ?? '-'); ?></td>
                                        <td>
                                            <?php
                                                $status = esc($kunjungan['status_persetujuan']);
                                                $badgeClass = '';
                                                if ($status == 'menunggu') $badgeClass = 'bg-info';
                                                elseif ($status == 'disetujui') $badgeClass = 'bg-success';
                                                elseif ($status == 'ditolak') $badgeClass = 'bg-danger';
                                                ?>
                                            <span
                                                class="badge <?= $badgeClass; ?> text-white"><?= ucfirst($status); ?></span>
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-gradient-secondary btn-sm btn-detail-kunjungan-saya"
                                                data-bs-toggle="modal" data-bs-target="#detailKunjunganSayaModal"
                                                data-id_kunjungan="<?= $kunjungan['id_kunjungan']; ?>"
                                                data-nama_tamu="<?= esc($kunjungan['nama_lengkap'] ?? '-'); ?>"
                                                data-asal_instansi="<?= esc($kunjungan['asal_instansi'] ?? '-'); ?>"
                                                data-tanggal="<?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?>"
                                                data-masuk="<?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?>"
                                                data-keluar="<?= $kunjungan['waktu_keluar'] ? date('H:i', strtotime(esc($kunjungan['waktu_keluar']))) : 'Belum keluar'; ?>"
                                                data-tujuan="<?= esc($kunjungan['nama_tujuan'] ?? '-'); ?>"
                                                data-keperluan="<?= esc($kunjungan['keperluan']); ?>"
                                                data-catatan="<?= esc($kunjungan['catatan'] ?? '-'); ?>"
                                                data-status_persetujuan="<?= ucfirst(esc($kunjungan['status_persetujuan'])); ?>"
                                                data-catatan_persetujuan="<?= esc($kunjungan['catatan_persetujuan'] ?? '-'); ?>"
                                                data-nama_penyetuju="<?= esc($kunjungan['nama_penyetuju'] ?? '-'); ?>"
                                                data-tanggal_persetujuan="<?= $kunjungan['tanggal_persetujuan'] ? date('d M Y H:i', strtotime(esc($kunjungan['tanggal_persetujuan']))) : '-'; ?>">
                                                <i class="mdi mdi-eye"></i> Detail
                                            </button>
                                            <?php if ($kunjungan['status_persetujuan'] === 'menunggu'): ?>
                                            <?php endif; ?>
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

<div class="modal fade" id="detailKunjunganSayaModal" tabindex="-1" aria-labelledby="detailKunjunganSayaModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailKunjunganSayaModalLabel">Detail Kunjungan Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Tamu:</strong> <span id="detail_nama_tamu_saya"></span></p>
                <p><strong>Asal Instansi:</strong> <span id="detail_asal_instansi_saya"></span></p>
                <p><strong>Tanggal Kunjungan:</strong> <span id="detail_tanggal_saya"></span></p>
                <p><strong>Waktu Masuk:</strong> <span id="detail_waktu_masuk_saya"></span></p>
                <p><strong>Waktu Keluar:</strong> <span id="detail_waktu_keluar_saya"></span></p>
                <p><strong>Tujuan Kunjungan:</strong> <span id="detail_tujuan_saya"></span></p>
                <p><strong>Keperluan:</strong> <span id="detail_keperluan_saya"></span></p>
                <p><strong>Catatan:</strong> <span id="detail_catatan_saya"></span></p>
                <hr>
                <p><strong>Status Persetujuan:</strong> <span id="detail_status_persetujuan_saya"></span></p>
                <p><strong>Catatan Persetujuan:</strong> <span id="detail_catatan_persetujuan_saya"></span></p>
                <p><strong>Disetujui Oleh:</strong> <span id="detail_nama_penyetuju_saya"></span></p>
                <p><strong>Tanggal Persetujuan:</strong> <span id="detail_tanggal_persetujuan_saya"></span></p>
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
    var detailKunjunganSayaModal = document.getElementById('detailKunjunganSayaModal');
    if (detailKunjunganSayaModal) {
        detailKunjunganSayaModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;

            var nama_tamu = button.getAttribute('data-nama_tamu');
            var asal_instansi = button.getAttribute('data-asal_instansi');
            var tanggal = button.getAttribute('data-tanggal');
            var masuk = button.getAttribute('data-masuk');
            var keluar = button.getAttribute('data-keluar');
            var tujuan = button.getAttribute('data-tujuan');
            var keperluan = button.getAttribute('data-keperluan');
            var catatan = button.getAttribute('data-catatan');
            var status_persetujuan = button.getAttribute('data-status_persetujuan'); // NEW
            var catatan_persetujuan = button.getAttribute('data-catatan_persetujuan'); // NEW
            var nama_penyetuju = button.getAttribute('data-nama_penyetuju'); // NEW
            var tanggal_persetujuan = button.getAttribute('data-tanggal_persetujuan'); // NEW

            detailKunjunganSayaModal.querySelector('#detail_nama_tamu_saya').textContent = nama_tamu;
            detailKunjunganSayaModal.querySelector('#detail_asal_instansi_saya').textContent =
                asal_instansi;
            detailKunjunganSayaModal.querySelector('#detail_tanggal_saya').textContent = tanggal;
            detailKunjunganSayaModal.querySelector('#detail_waktu_masuk_saya').textContent = masuk;
            detailKunjunganSayaModal.querySelector('#detail_waktu_keluar_saya').textContent = keluar;
            detailKunjunganSayaModal.querySelector('#detail_tujuan_saya').textContent = tujuan;
            detailKunjunganSayaModal.querySelector('#detail_keperluan_saya').textContent = keperluan;
            detailKunjunganSayaModal.querySelector('#detail_catatan_saya').textContent = catatan;
            detailKunjunganSayaModal.querySelector('#detail_status_persetujuan_saya').textContent =
                status_persetujuan; // NEW
            detailKunjunganSayaModal.querySelector('#detail_catatan_persetujuan_saya').textContent =
                catatan_persetujuan; // NEW
            detailKunjunganSayaModal.querySelector('#detail_nama_penyetuju_saya').textContent =
                nama_penyetuju; // NEW
            detailKunjunganSayaModal.querySelector('#detail_tanggal_persetujuan_saya').textContent =
                tanggal_persetujuan; // NEW
        });
    } else {
        console.error("Elemen modal #detailKunjunganSayaModal tidak ditemukan.");
    }
});
</script>
<?= $this->endSection(); ?>
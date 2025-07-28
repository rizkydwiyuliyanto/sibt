<?= $this->extend('kepala_bagian/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-history"></i>
                </span> Riwayat Kunjungan (Kepala Bagian)
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('kepala-bagian/dashboard'); ?>">Dashboard</a></li>
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

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Riwayat Kunjungan</h4>
                        <div class="table-responsive table-responsive-custom">
                            <table class="table table-hover table-striped table-break-word">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Tamu</th>
                                        <th>Asal Instansi</th>
                                        <th>Tanggal</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Keluar</th>
                                        <th>Tujuan</th>
                                        <th>Keperluan</th>
                                        <th>Status</th>
                                        <th>Penyetuju</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($riwayatKunjungan)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center">Belum ada riwayat kunjungan.</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php $no = 1; foreach ($riwayatKunjungan as $kunjungan): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= esc($kunjungan['nama_lengkap'] ?? '-'); ?></td>
                                        <td><?= esc($kunjungan['asal_instansi'] ?? '-'); ?></td>
                                        <td><?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?></td>
                                        <td><?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?></td>
                                        <td><?= $kunjungan['waktu_keluar'] ? date('H:i', strtotime(esc($kunjungan['waktu_keluar']))) : '-'; ?>
                                        </td>
                                        <td><?= esc($kunjungan['nama_tujuan'] ?? '-'); ?></td>
                                        <td><?= esc($kunjungan['keperluan']); ?></td>
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
                                        <td><?= esc($kunjungan['nama_penyetuju'] ?? '-'); ?></td>
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
<?= $this->endSection(); ?>
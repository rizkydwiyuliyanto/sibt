<?= $this->extend('kepala_bagian/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-file-document-box"></i>
                </span> Laporan Kunjungan Bulanan
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('kepala-bagian/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('kepala-bagian/laporan-bulanan'); ?>">Laporan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Bulanan</li>
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
                        <h4 class="card-title">Filter Laporan</h4>
                        <form action="<?= base_url('kepala-bagian/laporan-bulanan'); ?>" method="GET" class="mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label for="bulan" class="form-label">Pilih Bulan:</label>
                                    <select class="form-control" id="bulan" name="bulan">
                                        <?php
                                            $bulanArray = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            foreach ($bulanArray as $num => $namaBulan) {
                                                echo "<option value=\"$num\"" . ($bulan == $num ? ' selected' : '') . ">$namaBulan</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="tahun" class="form-label">Pilih Tahun:</label>
                                    <select class="form-control" id="tahun" name="tahun">
                                        <?php
                                            $tahunSekarang = date('Y');
                                            for ($y = $tahunSekarang; $y >= 2020; $y--) {
                                                echo "<option value=\"$y\"" . ($tahun == $y ? ' selected' : '') . ">$y</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-auto mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-gradient-primary">Tampilkan</button>
                                </div>
                                <div class="col-md-auto mt-3 mt-md-0">
                                    <a href="<?= base_url('kepala-bagian/laporan/export-pdf?filter_type=bulanan&bulan=' . $bulan . '&tahun=' . $tahun); ?>"
                                        target="_blank" class="btn btn-gradient-danger">
                                        <i class="mdi mdi-file-pdf"></i> Export PDF
                                    </a>
                                </div>
                            </div>
                        </form>

                        <h4 class="card-title mt-4">Data Kunjungan Bulan <?= $bulanArray[(int)$bulan]; ?> Tahun
                            <?= $tahun; ?></h4>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($laporan)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada kunjungan pada bulan ini.</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php $no = 1; foreach ($laporan as $kunjungan): ?>
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
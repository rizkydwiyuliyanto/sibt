<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-file-document-box"></i>
                </span> Laporan Kunjungan Tahunan
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/laporan-bulanan'); ?>">Laporan</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tahunan</li>
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
                        <form action="<?= base_url('admin/laporan-tahunan'); ?>" method="GET" class="mb-4">
                            <div class="row align-items-end">
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
                                    <a href="<?= base_url('admin/laporan/export-pdf?filter_type=tahunan&tahun=' . $tahun); ?>"
                                        target="_blank" class="btn btn-gradient-danger">
                                        <i class="mdi mdi-file-pdf"></i> Export PDF
                                    </a>
                                </div>
                            </div>
                        </form>

                        <h4 class="card-title mt-4">Ringkasan Kunjungan Tahun <?= $tahun; ?></h4>
                        <div class="table-responsive table-responsive-custom">
                            <table class="table table-hover table-striped table-break-word">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Jumlah Kunjungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($laporanSummary)): ?>
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data kunjungan pada tahun ini.
                                        </td>
                                    </tr>
                                    <?php else: ?>
                                    <?php
                                            $bulanArray = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                        ?>
                                    <?php $no = 1; foreach ($laporanSummary as $summary): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $bulanArray[$summary['bulan']]; ?></td>
                                        <td><?= esc($summary['total_kunjungan']); ?> Kunjungan</td>
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
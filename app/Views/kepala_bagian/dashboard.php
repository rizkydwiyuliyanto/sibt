<?= $this->extend('kepala_bagian/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard Kepala Bagian
            </h3>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h2 class="mb-2 text-white">Selamat Datang,
                            <?= session()->get('nama_lengkap') ?? 'Kepala Bagian'; ?>!</h2>
                        <p class="card-text mb-0">
                            Anda memiliki akses untuk memantau laporan dan memberikan persetujuan kunjungan.
                            <br>
                            Gunakan menu di samping untuk melihat data.
                        </p>
                    </div>
                </div>
            </div>
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
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Kunjungan Menunggu Persetujuan<i
                                class="mdi mdi-clock-alert-outline mdi-24px float-end"></i></h4>
                        <h2 class="mb-5"><?= $kunjunganMenunggu;?> Kunjungan</h2>
                        <a class="card-text text-white"
                            href="<?= base_url('kepala-bagian/persetujuan-kunjungan');?>">Lihat Persetujuan ></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-warning card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Kunjungan Hari Ini<i
                                class="mdi mdi-calendar-today mdi-24px float-end"></i></h4>
                        <h2 class="mb-5"><?= $jumlahKunjunganHariIni;?> Kunjungan</h2>
                        <a class="card-text text-white" href="<?= base_url('kepala-bagian/riwayat-kunjungan');?>">Lihat
                            Detail ></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Kunjungan Bulan Ini<i
                                class="mdi mdi-chart-line mdi-24px float-end"></i></h4>
                        <h2 class="mb-5"><?= $totalKunjunganBulanIni;?> Kunjungan</h2>
                        <a class="card-text text-white" href="<?= base_url('kepala-bagian/laporan-bulanan');?>">Lihat
                            Laporan ></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-start">Statistik Kunjungan 7 Hari Terakhir</h4>
                        </div>
                        <canvas id="visit-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labelsGrafikKunjungan = <?= $labelsGrafikKunjungan; ?>;
const dataGrafikKunjungan = <?= $dataGrafikKunjungan; ?>;

const ctxVisit = document.getElementById('visit-chart').getContext('2d');
new Chart(ctxVisit, {
    type: 'bar',
    data: {
        labels: labelsGrafikKunjungan,
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: dataGrafikKunjungan,
            backgroundColor: 'rgba(75, 192, 192, 0.7)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Kunjungan'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            }
        }
    }
});
</script>
<?= $this->endSection(); ?>
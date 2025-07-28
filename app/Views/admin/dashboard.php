<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard
            </h3>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h2 class=" mb-2 text-white">Selamat Datang!</h2>
                        <p class="card-text mb-0">
                            Selamat datang di **Sistem Informasi Buku Tamu Online**.
                            <br>
                            Sistem ini dirancang untuk memudahkan pengelolaan data tamu, kunjungan, dan informasi
                            terkait.
                            <br>
                            Silakan gunakan menu di sebelah kiri untuk mengelola data pengunjung, melihat riwayat
                            kunjungan, dan mengakses laporan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Tamu Terdaftar<i
                                class="mdi mdi-account-group mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5"><?= isset($jumlahTamuTerdaftar) ? $jumlahTamuTerdaftar : '0';?> Tamu</h2>
                        <a class="card-text" href="<?= base_url('admin/daftar_tamu');?>">Lihat Daftar Tamu ></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Jumlah Kunjungan Hari Ini<i
                                class="mdi mdi-calendar-today mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5"><?= isset($jumlahKunjunganHariIni) ? $jumlahKunjunganHariIni : '0';?> Kunjungan
                        </h2>
                        <a class="card-text" href="<?= base_url('admin/riwayat_kunjungan');?>">Lihat Kunjungan Hari Ini
                            ></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Total Kunjungan Bulan Ini <i
                                class="mdi mdi-chart-line mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5"><?= isset($totalKunjunganBulanIni) ? $totalKunjunganBulanIni : '0';?> Kunjungan
                        </h2>
                        <a class="card-text" href="<?= base_url('admin/laporan_bulanan');?>">Lihat Laporan ></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <h4 class="card-title float-start">Statistik Kunjungan (Contoh)</h4>
                        </div>
                        <canvas id="visit-chart" class="mt-4"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data dummy untuk contoh grafik buku tamu
// Anda perlu mengganti ini dengan data aktual dari controller Anda
const visitLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
const visitData = [15, 22, 18, 25, 30]; // Contoh jumlah kunjungan per hari

// Bar Chart Contoh Statistik Kunjungan
const ctxVisit = document.getElementById('visit-chart').getContext('2d');
new Chart(ctxVisit, {
    type: 'bar',
    data: {
        labels: visitLabels,
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: visitData,
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
                    text: 'Hari'
                }
            }
        }
    }
});
</script>
<?= $this->endSection(); ?>
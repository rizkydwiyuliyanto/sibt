<?= $this->extend('masyarakat/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Dashboard Masyarakat
            </h3>
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
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h2 class="mb-2 text-white">Halo, <?= esc($nama_pengguna); ?>!</h2>
                        <p class="card-text mb-0">
                            Selamat datang di Sistem Informasi Buku Tamu Online.
                            <br>
                            Anda dapat mencatat kunjungan baru dan melihat riwayat kunjungan Anda di sini.
                            <br>
                            Gunakan menu di sebelah kiri untuk navigasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Kunjungan Anda 7 Hari Terakhir<i
                                class="mdi mdi-calendar-clock mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5"><?= $jumlahKunjunganTerakhir;?> Kunjungan</h2>
                        <a class="card-text text-white"
                            href="<?= base_url('masyarakat/riwayat-kunjungan-saya');?>">Lihat Riwayat Saya ></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                    <div class="card-body">
                        <img src="<?= base_url();?>template/assets/images/dashboard/circle.svg"
                            class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal mb-3">Cepat Catat Kunjungan Baru<i
                                class="mdi mdi-notebook-plus mdi-24px float-end"></i>
                        </h4>
                        <h2 class="mb-5">Mulai Sekarang</h2>
                        <a class="card-text text-white" href="<?= base_url('masyarakat/input-kunjungan');?>">Catat
                            Kunjungan ></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection(); ?>
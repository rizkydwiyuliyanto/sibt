<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'Dashboard Admin'; ?> - Sistem Informasi Buku Tamu</title>
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/css/style.css">
    <link rel="shortcut icon" href="<?= base_url();?>template/assets/images/favicon.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    /* Beberapa gaya kustom dasar untuk konsistensi */
    .alert {
        margin-top: 15px;
    }
    </style>

    <?= $this->renderSection('css'); ?>
</head>

<body>
    <div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo" href="<?= base_url('admin/dashboard');?>">
                    <h4 class="text-primary font-weight-bold">Buku Tamu Admin</h4>
                </a>
                <a class="navbar-brand brand-logo-mini" href="<?= base_url('admin/dashboard');?>">
                    <h4 class="text-primary font-weight-bold">BTA</h4>
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <!-- <div class="search-field d-none d-md-block">
                    <form class="d-flex align-items-center h-100" action="#">
                        <div class="input-group">
                            <div class="input-group-prepend bg-transparent">
                                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                            </div>
                            <input type="text" class="form-control bg-transparent border-0" placeholder="Cari...">
                        </div>
                    </form>
                </div> -->
                <!-- <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="nav-profile-img">
                                <img src="<?= base_url();?>template/assets/images/faces/face1.jpg" alt="image">
                                <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black"><?= session()->get('nama_lengkap') ?? 'Admin'; ?></p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="<?= base_url('admin/pengaturan-akun'); ?>">
                                <i class="mdi mdi-settings me-2 text-success"></i> Pengaturan Akun
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('logout'); ?>">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Signout
                            </a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block full-screen-link">
                        <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                        </a>
                    </li>
                </ul> -->
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item nav-profile">
                        <a href="<?= base_url('admin/dashboard');?>" class="nav-link">
                            <div class="nav-profile-image">
                                <img src="<?= base_url();?>template/assets/images/faces/face1.jpg" alt="profile" />
                                <span class="login-status online"></span>
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                                <span class="font-weight-bold mb-2"><?= session()->get('username') ?? 'Admin'; ?></span>
                                <span class="text-secondary text-small">Administrator Sistem</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/dashboard');?>">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/data-tamu');?>">
                            <span class="menu-title">Data Tamu</span>
                            <i class="mdi mdi-account-group menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/riwayat-kunjungan');?>">
                            <span class="menu-title">Riwayat Kunjungan</span>
                            <i class="mdi mdi-history menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/tujuan-kunjungan');?>">
                            <span class="menu-title">Tujuan Kunjungan</span>
                            <i class="mdi mdi-map-marker-path menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#laporan-menu" aria-expanded="false"
                            aria-controls="laporan-menu">
                            <span class="menu-title">Laporan</span>
                            <i class="menu-arrow"></i>
                            <i class="mdi mdi-file-document-box menu-icon"></i>
                        </a>
                        <div class="collapse" id="laporan-menu">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('admin/laporan-harian');?>">Laporan
                                        Harian</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('admin/laporan-bulanan');?>">Laporan
                                        Bulanan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('admin/laporan-tahunan');?>">Laporan
                                        Tahunan</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/pengaturan-akun');?>">
                            <span class="menu-title">Pengaturan Akun</span>
                            <i class="mdi mdi-settings menu-icon"></i>
                        </a>
                    </li>
                    <li class="nav-item sidebar-actions">
                        <span class="nav-link">
                            <div class="border-bottom">
                                <h6 class="font-weight-normal mb-3">Sesi Login</h6>
                            </div>
                            <a href="<?= base_url('logout'); ?>" class="btn btn-block btn-lg btn-gradient-primary mt-4">
                                Logout
                            </a>
                        </span>
                    </li>
                </ul>
            </nav>
            <?= $this->renderSection('content'); ?>
        </div>
    </div>
    <script src="<?= base_url();?>template/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= base_url();?>template/assets/js/off-canvas.js"></script>
    <script src="<?= base_url();?>template/assets/js/misc.js"></script>
    <script src="<?= base_url();?>template/assets/js/settings.js"></script>
    <script src="<?= base_url();?>template/assets/js/todolist.js"></script>
    <script src="<?= base_url();?>template/assets/js/jquery.cookie.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('js'); ?>

    <script>
    // Optional: Hide alerts after a few seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000); // Sembunyikan setelah 5 detik
    });
    </script>
</body>

</html>
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="<?= base_url();?>" class="nav-link">
                <div class="nav-profile-image">
                    <img src="<?= base_url();?>template/assets/images/faces/face1.jpg" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">Admin</span>
                    <span class="text-secondary text-small">Administrator Sistem</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('/admin');?>">
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
            <a class="nav-link" data-bs-toggle="collapse" href="#laporan-menu" aria-expanded="false"
                aria-controls="laporan-menu">
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-file-document-box menu-icon"></i>
            </a>
            <div class="collapse" id="laporan-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/laporan-harian');?>">Laporan Harian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/laporan-bulanan');?>">Laporan Bulanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/laporan-tahunan');?>">Laporan Tahunan</a>
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
    </ul>
</nav>
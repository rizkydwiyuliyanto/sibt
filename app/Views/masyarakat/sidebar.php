<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="<?= base_url('masyarakat/dashboard');?>" class="nav-link">
                <div class="nav-profile-img">
                    <img src="<?= base_url();?>template/assets/images/faces/face2.jpg" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2"><?= session()->get('username') ?? 'Masyarakat'; ?></span>
                    <span class="text-secondary text-small">Pengguna Umum</span>
                </div>
                <i class="mdi mdi-check-circle text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('masyarakat/dashboard');?>">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('masyarakat/input-kunjungan');?>">
                <span class="menu-title">Input Kunjungan Baru</span>
                <i class="mdi mdi-notebook-plus menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('masyarakat/riwayat-kunjungan-saya');?>">
                <span class="menu-title">Riwayat Kunjungan Saya</span>
                <i class="mdi mdi-format-list-numbered menu-icon"></i>
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
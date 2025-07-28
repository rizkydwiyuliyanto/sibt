<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Sistem Informasi Buku Tamu</title>

    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url();?>template/assets/vendors/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url();?>template/assets/css/style.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="<?= base_url();?>template/assets/images/favicon.png" />

    <style>
    /* Styling tambahan agar modal alert Bootstrap terlihat jelas di atas yang lain */
    .alert-fixed {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1100;
        /* Lebih tinggi dari modal Bootstrap default (1050) */
        width: auto;
        min-width: 300px;
        max-width: 90%;
        padding: 1rem 1.5rem;
        border-radius: .25rem;
        display: none;
        /* Sembunyikan secara default */
    }

    .alert-fixed.show {
        display: block;
    }
    </style>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo d-flex justify-content-center mb-4">
                                <h2 class="text-primary font-weight-bold">Sistem Informasi Buku Tamu</h2>
                            </div>
                            <h4>Silakan Login</h4>

                            <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('info')): ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('info'); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <form class="pt-3" method="post" action="<?= base_url('auth'); ?>">
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-lg" id="usernameInput"
                                        placeholder="Username" name="username" value="<?= old('username'); ?>" required>
                                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
                                    <small
                                        class="text-danger"><?= session()->getFlashdata('errors')['username']; ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="passwordInput"
                                        placeholder="Password" name="password" required>
                                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                                    <small
                                        class="text-danger"><?= session()->getFlashdata('errors')['password']; ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label class="form-label mb-2">Pilih Role:</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="roleMasyarakat" name="role"
                                            value="1" <?= old('role') == '1' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="roleMasyarakat">Masyarakat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="roleAdmin" name="role"
                                            value="2" <?= old('role') == '2' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="roleAdmin">Admin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="roleKepalaBagian" name="role"
                                            value="3" <?= old('role') == '3' ? 'checked' : ''; ?> required>
                                        <label class="form-check-label" for="roleKepalaBagian">Kepala Bagian</label>
                                    </div>
                                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['role'])): ?>
                                    <small
                                        class="text-danger d-block mt-2"><?= session()->getFlashdata('errors')['role']; ?></small>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit"
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                        Masuk
                                    </button>
                                </div>
                                <div class="text-center mt-4 font-weight-light">
                                    Belum punya akun?
                                    <a href="#" class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#registrationModal">Registrasi</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registrationModalLabel">Form Registrasi Masyarakat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('auth/register_masyarakat'); ?>" method="POST">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="nama_lengkap_reg" class="form-label">Nama Lengkap:</label>
                            <input type="text" class="form-control" id="nama_lengkap_reg" name="nama_lengkap"
                                value="<?= old('nama_lengkap'); ?>" required>
                            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_lengkap'])): ?>
                            <small class="text-danger"><?= session()->getFlashdata('errors')['nama_lengkap']; ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="username_reg" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username_reg" name="username"
                                value="<?= old('username'); ?>" required>
                            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
                            <small class="text-danger"><?= session()->getFlashdata('errors')['username']; ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password_reg" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password_reg" name="password" required>
                            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                            <small class="text-danger"><?= session()->getFlashdata('errors')['password']; ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="konfirmasi_password_reg" class="form-label">Konfirmasi Password:</label>
                            <input type="password" class="form-control" id="konfirmasi_password_reg"
                                name="konfirmasi_password" required>
                            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['konfirmasi_password'])): ?>
                            <small
                                class="text-danger"><?= session()->getFlashdata('errors')['konfirmasi_password']; ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient-primary">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url();?>template/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= base_url();?>template/assets/js/off-canvas.js"></script>
    <script src="<?= base_url();?>template/assets/js/misc.js"></script>
    <script src="<?= base_url();?>template/assets/js/settings.js"></script>
    <script src="<?= base_url();?>template/assets/js/todolist.js"></script>
    <script src="<?= base_url();?>template/assets/js/jquery.cookie.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // JavaScript untuk membuka modal registrasi jika ada error validasi dari proses registrasi
    <?php if (session()->getFlashdata('openRegisterModal')): ?>
    var registerModal = new bootstrap.Modal(document.getElementById('registrationModal'));
    registerModal.show();
    <?php endif; ?>

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
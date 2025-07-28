<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-settings"></i>
                </span> Pengaturan Akun Pengguna
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengaturan Akun</li>
                </ol>
            </nav>
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

        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Akun Pengguna</h4>
                        <button type="button" class="btn btn-gradient-primary btn-sm mb-3" data-bs-toggle="modal"
                            data-bs-target="#tambahUserModal">
                            <i class="mdi mdi-plus"></i> Tambah Pengguna
                        </button>
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data pengguna.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($user['nama_lengkap']); ?></td>
                                    <td><?= esc($user['username']); ?></td>
                                    <td>
                                        <?php
                                                if ($user['role'] == 1) echo 'Masyarakat';
                                                elseif ($user['role'] == 2) echo 'Admin';
                                                elseif ($user['role'] == 3) echo 'Kepala Bagian';
                                                else echo 'Tidak Dikenal';
                                            ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-gradient-info btn-sm btn-edit-user"
                                            data-bs-toggle="modal" data-bs-target="#editUserModal"
                                            data-id="<?= $user['id']; ?>" data-nama="<?= esc($user['nama_lengkap']); ?>"
                                            data-username="<?= esc($user['username']); ?>"
                                            data-role="<?= esc($user['role']); ?>">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <?php if ($user['id'] != session()->get('user_id')): // Tidak bisa menghapus akun sendiri ?>
                                        <a href="<?= base_url('admin/pengaturan-akun/hapus/' . $user['id']); ?>"
                                            class="btn btn-gradient-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? (Username: <?= esc($user['username']); ?>)')">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </a>
                                        <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>Tidak Dapat Dihapus</button>
                                        <?php endif; ?>
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

<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/pengaturan-akun/tambah'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="mb-3">
                        <label for="add_nama_lengkap" class="form-label">Nama Lengkap:</label>
                        <input type="text" class="form-control" id="add_nama_lengkap" name="nama_lengkap"
                            value="<?= old('nama_lengkap'); ?>" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_lengkap'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['nama_lengkap']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="add_username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="add_username" name="username"
                            value="<?= old('username'); ?>" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['username']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="add_password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="add_password" name="password" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['password']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="add_role" class="form-label">Role:</label>
                        <select class="form-control" id="add_role" name="role" required>
                            <option value="1" <?= old('role') == '1' ? 'selected' : ''; ?>>Masyarakat</option>
                            <option value="2" <?= old('role') == '2' ? 'selected' : ''; ?>>Admin</option>
                            <option value="3" <?= old('role') == '3' ? 'selected' : ''; ?>>Kepala Bagian</option>
                        </select>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['role'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['role']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Simpan Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/pengaturan-akun/edit'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_user" id="edit_id_user">
                    <div class="mb-3">
                        <label for="edit_nama_lengkap" class="form-label">Nama Lengkap:</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_lengkap'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['nama_lengkap']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['username'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['username']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password_new" class="form-label">Password Baru (Kosongkan jika tidak
                            diubah):</label>
                        <input type="password" class="form-control" id="edit_password_new" name="password_new">
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password_new'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['password_new']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label">Role:</label>
                        <select class="form-control" id="edit_role" name="role" required>
                            <option value="1">Masyarakat</option>
                            <option value="2">Admin</option>
                            <option value="3">Kepala Bagian</option>
                        </select>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['role'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['role']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Perbarui Pengguna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        var username = button.getAttribute('data-username');
        var role = button.getAttribute('data-role');

        var modalTitle = editUserModal.querySelector('.modal-title');
        var modalBodyInputId = editUserModal.querySelector('#edit_id_user');
        var modalBodyInputNama = editUserModal.querySelector('#edit_nama_lengkap');
        var modalBodyInputUsername = editUserModal.querySelector('#edit_username');
        var modalBodySelectRole = editUserModal.querySelector('#edit_role');

        modalTitle.textContent = 'Edit Pengguna: ' + username;
        modalBodyInputId.value = id;
        modalBodyInputNama.value = nama;
        modalBodyInputUsername.value = username;
        modalBodySelectRole.value = role;
    });

    // Logika untuk menampilkan modal jika ada error validasi
    <?php if (session()->getFlashdata('errors')): ?>
    var errors = <?= json_encode(session()->getFlashdata('errors')); ?>;
    var oldInput = <?= json_encode(session()->getFlashdata('old_input') ?? []); ?>;

    if (oldInput && oldInput['id_user']) { // Jika ada id_user, kemungkinan ini edit form
        var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        // Repopulate edit form with old data
        document.getElementById('edit_id_user').value = oldInput['id_user'] || '';
        document.getElementById('edit_nama_lengkap').value = oldInput['nama_lengkap'] || '';
        document.getElementById('edit_username').value = oldInput['username'] || '';
        document.getElementById('edit_role').value = oldInput['role'] || '';
        editUserModal.show();
    } else if (errors['nama_lengkap'] || errors['username'] || errors['password'] || errors[
        'role']) { // Kemungkinan tambah form
        var tambahUserModal = new bootstrap.Modal(document.getElementById('tambahUserModal'));
        tambahUserModal.show();
    }
    <?php endif; ?>
});
</script>
<?= $this->endSection(); ?>
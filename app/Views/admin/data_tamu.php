<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account-group"></i>
                </span> Data Tamu
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Tamu</li>
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
                        <!--<h4 class="card-title">Daftar Tamu</h4>-->
                        <div class="d-flex align-items-end justify-content-between">
                            <button type="button" class="btn btn-gradient-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#tambahTamuModal">
                                <i class="mdi mdi-plus"></i> Tambah Tamu
                            </button>
                            <div>
                                <form class="d-flex align-items-end" method="GET" action='<?php echo base_url()?>admin/data-tamu'>
                                    <div class="me-2">
                                        <label for="pencarian_tamu" class="form-label">Cari tamu:</label>
                                        <input type="text" class="form-control" value="<?php echo $nama_lengkap?>" id="pencarian_tamu" name="nama_lengkap" autocomplete="off" placeholder="">
                                        <div id="instansiSuggestionsDataTamu" class="list-group position-absolute"
                                            style="z-index: 1000; display: none;">
                                        
                                        </div>
                                    </div>
                                    <!--<?php if ($nama_lengkap !== "") {?>-->
                                    <!--<a href="<?php echo base_url()?>admin/data-tamu?nama_lengkap=''" class="me-2">-->
                                    <!--    <button type="submit" class="btn btn-gradient-danger btn-sm">-->
                                    <!--         Reset-->
                                    <!--    </button>-->
                                    <!--</a>-->
                                    <!--<?php }?>-->
                                    <button type="submit" class="btn btn-gradient-primary btn-sm">
                                        Cari
                                    </button>
                                </form>
                            </div>
                        </div>
                        <table class="table mt-4 table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Asal Instansi</th>
                                    <th>No. Telepon</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>Tipe Tamu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($dataTamu)): ?>
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data tamu.</td>
                                </tr>
                                <?php else: ?>
                                <?php $no = 1; foreach ($dataTamu as $tamu): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= esc($tamu['nama_lengkap']); ?></td>
                                    <td><?= esc($tamu['asal_instansi'] ?? '-'); ?></td>
                                    <td><?= esc($tamu['no_telepon'] ?? '-'); ?></td>
                                    <td><?= esc($tamu['email'] ?? '-'); ?></td>
                                    <td>
                                        <?php
                                            $alamat = $tamu['alamat'] ?? '-';
                                            if ($alamat !== '-' && mb_strlen($alamat) > 15) {
                                                echo esc(mb_substr($alamat, 0, 15)) . '...';
                                            } else {
                                                echo esc($alamat);
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($tamu['user_id']): ?>
                                        <span class="badge bg-gradient-info text-white">Dari Akun User</span>
                                        <?php else: ?>
                                        <span class="badge bg-gradient-success text-white">Manual Admin</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-gradient-info btn-sm btn-edit-tamu"
                                            data-bs-toggle="modal" data-bs-target="#editTamuModal"
                                            data-id="<?= $tamu['id_tamu']; ?>"
                                            data-nama="<?= esc($tamu['nama_lengkap']); ?>"
                                            data-instansi="<?= esc($tamu['asal_instansi']); ?>"
                                            data-telp="<?= esc($tamu['no_telepon']); ?>"
                                            data-email="<?= esc($tamu['email']); ?>"
                                            data-alamat="<?= esc($tamu['alamat']); ?>">
                                            <i class="mdi mdi-pencil"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-gradient-danger btn-sm btn-delete-tamu"
                                            data-bs-toggle="modal" data-bs-target="#hapusTamuModal"
                                            data-id="<?= $tamu['id_tamu']; ?>"
                                            data-nama="<?= esc($tamu['nama_lengkap']); ?>">
                                            <i class="mdi mdi-delete"></i> Hapus
                                        </button>
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

<div class="modal fade" id="tambahTamuModal" tabindex="-1" aria-labelledby="tambahTamuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahTamuModalLabel">Tambah Data Tamu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/data-tamu/tambah'); ?>" method="POST">
                    <?= csrf_field(); ?>

                    <div class="mb-3">
                        <label for="add_user_id_from_account" class="form-label">Pilih dari Akun User
                            (Masyarakat):</label>
                        <select class="form-control" id="add_user_id_from_account" name="user_id_from_account">
                            <option value="">-- Pilih Akun User (Jika ada) --</option>
                            <?php foreach ($usersNotYetTamu as $user): ?>
                            <option value="<?= $user['id']; ?>"
                                <?= old('user_id_from_account') == $user['id'] ? 'selected' : ''; ?>>
                                <?= esc($user['nama_lengkap']); ?> (<?= esc($user['username']); ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Hanya user masyarakat yang belum memiliki data tamu.</small>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['user_id_from_account'])): ?>
                        <small
                            class="text-danger d-block"><?= session()->getFlashdata('errors')['user_id_from_account']; ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3" id="nama_lengkap_manual_div">
                        <label for="nama_lengkap_manual" class="form-label">Nama Lengkap (Manual):</label>
                        <input type="text" class="form-control" id="nama_lengkap_manual" name="nama_lengkap"
                            value="<?= old('nama_lengkap'); ?>">
                        <small class="form-text text-muted">Isi jika tidak memilih dari akun user.</small>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_lengkap'])): ?>
                        <small
                            class="text-danger d-block"><?= session()->getFlashdata('errors')['nama_lengkap']; ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="asal_instansi" class="form-label">Asal Instansi/Perusahaan:</label>
                        <input type="text" class="form-control" id="asal_instansi" name="asal_instansi"
                            value="<?= old('asal_instansi'); ?>" autocomplete="off"
                            placeholder="Masukkan asal instansi">
                        <div id="instansiSuggestionsAdmin" class="list-group position-absolute"
                            style="z-index: 1000; display: none;"></div>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['asal_instansi'])): ?>
                        <small
                            class="text-danger d-block"><?= session()->getFlashdata('errors')['asal_instansi']; ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">No. Telepon:</label>
                        <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                            value="<?= old('no_telepon'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>">
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['email']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat:</label>
                        <textarea class="form-control" id="alamat" name="alamat"
                            rows="3"><?= old('alamat'); ?></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Simpan Data Tamu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="hapusTamuModal" tabindex="-1" aria-labelledby="hapusTamuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('admin/data-tamu/hapus/'); ?>" method="GET" id="formHapusTamu"
                onsubmit="this.action = '<?= base_url('admin/data-tamu/hapus/'); ?>' + document.getElementById('hapus_id_tamu').value;">
                <?= csrf_field(); ?>
                <input type="hidden" name="id_tamu" id="hapus_id_tamu">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusTamuModalLabel">Konfirmasi Hapus Data Tamu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data tamu berikut?</p>
                    <div class="alert alert-warning mb-0">
                        <strong id="hapus_nama_tamu"></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var hapusTamuModal = document.getElementById('hapusTamuModal');
    hapusTamuModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        document.getElementById('hapus_id_tamu').value = id;
        document.getElementById('hapus_nama_tamu').textContent = nama;
    });
});
</script>
<div class="modal fade" id="editTamuModal" tabindex="-1" aria-labelledby="editTamuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTamuModalLabel">Edit Data Tamu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/data-tamu/edit'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_tamu" id="edit_id_tamu">
                    <div class="mb-3">
                        <label for="edit_nama_lengkap" class="form-label">Nama Lengkap:</label>
                        <input type="text" class="form-control" id="edit_nama_lengkap" name="nama_lengkap" required>
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['nama_lengkap'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['nama_lengkap']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_asal_instansi" class="form-label">Asal Instansi/Perusahaan:</label>
                        <input type="text" class="form-control" id="edit_asal_instansi" name="asal_instansi">
                    </div>
                    <div class="mb-3">
                        <label for="edit_no_telepon" class="form-label">No. Telepon:</label>
                        <input type="text" class="form-control" id="edit_no_telepon" name="no_telepon">
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                        <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email'])): ?>
                        <small class="text-danger"><?= session()->getFlashdata('errors')['email']; ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat:</label>
                        <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-gradient-primary">Perbarui Data Tamu</button>
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
    // --- LOGIKA UNTUK MODAL EDIT TAMU (SUDAH ADA) ---
    var editTamuModal = document.getElementById('editTamuModal');
    editTamuModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nama = button.getAttribute('data-nama');
        var instansi = button.getAttribute('data-instansi');
        var telp = button.getAttribute('data-telp');
        var email = button.getAttribute('data-email');
        var alamat = button.getAttribute('data-alamat');

        var modalTitle = editTamuModal.querySelector('.modal-title');
        var modalBodyInputId = editTamuModal.querySelector('#edit_id_tamu');
        var modalBodyInputNama = editTamuModal.querySelector('#edit_nama_lengkap');
        var modalBodyInputInstansi = editTamuModal.querySelector('#edit_asal_instansi');
        var modalBodyInputTelp = editTamuModal.querySelector('#edit_no_telepon');
        var modalBodyInputEmail = editTamuModal.querySelector('#edit_email');
        var modalBodyInputAlamat = editTamuModal.querySelector('#edit_alamat');

        modalTitle.textContent = 'Edit Data Tamu: ' + nama;
        modalBodyInputId.value = id;
        modalBodyInputNama.value = nama;
        modalBodyInputInstansi.value = instansi;
        modalBodyInputTelp.value = telp;
        modalBodyInputEmail.value = email;
        modalBodyInputAlamat.value = alamat;
    });

    // --- LOGIKA UNTUK MODAL TAMBAH TAMU (PILIH USER VS INPUT MANUAL) ---
    const selectUserAccount = document.getElementById('add_user_id_from_account');
    const namaLengkapManualDiv = document.getElementById('nama_lengkap_manual_div');
    const namaLengkapManualInput = document.getElementById('nama_lengkap_manual');

    function toggleNamaLengkapManual() {
        if (selectUserAccount.value !== '') {
            namaLengkapManualDiv.style.display = 'none';
            namaLengkapManualInput.removeAttribute('required');
            namaLengkapManualInput.value = '';
        } else {
            namaLengkapManualDiv.style.display = 'block';
            namaLengkapManualInput.setAttribute('required', 'required');
        }
    }
    toggleNamaLengkapManual(); // Panggil saat halaman dimuat
    selectUserAccount.addEventListener('change',
        toggleNamaLengkapManual); // Panggil saat pilihan dropdown berubah


    // --- LOGIKA AUTOCOMPLETE ASAL INSTANSI (DITERAPKAN DARI MASYARAKAT) ---

    // Kita perlu mendapatkan instansiList dari controller Admin, sama seperti di Masyarakat
    // Untuk saat ini, kita akan asumsikan instansiList sudah tersedia secara global atau diambil via AJAX.
    // Jika belum, Anda harus mengirimnya dari Admin controller ke view ini.
    // Contoh: const instansiList = <?= json_encode($instansiList ?? []); ?>; 
    // Atau, jika Anda belum punya $instansiList di AdminController->dataTamu(),
    // Anda bisa membuat daftar dummy atau mengambilnya via AJAX.
    // Untuk demo ini, saya asumsikan ada variabel instansiList yang valid
    // Anda perlu memastikan $instansiList dikirim dari Admin controller.
    const instansiList = <?= $instansiListForAdmin ?? '[]'; ?>; // Gunakan variabel yang dikirim dari controller
    const dataTamuList = <?= $dataTamuListForAdmin ?? '[]'; ?>;
    const pencarianTamuInput = document.getElementById('pencarian_tamu');
    const tamuSuggestions = document.getElementById('instansiSuggestionsDataTamu'); // ID kontainer saran di modal admin
    const instansiInput = document.getElementById('asal_instansi'); // ID input di modal admin
    const instansiSuggestions = document.getElementById('instansiSuggestionsAdmin'); // ID kontainer saran di modal admin
    let isSelectingSuggestionAdmin = false; // Gunakan variabel berbeda untuk menghindari konflik
    const FUZZY_THRESHOLD_ADMIN = 2;
    function KMP(a, b) {
        if (a.length === 0) return b.length;
        if (b.length === 0) return a.length;
        const matrix = [];
        for (let i = 0; i <= b.length; i++) matrix[i] = [i];
        for (let j = 0; j <= a.length; j++) matrix[0][j] = j;
        for (let i = 1; i <= b.length; i++) {
            for (let j = 1; j <= a.length; j++) {
                if (b.charAt(i - 1) === a.charAt(j - 1)) {
                    matrix[i][j] = matrix[i - 1][j - 1];
                } else {
                    matrix[i][j] = Math.min(matrix[i - 1][j - 1] + 1, Math.min(matrix[i][j - 1] + 1, matrix[i -
                        1][j] + 1));
                }
            }
        }
        return matrix[b.length][a.length];
    }

    function matchesInitialism(text, pattern) {
        if (pattern.length === 0) return false;
        const words = text.split(/\s+/).filter(word => word.length > 0);
        let initials = '';
        for (const word of words) initials += word.charAt(0);
        return initials.toLowerCase().startsWith(pattern.toLowerCase());
    }

    function setSuggestionsWidthAdmin() { // Fungsi baru untuk admin modal
        const inputWidth = instansiInput.offsetWidth;
        instansiSuggestions.style.width = inputWidth + 'px';
    }
    
    function getSuggestion(value,input,suggenstionResultElem, list) {
        // console.log(value);
        // console.log(list);
        // console.log(input)
        // console.log(suggenstionResultElem)
        const inputValue = value;
        const matchedSuggestions = [];
        for (const instansi of list) {
            if (instansi && typeof instansi === 'string') {
                const lowerInstansi = instansi.toLowerCase();

                if (lowerInstansi.startsWith(inputValue)) {
                    matchedSuggestions.push({
                        text: instansi,
                        score: 0
                    });
                    continue;
                }
                if (lowerInstansi.includes(inputValue)) {
                    matchedSuggestions.push({
                        text: instansi,
                        score: 1
                    });
                    continue;
                }
                if (matchesInitialism(instansi, inputValue)) {
                    matchedSuggestions.push({
                        text: instansi,
                        score: 2
                    });
                    continue;
                }

                const cleanInputValue = inputValue.replace(/[^a-z0-9]/g, '');
                const cleanInstansi = lowerInstansi.replace(/[^a-z0-9]/g, '');

                if (cleanInputValue.length > 2) {
                    const distance = KMP(cleanInputValue, cleanInstansi);
                    if (distance <= FUZZY_THRESHOLD_ADMIN && distance / cleanInputValue.length < 0.5) {
                        matchedSuggestions.push({
                            text: instansi,
                            score: distance + 3
                        });
                    }
                }
            }
        }
        matchedSuggestions.sort((a, b) => a.score - b.score);
        
        const uniqueSuggestions = [];
        const seen = new Set();
        for (const item of matchedSuggestions) {
            if (!seen.has(item.text)) {
                uniqueSuggestions.push(item.text);
                seen.add(item.text);
            }
        }
        if (uniqueSuggestions.length > 0) {
            uniqueSuggestions.forEach(suggestion => {
                const div = document.createElement('div');
                div.classList.add('list-group-item', 'list-group-item-action');
                div.textContent = suggestion;
                div.style.cursor = 'pointer';
                div.addEventListener("click", (e) => {
                    console.log(e);
                })
                div.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    isSelectingSuggestionAdmin = true;
                    suggenstionResultElem.value = this.textContent;
                    suggenstionResultElem.innerHTML = '';
                    suggenstionResultElem.style.display = 'none';
                    input.focus();
                });
                console.log(div);
                suggenstionResultElem.appendChild(div);
            });
            suggenstionResultElem.style.display = 'block';
        } else {
            suggenstionResultElem.style.display = 'none';
        }
    }

    setSuggestionsWidthAdmin();
    window.addEventListener('resize', setSuggestionsWidthAdmin);
    pencarianTamuInput.addEventListener("input", (e) => {
        // console.log(e.target.value);
        const inputValue = e?.target?.value.toLowerCase().trim();
        tamuSuggestions.innerHTML = '';
        tamuSuggestions.style.display = 'none';

        if (inputValue.length === 0) {
            return;
        }
        getSuggestion(inputValue,pencarianTamuInput,tamuSuggestions,dataTamuList);
    });
    pencarianTamuInput.addEventListener('blur', function() {
        setTimeout(() => {
            if (!isSelectingSuggestionAdmin) {
                tamuSuggestions.innerHTML = '';
                tamuSuggestions.style.display = 'none';
            }
        }, 150);
    });
    instansiInput.addEventListener('input', function() {
        console.log(this.value);
        const inputValue = this.value.toLowerCase().trim();
        instansiSuggestions.innerHTML = '';
        instansiSuggestions.style.display = 'none';
        console.log(inputValue)
        if (inputValue.length === 0) {
            return;
        }
        getSuggestion(inputValue,instansiInput,instansiSuggestions,instansiList);
    });

    instansiInput.addEventListener('blur', function() {
        setTimeout(() => {
            if (!isSelectingSuggestionAdmin) {
                instansiSuggestions.innerHTML = '';
                instansiSuggestions.style.display = 'none';
            }
            isSelectingSuggestionAdmin = false;
        }, 150);
    });

    instansiSuggestions.addEventListener('mouseover', function() {
        isSelectingSuggestionAdmin = true;
    });

    instansiSuggestions.addEventListener('mouseout', function() {
        isSelectingSuggestionAdmin = false;
    });
    // --- END LOGIKA AUTOCOMPLETE ---


    // --- Tampilkan modal tambah/edit jika ada error validasi dari old() input ---
    <?php if (session()->getFlashdata('errors')): ?>
    var errors = <?= json_encode(session()->getFlashdata('errors')); ?>;
    var addTamuModal = new bootstrap.Modal(document.getElementById('tambahTamuModal'));

    let isAddFormError = false;
    if (errors['nama_lengkap'] || errors['user_id_from_account'] || errors['email'] || errors[
            'asal_instansi']) {
        isAddFormError = true;
    }

    if (isAddFormError) {
        addTamuModal.show();
        setTimeout(toggleNamaLengkapManual, 100);
    } else if (old('id_tamu')) {
        var editTamuModal = new bootstrap.Modal(document.getElementById('editTamuModal'));
        document.getElementById('edit_id_tamu').value = '<?= old('id_tamu'); ?>';
        document.getElementById('edit_nama_lengkap').value = '<?= old('nama_lengkap'); ?>';
        document.getElementById('edit_asal_instansi').value = '<?= old('asal_instansi'); ?>';
        document.getElementById('edit_no_telepon').value = '<?= old('no_telepon'); ?>';
        document.getElementById('edit_email').value = '<?= old('email'); ?>';
        document.getElementById('edit_alamat').value = '<?= old('alamat'); ?>';
        editTamuModal.show();
    }
    <?php endif; ?>
    })
</script>
<?= $this->endSection(); ?>
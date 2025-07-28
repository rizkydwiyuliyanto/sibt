<?= $this->extend('masyarakat/template'); ?>

<?= $this->section('content'); ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-notebook-plus"></i>
                </span> Input Kunjungan Baru
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('masyarakat/dashboard'); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Input Kunjungan</li>
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
            <div class="col-lg-8 mx-auto grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Form Catat Kunjungan Anda</h4>
                        <p class="card-description">
                            Silakan isi detail kunjungan Anda.
                        </p>
                        <form class="forms-sample" action="<?= base_url('masyarakat/submit-kunjungan'); ?>"
                            method="POST">
                            <?= csrf_field(); ?>

                            <div class="mb-3">
                                <label for="nama_lengkap_tamu" class="form-label">Nama Lengkap Anda:</label>
                                <input type="text" class="form-control" id="nama_lengkap_tamu"
                                    value="<?= esc($tamuInfo['nama_lengkap'] ?? 'Nama Tidak Ditemukan'); ?>" readonly
                                    disabled>
                                <small class="form-text text-muted">Nama ini diambil dari akun Anda.</small>
                            </div>

                            <div class="mb-3 position-relative">
                                <label for="asal_instansi_input" class="form-label">Asal Instansi/Perusahaan:</label>
                                <input type="text" class="form-control" id="asal_instansi_input"
                                    name="asal_instansi_input"
                                    value="<?= old('asal_instansi_input', $tamuInfo['asal_instansi'] ?? ''); ?>"
                                    placeholder="Masukkan nama instansi Anda" autocomplete="off">
                                <div id="instansiSuggestions" class="list-group position-absolute"
                                    style="z-index: 1000; display: none;"></div>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['asal_instansi_input'])): ?>
                                <small
                                    class="text-danger"><?= session()->getFlashdata('errors')['asal_instansi_input']; ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan:</label>
                                <input type="date" class="form-control" id="tanggal_kunjungan" name="tanggal_kunjungan"
                                    value="<?= esc($currentDate); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="waktu_masuk" class="form-label">Waktu Masuk:</label>
                                <input type="time" class="form-control" id="waktu_masuk" name="waktu_masuk"
                                    value="<?= esc($currentTime); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="id_tujuan" class="form-label">Tujuan Kunjungan (Opsional):</label>
                                <select class="form-control" id="id_tujuan" name="id_tujuan">
                                    <option value="">-- Pilih Tujuan --</option>
                                    <?php foreach ($daftarTujuan as $tujuan): ?>
                                    <option value="<?= $tujuan['id_tujuan']; ?>"
                                        <?= old('id_tujuan') == $tujuan['id_tujuan'] ? 'selected' : ''; ?>>
                                        <?= esc($tujuan['nama_tujuan']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['id_tujuan'])): ?>
                                <small
                                    class="text-danger"><?= session()->getFlashdata('errors')['id_tujuan']; ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan (Wajib diisi):</label>
                                <textarea class="form-control" id="keperluan" name="keperluan" rows="4"
                                    required><?= old('keperluan'); ?></textarea>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['keperluan'])): ?>
                                <small
                                    class="text-danger"><?= session()->getFlashdata('errors')['keperluan']; ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan Tambahan (Opsional):</label>
                                <textarea class="form-control" id="catatan" name="catatan"
                                    rows="3"><?= old('catatan'); ?></textarea>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['catatan'])): ?>
                                <small class="text-danger"><?= session()->getFlashdata('errors')['catatan']; ?></small>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-gradient-primary me-2">Catat Kunjungan</button>
                            <button type="reset" class="btn btn-light">Reset Form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Optional: Hide alerts after a few seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            var bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);

    const instansiInput = document.getElementById('asal_instansi_input');
    const instansiSuggestions = document.getElementById('instansiSuggestions');
    const instansiList = <?= $instansiList; ?>;

    let isSelectingSuggestion = false;
    const FUZZY_THRESHOLD = 2; // Toleransi jarak Levenshtein. Misalnya, 1 atau 2 kesalahan.

    // --- Fungsi Levenshtein Distance ---
    function levenshteinDistance(a, b) {
        if (a.length === 0) return b.length;
        if (b.length === 0) return a.length;

        const matrix = [];

        let i;
        for (i = 0; i <= b.length; i++) {
            matrix[i] = [i];
        }

        let j;
        for (j = 0; j <= a.length; j++) {
            matrix[0][j] = j;
        }

        for (i = 1; i <= b.length; i++) {
            for (j = 1; j <= a.length; j++) {
                if (b.charAt(i - 1) === a.charAt(j - 1)) {
                    matrix[i][j] = matrix[i - 1][j - 1];
                } else {
                    matrix[i][j] = Math.min(
                        matrix[i - 1][j - 1] + 1, // substitution
                        Math.min(
                            matrix[i][j - 1] + 1, // insertion
                            matrix[i - 1][j] + 1 // deletion
                        )
                    );
                }
            }
        }
        return matrix[b.length][a.length];
    }
    // --- END Levenshtein Distance ---

    // --- Fungsi Pencarian Inisial ---
    function matchesInitialism(text, pattern) {
        if (pattern.length === 0) return false;

        const words = text.split(/\s+/).filter(word => word.length > 0);
        let initials = '';
        for (const word of words) {
            initials += word.charAt(0);
        }

        return initials.toLowerCase().startsWith(pattern.toLowerCase());
    }
    // --- END Fungsi Pencarian Inisial ---


    // Set width of suggestions box to match input width
    function setSuggestionsWidth() {
        const inputWidth = instansiInput.offsetWidth;
        instansiSuggestions.style.width = inputWidth + 'px';
    }

    setSuggestionsWidth();
    window.addEventListener('resize', setSuggestionsWidth);

    instansiInput.addEventListener('input', function() {
        const inputValue = this.value.toLowerCase().trim();
        instansiSuggestions.innerHTML = '';
        instansiSuggestions.style.display = 'none';

        if (inputValue.length === 0) {
            return;
        }

        const matchedSuggestions = [];
        for (const instansi of instansiList) {
            if (instansi && typeof instansi === 'string') {
                const lowerInstansi = instansi.toLowerCase();

                // Prioritas Pencarian:
                // 1. Pencocokan exact prefix (score 0)
                if (lowerInstansi.startsWith(inputValue)) {
                    matchedSuggestions.push({
                        text: instansi,
                        score: 0
                    });
                    continue;
                }

                // 2. Pencocokan substring (score 1)
                if (lowerInstansi.includes(inputValue)) {
                    matchedSuggestions.push({
                        text: instansi,
                        score: 1
                    });
                    continue;
                }

                // 3. Pencocokan Inisial (Singkatan) (score 2)
                if (matchesInitialism(instansi, inputValue)) {
                    matchedSuggestions.push({
                        text: instansi,
                        score: 2
                    });
                    continue;
                }

                // 4. Fuzzy matching dengan Levenshtein (score 3 + jarak)
                const cleanInputValue = inputValue.replace(/[^a-z0-9]/g, '');
                const cleanInstansi = lowerInstansi.replace(/[^a-z0-9]/g, '');

                if (cleanInputValue.length > 2) {
                    const distance = levenshteinDistance(cleanInputValue, cleanInstansi);
                    if (distance <= FUZZY_THRESHOLD && distance / cleanInputValue.length < 0.5) {
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

                div.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    isSelectingSuggestion = true;
                    instansiInput.value = this.textContent;
                    instansiSuggestions.innerHTML = '';
                    instansiSuggestions.style.display = 'none';
                    instansiInput.focus();
                });
                instansiSuggestions.appendChild(div);
            });
            instansiSuggestions.style.display = 'block';
        } else {
            instansiSuggestions.style.display = 'none';
        }
    });

    instansiInput.addEventListener('blur', function() {
        setTimeout(() => {
            if (!isSelectingSuggestion) {
                instansiSuggestions.innerHTML = '';
                instansiSuggestions.style.display = 'none';
            }
            isSelectingSuggestion = false;
        }, 150);
    });

    instansiSuggestions.addEventListener('mouseover', function() {
        isSelectingSuggestion = true;
    });

    instansiSuggestions.addEventListener('mouseout', function() {
        isSelectingSuggestion = false;
    });
});
</script>
<?= $this->endSection(); ?>
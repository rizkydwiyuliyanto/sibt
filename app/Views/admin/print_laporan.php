<!DOCTYPE html>
<html>

<head>
    <title><?= $title; ?></title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 10pt;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
    }

    .header h1 {
        margin: 0;
        font-size: 16pt;
    }

    .header p {
        margin: 2px 0;
        font-size: 11pt;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .footer {
        text-align: right;
        font-size: 9pt;
        margin-top: 30px;
    }

    .text-center {
        text-align: center;
    }
    </style>
</head>

<body>
    <div class="header">
        <h1>Sistem Informasi Buku Tamu</h1>
        <h2><?= $title; ?></h2>
        <?php if (!empty($filterInfo)): ?>
        <p><?= $filterInfo; ?></p>
        <?php endif; ?>
    </div>

    <?php if (empty($laporan)): ?>
    <p class="text-center">Tidak ada data kunjungan untuk periode ini.</p>
    <?php else: ?>
    <?php if ($filterType == 'tahunan' && isset($laporanSummary)): // Jika ini laporan tahunan dengan ringkasan ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Jumlah Kunjungan</th>
            </tr>
        </thead>
        <tbody>
            <?php
                        $bulanArray = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    ?>
            <?php $no = 1; foreach ($laporanSummary as $summary): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $bulanArray[$summary['bulan']]; ?></td>
                <td><?= esc($summary['total_kunjungan']); ?> Kunjungan</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: // Laporan harian, bulanan, atau tahunan dengan detail ?>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tamu</th>
                <th>Instansi</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Tujuan</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($laporan as $kunjungan): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= esc($kunjungan['nama_lengkap']); ?></td>
                <td><?= esc($kunjungan['asal_instansi'] ?: '-'); ?></td>
                <td><?= date('d M Y', strtotime(esc($kunjungan['tanggal_kunjungan']))); ?></td>
                <td><?= date('H:i', strtotime(esc($kunjungan['waktu_masuk']))); ?></td>
                <td><?= $kunjungan['waktu_keluar'] ? date('H:i', strtotime(esc($kunjungan['waktu_keluar']))) : '-'; ?>
                </td>
                <td><?= esc($kunjungan['nama_tujuan'] ?: '-'); ?></td>
                <td><?= esc($kunjungan['keperluan']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    <?php endif; ?>

    <div class="footer">
        <p>Dicetak pada: <?= date('d M Y, H:i'); ?></p>
        <p>Oleh: <?= session()->get('nama_lengkap') ?? 'Admin Sistem'; ?></p>
    </div>
</body>

</html>
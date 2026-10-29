<?php

$matkul = [
    ["nama" => "Jaringan komputer",        "sks" => 3, "nilai" => 85],
    ["nama" => "Pemrograman web",           "sks" => 3, "nilai" => 75],
    ["nama" => "Sistem basis data",         "sks" => 3, "nilai" => 82],
    ["nama" => "Desain analisis algoritma", "sks" => 3, "nilai" => 65],
    ["nama" => "Internet of Things",        "sks" => 3, "nilai" => 45],
];

function hitungBobot($nilai): array {
    return match(true) {
        $nilai >= 80 => ["huruf" => "A", "bobot" => 4.0],
        $nilai >= 70 => ["huruf" => "B", "bobot" => 3.0],
        $nilai >= 60 => ["huruf" => "C", "bobot" => 2.0],
        $nilai >= 50 => ["huruf" => "D", "bobot" => 1.0],
        default       => ["huruf" => "E", "bobot" => 0.0],
    };
}

function statusKuliah($bobot): string {
    return ($bobot >= 2.0) ? "LULUS" : "MENGULANG";
}

$totalBobotSks = 0; $totalSks = 0;
foreach ($matkul as $m) {
    $r = hitungBobot($m["nilai"]);
    $totalBobotSks += $r["bobot"] * $m["sks"];
    $totalSks += $m["sks"];
}
$ips = ($totalSks > 0) ? $totalBobotSks / $totalSks : 0;

$maxSks = ($ips >= 3.00) ? 24 : 20;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah & Ringkasan IPS</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9; margin: 0; padding: 30px; color: #333;
        }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 10px; }
        h2 { text-align: center; color: #7f8c8d; margin-top: 0; font-weight: normal; }
        table {
            width: 100%; max-width: 900px; margin: 20px auto;
            border-collapse: collapse; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background-color: #fff; border-radius: 8px; overflow: hidden;
        }
        th, td { padding: 12px 15px; text-align: center; border-bottom: 1px solid #e0e0e0; }
        th { background-color: #34495e; color: #fff; font-weight: 600; }
        tr:hover td:not(.mengulang) { background-color: #f8f9fa; }
        .mengulang { background-color: #e74c3c !important; color: #fff !important; }
        .status-lulus { color: #27ae60; font-weight: bold; }
        .status-mengulang { color: #fff; font-weight: bold; }
        .summary {
            max-width: 900px; margin: 30px auto 0; padding: 25px;
            background-color: #fff; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .summary h3 { color: #2c3e50; margin-top: 0; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .summary p { font-size: 16px; line-height: 1.6; }
        .ips-value { font-size: 24px; font-weight: bold; color: #2980b9; }
        .sks-value { font-size: 24px; font-weight: bold; color: #8e44ad; }
        .highlight { background-color: #fff3cd; padding: 3px 8px; border-radius: 4px; }
    </style>
</head>
<body>

<h1>Daftar Mata Kuliah</h1>
<h2>Semester Ini</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Nilai Angka</th>
            <th>Nilai Huruf</th>
            <th>Bobot</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($matkul as $m):
            $hasil       = hitungBobot($m["nilai"]);
            $huruf       = $hasil["huruf"];
            $bobot       = $hasil["bobot"];
            $status      = statusKuliah($bobot);
            $isMengulang = ($bobot < 2.0);
        ?>
            <tr class="<?= $isMengulang ? 'mengulang' : '' ?>">
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($m["nama"]) ?></td>
                <td><?= $m["sks"] ?></td>
                <td><?= $m["nilai"] ?></td>
                <td><?= $huruf ?></td>
                <td><?= $bobot ?></td>
                <td class="<?= $isMengulang ? 'status-mengulang' : 'status-lulus' ?>">
                    <?= $status ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<div class="summary">
    <h3>Ringkasan IPS</h3>
    <p><strong>Total SKS:</strong> <span class="highlight"><?= $totalSks ?> SKS</span></p>
    <p><strong>Total Bobot × SKS:</strong> <span class="highlight"><?= $totalBobotSks ?></span></p>
    <p><strong>IPS:</strong> <span class="ips-value"><?= number_format($ips, 2) ?></span></p>
</div>

<div class="summary" style="margin-top: 15px;">
    <h3>Batas Maksimal SKS Semester Depan</h3>
    <p>
        Berdasarkan IPS <strong><?= number_format($ips, 2) ?></strong>,
        <?php if ($ips >= 3.00): ?>
            IPS Anda >= 3.00, Anda <strong>boleh mengambil 24 SKS</strong> pada semester depan.
        <?php else: ?>
            IPS Anda < 3.00, maksimal yang <strong>dapat Anda ambil adalah 20 SKS</strong> pada semester depan.
        <?php endif ?>
    </p>
    <p><strong>Maksimal SKS:</strong> <span class="sks-value"><?= $maxSks ?> SKS</span></p>
</div>

</body>
</html>


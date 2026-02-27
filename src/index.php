<?php
// src/index.php
require 'database.php';

// [BUG 1: PROFILING] Asesi harus menambahkan fungsi microtime(true) di awal dan akhir file.

// Ambil semua data antrean
$query_utama = $db->query("SELECT * FROM pengajuan_skripsi");
$data_utama = $query_utama->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pengajuan Judul Skripsi</title>
</head>
<body>
    <h1>Form Pengajuan Topik Skripsi / Tugas Akhir</h1>
    
    <form action="proses.php" method="POST">
        <input type="text" name="nama_mahasiswa" placeholder="Nama Lengkap Mahasiswa"><br><br>
        <input type="text" name="nim" placeholder="NIM"><br><br>
        <select name="id_bidang_minat">
            <option value="1">Machine Learning</option>
            <option value="2">UI/UX Design</option>
            <option value="3">Internet of Things (IoT)</option>
            <option value="4">Cyber Security</option>
        </select><br><br>
        <button type="submit">Ajukan Judul</button>
    </form>
    
    <hr>
    
    <h2>Antrean Pengajuan Skripsi (5.000+ Antrean)</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Topik Riset Pilihan</th>
        </tr>
        <?php
        foreach ($data_utama as $row) {
            $id_bidang_minat = $row['id_bidang_minat'];
            
            // [BUG 2: SKALABILITAS / N+1 QUERY] 
            // Kueri di dalam looping yang akan membunuh server. Asesi wajib menghapus ini 
            // dan menggabungkannya ke kueri utama di atas menggunakan JOIN.
            $query_relasi = $db->query("SELECT nama_bidang FROM bidang_minat WHERE id = $id_bidang_minat");
            $relasi = $query_relasi->fetch();

            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nama_mahasiswa'] . "</td>";
            echo "<td>" . $row['nim'] . "</td>";
            echo "<td>" . $relasi['nama_bidang'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
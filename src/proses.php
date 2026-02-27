<?php
// src/proses.php
require 'database.php';

// [BUG 1: ALGORITMA] Tidak ada validasi. Jika user submit form kosong, program akan tetap lanjut dan error.
$nama_mahasiswa = $_POST['nama_mahasiswa'];
$nim = $_POST['nim'];
$id_bidang_minat = $_POST['id_bidang_minat'];

// [BUG 2: SQL INJECTION] Parameter langsung digabung ke string SQL!
// Asesi wajib mengubahnya menjadi Prepared Statement.
$sql = "INSERT INTO pengajuan_skripsi (nama_mahasiswa, nim, id_bidang_minat) VALUES ('$nama_mahasiswa', '$nim', '$id_bidang_minat')";

// Mengeksekusi kueri kotor
$db->exec($sql);

header("Location: index.php");
exit;
?>
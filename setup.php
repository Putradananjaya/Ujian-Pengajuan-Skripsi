<?php
// setup.php - Eksekusi: php setup.php
$db = new PDO('sqlite:src/pendaftaran.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Buat Tabel Bidang Minat dan Pengajuan Skripsi
$db->exec("CREATE TABLE IF NOT EXISTS bidang_minat (id INTEGER PRIMARY KEY AUTOINCREMENT, nama_bidang TEXT)");
$db->exec("CREATE TABLE IF NOT EXISTS pengajuan_skripsi (id INTEGER PRIMARY KEY AUTOINCREMENT, nama_mahasiswa TEXT, nim TEXT, id_bidang_minat INTEGER)");

// Masukkan data referensi bidang minat penelitian
$db->exec("INSERT INTO bidang_minat (nama_bidang) VALUES ('Machine Learning'), ('UI/UX Design'), ('Internet of Things (IoT)'), ('Cyber Security')");

// Masukkan 5.000 data dummy untuk mensimulasikan beban server
echo "Sedang men-generate 5.000 antrean pengajuan skripsi...\n";
$db->beginTransaction();
for ($i = 1; $i <= 5000; $i++) {
    $id_bidang_minat = rand(1, 4);
    $db->exec("INSERT INTO pengajuan_skripsi (nama_mahasiswa, nim, id_bidang_minat) VALUES ('Mahasiswa Tingkat Akhir $i', 'NIM2022$i', $id_bidang_minat)");
}
$db->commit();

echo "Setup Selesai! File pendaftaran.sqlite berhasil dibuat di dalam folder src/.";
?>
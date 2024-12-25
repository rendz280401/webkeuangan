<?php
session_start();

// Cek apakah pengguna sudah login, jika belum, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bars</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .vertical-navbar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 50px; /* Adjusted to accommodate horizontal navbar */
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: transform 0.3s;
            padding-top: 20px;
        }

        .vertical-navbar.collapsed {
            transform: translateX(-250px);
        }

        .vertical-navbar a {
            display: block;
            color: white;
            padding: 15px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .vertical-navbar a:hover {
            background-color: #575757;
        }

        .horizontal-navbar {
            width: 100%;
            height: 50px;
            background-color: #444;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 0 10px;
        }

        .horizontal-navbar a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }

        .horizontal-navbar a:hover {
            background-color: #575757;
        }

        .content {
            margin-left: 260px;
            margin-top: 70px; /* Adjusted to accommodate horizontal navbar */
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .content.collapsed {
            margin-left: 10px;
        }

        .toggle-btn {
            background-color: #333;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
         table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        .btn-dsh {
            display: inline-block; /* Membuat elemen inline berbentuk block untuk properti padding */
            padding: 10px 20px; /* Mengatur jarak dalam tombol */
            margin: 5px; /* Menambahkan sedikit jarak antar tombol */
            background-color: #f14d4d; /* Warna dasar tombol (biru) */
            color: white; /* Warna teks */
            text-decoration: none; /* Menghilangkan garis bawah */
            font-size: 16px; /* Ukuran font */
            border-radius: 5px; /* Membuat sudut tombol melengkung */
            border: none; /* Menghilangkan border default */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Menambahkan efek bayangan */
            transition: background-color 0.3s, transform 0.2s; /* Efek hover dan klik */
        }

        .btn-dsh:hover {
            background-color: #dc3545; /* Warna saat hover */
            transform: scale(1.05); /* Sedikit memperbesar tombol saat hover */
        }

        .btn-dsh:active {
            background-color: #003d80; /* Warna saat tombol ditekan */
            transform: scale(0.95); /* Sedikit mengecilkan tombol saat ditekan */
        }
        form {
            display: flex;
            flex-wrap: wrap; /* Membuat elemen menyesuaikan pada layar kecil */
            gap: 15px; /* Menambahkan jarak antar elemen */
            align-items: center; /* Menjaga elemen tetap sejajar secara vertikal */
            margin-bottom: 20px; /* Menambahkan jarak bawah form */
        }

        form label {
            font-size: 16px; /* Ukuran font label */
            font-weight: bold; /* Menekankan label */
            margin-right: 5px; /* Jarak antara label dan elemen input */
        }

        form select {
            padding: 8px 12px; /* Memberikan jarak dalam select box */
            font-size: 16px; /* Ukuran font */
            border: 1px solid #ccc; /* Border abu-abu */
            border-radius: 5px; /* Membuat sudut melengkung */
            background-color: #fff; /* Warna latar putih */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan ringan */
            transition: border-color 0.3s; /* Animasi saat fokus */
            width: 200px; /* Panjang select box */
        }

        form select:focus {
            border-color: #007bff; /* Warna border saat fokus */
            outline: none; /* Menghilangkan outline default */
        }

        form button {
            padding: 10px 20px; /* Jarak dalam tombol */
            font-size: 16px; /* Ukuran font */
            background-color: #007bff; /* Warna dasar biru */
            color: white; /* Warna teks */
            border: none; /* Menghilangkan border */
            border-radius: 5px; /* Membuat sudut tombol melengkung */
            cursor: pointer; /* Menambahkan pointer saat hover */
            transition: background-color 0.3s, transform 0.2s; /* Animasi hover dan klik */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan */
        }

        form button:hover {
            background-color: #0056b3; /* Warna tombol saat hover */
            transform: scale(1.05); /* Sedikit memperbesar tombol */
        }

        form button:active {
            background-color: #003d80; /* Warna tombol saat ditekan */
            transform: scale(0.95); /* Sedikit mengecilkan tombol */
        }

        @media (max-width: 768px) {
            form select {
        width: 100%; /* Lebar penuh pada layar kecil */
            }
            form button {
        width: 100%; 
        text-align: center;
            }
        }

    </style>
    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.vertical-navbar');
            const content = document.querySelector('.content');
            navbar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        }
    </script>
</head>
<body>
    <div class="horizontal-navbar">
        <button class="toggle-btn" onclick="toggleNavbar()">☰</button>
        <a href="logout.php">Logout</a> <!-- Tombol Logout -->
    </div>

    <div class="vertical-navbar">
        <a href="index.php">Dashboard</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="makanan.php">Menu</a>
        <a href="laporan.php">Laporan</a>
    </div>

    <div class="content">
      <?php
include 'db.php';

// Default bulan dan tahun (bulan ini)
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Mengambil total pemasukan untuk bulan dan tahun yang dipilih
$query_pemasukan = "
    SELECT SUM(total_harga) AS total_pemasukan
    FROM transaksi
    WHERE jenis = 'Pemasukan' 
    AND MONTH(tanggal) = $bulan
    AND YEAR(tanggal) = $tahun
";
$result_pemasukan = $conn->query($query_pemasukan);
$pemasukan = $result_pemasukan->fetch_assoc()['total_pemasukan'];

// Mengambil total pengeluaran untuk bulan dan tahun yang dipilih
$query_pengeluaran = "
    SELECT SUM(total_harga) AS total_pengeluaran
    FROM transaksi
    WHERE jenis = 'Pengeluaran'
    AND MONTH(tanggal) = $bulan
    AND YEAR(tanggal) = $tahun
";
$result_pengeluaran = $conn->query($query_pengeluaran);
$pengeluaran = $result_pengeluaran->fetch_assoc()['total_pengeluaran'];

// Menghitung saldo
$saldo = $pemasukan - $pengeluaran;

// Ambil detail pemasukan untuk bulan dan tahun yang dipilih
$query_detail_pemasukan = "
    SELECT t.id, t.tanggal, m.nama AS makanan, t.jumlah, t.total_harga
    FROM transaksi t
    LEFT JOIN makanan m ON t.makanan_id = m.id
    WHERE t.jenis = 'Pemasukan'
    AND MONTH(t.tanggal) = $bulan
    AND YEAR(t.tanggal) = $tahun
    ORDER BY t.tanggal DESC
";
$result_detail_pemasukan = $conn->query($query_detail_pemasukan);

// Ambil detail pengeluaran untuk bulan dan tahun yang dipilih
$query_detail_pengeluaran = "
    SELECT t.id, t.tanggal, m.nama AS makanan, t.jumlah, t.total_harga
    FROM transaksi t
    LEFT JOIN makanan m ON t.makanan_id = m.id
    WHERE t.jenis = 'Pengeluaran'
    AND MONTH(t.tanggal) = $bulan
    AND YEAR(t.tanggal) = $tahun
    ORDER BY t.tanggal DESC
";
$result_detail_pengeluaran = $conn->query($query_detail_pengeluaran);
?>

    <h1>Laporan Bulanan</h1>

    <!-- Form Pilih Bulan dan Tahun -->
    <form method="GET">
        <label for="bulan">Pilih Bulan:</label>
        <select name="bulan" id="bulan">
            <option value="01" <?= $bulan == '01' ? 'selected' : '' ?>>Januari</option>
            <option value="02" <?= $bulan == '02' ? 'selected' : '' ?>>Februari</option>
            <option value="03" <?= $bulan == '03' ? 'selected' : '' ?>>Maret</option>
            <option value="04" <?= $bulan == '04' ? 'selected' : '' ?>>April</option>
            <option value="05" <?= $bulan == '05' ? 'selected' : '' ?>>Mei</option>
            <option value="06" <?= $bulan == '06' ? 'selected' : '' ?>>Juni</option>
            <option value="07" <?= $bulan == '07' ? 'selected' : '' ?>>Juli</option>
            <option value="08" <?= $bulan == '08' ? 'selected' : '' ?>>Agustus</option>
            <option value="09" <?= $bulan == '09' ? 'selected' : '' ?>>September</option>
            <option value="10" <?= $bulan == '10' ? 'selected' : '' ?>>Oktober</option>
            <option value="11" <?= $bulan == '11' ? 'selected' : '' ?>>November</option>
            <option value="12" <?= $bulan == '12' ? 'selected' : '' ?>>Desember</option>
        </select>
        
        <label for="tahun">Pilih Tahun:</label>
        <select name="tahun" id="tahun">
            <option value="2025" <?= $tahun == '2025' ? 'selected' : '' ?>>2025</option>
            <option value="2024" <?= $tahun == '2024' ? 'selected' : '' ?>>2024</option>
            <option value="2023" <?= $tahun == '2023' ? 'selected' : '' ?>>2023</option>
            <!-- Tambahkan tahun lainnya sesuai kebutuhan -->
        </select>
        <button type="submit">Tampilkan Laporan</button>
    </form>

    <h2>Laporan Bulan <?= date('F', strtotime($tahun . '-' . $bulan . '-01')) ?> <?= $tahun ?></h2>

    <!-- Tampilkan Total Pemasukan, Pengeluaran dan Saldo -->
    <table border="1">
        <thead>
            <tr>
                <th>Total Pemasukan</th>
                <th>Total Pengeluaran</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Rp <?= number_format($pemasukan, 0, ',', '.') ?: '0' ?></td>
                <td>Rp <?= number_format($pengeluaran, 0, ',', '.') ?: '0' ?></td>
                <td>Rp <?= number_format($saldo, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Detail Pemasukan</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Nama Makanan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_detail_pemasukan->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['makanan'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h3>Detail Pengeluaran</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Nama Makanan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_detail_pengeluaran->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['makanan'] ?></td>
                    <td><?= $row['jumlah'] ?></td>
                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>
    <a class="btn-dsh" href="index.php">Kembali ke Dashboard</a>


</body>
</html>
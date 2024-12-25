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
            background-color: #007bff; /* Warna dasar tombol (biru) */
            color: white; /* Warna teks */
            text-decoration: none; /* Menghilangkan garis bawah */
            font-size: 16px; /* Ukuran font */
            border-radius: 5px; /* Membuat sudut tombol melengkung */
            border: none; /* Menghilangkan border default */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Menambahkan efek bayangan */
            transition: background-color 0.3s, transform 0.2s; /* Efek hover dan klik */
        }

        .btn-dsh:hover {
            background-color: #0056b3; /* Warna saat hover */
            transform: scale(1.05); /* Sedikit memperbesar tombol saat hover */
        }

        .btn-dsh:active {
            background-color: #003d80; /* Warna saat tombol ditekan */
            transform: scale(0.95); /* Sedikit mengecilkan tombol saat ditekan */
        }
        .financial-summary {
            display: flex; /* Menampilkan item secara horizontal */
            justify-content: space-between; /* Memberi jarak antar box */
            align-items: center; /* Pusatkan vertikal */
            gap: 40px; /* Menambah jarak antar box */
            width: 100%; /* Memenuhi lebar layar */
            padding: 0 20px; /* Memberi padding di kiri dan kanan */
            box-sizing: border-box; /* Memastikan padding tidak melebihi lebar */
            margin: 20px 0; /* Jarak atas dan bawah */
        }

        .financial-item {
            flex: 1; /* Ukuran box seimbang */
            text-align: center; /* Pusatkan teks dalam box */
            padding: 20px; /* Jarak dalam elemen */
            border-radius: 10px; /* Sudut melengkung */
            color: white; /* Warna font tetap putih */
            font-family: Arial, sans-serif; /* Font modern */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Bayangan lembut */
            max-width: 400px; /* Lebar maksimum setiap box */
        }

        .financial-item.pemasukan {
            background-color: #28a745; /* Warna hijau untuk pemasukan */
        }

        .financial-item.pengeluaran {
            background-color: #dc3545; /* Warna merah untuk pengeluaran */
        }

        .financial-item p {
            margin: 5px 0; /* Jarak antar paragraf */
        }

        .financial-item p strong {
            font-size: 18px; /* Ukuran lebih besar untuk label */
        }

        .financial-item p:last-child {
            font-size: 20px; /* Ukuran lebih besar untuk angka */
            font-weight: bold; /* Penekanan angka */
        }

        @media (max-width: 768px) {
            .financial-summary {
                flex-direction: column; /* Susun kotak secara vertikal pada layar kecil */
                gap: 20px; /* Jarak antar kotak lebih kecil */
            }

            .financial-item {
                max-width: 100%; /* Penuhi lebar container */
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

// Ambil total pemasukan dan pengeluaran
$pemasukan = $conn->query("SELECT SUM(total_harga) AS total_pemasukan FROM transaksi WHERE jenis = 'Pemasukan'")->fetch_assoc()['total_pemasukan'];
$pengeluaran = $conn->query("SELECT SUM(total_harga) AS total_pengeluaran FROM transaksi WHERE jenis = 'Pengeluaran'")->fetch_assoc()['total_pengeluaran'];

// Ambil riwayat transaksi
// Ambil riwayat transaksi dan nama makanan
// Ambil riwayat transaksi dan nama makanan
$riwayat = $conn->query("SELECT t.id, t.tanggal, t.jenis, t.jumlah, m.nama AS makanan, t.total_harga
                         FROM transaksi t
                         LEFT JOIN makanan m ON t.makanan_id = m.id
                         ORDER BY t.tanggal DESC LIMIT 5");


?>
<h1>Dashboard Keuangan Restoran</h1>
    <div class="financial-summary">
    <div class="financial-item pemasukan">
        <p><strong>Total Pemasukan:</strong></p>
        <p>Rp <?= number_format($pemasukan, 0, ',', '.') ?></p>
    </div>
    <div class="financial-item pengeluaran">
        <p><strong>Total Pengeluaran:</strong></p>
        <p>Rp <?= number_format($pengeluaran, 0, ',', '.') ?></p>
    </div>
</div>


    <h2>Riwayat Transaksi Terbaru</h2>
    <table border="1">
    <thead>
        <tr>
            <th>ID Transaksi</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Nama</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $riwayat->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td><?= $row['jumlah'] ?></td>
                <td><?= $row['makanan'] ?: '-' ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>


    <br>
    <a class="btn-dsh" href="transaksi.php">Tambah Transaksi</a> |
    <a class="btn-dsh" href="makanan.php">Kelola Makanan</a> |
    <a class="btn-dsh" href="laporan.php">Laporan Bulanan</a>
    </div>
</body>
</html>

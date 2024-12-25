<?php
session_start();

// Cek apakah pengguna sudah login
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
        form {
         width: 100%; 
    max-width: 400px; 
    margin: 0; 
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
       
    }

    form h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.5rem;
        color: black;
    }

    form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: black;
    }

    form input, form select, form textarea, form button {
        width: 100%; /* Semua elemen form memiliki lebar penuh */
        max-width: 100%; /* Hindari melebihi ukuran form */
        box-sizing: border-box; /* Pastikan padding tidak memengaruhi lebar */
        padding: 12px; /* Sama untuk semua elemen */
        margin-bottom: 15px;
        font-size: 1rem;
        border: 1px solid #007BFF;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    form input:focus, form select:focus, form textarea:focus {
        border-color: black;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    form textarea {
        resize: vertical;
        min-height: 100px;
    }

    form button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s, transform 0.2s;
    }

    form button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    form button:active {
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        form {
            padding: 15px;
        }

        form h2 {
            font-size: 1.3rem;
        }

        form input, form select, form textarea, form button {
            font-size: 0.9rem;
            padding: 10px;
        }
    }

    @media (max-width: 480px) {
        form {
            padding: 10px;
        }

        form h2 {
            font-size: 1.1rem;
        }

        form input, form select, form textarea, form button {
            font-size: 0.8rem;
            padding: 8px;
        }
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
        background-color: #dc3545 ; /* Warna saat hover */
        transform: scale(1.05); /* Sedikit memperbesar tombol saat hover */
    }

    .btn-dsh:active {
        background-color: #003d80; /* Warna saat tombol ditekan */
        transform: scale(0.95); /* Sedikit mengecilkan tombol saat ditekan */
    }

    </style>

    <script>
        function toggleNavbar() {
            const navbar = document.querySelector('.vertical-navbar');
            const content = document.querySelector('.content');
            navbar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');
        }

        // Function to show a popup after transaction success
        function showSuccessMessage(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <div class="horizontal-navbar">
        <button class="toggle-btn" onclick="toggleNavbar()">☰</button>
        <a href="logout.php">Logout</a>
    </div>

    <div class="vertical-navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="transaksi.php">Transaksi</a>
        <a href="makanan.php">Menu</a>
        <a href="laporan.php">Laporan</a>
    </div>

    <div class="content">
<?php
include 'db.php';

// Tambah transaksi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis = $_POST['jenis'];
    $makanan_id = $_POST['makanan_id'];
    $jumlah = $_POST['jumlah'];

    // Ambil harga dari makanan/minuman yang dipilih
    $result = $conn->query("SELECT harga FROM makanan WHERE id = $makanan_id");
    $harga = $result->fetch_assoc()['harga'];

    // Hitung total harga
    $total_harga = $jumlah * $harga;

    $query = "INSERT INTO transaksi (jenis, makanan_id, jumlah, total_harga) 
              VALUES ('$jenis', $makanan_id, $jumlah, $total_harga)";
    if ($conn->query($query)) {
        echo "<script>showSuccessMessage('Transaksi berhasil ditambahkan!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Ambil semua data makanan dan minuman
$makanan = $conn->query("SELECT * FROM makanan WHERE kategori = 'Makanan'");
$bahan_baku = $conn->query("SELECT * FROM makanan WHERE kategori = 'Bahan Baku'");
?>

    <script>
        function updateKategoriDropdown() {
            const jenis = document.getElementById('jenis').value;
            const makananDropdown = document.getElementById('makanan_id');
            const makananOptions = makananDropdown.options;

            for (let i = 0; i < makananOptions.length; i++) {
                const option = makananOptions[i];
                if (jenis === 'Pemasukan' && option.dataset.kategori === 'Makanan') {
                    option.style.display = 'block';
                } else if (jenis === 'Pengeluaran' && option.dataset.kategori === 'Bahan Baku') {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            }
        }
    </script>

    <h1>Tambah Transaksi</h1>

    <form method="POST">
        <label for="jenis">Jenis Transaksi:</label>
        <select name="jenis" id="jenis" onchange="updateKategoriDropdown()" required>
            <option value="">Pilih Jenis</option>
            <option value="Pemasukan">Pemasukan</option>
            <option value="Pengeluaran">Pengeluaran</option>
        </select><br>

        <label for="makanan_id">Pilih Item:</label>
        <select name="makanan_id" id="makanan_id" required>
            <option value="">Pilih Item</option>
            <?php while ($row = $makanan->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" data-kategori="Makanan"><?= $row['nama'] ?> (Rp <?= number_format($row['harga'], 0, ',', '.') ?>)</option>
            <?php endwhile; ?>
            <?php while ($row = $bahan_baku->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" data-kategori="Bahan Baku"><?= $row['nama'] ?> (Rp <?= number_format($row['harga'], 0, ',', '.') ?>)</option>
            <?php endwhile; ?>
        </select><br>

        <label for="jumlah">Jumlah:</label>
        <input type="number" name="jumlah" id="jumlah" required><br>

        <button type="submit">Tambah Transaksi</button>
    </form>

    <br>
    <a class="btn-dsh" href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>

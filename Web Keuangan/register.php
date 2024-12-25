<?php
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
    /* Reset margin dan padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        width: 100%;
        max-width: 400px;
        background-color: white;
        color: black;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 24px;
        color: black;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        background-color: white;
        border: 1px solid #007bff;
        border-radius: 4px;
        color: black;
        font-size: 16px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    /* Tautan antara halaman login dan register */
    a {
        color: #007bff;
        text-decoration: none;
        text-align: center;
        display: block;
        margin-top: 15px;
    }

    a:hover {
        text-decoration: underline;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    form .form-title {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h2 class="form-title">Register</h2>
    <center>
        <?php
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
            $email = $_POST['email'];

            // Memeriksa apakah username atau email sudah ada
            $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $result = $conn->query($check_query);

            if ($result->num_rows > 0) {
                echo "<script>alert('Username atau Email sudah terdaftar!');window.location.href = 'register.php';</script>";
            } else {
                // Menyimpan data pengguna ke database
                $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Registrasi berhasil!');window.location.href = 'login.php';</script>";
                } else {
                    echo "<script>alert('Terjadi kesalahan, silakan coba lagi.');window.location.href = 'register.php';</script>";
                }
            }
        }
        ?>
    </center>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="submit" value="Register">
    </form>
    <a href="login.php">Sudah punya akun? Login di sini</a>
</div>
</body>
</html>


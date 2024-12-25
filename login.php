

<?php
include('db.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            color: white;
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
    <script>
        // Function to show the popup based on the message
        function showPopup(message, type) {
            let color = (type === 'success') ? 'green' : 'red';
            alert(message);
            // Optionally, use a custom alert box instead of the default JavaScript alert
            // Example: change the background color of the alert message based on the type.
        }
    </script>
</head>
<body>

    <div class="container">
        <h2 class="form-title">Login</h2>
        <center>
        <?php
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Query untuk mengecek username dan password
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    // Jika login berhasil
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['user_id'] = $row['id'];
                     echo "<script>alert('Login berhasil!');window.location.href = 'index.php';</script>";
                    exit();
                } else {
                    echo "<script>showPopup('Password salah!', 'error');</script>";
                }
            } else {
                echo "<script>showPopup('Username tidak ditemukan!', 'error');</script>";
            }
        }
        ?>
        </center>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="submit" value="Login">
        </form>
        <a class="login" href="register.php">Belum punya akun? Daftar di sini</a>
    </div>
</body>
</html>

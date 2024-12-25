<?php
session_start();
session_unset(); // Clear all session variables
session_destroy(); // Destroy the session

// Show popup and redirect to login page
echo "<script>
    alert('Logout berhasil!');
    window.location.href = 'login.php'; // Redirect immediately
</script>";
exit();

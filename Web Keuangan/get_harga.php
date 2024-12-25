<?php
include 'config.php';

if (isset($_GET['id'])) {
    $makanan_id = $_GET['id'];
    $query = "SELECT harga FROM makanan WHERE id = $makanan_id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['harga' => $row['harga']]);
    } else {
        echo json_encode(['harga' => 0]);
    }
}
?>

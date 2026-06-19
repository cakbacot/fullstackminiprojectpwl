<?php
include 'config.php';
if (isset($_GET['id'])) {
    $stmt = $koneksi->prepare("DELETE FROM bahan WHERE id=?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
}
header("Location: bahan.php");
exit;
?> 
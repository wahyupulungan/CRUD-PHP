<?php
include 'koneksi.php';

// Ambil ID barang yang akan dihapus dari parameter URL
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Query untuk hapus data barang berdasarkan ID
    $delete_sql = "DELETE FROM barang WHERE id_barang = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $id_barang);

    if ($stmt->execute()) {
        // Redirect kembali ke index.php setelah berhasil hapus
        header('Location: index.php');
        exit;
    } else {
        // Jika terjadi error saat hapus
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

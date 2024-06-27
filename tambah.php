<?php
// Mengimpor file koneksi.php
require 'koneksi.php';

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $persediaan = $_POST['persediaan'];
    $harga = $_POST['harga'];
    $jumlah = $persediaan * $harga;

    // Menyiapkan pernyataan SQL untuk memasukkan data
    $sql = "INSERT INTO barang (id_barang, nama_barang, persediaan, harga, jumlah) 
            VALUES ('$id_barang', '$nama_barang', '$persediaan', '$harga', '$jumlah')";

    // Mengeksekusi pernyataan SQL
    if ($conn->query($sql) === TRUE) {
        // Jika data berhasil dimasukkan, kembali ke halaman utama atau tampilkan pesan sukses
        header("Location: index.php?notif=Data berhasil ditambahkan");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        $notif = "Error: " . $sql . "<br>" . $conn->error;
    }

    // Menutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type=text], input[type=number] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        input[type=submit], button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type=submit]:hover, button:hover {
            background-color: #0056b3;
        }
        .error-msg {
            background-color: #f44336;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
        }
        .back-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Form Tambah Data Barang</h2>
    <!-- Menampilkan pesan notifikasi jika ada -->
    <?php if (!empty($notif)): ?>
        <div class="error-msg">
            <?php echo $notif; ?>
        </div>
    <?php endif; ?>

    <!-- Form untuk input data -->
    <form action="tambah.php" method="post">
        <label for="id_barang">ID Barang:</label><br>
        <input type="text" id="id_barang" name="id_barang" required autocomplete="off"><br><br>

        <label for="nama_barang">Nama Barang:</label><br>
        <input type="text" id="nama_barang" name="nama_barang" required autocomplete="off"><br><br>

        <label for="persediaan">Persediaan:</label><br>
        <input type="number" id="persediaan" name="persediaan" required autocomplete="off"><br><br>

        <label for="harga">Harga:</label><br>
        <input type="number" id="harga" name="harga" required autocomplete="off" onchange="hitungTotal()"><br><br>

        <label for="jumlah">Jumlah:</label><br>
        <input type="number" id="jumlah" name="jumlah" required autocomplete="off" readonly><br><br>

        <input type="submit" value="Tambah">
    </form>

    <br>
    <a href="index.php" class="back-btn">Kembali ke Data Barang</a>

    <!-- Script JavaScript untuk menghitung total secara otomatis -->
    <script>
        function hitungTotal() {
            var harga = document.getElementById("harga").value;
            var persediaan = document.getElementById("persediaan").value;
            var jumlah = persediaan * harga;
            document.getElementById("jumlah").value = jumlah;
        }
    </script>
</body>
</html>

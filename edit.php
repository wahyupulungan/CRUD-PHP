<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Barang</title>
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
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type=submit], button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type=submit]:hover, button:hover {
            background-color: #45a049;
        }
        .error-msg {
            background-color: #f44336;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .btn-cancel {
            background-color: #f44336;
        }
        .btn-cancel:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <h2>Edit Data Barang</h2>
    
    <!-- PHP untuk mengambil data dari database -->
    <?php
    include 'koneksi.php';

    $notif = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Ambil data dari form
        $id_barang = $_POST["id_barang"];
        $nama_barang = $_POST["nama_barang"];
        $persediaan = $_POST["persediaan"];
        $harga = $_POST["harga"];
        $jumlah = $_POST["jumlah"];

        // Query untuk update data barang
        $update_sql = "UPDATE barang SET nama_barang = ?, persediaan = ?, harga = ?, jumlah = ? WHERE id_barang = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("siiis", $nama_barang, $persediaan, $harga, $jumlah, $id_barang);

        if ($stmt->execute()) {
            // Redirect kembali ke index.php setelah berhasil update
            header('Location: index.php');
            exit;
        } else {
            // Jika terjadi error saat update
            $notif = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Ambil data barang berdasarkan ID yang diterima dari parameter URL
        if (isset($_GET['id'])) {
            $id_barang = $_GET['id'];

            // Query untuk mengambil data barang berdasarkan ID
            $select_sql = "SELECT id_barang, nama_barang, persediaan, harga, jumlah FROM barang WHERE id_barang = ?";
            $stmt = $conn->prepare($select_sql);
            $stmt->bind_param("s", $id_barang);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
            } else {
                // Redirect jika data tidak ditemukan
                header('Location: index.php');
                exit;
            }

            $stmt->close();
        } else {
            // Redirect jika parameter ID tidak ada
            header('Location: index.php');
            exit;
        }
    }

    $conn->close();
    ?>

    <!-- Menampilkan pesan notifikasi jika ada -->
    <?php if (!empty($notif)): ?>
        <div class="error-msg">
            <?php echo $notif; ?>
        </div>
    <?php endif; ?>

    <!-- Form untuk edit data -->
    <form action="edit.php" method="post">
        <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
        
        <label for="id_barang">ID Barang:</label>
        <input type="text" id="id_barang" name="id_barang" value="<?php echo $data['id_barang']; ?>" disabled><br>

        <label for="nama_barang">Nama Barang:</label>
        <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" required><br>

        <label for="persediaan">Persediaan:</label>
        <input type="number" id="persediaan" name="persediaan" value="<?php echo $data['persediaan']; ?>" required oninput="hitungJumlah()"><br>

        <label for="harga">Harga:</label>
        <input type="number" id="harga" name="harga" value="<?php echo $data['harga']; ?>" required oninput="hitungJumlah()"><br>

        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" value="<?php echo $data['persediaan'] * $data['harga']; ?>" required><br>

        <input type="submit" value="Simpan Perubahan">
    </form>

    <br>
    <a href="index.php"><button class="btn-cancel">Batal</button></a>

    <!-- Script JavaScript untuk menghitung jumlah secara otomatis -->
    <script>
        function hitungJumlah() {
            var persediaan = document.getElementById("persediaan").value;
            var harga = document.getElementById("harga").value;
            var jumlah = persediaan * harga;
            document.getElementById("jumlah").value = jumlah;
        }
    </script>
</body>
</html>

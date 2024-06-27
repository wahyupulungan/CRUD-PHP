<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .action-links a {
            text-decoration: none;
            margin-right: 10px;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border-radius: 3px;
        }
        .action-links a:hover {
            background-color: #0056b3;
        }
        .error-msg {
            background-color: #f44336;
            color: white;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
        }
        .add-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h2>Data Barang</h2>
    
    <!-- Tabel untuk menampilkan data -->
    <table>
        <tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Persediaan</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php
        include 'koneksi.php';

        // Query untuk mengambil data barang
        $sql = "SELECT id_barang, nama_barang, persediaan, harga, jumlah FROM barang";
        $hasil = $conn->query($sql);

        if ($hasil->num_rows > 0) {
            while ($baris = $hasil->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $baris["id_barang"] . '</td>';
                echo '<td>' . $baris["nama_barang"] . '</td>';
                echo '<td>' . $baris["persediaan"] . '</td>';
                echo '<td>Rp ' . number_format($baris["harga"], 0, ",", ".") . '</td>'; // Menampilkan harga dengan satuan "Rp"
                echo '<td>Rp ' . number_format($baris["jumlah"], 0, ",", ".") . '</td>'; // Menampilkan jumlah dengan satuan "Rp"
                echo '<td class="action-links">
                        <a href="edit.php?id=' . $baris["id_barang"] . '">Edit</a>
                        <a href="hapus.php?id=' . $baris["id_barang"] . '">Hapus</a>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">0 hasil</td></tr>';
        }

        $conn->close();
        ?>
    </table>

    <!-- Tombol "Tambah Data" -->
    <br>
    <a href="tambah.php" class="add-btn">Tambah Data</a>
</body>
</html>

<?php 
include 'config.php'; 
?>
<h2>Data Bahan</h2>
<a href="bahan_add.php">+ Tambah Data</a>
<table border="1">
    <tr>
        <th>Nama Bahan</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Stok Min</th>
        <th>Aksi</th>
    </tr>
    <?php
    // Melakukan JOIN dengan tabel kategori_bahan agar nama kategori muncul
    $query = "SELECT bahan.*, kategori_bahan.nama_kategori 
              FROM bahan 
              LEFT JOIN kategori_bahan ON bahan.kategori_id = kategori_bahan.id";
    $result = mysqli_query($koneksi, $query);
    
    while ($d = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$d['nama_bahan']}</td>
            <td>{$d['nama_kategori']}</td>
            <td>{$d['stok_saat_ini']}</td>
            <td>{$d['satuan']}</td>
            <td>{$d['stok_minimum']}</td>
            <td>
                <a href='bahan_edit.php?id={$d['id']}'>Edit</a> | 
                <a href='bahan_delete.php?id={$d['id']}' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>
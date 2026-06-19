<?php

include 'config.php';
include 'header.php'; 
?>

<div class="container">
    <h2>Form Stok Keluar</h2>

    <!-- Notifikasi jika stok tidak mencukupi -->
    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'stok_kurang'): ?>
        <div style="color: red; margin-bottom: 10px;">
            <strong>Gagal!</strong> Jumlah barang yang dikeluarkan melebihi sisa stok yang ada.
        </div>
    <?php endif; ?>

    <!-- Form dikirim ke proses_stok_keluar.php -->
    <form <form action="proses_stok_keluar.php" method="POST">
        <div class="form-group">
            <label for="id_bahan">Pilih Bahan:</label>
            <select name="id_bahan" id="id_bahan" required>
                <option value="">-- Pilih Bahan --</option>
                <?php
                // MENGGUNAKAN KOLOM stok_saat_ini dan satuan
                $query = mysqli_query($koneksi, "SELECT id, nama_bahan, stok_saat_ini, satuan FROM bahan");
                
                if (!$query) {
                    die("<option value=''>Error: " . mysqli_error($koneksi) . "</option>");
                }

                while($data = mysqli_fetch_array($query)) {
                    // Menampilkan stok_saat_ini beserta satuannya (contoh: 500.00 ml)
                    echo "<option value='".$data['id']."'>".$data['nama_bahan']." (Sisa: ".$data['stok_saat_ini']." ".$data['satuan'].")</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group" style="margin-top: 15px;">
            <label for="jumlah_keluar">Jumlah Keluar:</label>
            <input type="number" name="jumlah_keluar" id="jumlah_keluar" min="0.01" step="any" required>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" name="submit">Simpan Data</button>
            <a href="index.php">Batal</a>
        </div>
    </form>
</div>

<?php 
// Memanggil bagian bawah template (Pekerjaan Bembeng)
include 'footer.php'; 
?>
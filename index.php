<?php
/**
 * File: index.php
 * Deskripsi: Halaman Utama / Dashboard Ringkasan Stok
 * Penanggung Jawab: Wildan
 */

// Memanggil file konfigurasi untuk koneksi database
include 'config.php';

// Memanggil header untuk navigasi
include 'header.php';

// Query untuk mengambil data bahan dan kategori
// Menampilkan bahan yang stoknya paling sedikit di urutan teratas
$query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori 
                                 FROM bahan b 
                                 LEFT JOIN kategori_bahan k ON b.kategori_id = k.id 
                                 ORDER BY b.stok_saat_ini ASC");
?>

<div class="container">
    <div class="dashboard-header">
        <h2>Dashboard Inventaris</h2>
        <p>Ringkasan stok bahan baku Kuro.</p>
    </div>

    <!-- Tabel Daftar Bahan -->
    <table class="minimal-table">
        <thead>
            <tr>
                <th>Nama Bahan</th>
                <th>Kategori</th>
                <th>Stok Tersedia</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_array($query)) { 
                    // Logika Status: Menentukan apakah bahan perlu restock atau aman
                    $is_kritis = ($row['stok_saat_ini'] <= $row['stok_minimum']);
                    $status_text = $is_kritis ? "Perlu Restock" : "Aman";
                    $status_class = $is_kritis ? "status-kritis" : "status-aman";
            ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_bahan']) ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= $row['stok_saat_ini'] . ' ' . htmlspecialchars($row['satuan']) ?></td>
                <td><span class="<?= $status_class ?>"><?= $status_text ?></span></td>
            </tr>
            <?php 
                } 
            } else {
                // Pesan jika database masih kosong
                echo "<tr><td colspan='4' style='text-align:center;'>Data bahan belum tersedia. Silakan input bahan baru.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php 
// Memanggil footer untuk menutup tag HTML
include 'footer.php'; 
?>
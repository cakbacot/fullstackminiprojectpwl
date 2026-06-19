<?php
include 'config.php';

// Ambil kategori untuk pilihan dropdown agar lebih dinamis
$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori_bahan");

if (isset($_POST['simpan'])) {
    // Menggunakan prepared statement untuk keamanan
    $stmt = $koneksi->prepare("INSERT INTO bahan (nama_bahan, kategori_id, stok_saat_ini, satuan, stok_minimum) VALUES (?, ?, ?, ?, ?)");
    
    // "sidis" berarti: string, integer, double, string, double
    $stmt->bind_param("sidsd", 
        $_POST['nama_bahan'], 
        $_POST['kategori_id'], 
        $_POST['stok_saat_ini'], 
        $_POST['satuan'], 
        $_POST['stok_minimum']
    );
    
    $stmt->execute();
    header("Location: bahan.php");
    exit;
}
?>

<form method="POST">
    <h3>Tambah Bahan Baru</h3>
    
    <label>Nama Bahan:</label><br>
    <input type="text" name="nama_bahan" required><br><br>

    <label>Kategori:</label><br>
    <select name="kategori_id" required>
        <?php while($kat = mysqli_fetch_assoc($kategori_query)) { ?>
            <option value="<?php echo $kat['id']; ?>"><?php echo $kat['nama_kategori']; ?></option>
        <?php } ?>
    </select><br><br>

    <label>Stok Awal:</label><br>
    <input type="number" step="0.01" name="stok_saat_ini" required><br><br>

    <label>Satuan:</label><br>
    <input type="text" name="satuan" required><br><br>

    <label>Stok Minimum (Peringatan):</label><br>
    <input type="number" step="0.01" name="stok_minimum" required><br><br>

    <button type="submit" name="simpan">Simpan Data</button>
    <a href="bahan.php">Batal</a>
</form>
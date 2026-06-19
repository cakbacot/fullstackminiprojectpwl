<?php
include 'config.php';
$id = $_GET['id'];

if (isset($_POST['update'])) {
    $stmt = $koneksi->prepare("UPDATE bahan SET nama_bahan=?, kategori_id=?, stok_saat_ini=?, satuan=?, stok_minimum=? WHERE id=?");
    $stmt->bind_param("sidsdi", 
        $_POST['nama_bahan'], $_POST['kategori_id'], $_POST['stok_saat_ini'], $_POST['satuan'], $_POST['stok_minimum'], $id);
    $stmt->execute();
    header("Location: bahan.php");
    exit;
}

$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM bahan WHERE id=$id"));
$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori_bahan");
?>

<form method="POST">
    <h3>Edit Bahan</h3>
    <input type="text" name="nama_bahan" value="<?php echo $data['nama_bahan']; ?>" required><br>
    
    <select name="kategori_id" required>
        <?php while($kat = mysqli_fetch_assoc($kategori_query)) { ?>
            <option value="<?php echo $kat['id']; ?>" <?php if($kat['id'] == $data['kategori_id']) echo 'selected'; ?>>
                <?php echo $kat['nama_kategori']; ?>
            </option>
        <?php } ?>
    </select><br>
    
    <input type="number" step="0.01" name="stok_saat_ini" value="<?php echo $data['stok_saat_ini']; ?>" required><br>
    <input type="text" name="satuan" value="<?php echo $data['satuan']; ?>" required><br>
    <input type="number" step="0.01" name="stok_minimum" value="<?php echo $data['stok_minimum']; ?>" required><br>
    
    <button type="submit" name="update">Update Data</button>
    <a href="bahan.php">Batal</a>
</form>
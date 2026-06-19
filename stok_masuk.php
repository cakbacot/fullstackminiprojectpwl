<?php
include 'config.php';
include 'header.php';

// Ambil data bahan untuk dropdown
$query_bahan = mysqli_query($koneksi, "SELECT * FROM bahan");
?>

<div class="container">
    <h2>Catat Stok Masuk</h2>
    <form action="proses_stok_masuk.php" method="POST">
        <div class="form-group">
            <label>Pilih Bahan:</label>
            <select name="bahan_id" required>
                <option value="">-- Pilih Bahan --</option>
                <?php while ($b = mysqli_fetch_array($query_bahan)) { ?>
                    <option value="<?= $b['id'] ?>"><?= $b['nama_bahan'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah Masuk:</label>
            <input type="number" step="0.01" name="jumlah" required placeholder="Contoh: 500.00">
        </div>
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" placeholder="Contoh: Pembelian dari Supplier X"></textarea>
        </div>
        <button type="submit" class="btn-black">Simpan Stok Masuk</button>
    </form>
</div>

<?php include 'footer.php'; ?>
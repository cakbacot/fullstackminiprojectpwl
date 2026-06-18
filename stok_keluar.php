<?php
include 'config.php';
include 'header.php';

// Ambil data bahan untuk dropdown
$query_bahan = mysqli_query($koneksi, "SELECT * FROM bahan");
?>

<div class="container">
    <h2>Catat Penggunaan Bahan (Stok Keluar)</h2>
    <form action="proses_stok_keluar.php" method="POST">
        <div class="form-group">
            <label>Pilih Bahan:</label>
            <select name="bahan_id" required>
                <option value="">-- Pilih Bahan --</option>
                <?php while ($b = mysqli_fetch_array($query_bahan)) { ?>
                    <option value="<?= $b['id'] ?>"><?= $b['nama_bahan'] ?> (Stok: <?= $b['stok_saat_ini'] ?>)</option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Jumlah Keluar:</label>
            <input type="number" step="0.01" name="jumlah" required placeholder="Contoh: 10.50">
        </div>
        <div class="form-group">
            <label>Keterangan:</label>
            <textarea name="keterangan" placeholder="Contoh: Produksi parfum batch 01"></textarea>
        </div>
        <button type="submit" class="btn-black">Simpan Penggunaan</button>
    </form>
</div>

<?php include 'footer.php'; ?>
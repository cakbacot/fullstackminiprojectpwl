<?php
include 'config.php';
include 'header.php';

$kategori_query = mysqli_query($koneksi, "SELECT * FROM kategori_bahan");

if (isset($_POST['simpan'])) {
    $stmt = $koneksi->prepare("INSERT INTO bahan (nama_bahan, kategori_id, stok_saat_ini, satuan, stok_minimum) VALUES (?, ?, ?, ?, ?)");
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

<div class="page-wrapper">

  <!-- Header -->
  <div class="page-header">
    <h2 class="page-title">Tambah <span>Bahan</span> Baru</h2>
  </div>

  <!-- Form card -->
  <div class="form-card">
    <form method="POST">

      <!-- Nama Bahan -->
      <div class="field">
        <label for="nama_bahan">Nama Bahan</label>
        <input type="text" id="nama_bahan" name="nama_bahan"
               placeholder="Contoh: Bibit Parfum Rose" required>
      </div>

      <!-- Kategori -->
      <div class="field">
        <label for="kategori_id">Kategori</label>
        <div class="select-wrap">
          <select id="kategori_id" name="kategori_id" required>
            <option value="" disabled selected>— Pilih kategori —</option>
            <?php while($kat = mysqli_fetch_assoc($kategori_query)) { ?>
              <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['nama_kategori']) ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <hr class="form-divider">

      <!-- Stok & Satuan -->
      <div class="field-row">
        <div class="field">
          <label for="stok_saat_ini">Stok Awal</label>
          <input type="number" id="stok_saat_ini" name="stok_saat_ini"
                 step="0.01" min="0" placeholder="0.00" required>
        </div>
        <div class="field">
          <label for="satuan">Satuan</label>
          <input type="text" id="satuan" name="satuan"
                 placeholder="pcs, kg, liter…" required>
        </div>
      </div>

      <!-- Stok Minimum -->
      <div class="field">
        <label for="stok_minimum">Stok Minimum (Peringatan)</label>
        <input type="number" id="stok_minimum" name="stok_minimum"
               step="0.01" min="0" placeholder="0.00" required>
      </div>

      <!-- Actions -->
      <div class="btn-group">
        <button type="submit" name="simpan" class="btn-primary">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 7l3.5 3.5L11 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Simpan Data
        </button>
        <a href="bahan.php" class="btn-secondary">
          <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2l8 8M10 2l-8 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
          Batal
        </a>
      </div>

    </form>
  </div>

</div>

<?php include 'footer.php'; ?>
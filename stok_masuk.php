<?php
include 'config.php';
include 'header.php';

$query_bahan = mysqli_query($koneksi, "SELECT * FROM bahan");
?>

<div class="page-wrapper">

  <!-- Header -->
  <div class="page-header">
    <h2 class="page-title">Catat Stok <span>Masuk</span></h2>
  </div>

  <!-- Form card -->
  <div class="form-card">
    <form action="proses_stok_masuk.php" method="POST">

      <!-- Pilih Bahan -->
      <div class="field">
        <label for="bahan_id">Pilih Bahan</label>
        <div class="select-wrap">
          <select id="bahan_id" name="bahan_id" required>
            <option value="" disabled selected>— Pilih bahan —</option>
            <?php while ($b = mysqli_fetch_array($query_bahan)) { ?>
              <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nama_bahan']) ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <!-- Jumlah Masuk -->
      <div class="field">
        <label for="jumlah">Jumlah Masuk</label>
        <input type="number" id="jumlah" name="jumlah"
               step="0.01" min="0"
               placeholder="Contoh: 500.00" required>
      </div>

      <!-- Keterangan -->
      <div class="field">
        <label for="keterangan">Keterangan</label>
        <textarea id="keterangan" name="keterangan" rows="3"
                  placeholder="Contoh: Pembelian dari Supplier X"></textarea>
      </div>

      <!-- Actions -->
      <div class="btn-group">
        <button type="submit" class="btn-primary">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 7l3.5 3.5L11 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Simpan Stok Masuk
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
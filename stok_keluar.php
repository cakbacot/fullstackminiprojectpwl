<?php
include 'config.php';
include 'header.php';
?>

<div class="page-wrapper">

  <!-- Header -->
  <div class="page-header">
    <h2 class="page-title">Catat Stok <span>Keluar</span></h2>
  </div>

  <!-- Notifikasi stok kurang -->
  <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'stok_kurang'): ?>
    <div style="
      display:flex; align-items:center; gap:10px;
      background: rgba(241,1,1,.10);
      border: 1px solid #F10101;
      border-radius: 8px;
      padding: 13px 18px;
      margin-bottom: 24px;
      color: #F10101;
      font-size: 0.9rem;
      font-weight: 600;
    ">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink:0;">
        <circle cx="8" cy="8" r="7" stroke="#F10101" stroke-width="1.6"/>
        <path d="M8 5v4M8 11v.5" stroke="#F10101" stroke-width="1.8" stroke-linecap="round"/>
      </svg>
      <span><strong>Gagal!</strong> Jumlah barang yang dikeluarkan melebihi sisa stok yang ada.</span>
    </div>
  <?php endif; ?>

  <!-- Form card -->
  <div class="form-card">
    <form action="proses_stok_keluar.php" method="POST">

      <!-- Pilih Bahan -->
      <div class="field">
        <label for="id_bahan">Pilih Bahan</label>
        <div class="select-wrap">
          <select id="id_bahan" name="id_bahan" required>
            <option value="" disabled selected>— Pilih bahan —</option>
            <?php
              $query = mysqli_query($koneksi, "SELECT id, nama_bahan, stok_saat_ini, satuan FROM bahan");
              if (!$query) {
                echo "<option value=''>Error: " . mysqli_error($koneksi) . "</option>";
              } else {
                while ($data = mysqli_fetch_array($query)) {
                  $label = htmlspecialchars($data['nama_bahan']) . ' (Sisa: ' . $data['stok_saat_ini'] . ' ' . htmlspecialchars($data['satuan']) . ')';
                  echo "<option value='{$data['id']}'>{$label}</option>";
                }
              }
            ?>
          </select>
        </div>
      </div>

      <!-- Jumlah Keluar -->
      <div class="field">
        <label for="jumlah_keluar">Jumlah Keluar</label>
        <input type="number" id="jumlah_keluar" name="jumlah_keluar"
               min="0.01" step="any" placeholder="Contoh: 100.00" required>
      </div>

      <!-- Actions -->
      <div class="btn-group">
        <button type="submit" name="submit" class="btn-primary">
          <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 7l3.5 3.5L11 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Simpan Data
        </button>
        <a href="index.php" class="btn-secondary">
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
<?php 
include 'config.php'; 
include 'header.php';
?>

<div class="page-wrapper">

  <!-- Header -->
  <div class="page-header">
    <h2 class="page-title">Data <span>Bahan</span></h2>
    <a href="bahan_add.php" class="btn-primary">
      <svg width="13" height="13" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.5 1v13M1 7.5h13" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
      </svg>
      Tambah Data
    </a>
  </div>

  <!-- Table -->
  <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Nama Bahan</th>
          <th>Kategori</th>
          <th>Stok</th>
          <th>Satuan</th>
          <th>Stok Min</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $query = "SELECT bahan.*, kategori_bahan.nama_kategori 
                    FROM bahan 
                    LEFT JOIN kategori_bahan ON bahan.kategori_id = kategori_bahan.id";
          $result = mysqli_query($koneksi, $query);
          $rowCount = mysqli_num_rows($result);

          if ($rowCount > 0):
            while ($d = mysqli_fetch_assoc($result)):
        ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($d['nama_bahan']) ?></strong></td>
          <td><span class="badge badge-gold"><?= htmlspecialchars($d['nama_kategori'] ?? '—') ?></span></td>
          <td><span class="num"><?= number_format($d['stok_saat_ini'], 2) ?></span></td>
          <td><span class="badge badge-cream"><?= htmlspecialchars($d['satuan']) ?></span></td>
          <td><span class="num-muted"><?= number_format($d['stok_minimum'], 2) ?></span></td>
          <td>
            <div style="display:flex; gap:8px; align-items:center;">
              <a href="bahan_edit.php?id=<?= $d['id'] ?>" class="btn-secondary" style="padding:6px 14px; font-size:0.78rem;">
                <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.5 1.5l2 2-7 7H1.5v-2l7-7z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
                Edit
              </a>
              <a href="bahan_delete.php?id=<?= $d['id'] ?>" class="btn-danger" style="padding:6px 14px; font-size:0.78rem;"
                 onclick="return confirm('Yakin ingin menghapus bahan ini?')">
                <svg width="11" height="11" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2 3h8M5 3V2h2v1M4 3v6h4V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Hapus
              </a>
            </div>
          </td>
        </tr>
        <?php
            endwhile;
          else:
        ?>
        <tr>
          <td colspan="6" style="text-align:center; padding:56px 24px; color:#a8925a;">
            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:block; margin:0 auto 12px; opacity:.45;">
              <rect x="6" y="10" width="28" height="24" rx="3" stroke="#a8925a" stroke-width="2"/>
              <path d="M14 10V7a1 1 0 011-1h10a1 1 0 011 1v3" stroke="#a8925a" stroke-width="2"/>
              <path d="M14 20h12M14 26h8" stroke="#a8925a" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <p style="margin:0 0 16px; font-size:0.95rem;">Belum ada data bahan.</p>
            <a href="bahan_add.php" class="btn-primary">+ Tambah Bahan Pertama</a>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<?php include 'footer.php'; ?>
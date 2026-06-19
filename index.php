<?php
include 'config.php';
include 'header.php';

// 1. Ambil data untuk Tabel dan Diagram
$query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori 
                                 FROM bahan b 
                                 LEFT JOIN kategori_bahan k ON b.kategori_id = k.id 
                                 ORDER BY b.stok_saat_ini ASC");

// 2. Siapkan array untuk data diagram
$nama_bahan = [];
$stok_bahan = [];

while ($row = mysqli_fetch_array($query)) {
    $nama_bahan[] = $row['nama_bahan'];
    $stok_bahan[] = $row['stok_saat_ini'];
    $data_tabel[] = $row; // Simpan untuk ditampilkan di tabel
}
?>

<div class="container">
    <h2>Dashboard Inventaris Kuro</h2>

    <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <canvas id="stokChart" height="100"></canvas>
    </div>

    <table class="minimal-table">
        <thead>
            <tr><th>Nama Bahan</th><th>Stok</th><th>Status</th></tr>
        </thead>
        <tbody>
            <?php foreach ($data_tabel as $row) { 
                $is_kritis = ($row['stok_saat_ini'] <= $row['stok_minimum']);
            ?>
            <tr>
                <td><?= htmlspecialchars($row['nama_bahan']) ?></td>
                <td><?= $row['stok_saat_ini'] ?> <?= $row['satuan'] ?></td>
                <td><?= $is_kritis ? "<span style='color:red;'>Perlu Restock</span>" : "Aman" ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stokChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_bahan) ?>, // Data dari PHP
            datasets: [{
                label: 'Jumlah Stok (ml/gr)',
                data: <?= json_encode($stok_bahan) ?>, // Data dari PHP
                backgroundColor: 'rgba(0, 0, 0, 0.7)'
            }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });
</script>

<?php include 'footer.php'; ?>
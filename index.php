<?php
include 'config.php';
include 'header.php';

$query = mysqli_query($koneksi, "SELECT b.*, k.nama_kategori 
                                 FROM bahan b 
                                 LEFT JOIN kategori_bahan k ON b.kategori_id = k.id 
                                 ORDER BY b.stok_saat_ini ASC");

$nama_bahan = [];
$stok_bahan = [];
$data_tabel = []; 

while ($row = mysqli_fetch_array($query)) {
    $nama_bahan[] = $row['nama_bahan'];
    $stok_bahan[] = $row['stok_saat_ini'];
    $data_tabel[] = $row; 
}

$query_riwayat = mysqli_query($koneksi, "SELECT r.*, b.nama_bahan, b.satuan 
                                         FROM riwayat_stok r 
                                         LEFT JOIN bahan b ON r.bahan_id = b.id 
                                         ORDER BY r.tanggal DESC LIMIT 7");
?>

<div class="container mt-4 mb-5">
    <h2 class="fw-bold mb-4 text-dark">📊 Dashboard Inventaris Kuro</h2>

    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-4" style="position: relative; height:300px;">
            <canvas id="stokChart"></canvas>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white pt-4 border-0">
                    <h5 class="fw-bold mb-0 text-dark">📦 Status Stok Bahan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th class="text-start py-3 ps-3">Nama Bahan</th>
                                    <th class="py-3">Stok</th>
                                    <th class="py-3 pe-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <?php 
                                if (!empty($data_tabel)) {
                                    foreach ($data_tabel as $row) { 
                                        $is_kritis = ($row['stok_saat_ini'] <= $row['stok_minimum']);
                                        $badge_status = $is_kritis ? 
                                            '<span class="badge text-white" style="background-color: #ff0707;">Perlu Restock</span>' : 
                                            '<span class="badge bg-success-subtle text-success border border-success">Aman</span>';
                                ?>
                                <tr>
                                    <td class="text-start fw-semibold py-3 ps-3"><?= htmlspecialchars($row['nama_bahan']) ?></td>
                                    <td class="py-3"><?= $row['stok_saat_ini'] ?> <small class="text-muted"><?= htmlspecialchars($row['satuan']) ?></small></td>
                                    <td class="py-3 pe-3"><?= $badge_status ?></td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='3' class='text-center py-4 text-muted'>Belum ada data bahan.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-white pt-4 border-0">
                    <h5 class="fw-bold mb-0 text-dark">⏱️ Riwayat Transaksi Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center mb-0">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th class="py-3">Waktu</th>
                                    <th class="text-start py-3">Bahan</th>
                                    <th class="py-3">Tipe</th>
                                    <th class="py-3 pe-3">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                <?php 
                                if (mysqli_num_rows($query_riwayat) > 0) {
                                    while ($r = mysqli_fetch_assoc($query_riwayat)) {
                                        $tgl = date('d M H:i', strtotime($r['tanggal']));
                                        
                                        if ($r['tipe'] == 'Masuk') {
                                            $badge_tipe = '<span class="badge bg-success text-white px-2 py-1">Masuk</span>';
                                            $jumlah_style = 'text-success fw-bold';
                                            $simbol = '+';
                                        } else {
                                            $badge_tipe = '<span class="badge bg-danger text-white px-2 py-1">Keluar</span>';
                                            $jumlah_style = 'text-danger fw-bold';
                                            $simbol = '-';
                                        }
                                        
                                        $nama_b = $r['nama_bahan'] ? htmlspecialchars($r['nama_bahan']) : '<i class="text-muted">Bahan dihapus</i>';
                                        $satuan_b = $r['satuan'] ? htmlspecialchars($r['satuan']) : '';
                                ?>
                                <tr>
                                    <td class="py-3"><small class="text-muted"><?= $tgl ?></small></td>
                                    <td class="text-start fw-semibold py-3"><?= $nama_b ?></td>
                                    <td class="py-3"><?= $badge_tipe ?></td>
                                    <td class="py-3 pe-3 <?= $jumlah_style ?>"><?= $simbol ?> <?= $r['jumlah'] ?> <small class="text-muted fw-normal"><?= $satuan_b ?></small></td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='4' class='text-center py-5 text-muted'>Belum ada transaksi terekam.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('stokChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($nama_bahan) ?>,
            datasets: [{
                label: 'Jumlah Stok (ml/gr)',
                data: <?= json_encode($stok_bahan) ?>,
                backgroundColor: '#fac23e',
                borderColor: '#fac23e',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            hover: {
                mode: null 
            },
            plugins: {
                tooltip: {
                    enabled: false 
                },
                legend: {
                    labels: { color: '#FDFCF7' }
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true,
                    ticks: { color: '#FDFCF7' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' }
                },
                x: {
                    ticks: { color: '#FDFCF7' },
                    grid: { display: false }
                }
            } 
        }
    });
</script>

<?php include 'footer.php'; ?>
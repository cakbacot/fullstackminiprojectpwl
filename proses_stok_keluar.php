<?php
include 'config.php';

if(isset($_POST['submit'])){
    $id_bahan = $_POST['id_bahan'];
    $jumlah_keluar = $_POST['jumlah_keluar'];
    
    // Opsional: Jika form stok_keluar.php kamu memiliki input keterangan
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : 'Stok Keluar';

    // 1. Cek stok saat ini
    $stmt_cek = $koneksi->prepare("SELECT stok_saat_ini FROM bahan WHERE id = ?");
    $stmt_cek->bind_param("i", $id_bahan);
    $stmt_cek->execute();
    $result = $stmt_cek->get_result();
    $data_stok = $result->fetch_assoc();
    
    $stok_sekarang = $data_stok['stok_saat_ini'];

    // 2. Validasi stok
    if($stok_sekarang >= $jumlah_keluar) {
        
        // 3. Update (kurangi) stok_saat_ini
        $stmt_update = $koneksi->prepare("UPDATE bahan SET stok_saat_ini = stok_saat_ini - ? WHERE id = ?");
        // "di" berarti Double (jumlah desimal) dan Integer (id)
        $stmt_update->bind_param("di", $jumlah_keluar, $id_bahan);
        $update_berhasil = $stmt_update->execute();

        // 4. Catat ke tabel riwayat_stok
        $tipe = 'Keluar';
        
        // Menggunakan NOW() agar jam, menit, dan detik ikut tersimpan presisi di database
        $stmt_riwayat = $koneksi->prepare("INSERT INTO riwayat_stok (bahan_id, tipe, jumlah, keterangan, tanggal) VALUES (?, ?, ?, ?, NOW())");
        $stmt_riwayat->bind_param("isds", $id_bahan, $tipe, $jumlah_keluar, $keterangan);
        $riwayat_berhasil = $stmt_riwayat->execute();

        if($update_berhasil && $riwayat_berhasil) {
            header("Location: index.php?pesan=sukses_keluar");
            exit;
        } else {
            echo "Error Database: " . $koneksi->error;
        }

    } else {
        // Jika stok tidak cukup
        header("Location: stok_keluar.php?pesan=stok_kurang");
        exit;
    }
} else {
    // Jika diakses langsung tanpa tombol submit
    header("Location: stok_keluar.php");
    exit;
}
?>
<?php
require 'functions.php';

if(isset($_POST['btn-confirm'])){
    global $conn;
    $id_transaksi = $_POST['id_transaksi'];
    $metode = $_POST['metode'];
    $btn = $_POST['btn-confirm'];
    $jumlah = $_POST['jumlah'];
    $stok = $_POST ['stok'];
    $stokUpdate = $stok- $jumlah;
    $id_produk = $_POST['id_produk'];

    //KALAU ABIS
    if($stok == $jumlah){
        $query ="INSERT INTO pembayaran(id_transaksi,metode_pembayaran) VALUES('$id_transaksi','$metode');";
        $query .= "UPDATE produk SET stok = '$stokUpdate' WHERE id_produk = '$id_produk';";
        $query .= "UPDATE produk SET status_produk = 'Sold out' WHERE id_produk = '$id_produk';";
        $result = mysqli_multi_query($conn,$query);
        if(mysqli_affected_rows($conn)>0){
            echo "
            <script> 
            alert('Barang berhasil dipesan');
            document.location.href = '../pemesanan.php';
            </script>";
            exit;
        } else {
            echo mysqli_error($conn);
            exit;
        }
    }

    //KALAU STOK TIDAK CUKUP
    if($stokUpdate < 0){
        echo "
        <script> 
        alert('Stok barang sedang tidak ready');
        document.location.href = '../keranjang.php';
        </script>";
        exit;
    }

    // KALAU STOK ADA
    if($stokUpdate > 0) {
        $query ="INSERT INTO pembayaran(id_transaksi,metode_pembayaran) VALUES('$id_transaksi','$metode');";
        $query .= "UPDATE produk SET stok = '$stokUpdate' WHERE id_produk = '$id_produk'";
        $result = mysqli_multi_query($conn,$query);
            if(mysqli_affected_rows($conn)>0){
                echo "
                <script> 
                alert('Barang berhasil dipesan');
                document.location.href = '../pemesanan.php';
                </script>";
                exit;
            } else {
                echo mysqli_error($conn);
                exit;
            }
    }
}
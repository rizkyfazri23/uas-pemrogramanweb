<?php
include 'koneksi.php';

// Fungsi untuk menyimpan data buku tamu ke database
function simpanData($nama, $email, $isi) {
    global $con;

    $query = "INSERT INTO buku_tamu (NAMA, EMAIL, ISI) VALUES ('$nama', '$email', '$isi')";
    if (mysqli_query($con, $query)) {
        return true;
    } else {
        echo "Data gagal disimpan: " . mysqli_error($con);
        return false;
    }
}

function getDataBukuTamu() {
    global $con;
    $query = "SELECT * FROM buku_tamu ORDER BY ID_BT DESC";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $isi = $_POST['isi'];

    if (simpanData($nama, $email, $isi)) {
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Buku Tamu</title>
</head>
<body>
    <h2>Buku Tamu</h2>
    <form method="post" action="index.php">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="isi">Isi Pesan:</label>
        <textarea id="isi" name="isi" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
    
    <h3>Daftar Buku Tamu</h3>
    <?php
    $dataBukuTamu = getDataBukuTamu();
    foreach ($dataBukuTamu as $data) {
        echo "<p><b>Nama:</b> " . $data['NAMA'] . "</p>";
        echo "<p><b>Email:</b> " . $data['EMAIL'] . "</p>";
        echo "<p><b>Isi Pesan:</b> " . $data['ISI'] . "</p>";
        echo "<hr>";
    }
    ?>
</body>
</html>

<?php
mysqli_close($con);
?>

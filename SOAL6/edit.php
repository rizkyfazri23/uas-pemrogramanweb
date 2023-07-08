<?php
include 'koneksi.php';

function getSiswaById($id) {
    global $con;

    $query = "SELECT * FROM siswa WHERE ID_SISWA = '$id'";
    $result = mysqli_query($con, $query);
    $siswa = mysqli_fetch_assoc($result);

    return $siswa;
}

function updateSiswa($id, $nis, $nama, $jenisKelamin, $telepon, $alamat, $foto) {
    global $con;

    $query = "UPDATE siswa SET NIS = '$nis', NAMA = '$nama', JENIS_KELAMIN = '$jenisKelamin', TELEPON = '$telepon', ALAMAT = '$alamat', FOTO = '$foto' WHERE ID_SISWA = '$id'";
    $result = mysqli_query($con, $query);

    return $result;
}

$idSiswa = $_GET['id'];

$siswa = getSiswaById($idSiswa);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $jenisKelamin = $_POST['jeniskelamin'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $foto = $_FILES['foto']['name'];
    $tempFoto = $_FILES['foto']['tmp_name'];

    // Upload foto ke folder
    move_uploaded_file($tempFoto, 'uploads/' . $foto);

    // Panggil fungsi updateSiswa
    updateSiswa($idSiswa, $nis, $nama, $jenisKelamin, $telepon, $alamat, $foto);

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa</title>
</head>
<body>
    <h2>Edit Siswa</h2>

    <!-- Form Edit Siswa -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $idSiswa; ?>" enctype="multipart/form-data">
        <div>
            <label for="nis">NIS:</label>
            <input type="text" id="nis" name="nis" value="<?php echo $siswa['NIS']; ?>" required>
        </div>
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $siswa['NAMA']; ?>" required>
        </div>
        <div>
            <label>Jenis Kelamin:</label>
            <label><input type="radio" name="jeniskelamin" value="Laki-Laki" <?php if ($siswa['JENIS_KELAMIN'] === 'Laki-Laki') echo 'checked'; ?> required> Laki-laki</label>
            <label><input type="radio" name="jeniskelamin" value="Perempuan" <?php if ($siswa['JENIS_KELAMIN'] === 'Perempuan') echo 'checked'; ?> required> Perempuan</label>
        </div>
        <div>
            <label for="telepon">Telepon:</label>
            <input type="text" id="telepon" name="telepon" value="<?php echo $siswa['TELEPON']; ?>" required>
        </div>
        <div>
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required><?php echo $siswa['ALAMAT']; ?></textarea>
        </div>
        <div>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto">
        </div>
        <div>
            <button type="submit" name="edit">Edit</button>
        </div>
    </form>
</body>
</html>

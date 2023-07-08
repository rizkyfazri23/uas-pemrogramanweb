<?php
// Include file koneksi.php untuk melakukan koneksi database
include 'koneksi.php';

// Function untuk menyimpan data siswa ke database
function tambahSiswa($nis, $nama, $jenisKelamin, $telepon, $alamat, $foto) {
    global $con;

    $query = "INSERT INTO siswa (NIS, NAMA, JENIS_KELAMIN, TELEPON, ALAMAT, FOTO) VALUES ('$nis', '$nama', '$jenisKelamin', '$telepon', '$alamat', '$foto')";
    $result = mysqli_query($con, $query);

    return $result;
}

// Function untuk mengambil data siswa dari database
function getDataSiswa() {
    global $con;

    $query = "SELECT * FROM siswa";
    $result = mysqli_query($con, $query);

    $dataSiswa = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dataSiswa[] = $row;
    }

    return $dataSiswa;
}

// Function untuk menghapus data siswa dari database
function hapusSiswa($id) {
    global $con;

    $query = "DELETE FROM siswa WHERE ID_SISWA = '$id'";
    $result = mysqli_query($con, $query);

    return $result;
}

// Function untuk mengupdate data siswa ke database
function updateSiswa($id, $nis, $nama, $jenisKelamin, $telepon, $alamat, $foto) {
    global $con;

    $query = "UPDATE siswa SET NIS = '$nis', NAMA = '$nama', JENIS_KELAMIN = '$jenisKelamin', TELEPON = '$telepon', ALAMAT = '$alamat', FOTO = '$foto' WHERE ID_SISWA = '$id'";
    $result = mysqli_query($con, $query);

    return $result;
}

// Menyimpan data saat form tambah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $jenisKelamin = $_POST['jeniskelamin'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    $foto = $_FILES['foto']['name'];
    $tempFoto = $_FILES['foto']['tmp_name'];

    // Upload foto ke folder
    move_uploaded_file($tempFoto, 'uploads/' . $foto);

    // Panggil fungsi tambahSiswa
    tambahSiswa($nis, $nama, $jenisKelamin, $telepon, $alamat, $foto);

    header("Location: index.php");
    exit();
}

// Menghapus data saat tombol hapus diklik
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hapus'])) {
    $idSiswa = $_GET['hapus'];

    // Panggil fungsi hapusSiswa
    hapusSiswa($idSiswa);

    header("Location: index.php");
    exit();
}

// Mengambil data siswa dari database
$dataSiswa = getDataSiswa();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Siswa</title>
</head>
<body>
    <h2>CRUD Siswa</h2>

    <!-- Form Tambah Siswa -->
    <h3>Tambah Siswa</h3>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <div>
            <label for="nis">NIS:</label>
            <input type="text" id="nis" name="nis" required>
        </div>
        <div>
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div>
            <label>Jenis Kelamin:</label>
            <label><input type="radio" name="jeniskelamin" value="Laki-Laki" required> Laki-laki</label>
            <label><input type="radio" name="jeniskelamin" value="Perempuan" required> Perempuan</label>
        </div>
        <div>
            <label for="telepon">Telepon:</label>
            <input type="text" id="telepon" name="telepon" required>
        </div>
        <div>
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required></textarea>
        </div>
        <div>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" required>
        </div>
        <div>
            <button type="submit" name="tambah">Tambah</button>
        </div>
    </form>

    <!-- Daftar Siswa -->
    <h3>Daftar Siswa</h3>
    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataSiswa as $siswa) : ?>
                <tr>
                    <td><?php echo $siswa['NIS']; ?></td>
                    <td><?php echo $siswa['NAMA']; ?></td>
                    <td><?php echo $siswa['JENIS_KELAMIN']; ?></td>
                    <td><?php echo $siswa['TELEPON']; ?></td>
                    <td><?php echo $siswa['ALAMAT']; ?></td>
                    <td><img src="uploads/<?php echo $siswa['FOTO']; ?>" width="50"></td>
                    <td>
                        <a href="edit.php?id=<?php echo $siswa['ID_SISWA']; ?>">Edit</a>
                        <a href="index.php?hapus=<?php echo $siswa['ID_SISWA']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

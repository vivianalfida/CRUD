<!DOCTYPE html>
<html>

<head>
    <title>CRUD Data Barang</title>
</head>

<body>

    <?php
    $host       = "localhost";
    $user       = "root";
    $pass       = "vivianalfida";
    $db         = "crud";

    $koneksi    = mysqli_connect($host, $user, $pass, $db);
    if (!$koneksi) {
        die("Tidak dapat terkoneksi");
    }
    // --- Tambah data
    function tambah($koneksi)
    {

        if (isset($_POST['btn_simpan'])) {
            $id_barang = time();
            $nama_barang= $_POST['nama_barang'];
            $harga_barang = $_POST['harga_barang'];
            $stok_barang= $_POST['stok_barang'];

            if (!empty($nama_barang) && !empty($harga_barang) && !empty($stok_barang)) {
                $sql = "INSERT INTO barang (id_barang, nama_barang, harga_barang, stok_barang) VALUES(" . $id_barang . ",'" . $nama_barang . "','" . $harga_barang . "','" . $stok_barang . "')";
                $simpan = mysqli_query($koneksi, $sql);
                if ($simpan && isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'create') {
                        header('location: crud.php');
                    }
                }
            } else {
                $pesan = "Data tidak dapat disimpan karena data belum lengkap!";
            }
        }
    ?>
        <form action="" method="POST">
            <fieldset>
                <legend>
                    <h2>Tambah data</h2>
                </legend>
                <label>Nama Barang<input type="text" name="nama_barang" /></label> <br>
                <label>Harga Barang <input type="text" name="harga_barang" /></label><br>
                <label>Stok Barang <input type="number" name="stok_barang" /></label> <br>
                <br>
                <label>
                    <input type="submit" name="btn_simpan" value="Simpan" />
                    <input type="reset" name="reset" value="Besihkan" />
                </label>
                <br>
                <p><?php echo isset($pesan) ? $pesan : "" ?></p>
            </fieldset>
        </form>
        <?php
    }

    // --- Lihat Data
    function tampil_data($koneksi)
    {
        $sql = "SELECT * FROM barang";
        $query = mysqli_query($koneksi, $sql);

        echo "<fieldset>";
        echo "<legend><h2>Data Barang</h2></legend>";

        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
            <th>ID Barang</th>
            <th>Nama Barang</th>
            <th>Harga Barang</th>
            <th>Stok Barang</th>
            <th>Action</th>
          </tr>";

        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $data['id_barang']; ?></td>
                <td><?php echo $data['nama_barang']; ?></td>
                <td><?php echo $data['harga_barang']; ?></td>
                <td><?php echo $data['stok_barang']; ?></td>
                <td>
                    <a href="crud.php?aksi=update&id_barang=<?php echo $data['id_barang']; ?>&nama_barang=<?php echo $data['nama_barang']; ?>&harga_barang=<?php echo $data['harga_barang']; ?>&stok_barang=<?php echo $data['stok_barang'];?>">Ubah</a> |
                    <a href="crud.php?aksi=delete&id_barang=<?php echo $data['id_barang']; ?>">Hapus</a>
                </td>
            </tr>
        <?php
        }
        echo "</table>";
        echo "</fieldset>";
    }

    // --- Update data
    function ubah($koneksi)
    {
        // ubah data
        if (isset($_POST['btn_ubah'])) {
            $id_barang= $_POST['id_barang'];
            $nama_barang = $_POST['nama_barang'];
            $harga_barang = $_POST['harga_barang'];
            $stok_barang = $_POST['stok_barang'];

            if (!empty($nama_barang) && !empty($harga_barang) && !empty($stok_barang)) {
                $perubahan = "nama_barang='" . $nama_barang . "',harga_barang =" . $harga_barang . ",stok_barang=" . $stok_barang . "'";
                $sql_update = "UPDATE barang SET " . $perubahan . " WHERE id_barang =$id_barang";
                $update = mysqli_query($koneksi, $sql_update);
                if ($update && isset($_GET['aksi'])) {
                    if ($_GET['aksi'] == 'update') {
                        header('location: crud.php');
                    }
                }
            } else {
                $pesan = "Data yang anda masukkan tidak lengkap!";
            }
        }

        // tampilkan form ubah
        if (isset($_GET['id_barang'])) {
        ?>
            <a href="crud.php"> &laquo; Home</a> |
            <a href="crud.php?aksi=create"> (+) Tambah Data</a>
            <hr>

            <form action="" method="POST">
                <fieldset>
                    <legend>
                        <h2>Ubah data</h2>
                    </legend>
                    <input type="hidden" name="id_barang" value="<?php echo $_GET['id_barang'] ?>" />
                    <label>Nama Barang <input type="text" name="nama_barang" value="<?php echo $_GET['nama_barang'] ?>" /></label> <br>
                    <label>Harga Barang <input type="number" name="harga_barang" value="<?php echo $_GET['harga_barang'] ?>" /></label><br>
                    <label>Stok Barang <input type="number" name="stok_barang" value="<?php echo $_GET['stok_barang'] ?>" /></label> <br>
                    <br>
                    <label>
                        <input type="submit" name="btn_ubah" value="Simpan Perubahan" /> atau <a href="crud.php?aksi=delete&id_barang=<?php echo $_GET['id_barang'] ?>"> (x) Hapus data ini</a>!
                    </label>
                    <br>
                    <p><?php echo isset($pesan) ? $pesan : "" ?></p>

                </fieldset>
            </form>
    <?php
        }
    }

    // --- Fungsi Delete
    function hapus($koneksi)
    {
        if (isset($_GET['id_barang']) && isset($_GET['aksi'])) {
            $id_barang = $_GET['id_barang'];
            $sql_hapus = "DELETE FROM barang WHERE id_barang=" . $id_barang;
            $hapus = mysqli_query($koneksi, $sql_hapus);

            if ($hapus) {
                if ($_GET['aksi'] == 'delete') {
                    header('location: crud.php');
                }
            }
        }
    }

    // ===================================================================
    if (isset($_GET['aksi'])) {
        switch ($_GET['aksi']) {
            case "create":
                echo '<a href="crud.php"> &laquo; Home</a>';
                tambah($koneksi);
                break;
            case "read":
                tampil_data($koneksi);
                break;
            case "update":
                ubah($koneksi);
                tampil_data($koneksi);
                break;
            case "delete":
                hapus($koneksi);
                break;
            default:
                echo "<h3>Aksi <i>" . $_GET['aksi'] . "</i> tidak ada!</h3>";
                tambah($koneksi);
                tampil_data($koneksi);
        }
    } else {
        tambah($koneksi);
        tampil_data($koneksi);
    }
    ?>
</body>

</html>
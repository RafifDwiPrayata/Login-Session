<?php
session_start(); 

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

function ambil_data()
{
    $nama_file = 'database.text';
    $akses_file_tambah = fopen($nama_file, 'r');
    $ambil_Data = fgets($akses_file_tambah);
    $data_to_array = unserialize($ambil_Data);
    fclose($akses_file_tambah);
    return $data_to_array;
}

function tambah_data($nama)
{
    $nama_file = 'database.text';
    $akses_file_tambah = fopen($nama_file, 'r');
    $ambil_Data = fgets($akses_file_tambah);
    fclose($akses_file_tambah);

    $data_to_array = unserialize($ambil_Data);
    $data_to_array[] = $nama;
    $data_serial_baru = serialize($data_to_array);
    $akses_file_tambah = fopen($nama_file, 'w');
    fwrite($akses_file_tambah, $data_serial_baru);
    fclose($akses_file_tambah);
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (isset($_POST['nama'])) {
    tambah_data($_POST['nama']);
    header('Location:dashboard.php');
    exit();
}
$data_tersimpan = ambil_data();

echo "Selamat datang, " . htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
        }
        form {
            margin: 20px 0;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
            box-sizing: border-box;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background: #f4f4f4;
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat datang di dashboard</h2>
        <p>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>, Kamu telah login</p>
        
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>

        <h2>Input Nama</h2>
        <form method="POST" action="">
            <input type="text" name="nama" required placeholder="Masukkan Nama">
            <button type="submit">Tambah</button>
        </form>

        <h3>Data Nama yang Tersimpan:</h3>
        <ul>
            <?php
            if (!empty($data_tersimpan)) {
                foreach ($data_tersimpan as $data) {
                    echo "<li>" . htmlspecialchars($data) . "</li>";
                }
            } else {
                echo "<li>Belum ada data nama</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>

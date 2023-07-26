<!DOCTYPE html>
<html>
<head>
<title>Tampilan Data Pegawai</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    /* CSS untuk tampilan */
    body {
      font-family: 'Times New Roman', Times, serif;
      background-color: #f2f2f2;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
    }

    form {
      margin-bottom: 20px;
    }
    

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      background-color: #f8f9fa; /* Set the table background color */
    }

    th, td {
     padding: 8px;
      border: 1px solid #ddd;
      width: 33.33%; /* Divide the table width equally among columns */
      word-wrap: break-word; 
    }

    tr:hover {background-color: #FFA500;}

    .error-message {
      color: red;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Data Pegawai</h2>
    <form method="POST" action="">
      <label for="nip">Masukkan NIP:</label>
      <input type="text" id="nip" name="nip">
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dbpegawai";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Mengecek apakah form sudah disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nip'])) {
      $nip = $_POST['nip'];

      // Query untuk mendapatkan data pegawai berdasarkan NIP
      $sql = "SELECT * FROM tblpegawai WHERE NIP = '$nip'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Menampilkan data pegawai
        echo "<h3>Hasil Pencarian Data Pegawai:</h3>";
        echo "<table>";
        echo "<tr><th>NIP</th><th>Nama</th><th>Alamat</th><th>Tanggal Lahir</th><th>Kode Divisi</th></tr>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['NIP']."</td><td>".$row['Nama']."</td><td>".$row['Alamat']."</td><td>".$row['Tanggal_lahir']."</td><td>".$row['Kode_divisi']."</td></tr>";
        }

        echo "</table>";

        // Tombol untuk mencetak ke Excel
        echo "<form method='POST' action='export_excel.php'>";
        echo "<input type='hidden' name='nip' value='".$nip."'>";
        echo "<button type='submit'>Export ke Excel</button>";
        echo "</form>";

         // Tombol untuk mencetak ke PDF
         echo "<form method='POST' action='export_pdf_divisi.php'>";
         echo "<input type='hidden' name='nip' value='".$nip."'>";
         echo "<button type='submit'>Export ke PDF</button>";
         echo "</form>";

      } else {
        echo "<p class='error-message'>Data pegawai tidak ditemukan.</p>";
      }
    }
    ?>

<h2>Data Presensi Pegawai</h2>
    <form method="POST" action="">
      <label for="tanggal">Pilih Tanggal:</label>
      <input type="date" id="tanggal" name="tanggal">
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <?php
    // Mengecek apakah form sudah disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tanggal'])) {
      $tanggal = $_POST['tanggal'];

      // Query untuk mendapatkan data presensi pegawai berdasarkan tanggal
      $sql = "SELECT * FROM tblpresensi WHERE Tanggal = '$tanggal'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Menampilkan data presensi pegawai
        echo "<h3>Data Presensi Pegawai:</h3>";
        echo "<table>";
        echo "<tr><th>Tanggal</th><th>NIP</th><th>Jam Masuk</th><th>Jam Pulang</th></tr>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['Tanggal']."</td><td>".$row['NIP']."</td><td>".$row['Jam_masuk']."</td><td>".$row['Jam_pulang']."</td></tr>";
        }

        echo "</table>";

        // Tombol untuk mencetak ke Excel
        echo "<form method='POST' action='export_excel_presensi.php'>";
        echo "<input type='hidden' name='tanggal' value='".$tanggal."'>";
        echo "<button type='submit'>Export ke Excel</button>";
        echo "</form>";

         // Tombol untuk mencetak ke PDF
         echo "<form method='POST' action='export_pdf_divisi.php'>";
         echo "<input type='hidden' name='tanggal' value='".$tanggal."'>";
         echo "<button type='submit'>Export ke PDF</button>";
         echo "</form>";

      } else {
        echo "<p class='error-message'>Data presensi pegawai tidak ditemukan pada tanggal tersebut.</p>";
      }
    }
    ?>

    <h2>Data Pegawai per Divisi</h2>
    <form method="POST" action="">
      <label for="divisi">Pilih Divisi:</label>
      <select id="divisi" name="divisi">
        <option value="">-- Pilih Divisi --</option>
        <option value="S1">Gudang</option>
        <option value="S2">Produksi</option>
        <option value="S3">HRD</option>
      </select>
      <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <?php
    // Mengecek apakah form sudah disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['divisi'])) {
      $kodeDivisi = $_POST['divisi'];

      // Query untuk mendapatkan data pegawai berdasarkan divisi
      $sql = "SELECT * FROM tblpegawai WHERE Kode_Divisi = '$kodeDivisi'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Menampilkan data pegawai per divisi
        echo "<h3>Data Pegawai per Divisi:</h3>";
        echo "<table>";
        echo "<tr><th>NIP</th><th>Nama</th><th>Alamat</th><th>Tanggal Lahir</th></tr>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>".$row['NIP']."</td><td>".$row['Nama']."</td><td>".$row['Alamat']."</td><td>".$row['Tanggal_lahir']."</td></tr>";
        }

        echo "</table>";

        // Tombol untuk mencetak ke Excel
        echo "<form method='POST' action='export_excel_divisi.php'>";
        echo "<input type='hidden' name='divisi' value='".$kodeDivisi."'>";
        echo "<button type='submit'>Export ke Excel</button>";
        echo "</form>";

        echo "</table>";

        // Tombol untuk mencetak ke PDF
        echo "<form method='POST' action='export_excel_divisi.php'>";
        echo "<input type='hidden' name='divisi' value='".$kodeDivisi."'>";
        echo "<button type='submit'>Export ke PDF</button>";
        echo "</form>";
          
      } else {
        echo "<p class='error-message'>Data pegawai tidak ditemukan pada divisi tersebut.</p>";
      }
    }



    // Menutup koneksi ke database
    $conn->close();
    ?>
  </div>
</body>
</html>
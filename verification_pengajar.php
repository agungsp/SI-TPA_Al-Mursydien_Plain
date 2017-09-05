<?php
//   include 'mysql.php';
  include 'koneksi.php';
  $pengajar_id = $_POST['pengajar_id'];
  $pengajar_name = $_POST['pengajar_name'];
  $pengajar_jabatan = $_POST['pengajar_jabatan'];
  $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar where NAMA_PENGAJAR LIKE '$pengajar_name' AND STATUS_PENGAJAR = 'Aktif'");
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
     <title>Verification of Pengajar</title>
  </head>
  <body>
     <div class=""><!-- Sebelah Kiri -->
        <form class="" action="input_proses.php" method="post">
           <div class="">
              <label for="">ID: </label>
              <input type="text" name="pengajar_id" value="<?php echo $pengajar_id ; ?>" readonly="readonly">
           </div>
           <div class="">
              <label for="">Nama: </label>
              <input type="text" name="pengajar_name" value="<?php echo $pengajar_name ; ?>" readonly="readonly">
           </div>
           <div class="">
              <label for="">Jabatan: </label>
              <input type="text" name="pengajar_jabatan" value="<?php echo $pengajar_jabatan ; ?>" readonly="readonly">
           </div>
           <input type="submit" name="submit_pengajar" value="Submit" autofocus>
           <a href="pengajar_signup.php"><input type="button" value="Cancel"></a>
        </form>
     </div>
     <div class=""><!-- Sebelah Kanan -->
        <p>Data yang mungkin sama...</p>
     <?php
        if (mysqli_num_rows($query) != 0) {
           $data = mysqli_fetch_assoc($query);
           echo '
              <div class="">
                 <label for="">ID: </label>
                 <span>'.$data['ID_PENGAJAR'].'</span>
              </div>
              <div class="">
                 <label for="">Nama: </label>
                 <span>'.$data['NAMA_PENGAJAR'].'</span>
              </div>
              <div class="">
                 <label for="">Jabatan: </label>
                 <span>'.$data['JABATAN'].'</span>
              </div>
              ';
        } else {
           echo '<p><strong>Tidak ada data yang sama</strong></p>';
        }
     ?>
     </div>
  </body>
</html>

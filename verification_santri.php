<?php
//   include 'mysql.php';
  include 'koneksi.php';
  $santri_id = $_POST['santri_id'];
  $santri_name = $_POST['santri_name'];
  $santri_walas = $_POST['santri_walas'];
  $santri_tingkatan = $_POST['santri_tingkatan'];
  $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT santri.ID_SANTRI, santri.NAMA_SANTRI, pengajar.NAMA_PENGAJAR, santri.TINGKATAN FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR where NAMA_SANTRI LIKE '$santri_name' AND STATUS_SANTRI = 'Aktif' ");
  $q = mysqli_query($GLOBALS['___mysqli_ston'], "SELECT NAMA_PENGAJAR FROM pengajar WHERE ID_PENGAJAR = '$santri_walas'");
  $q_result = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
     <title>Verification of Santri</title>
  </head>
  <body>
     <div class=""><!-- Sebelah Kiri -->
        <form class="" action="input_proses.php" method="post">
           <div class="">
              <label for="">ID: </label>
              <input type="text" name="santri_id" value="<?php echo $santri_id; ?>" readonly="readonly">
           </div>
           <div class="">
              <label for="">Nama: </label>
              <input type="text" name="santri_name" value="<?php echo $santri_name; ?>" readonly="readonly">
           </div>
           <div class="">
              <label for="">Walas: </label>
              <input type="text" name="" value="<?php echo $q_result['NAMA_PENGAJAR']; ?>" readonly="readonly">
              <input type="hidden" name="santri_walas" value="<?php echo $santri_walas; ?>">
           </div>
           <div class="">
              <label for="">Tingkatan: </label>
              <input type="text" name="santri_tingkatan" value="<?php echo $santri_tingkatan; ?>" readonly="readonly">
           </div>
           <input type="submit" name="submit_santri" value="Submit" autofocus>
           <a href="santri_signup.php"><input type="button" value="Cancel"></a>
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
                 <span>'.$data['ID_SANTRI'].'</span>
              </div>
              <div class="">
                 <label for="">Nama: </label>
                 <span>'.$data['NAMA_SANTRI'].'</span>
              </div>
              <div>
                 <label for="">Walas: </label>
                 <span>'.$data['NAMA_PENGAJAR'].'</span>
              </div>
              <div class="">
                 <label for="">Tingkatan: </label>
                 <span>'.$data['TINGKATAN'].'</span>
              </div>
              ';
        } else {
           echo '<p><strong>Tidak ada data yang sama</strong></p>';
        }
     ?>
     </div>
  </body>
</html>

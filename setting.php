<?php
   include 'koneksi.php';
   include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Pengaturan - Sistem Informasi TPA Al Mursyidien</title>
      <link rel="stylesheet" href="css/jquery-ui.css" />
   </head>
   <body>
      <a href="#">Potongan Gaji</a><br>
      <a href="setting_user.php">Menejemen User</a><br>
      <a href="setting_batasan.php">Batasan SPP</a><br>
      <a href="setting_aktivitas.php">Menejemen Aktivitas</a><br>
      <!-- RESET SPP -->
      <div class="">
         <form class="" action="setting.php" method="post">
            <div class="">
               <p><strong>PERHATIAN!</strong> Tombol ini akan mereset semua catatan pembayaran santri, hanya yang <strong>telah</strong> mencapai limit</p>
               <button type="submit" name="reset_spp">RESET SPP</button>
            </div>
         </form>
         <?php
            if (isset($_POST['reset_spp'])) {
               $f_limit = fopen("limit_spp.txt","r") or die ("Unable to open file!!");
               $kalimat = fgets($f_limit);
               $kata = explode(" ",$kalimat);
               $limit = penghilangTitik($kata[1]);
               fclose($f_limit);

               $query  = mysqli_query($GLOBALS["___mysqli_ston"],"UPDATE `santri` SET `TOTAL_SPP` = '0' WHERE `santri`.`TOTAL_SPP` = '$limit'");
               header("location: setting.php");
            }
         ?>
      </div>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>

<?php
   include 'koneksi.php';

   $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ID_SANTRI FROM santri");
   $rows = mysqli_num_rows($q) + 1;
   $santri_id = "tpa-sntr$rows";
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Pendaftaran Santri - Sistem Informasi TPA Al Mursyidien</title>
      <link rel="stylesheet" href="css/jquery-ui.css" />
   </head>
   <body>
      <h3>Pendaftaran Santri</h3>
      <form class="" action="verification_santri.php" method="post">
         <div class="">
            <label for="">ID Santri: </label>
            <input type="text" name="santri_id" value="<?php echo $santri_id; ?>" readonly="readonly">
         </div>
         <div class="">
            <label for="">Nama: </label>
            <input type="text" id="santri_name" name="santri_name" autofocus required>
         </div>

         <div class="">
            <label for="">Walas: </label>
            <select class="" name="santri_walas">
               <option selected="selected">--Pilih Walas--</option>
               <?php

                  $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ID_PENGAJAR, NAMA_PENGAJAR FROM pengajar WHERE JABATAN = 'walas' ");
                  if (mysqli_num_rows($query) != 0) {
                     while ($data = mysqli_fetch_assoc($query)) {
                        echo '<option value="'.$data['ID_PENGAJAR'].'">'.$data['NAMA_PENGAJAR'].'</option>';
                     }
                  }

               ?>
            </select>
         </div>
         <div class="">
            <label for="">Tingkatan: </label>
            <select class="" name="santri_tingkatan">
               <option selected="selected">--Pilih Tingkatan--</option>
               <option value="TK Jilid 1">TK Jilid 1</option>
               <option value="TK Jilid 2">TK Jilid 2</option>
               <option value="TK Jilid 3">TK Jilid 3</option>
               <option value="TK Jilid 4">TK Jilid 4</option>
               <option value="TK Jilid 5">TK Jilid 5</option>
               <option value="TK Jilid 6">TK Jilid 6</option>
               <option value="TK Al-Quran">TK Al-Qur'an</option>
               <option value="SD Jilid 1">SD Jilid 1</option>
               <option value="SD Jilid 2">SD Jilid 2</option>
               <option value="SD Jilid 3">SD Jilid 3</option>
               <option value="SD Jilid 3">SD Jilid 3</option>
               <option value="SD Jilid 4">SD Jilid 4</option>
               <option value="SD Jilid 5">SD Jilid 5</option>
               <option value="SD Jilid 6">SD Jilid 6</option>
               <option value="SD Kls 1 Quran">SD Kls 1 Qur'an</option>
               <option value="SD Kls 2 Quran">SD Kls 2 Qur'an</option>
               <option value="SD Kls 3 Quran">SD Kls 3 Qur'an</option>
               <option value="SD Kls 4 Quran">SD Kls 4 Qur'an</option>
               <option value="SD Kls 5 Quran">SD Kls 5 Qur'an</option>
               <option value="SD Kls 6 Quran">SD Kls 6 Qur'an</option>
               <option value="Al-Quran">Al-Qur'an</option>
            </select>
         </div>
         <input type="submit" name="submit_santri" id="submit_santri" value="Submit"/>
      </form>

      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
      <script type="text/javascript">
         $(function(){
            $('#santri_date').val(tanggal());
         });
      </script>
   </body>
</html>

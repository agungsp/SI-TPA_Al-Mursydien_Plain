<?php
   include 'koneksi.php';
   include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <body>
      <!-- POTONGAN -->
      <div class="">
         <div class="">
            <form class="" action="setting_potongan.php" method="post">
               <div class="">
                  <label for="">Potongan: </label>
                  <input type="text" name="potongan">
               </div>
               <div class="">
                  <label for="">Biaya: </label>
                  <input type="text" name="biaya" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
               </div>
               <input type="submit" name="submit_potongan" value="Submit">
            </form>
         </div>
         <?php
            $potongan = NULL;
            $biaya = NULL;
            if (isset($_POST['submit_potongan'])) {
               $potongan = $_POST['potongan'];
               $biaya = $_POST['biaya'];

               $potongan_file = fopen("potongan.txt","a");
               $a = "$potongan $biaya\n";
               fwrite($potongan_file,$a);
               fclose($potongan_file);
               header("location: setting_potongan.php");
            }

            if (isset($_GET['hps'])) {
               $id = $_GET['id'];
               $keep = array();
               $i = 1;
               $f_potongan = fopen("potongan.txt","w+") or die ("Unable to open file!");
               while (!feof($f_potongan)) {
                  $kalimat = fgets($f_potongan);
                  if ($i != $id) {
                     if ($kalimat == true) {
                        $keep = $kalimat;
                     }
                  }
               }
               var_dump($keep);
               foreach ($keep as $simpan) {
                  fwrite($f_potongan,$simpan);
               }
               fclose($f_potongan);
               header("location: setting_potongan.php");
            }
            var_dump($keep);
            var_dump($kalimat);
         ?>
         <table border="1">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Potongan</th>
                  <th>Biaya Potongan</th>
                  <th>Hapus</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  $f_potongan = fopen("potongan.txt","r") or die ("Unable to open file!!");
                  $i = 1;
                  while (!feof($f_potongan)) {
                     $kalimat = fgets($f_potongan);
                     $kata = explode(" ",$kalimat);

                     if ($kalimat == true) {
                        echo '<tr>';
                           echo '<td>'.$i.'</td>';
                           echo '<td>'.$kata[0].'</td>';
                           echo '<td>Rp. '.$kata[1].',-</td>';
                           echo '<td><a href="setting_potongan.php?hps=pot&id='.$i.'">HAPUS</a></td>';
                        echo '</tr>';
                        $i++;
                     }
                  }
                  fclose($f_potongan);
               ?>
            </tbody>
         </table>

      </div>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>

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
      <!-- BATASAN SPP -->
      <div class="">
         <div class="">
            <?php
               $f_limit = fopen("limit_spp.txt","r") or die ("Unable to open file!!");
               $kalimat = fgets($f_limit);
               $kata = explode(" ",$kalimat);
               echo "<p>$kata[0] = Rp. $kata[1],-</p>";
               fclose($f_limit);
            ?>
         </div>
         <div class="">
            <form class="" action="setting_batasan.php" method="post">
               <label for="">Ubah Limit per 6 Bulan</label>
               <input type="text" name="limit" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
               <input type="submit" name="submit_limit" value="Edit">
            </form>
            <?php
               if (isset($_POST['submit_limit'])) {
                  $new_limit = $_POST['limit'];
                  $kalimat = "limit $new_limit";
                  $f_limit = fopen("limit_spp.txt","w") or die ("Unable to open file!!");
                  fwrite($f_limit,$kalimat);
				  fclose($f_limit);
               }
            ?>
         </div>
      </div>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>

<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>log test</title>
   </head>
   <body>
      <form class="" action="cek.php" method="post">
         <input type="submit" name="log" value="Log">
      </form>

      <?php
      include 'format_number.php';
         if (isset($_POST['log'])) {
            $log_file = fopen("log.txt","a");
            $date = tanggal_indo(date("Y-m-d"));
            $time = date("H:i:s");
            $log = "Log File $date $time \n";
            fwrite($log_file,$log);
            fclose($log_file);
         }
         $a = 1;
         $keep = array();
         while ($a <= 10) {
            $keep[$a] = $a;
            $a++;
         }
         echo "$keep";
         var_dump($keep);
      ?>
   </body>
</html>

<?php
//   include 'mysql.php';
  include 'koneksi.php';

  $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar");
  $rows = mysqli_num_rows($q) + 1;
  $pengajar_id = "tpa-pgjr$rows";
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
     <title>Pendaftaran Pengajar - Sistem Informasi TPA Al Mursyidien</title>
     <link rel="stylesheet" href="css/jquery-ui.css" />
  </head>
  <body>
     <h3>Pendaftaran Pengajar</h3>
     <form class="" action="verification_pengajar.php" method="post">
        <div class="">
           <label for="">ID Pengajar: </label>
           <input type="text" id="pengajar_id" name="pengajar_id" value="<?php echo $pengajar_id; ?>" readonly="readonly">
        </div>
        <div class="">
           <label for="">Nama: </label>
           <input type="text" id="pengajar_name" name="pengajar_name" autofocus required>
        </div>
        <div class="">
           <label for="">Jabatan: </label>
           <select class="" name="pengajar_jabatan">
              <option selected="selected">--Pilih Jabatan--</option>
              <option value="P.W">P.W</option>
              <option value="Kepala">Kepala</option>
              <option value="WK">WK</option>
              <option value="Bendahara">Bendahara</option>
              <option value="Walas">Walas</option>
           </select>
        </div>
        <div class="">
           <label for="">Tanggal: </label>
           <input type="text" name="pengajar_date" id="pengajar_date" readonly="readonly">
        </div>
        <input type="submit" name="submit_pengajar" id="submit_pengajar" value="Submit">
     </form>

     <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
     <script type="text/javascript" src="js/jquery-ui.js"></script>
     <script type="text/javascript" src="js/custom.js"></script>
     <script type="text/javascript">
        $(function(){
           $('#pengajar_date').val(tanggal());
        });
     </script>
  </body>
</html>

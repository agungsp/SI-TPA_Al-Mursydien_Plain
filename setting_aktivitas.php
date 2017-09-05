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
      <!-- AKTIVITAS -->
      <div class="">
         <!-- Input Aktivitas -->
         <div class="">
            <form class="" action="input_proses.php" method="post">
               <input type="text" name="aktivitas_name" id="aktivitas_name" placeholder="Nama aktivitas...">
               <input type="text" name="aktivitas_pay" id="aktivitas_pay" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="Honor...">
               <button type="submit" name="submit_aktivitas">Submit</button>
            </form>
         </div>
         <!-- Tabel aktivitas -->
         <div class="">
            <table border="1">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Aktivitas</th>
                     <th>Honor</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM aktivitas");
                     while ($data = mysqli_fetch_assoc($query)) {
                        echo '<tr>';
                           echo '<td>'.$data['ID_AKTIVITAS'].'</td>';
                           echo '<td>'.$data['NAMA_AKTIVITAS'].'</td>';
                           echo '<td>Rp. '.rupiahFormat($data['HONOR_AKTIVITAS']).',-</td>';
                           echo '<td><a href="edit.php?edt=aktivitas&id='.$data['ID_AKTIVITAS'].'&nama='.$data['NAMA_AKTIVITAS'].'&honor='.$data['HONOR_AKTIVITAS'].'">EDIT</a></td>';
                        echo '</tr>';
                     }
                  ?>
               </tbody>
            </table>
         </div>
      </div>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>

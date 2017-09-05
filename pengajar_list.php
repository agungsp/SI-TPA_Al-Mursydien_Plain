<?php
   include 'koneksi.php';
   include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Daftar Pengajar - Sistem Informasi TPA Al Mursyidien</title>
      <link rel="stylesheet" href="css/jquery-ui.css" />
   </head>
   <body>
      <form class="" action="pengajar_list.php" method="post"> <!-- Pencarian berdasarkan nama santri -->
         <input type="text" name="cari_nama" id="cari_nama" placeholder="Cari Nama Pengajar.." autofocus>
         <input type="hidden" name="cari_id" id="cari_id">
         <input type="submit" name="submit_cari_nama" value="Cari">
      </form>
      <form class="" action="pengajar_list.php" method="post"> <!-- Pencarian berdasarkan jabatan -->
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
         <input type="submit" name="submit_cari_jabatan" value="Cari">
      </form>
      <form class="" action="pengajar_list.php" method="post"><!--Pencarian berdasarkan Status -->
         <input type="submit" name="cari_aktif" value="Pengajar Aktif">
      </form>
      <form class="" action="pengajar_list.php" method="post"><!--Pencarian berdasarkan Status -->
         <input type="submit" name="cari_tidak_aktif" value="Pengajar Tidak Aktif">
      </form>
      <form class="" action="pengajar_list.php" method="post">
        <button type="submit" name="all">Semua</button>
     </form>
      <div class="">
         <table border="1">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Tahun Masuk</th>
                  <th>Tunjangan Abdi</th>
                  <th>Tunjangan Jabatan</th>
                  <th>Status</th>
                  <th>Edit</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  if (isset($_POST['submit_cari_nama'])) {
                     $id = $_POST['cari_id'];
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM pengajar WHERE ID_PENGAJAR = '$id' ");
                  }
                  elseif (isset($_POST['submit_cari_jabatan'])) {
                     $jabatan = $_POST['pengajar_jabatan'];
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM pengajar WHERE JABATAN = '$jabatan' ");
                  }
                  elseif (isset($_POST['cari_aktif'])) {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM pengajar WHERE STATUS_PENGAJAR = 'Aktif'");
                  }
                  elseif (isset($_POST['cari_tidak_aktif'])) {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM pengajar WHERE NOT STATUS_PENGAJAR = 'Aktif'");
                  }
                  elseif (isset($_POST['all'])) {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM pengajar");
                  }
                  else {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM pengajar");
                  }

                  if (mysqli_num_rows($query) > 0) {
                     while ($data = mysqli_fetch_assoc($query)) {
                        echo '<tr>';
                           echo '<td>'.$data['ID_PENGAJAR'].'</td>';
                           echo '<td>'.$data['NAMA_PENGAJAR'].'</td>';
                           echo '<td>'.$data['JABATAN'].'</td>';
                           echo '<td>'.$data['TAHUN_MASUK'].'</td>';
                           echo '<td>Rp. '.rupiahFormat($data['HONOR_ABDI']).',-</td>';
                           echo '<td>Rp. '.rupiahFormat($data['HONOR_JABATAN']).',-</td>';
                           echo '<td>'.$data['STATUS_PENGAJAR'].'</td>';
                           echo '<td><a href="edit.php?edt=plist&id='.$data['ID_PENGAJAR'].'&nama='.$data['NAMA_PENGAJAR'].'&habdi='.$data['HONOR_ABDI'].'&hjabatan='.$data['HONOR_JABATAN'].'">EDIT</a></td>';
                        echo '</tr>';
                     }
                  } else {
                     echo '<tr>';
                       echo '<td colspan="8">DATA KOSONG!</td>';
                    echo '</tr>';
                  }
               ?>
            </tbody>
         </table>
      </div>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){
            $("#cari_nama").autocomplete({
               minLength:1,
               source:'absensi_data2.php',
               select:function(event, ui){
                 $('#cari_id').val(ui.item.value);
              }
            });
         });
     </script>
   </body>
</html>

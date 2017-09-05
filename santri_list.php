<?php
   include 'koneksi.php';
   include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Daftar Santri - Sistem Informasi TPA Al Mursyidien</title>
      <link rel="stylesheet" href="css/jquery-ui.css" />
   </head>
   <body>
      <form class="" action="santri_list.php" method="post"> <!-- Pencarian berdasarkan nama santri -->
         <input type="text" name="cari_nama" id="cari_nama" placeholder="Cari Nama Santri.." autofocus>
         <input type="hidden" name="cari_id" id="cari_id">
         <input type="submit" name="submit_cari_nama" value="Cari">
      </form>
      <form class="" action="santri_list.php" method="post"> <!-- Pencarian berdasarkan walas -->
         <select class="" name="cari_pengajar">
            <option selected="selected">--Pilih Walas--</option>
            <?php
               $q = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT ID_PENGAJAR,NAMA_PENGAJAR FROM pengajar ORDER BY NAMA_PENGAJAR");
               while ($data = mysqli_fetch_assoc($q)) {
                  echo '<option value="'.$data['ID_PENGAJAR'].'">'.$data['NAMA_PENGAJAR'].'</option>';
               }
            ?>
         </select>
         <input type="submit" name="submit_cari_pengajar" value="Cari">
      </form>
      <form class="" action="santri_list.php" method="post"> <!-- Pencarian berdasarkan tingkatan -->
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
         <input type="submit" name="submit_cari_tingkatan" value="Cari">
      </form>
      <form class="" action="santri_list.php" method="post"><!--Pencarian berdasarkan LUNAS (Mencapai Limit) -->
         <input type="submit" name="cari_aktif" value="Santri Aktif">
      </form>
      <form class="" action="santri_list.php" method="post"><!--Pencarian berdasarkan BELUM LUNAS (Belum Mencapai Limit) -->
         <input type="submit" name="cari_tidak_aktif" value="Santri Tidak Aktif">
      </form>
      <form class="" action="santri_list.php" method="post">
        <button type="submit" name="all">Semua</button>
     </form>
      <div class="">
         <table border="1">
            <thead>
               <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>Tingkatan</th>
                  <th>Walas</th>
                  <th>Status</th>
                  <th>Edit</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  if (isset($_POST['submit_cari_nama'])) {
                     $id = $_POST['cari_id'];
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR WHERE santri.ID_SANTRI = '$id' ");
                  }
                  elseif (isset($_POST['submit_cari_pengajar'])) {
                     $id = $_POST['cari_pengajar'];
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR WHERE pengajar.ID_PENGAJAR = '$id' ");
                  }
                  elseif (isset($_POST['submit_cari_tingkatan'])) {
                     $tingkatan = $_POST['santri_tingkatan'];
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR WHERE santri.TINGKATAN = '$tingkatan' ");
                  }
                  elseif (isset($_POST['cari_aktif'])) {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR WHERE santri.STATUS_SANTRI = 'Aktif'");
                  }
                  elseif (isset($_POST['cari_tidak_aktif'])) {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR WHERE NOT santri.STATUS_SANTRI = 'Aktif'");
                  }
                  elseif (isset($_POST['all'])) {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR ");
                  }
                  else {
                     $query = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT santri.ID_SANTRI,santri.NAMA_SANTRI,santri.TINGKATAN,pengajar.NAMA_PENGAJAR,santri.STATUS_SANTRI FROM santri INNER JOIN pengajar ON santri.ID_PENGAJAR = pengajar.ID_PENGAJAR ");
                  }

                  if (mysqli_num_rows($query) > 0) {
                     while ($data = mysqli_fetch_assoc($query)) {
                        echo '<tr>';
                           echo '<td>'.$data['ID_SANTRI'].'</td>';
                           echo '<td>'.$data['NAMA_SANTRI'].'</td>';
                           echo '<td>'.$data['TINGKATAN'].'</td>';
                           echo '<td>'.$data['NAMA_PENGAJAR'].'</td>';
                           echo '<td>'.$data['STATUS_SANTRI'].'</td>';
                           echo '<td><a href="edit.php?edt=slist&id='.$data['ID_SANTRI'].'&nama='.$data['NAMA_SANTRI'].'">EDIT</a></td>';
                        echo '</tr>';
                     }

                  } else {
                     echo '<tr>';
                       echo '<td colspan="6">DATA KOSONG!</td>';
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
               source:'spp_report_data.php',
               select:function(event, ui){
                 $('#cari_id').val(ui.item.id);
              }
            });
         });
     </script>
   </body>
</html>

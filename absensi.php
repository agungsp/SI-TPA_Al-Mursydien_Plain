<?php
  include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
     <title>Absensi - Sistem Informasi TPA Al Mursyidien</title>
     <link rel="stylesheet" href="css/jquery-ui.css" />
  </head>
  <body>
     <h3>Absensi</h3>

     <!-- form Absensi -->
     <div class="">
        <form class="" action="input_proses.php" method="post">
           <div class="">
              <label for="">Cari/ID: </label>
              <input type="text" name="absensi_cari" id="absensi_cari" placeholder="Cari Nama Pengajar" autofocus>
           </div>
           <div class="">
              <label for="">Nama: </label>
              <span id="absensi_name" name="absensi_name">-</span>
           </div>
           <div class="">
              <label for="">Tanggal: </label>
              <input type="text" name="absensi_date" id="absensi_date" readonly="readonly">
           </div>
           <div class="">
              <label for="">Aktivitas: </label>
              <select class="" name="absensi_aktivitas">
                 <option selected="selected">--Pilih Aktivitas--</option>
                 <?php
                    $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM aktivitas");
                    if (mysqli_num_rows($query) != 0) {
                       while ($data = mysqli_fetch_assoc($query)) {
                          echo '<option value="'.$data['ID_AKTIVITAS'].'">'.$data['NAMA_AKTIVITAS'].'</option>';
                       }
                    }
                 ?>
              </select>
           </div>
           <input type="submit" name="submit_absensi" id="submit_absensi" value="Submit">
        </form>
     </div>
     <!-- Akhir form absensi -->

     <!-- Tabel yang menampilkan daftar absensi hari ini -->
     <div class="">
        <h3>Daftar Absensi Hari ini</h3>
        <table border="1">
           <thead>
              <tr>
                 <th>#</th>
                 <th>ID</th>
                 <th>Nama</th>
                 <th>Aktivitas</th>
                 <th>Tanggal</th>
              </tr>
           </thead>
           <tbody>
              <?php
                  $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT a.id_pengajar, a.nama_pengajar, b.nama_aktivitas, c.WAKTU_ABSENSI from pengajar a, aktivitas b, absensi c WHERE a.ID_PENGAJAR = c.ID_PENGAJAR && b.ID_AKTIVITAS = c.ID_AKTIVITAS && c.WAKTU_ABSENSI = (SELECT CURRENT_DATE())");
                  if (mysqli_num_rows($query) > 0) {
                     $i = 1;
                     while ($data = mysqli_fetch_assoc($query)) {
                        echo '<tr>';
                           echo '<td>'.$i.'</td>';
                           echo '<td>'.$data['id_pengajar'].'</td>';
                           echo '<td>'.$data['nama_pengajar'].'</td>';
                           echo '<td>'.$data['nama_aktivitas'].'</td>';
                           echo '<td>'.$data['WAKTU_ABSENSI'].'</td>';
                        echo '</tr>';
                        $i++;
                     }
                  } else {
                     echo '<tr>';
                       echo '<td>#</td>';
                       echo '<td colspan="4">Absensi Hari Ini KOSONG!</td>';
                    echo '</tr>';
                  }
              ?>
           </tbody>
        </table>
     </div>
     <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
     <script type="text/javascript" src="js/jquery-ui.js"></script>
     <script type="text/javascript" src="js/custom.js"></script>
     <script>
        /*autocomplete muncul setelah user mengetikan minimal2 karakter */
        $(document).ready(function(){
           $("#absensi_cari").autocomplete({
              minLength:1,
              source:'absensi_data2.php',
              select:function(event, ui){
                 $('#absensi_name').html(ui.item.nama);
              }
           });
        });

        $(function(){
           $('#absensi_date').val(tanggal());
        });
        </script>
  </body>
</html>

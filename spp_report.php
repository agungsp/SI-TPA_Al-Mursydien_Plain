<?php
  include 'koneksi.php';
  include 'format_number.php';
?>
<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
     <title>Laporan SPP - Sistem Informasi TPA Al Mursyidien</title>
     <link rel="stylesheet" href="css/jquery-ui.css" />
  </head>
  <body>
     <h3>Laporan SPP</h3>
     <form class="" action="spp_report.php" method="post"> <!-- Pencarian berdasarkan nama santri -->
        <input type="text" name="cari_nama" id="cari_nama" placeholder="Cari Nama Santri.." autofocus>
        <input type="hidden" name="cari_id" id="cari_id">
        <input type="submit" name="submit_cari_nama" value="Cari">
     </form>
     <form class="" action="spp_report.php" method="post"><!-- Pencarian berdasarkan bulan -->
        <!-- Waktu Awal Pencarian -->
        <div class="">
           <!-- Bulan Awal -->
           <select name="bln_awal">
              <option selected="selected">Bulan</option>
              <?php
                 $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                 $jlh_bln=count($bulan);
                 for($c=0; $c<$jlh_bln; $c+=1){
                    $bul = $c+1;
                    echo '<option value="'.num_zero($bul).'">'.$bulan[$c].'</option>';
                 }
              ?>
           </select>
           <!-- Tahun Awal -->
           <select name="thn_awal">
              <?php
                 echo '<option selected="selected">Tahun</option>';
                 $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT YEAR(TGL_PEMBAYARAN) AS THN FROM spp ORDER BY TGL_PEMBAYARAN ASC");
                 if (mysqli_num_rows($q) != 0) {
                    $x = 0;
                    while ($data = mysqli_fetch_assoc($q)) {
                       if ($x != $data['THN']) {
                          $x = $data['THN'];
                          echo '<option value="'.$data['THN'].'">'.$data['THN'].'</option>';
                       }
                    }
                 }
              ?>
           </select>
        </div>
        <span>Sampai</span>

        <!-- Waktu Akhir Pencarian -->
        <div class="">
           <!-- Bulan Akhir -->
           <select name="bln_akhir">
              <option selected="selected">Bulan</option>
              <?php
                 $bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                 $jlh_bln=count($bulan);
                 for($c=0; $c<$jlh_bln; $c+=1){
                    $bul = $c+1;
                    echo '<option value="'.$bul.'">'.$bulan[$c].'</option>';
                 }
              ?>
           </select>
           <!-- Tahun Akhir -->
           <select name="thn_akhir">
              <?php
                 echo '<option selected="selected">Tahun</option>';
                 $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT YEAR(TGL_PEMBAYARAN) AS THN FROM spp ORDER BY TGL_PEMBAYARAN ASC");
                 if (mysqli_num_rows($q) != 0) {
                    $x = 0;
                    while ($data = mysqli_fetch_assoc($q)) {
                       if ($x != $data['THN']) {
                          $x = $data['THN'];
                          echo '<option value="'.$data['THN'].'">'.$data['THN'].'</option>';
                       }
                    }
                 }
              ?>
           </select>
        </div>
        <input type="submit" name="submit_cari_periode" value="Cari">
     </form>

     <form class="" action="spp_report.php" method="post">
        <button type="submit" name="all">Semua</button>
     </form>

     <?php
        $f_limit = fopen("limit_spp.txt","r") or die ("Unable to open file!!");
        $kalimat = fgets($f_limit);
        $kata = explode(" ",$kalimat);
        echo "<p>Limit SPP per 6 bulan sebesar Rp. $kata[1],-</p>";
        fclose($f_limit);
     ?>
     <a href="spp_report_all.php">Catatan SPP Santri</a>
     <table border="1">
        <thead>
           <tr>
              <th>#</th>
              <th>ID</th>
              <th>Nama</th>
              <th>Bayar</th>
              <th>Tanggal</th>
           </tr>
        </thead>
        <tbody>
           <?php
              if (isset($_POST['submit_cari_nama'])) {
                 $cari = $_POST['cari_id'];
                 $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM tabel_spp where ID_SANTRI = '$cari'");
              }

              elseif (isset($_POST['submit_cari_periode'])) {
                 $bln_awal = $_POST['bln_awal'];
                 $thn_awal = $_POST['thn_awal'];
                 $bln_akhir = $_POST['bln_akhir'];
                 $thn_akhir = $_POST['thn_akhir'];
                 $awal = "$thn_awal-$bln_awal-01";
                 $akhir = "$thn_akhir-$bln_akhir-01";

                 $aw = date('Y-m-01', strtotime($awal));
                 $ak = date('Y-m-t', strtotime($akhir));

                 $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM tabel_spp where TGL_PEMBAYARAN between '$aw' and '$ak'");
              }

              elseif (isset($_POST['all'])) {
                 $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from tabel_spp");
              }

              else {
                 $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from tabel_spp");
              }


              if (mysqli_num_rows($query) > 0) {
                 $i = 1;
                 while ($data = mysqli_fetch_assoc($query)) {
                    echo '<tr>';
                       echo '<td>'.$i.'</td>';
                       echo '<td>'.$data['ID_SANTRI'].'</td>';
                       echo '<td>'.$data['NAMA_SANTRI'].'</td>';
                       echo '<td>Rp. '.rupiahFormat($data['TOTAL']).',-</td>';
                       echo '<td>'.date("d-n-Y",strtotime($data['TGL_PEMBAYARAN'])).'</td>';
                    echo '</tr>';
                    $i++;
                 }
              } else {
                 echo '<tr>';
                    echo '<td>#</td>';
                    echo '<td colspan="4">DATA KOSONG!</td>';
                 echo '</tr>';
              }
           ?>
        </tbody>
     </table>
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

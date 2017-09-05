<?php
  include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
  <head>
     <meta charset="utf-8">
     <title>SPP - Sistem Informasi TPA Al Mursyidien</title>
     <link rel="stylesheet" href="css/jquery-ui.css" />
  </head>
  <body>
     <h3>SPP</h3>
     <form class="" action="input_proses.php" method="post">
        <div class="">
           <label for="">Cari/ID</label>
           <input type="text" name="spp_cari" class="spp_cari" id="spp_cari" autofocus placeholder="Cari Nama Santri">
        </div>
        <div class="">
           <label for="">Nama: </label>
           <span id="spp_name" name="spp_name">-</span>
        </div>
        <div class="">
           <label for="">Tanggal: </label>
           <input type="text" name="spp_date" id="spp_date" readonly="readonly">
        </div>
        <div class="">
           <label for="">Membayar sebanyak: </label>
           <input type="text" name="spp_pay" id="spp_pay" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="">
        </div>
        <div class="">
           <label for="">Telah membayar: </label>
           <?php
              $f_limit = fopen("limit_spp.txt","r") or die ("Unable to open file!!");
              $kalimat = fgets($f_limit);
              $kata = explode(" ",$kalimat);
              echo '<span id="spp_last">-</span><span>  dari Rp. '.$kata[1].',-</span>';
              fclose($f_limit);
           ?>
        </div>
        <input type="submit" name="submit_spp" id="submit_spp" value="Submit">
     </form>
     <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
     <script type="text/javascript" src="js/jquery-ui.js"></script>
     <script type="text/javascript" src="js/custom.js"></script>
     <script>
        $(document).ready(function(){
           $("#spp_cari").autocomplete({
              minLength:1,
              source:'spp_data2.php',
              select:function(event, ui){
                 $('#spp_name').html(ui.item.nama);
                 $('#spp_last').html(ui.item.terakhir_bayar);
              }
           });
        });

        $(function(){
           $('#spp_date').val(tanggal());
        });
     </script>
  </body>
</html>

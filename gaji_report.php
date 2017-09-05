<?php
  include 'koneksi.php';
  include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Laporan Gaji - Sistem Informasi TPA Al Mursyidien</title>
      <link rel="stylesheet" href="css/jquery-ui.css" />
      <style media="screen">
         .print-area {border:1px solid red;padding:1em;margin:0 0 1em; width: 9.4cm; height: auto; }
      </style>
   </head>
   <body>
      <!--FORM-->
      <div class="">
         <form class="" action="gaji_report.php" method="post">
            <!--INPUT NAMA-->
            <div class="">
               <input type="text" name="cari_pengajar" id="cari_pengajar" placeholder="Cari Nama Pengajar.." autofocus>
               <input type="hidden" name="cari_idPengajar" id="cari_idPengajar">
            </div>

            <!--INPUT BULAN TAHUN-->
            <div class="">
               <select name="bln">
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

               <select name="thn">
                  <?php
                     echo '<option selected="selected">Tahun</option>';
                     $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT YEAR(WAKTU_ABSENSI) AS THN FROM absensi_upah GROUP BY YEAR(WAKTU_ABSENSI)");
                     if (mysqli_num_rows($q) != 0) {
                        while ($data = mysqli_fetch_assoc($q)) {
                           echo '<option value="'.$data['THN'].'">'.$data['THN'].'</option>';
                        }
                     } else {
                        echo '<option value="2017">2017</option>';
                     }
                  ?>
               </select>
            </div>
            <input type="submit" name="cari_gaji" value="Cari">
         </form>
      </div>

      <!--PRINT AREA-->
      <?php
		$d_pengajar = null; $id_pengajar = null; //$periode = null;
         if (isset($_POST['cari_gaji'])) {
            $id_pengajar = $_POST['cari_idPengajar'];
            $bln = $_POST['bln'];
            $thn = $_POST['thn'];
            $wkt = "$thn$bln";
            $periode = $wkt;
			   $q_pengajar = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT ID_PENGAJAR,NAMA_PENGAJAR,JABATAN,HONOR_ABDI,HONOR_JABATAN FROM pengajar WHERE ID_PENGAJAR = '$id_pengajar'");
            $d_pengajar = mysqli_fetch_assoc($q_pengajar);
         }
      ?>
      <div id="print-area-1" class="print-area">
          <div style="text-align:right;"><a class="no-print" href="javascript:printDiv('print-area-1');">Print</a></div>
          <center>
             <h4>Slip Honor TKA/TPA/Diniyah " ألمرشدين "</h4>
             <table width="360px">
               <?php
                  echo '<tr>';
                     echo '<td>Dicetak Pada</td>';
                     echo '<td>:</td>';
                     echo '<td colspan="3" style="text-align:right;">'.tanggal_indo(date("Y-m-d")).'</td>';
                  echo '</tr>';
                  echo '<tr>';
                     echo '<td>Periode</td>';
                     echo '<td>:</td>';
                     echo '<td colspan="3" style="text-align:right;">'.BulanIndo($bln).' '.$thn.'</td>';
                  echo '</tr>';
                  echo '<tr>';
                     echo '<td>ID</td>';
                     echo '<td>:</td>';
                     echo '<td colspan="3" style="text-align:right">'.$d_pengajar['ID_PENGAJAR'].'</td>';
                  echo '</tr>';
                  echo '<tr>';
                     echo '<td>Nama</td>';
                     echo '<td>:</td>';
                     echo '<td colspan="3" style="text-align:right">'.$d_pengajar['NAMA_PENGAJAR'].'</td>';
                  echo '</tr>';
                  echo '<tr>';
                     echo '<td>Masa Kerja</td>';
                     echo '<td colspan="3">:</td>';
                     echo '<td style="text-align:right">Rp. '.rupiahFormat($d_pengajar['HONOR_ABDI']).',-</td>';
                  echo '</tr>';
                  echo '<tr>';
                     echo '<td>Jabatan</td>';
                     echo '<td colspan="2">:</td>';
                     echo '<td style="text-align:center">'.$d_pengajar['JABATAN'].'</td>';
                     echo '<td style="text-align:right">Rp. '.rupiahFormat($d_pengajar['HONOR_JABATAN']).',-</td>';
                  echo '</tr>';

                  echo '<tr>';
                     echo '<td>Kehadiran</td>';
                     echo '<td colspan="4">:</td>';
                  echo '</tr>';
               $jumlah = $d_pengajar['HONOR_ABDI']+ $d_pengajar['HONOR_JABATAN'];
               $q_absensi = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT NAMA_AKTIVITAS,HONOR_AKTIVITAS,JML,UPAH FROM rekap_gaji WHERE ID_PENGAJAR = '$id_pengajar' && PERIODE = '$periode'");
               while ($d_absensi = mysqli_fetch_assoc($q_absensi)) {
                  echo '<tr>';
                     echo '<td></td>';
                     echo '<td>'.$d_absensi['NAMA_AKTIVITAS'].'</td>';
                     echo '<td style="text-align:center">'.$d_absensi['JML'].'</td>';
                     echo '<td style="text-align:right">Rp. '.rupiahFormat($d_absensi['HONOR_AKTIVITAS']).',-</td>';
                     echo '<td style="text-align:right">Rp. '.rupiahFormat($d_absensi['UPAH']).',-</td>';
                  echo '</tr>';
                  $jumlah = $jumlah + $d_absensi['UPAH'];
               }

               echo '<tr>';
                  echo '<td>Jumlah</td>';
                  echo '<td>:</td>';
                  echo '<td colspan="3" style="text-align:right">Rp. '.rupiahFormat($jumlah).',-</td>';
               echo '</tr>';
               echo '<tr>';
                  echo '<td>Potongan</td>';
                  echo '<td colspan="4">:</td>';
               echo '</tr>';

               $f_potongan = fopen("potongan.txt","r") or die ("Unable to open file!");
               while (!feof($f_potongan)) {
                  $kalimat = fgets($f_potongan);
                  $kata = explode(" ",$kalimat);
                  if ($kalimat == true) {
                     echo '<tr>';
                        echo '<td></td>';
                        echo '<td>'.$kata[0].'</td>';
                        echo '<td colspan="2"></td>';
                        echo '<td style="text-align:right">Rp. '.rupiahFormat($kata[1]).',-</td>';
                     echo '</tr>';
                     $jumlah = $jumlah-(float)$kata[1];
                  }
               }

               echo '<tr>';
                  echo '<td>Penerimaan</td>';
                  echo '<td>:</td>';
                  echo '<td colspan="3" style="text-align:right">Rp. '.rupiahFormat($jumlah).',-</td>';
               echo '</tr>';
              ?>
            </table>
          </center>
      </div>
      <textarea id="printing-css" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px dotted;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:1.5em 0}hr{height:1px;border:none;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:1.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:100%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:100%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid;padding:.5em 1em;text-align:left;vertical-align:top}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none}</textarea>
      <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){
            $("#cari_pengajar").autocomplete({
               minLength:1,
               source:'gaji_report_data.php',
               select:function(event, ui){
                 $('#cari_idPengajar').val(ui.item.id);
               }
            });
         });

         document.getElementById('potongan_lain_cb').onchange = function() {
            document.getElementById('potongan_lain_nama').disabled = !this.checked;
            document.getElementById('potongan_lain_bayar').disabled = !this.checked;
         };

         function printDiv(elementId) {
            var a = document.getElementById('printing-css').value;
            var b = document.getElementById(elementId).innerHTML;
            window.frames["print_frame"].document.title = document.title;
            window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
            window.frames["print_frame"].window.focus();
            window.frames["print_frame"].window.print();
         }

         $(function(){
            $('#gaji_date').val(tanggal());
         });
     </script>
   </body>
</html>

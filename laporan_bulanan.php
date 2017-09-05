<?php
   session_start();
   include 'koneksi.php';
   include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Laporan Bulanan - TPA Al Mursyidien</title>
      <link rel="stylesheet" href="css/jquery-ui.css" />
      <style media="screen">
         .print-area {border:1px solid red;padding:1em;margin:0 0 1em; width: 21.9cm; height: auto; }
      </style>
   </head>
   <body>
      <!-- ADD MORE -->
      <div class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Laporan Bulanan</div>
          <div class="panel-body">
              <form action="laporan_bulanan.php" method="POST">
                 <div class="">
                    <label for="">Saldo Awal: </label>
                    <input type="text" name="saldo_awal" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                 </div>
                 <div class="">
                    <label for="">Pendaftaran Santri: </label>
                    <input type="text" name="pendaftaran_santri" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                 </div>
                 <div class="">
                    <label for="">Infaq Santri: </label>
                    <input type="text" name="infaq_santri" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
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

                 <div class="input-group control-group after-add-more">
                    <div class="panel-heading">Pengeluaran</div>
                    <input type="text" name="addmoreitem[]" class="form-control" placeholder="Nama Pengeluaran">
                    <input type="text" name="addmoremoney[]" class="form-control" placeholder="Biaya" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                    <div class="input-group-btn">
                       <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i> Add</button>
                    </div>
                 </div>
                 <div class="control-group text-center">
                    <br>
                    <button class="btn btn-success" name="submit" type="submit">Submit</button>
                 </div>
              </form>
              <!-- Copy Fields -->
              <div class="copy hide">
                <div class="control-group input-group" style="margin-top:10px">
                  <input type="text" name="addmoreitem[]" class="form-control" placeholder="Nama Pengeluaran">
                  <input type="text" name="addmoremoney[]" class="form-control" placeholder="Biaya" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                     <div class="input-group-btn">
                        <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                     </div>
                </div>
              </div>
          </div>
        </div>
     </div>
     <!-- End ADD MORE -->

      <!--PRINT AREA-->
      <?php
         if (isset($_POST['submit'])) {
            $saldo_awal = $_POST['saldo_awal'];
            $pendaftaran_santri = $_POST['pendaftaran_santri'];
            $infaq_santri = $_POST['infaq_santri'];
            $bln = $_POST['bln'];
            $thn = $_POST['thn'];
            $inputitem = $_POST['addmoreitem'];
            $inputmoney = $_POST['addmoremoney'];
            $wkt = "$thn$bln";
            $periode = $wkt;

            $q_kepala = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT NAMA_PENGAJAR FROM pengajar WHERE JABATAN = 'Kepala' and STATUS_PENGAJAR = 'Aktif'");
            $d_kepala = mysqli_fetch_assoc($q_kepala);
            $q_bendahara = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT NAMA_PENGAJAR FROM pengajar WHERE JABATAN = 'Bendahara' and STATUS_PENGAJAR = 'Aktif'");
            $d_bendahara = mysqli_fetch_assoc($q_bendahara);
            $q_pengeluaran_karyawan = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT SUM(UPAH) AS TOTAL_UPAH FROM `rekap_gaji` WHERE PERIODE = '$wkt' ");
            $d_pengeluaran_karyawan = mysqli_fetch_assoc($q_pengeluaran_karyawan);
            $q_pemasukan_santri = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT * FROM total_spp_periode WHERE PERIODE = '$wkt'");
            $d_pemasukan_santri = mysqli_fetch_assoc($q_pemasukan_santri);
            $q_jml_santri = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT ID_SANTRI FROM santri");
            $jml_santri = mysqli_num_rows($q_jml_santri);

            $jumlah_pemasukan = penghilangTitik($saldo_awal)+$d_pemasukan_santri['TOTAL']+penghilangTitik($pendaftaran_santri)+penghilangTitik($infaq_santri);
         }
      ?>
      <div id="print-area-1" class="print-area">
          <div style="text-align:right;"><a class="no-print" href="javascript:printDiv('print-area-1');">Print</a></div>
          <center>
             <table>
               <tr>
                  <td><img src="pic1.png"></td>
                  <td>
                     <p style="text-align:center;">LEMBAGA PEMBINAAN DAN PENGEMBANGAN TK AL – QUR’AN <br>
                        (LPPTKA – BKPRMI  SURABAYA)<br>
                        UNIT  016 TKA/TPA/DINIYAH "AL MURSYIDIEN"<br>
                        Sekretariat : Jl. Semolowaru 114 – 118 Telp. 5930540/ 081-23116447 Surabaya
                     </p>
                  </td>
                  <td><img src="pic2.png"></td>
               </tr>
               <tr>
                  <td colspan="3">
                     <p style="text-align:center;"><b>LAPORAN KEUANGAN <br>
                     TKA/TPA/DINIYAH "AL MURSYIDIEN"<br>
                     <?php echo strtoupper(BulanIndo($bln)); echo " $thn"; ?></b>
                     </p>
                  </td>
               </tr>
             </table>
             <table border="1" style="width:19.5cm;">
                <thead>
                   <tr>
                      <th>No.</th>
                      <th>Uraian</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                      <th>Saldo</th>
                   </tr>
                </thead>
                <tbody>
                   <tr>
                      <td></td>
                      <td>Saldo Awal</td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;">Rp. <?php echo $saldo_awal; ?>,-</td>
                   </tr>
                   <tr>
                      <td style="text-align:center;">1</td>
                      <td>SPP <?php echo $jml_santri ?> Santri</td>
                      <td style="text-align:right;">Rp. <?php echo rupiahFormat($d_pemasukan_santri['TOTAL']); ?>,-</td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr>
                      <td style="text-align:center;">2</td>
                      <td>Pendaftaran Santri</td>
                      <td style="text-align:right;">Rp. <?php echo $pendaftaran_santri; ?>,-</td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr>
                      <td style="text-align:center;">3</td>
                      <td>Infaq Santri</td>
                      <td style="text-align:right;">Rp. <?php echo $infaq_santri; ?>,-</td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;">Rp. <?php echo rupiahFormat($d_pemasukan_santri['TOTAL']+penghilangTitik($pendaftaran_santri)+penghilangTitik($infaq_santri)); ?>,-</td>
                   </tr>
                   <tr>
                      <td></td>
                      <td><b>Jumlah Pemasukan</b></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;">Rp. <?php echo rupiahFormat($jumlah_pemasukan); ?>,-</td>
                   </tr>
                   <tr>
                      <td>&nbsp</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr>
                      <td style="text-align:center;">1</td>
                      <td>Gaji Ustadz/Ustadzah, Kebersihan</td>
                      <td></td>
                      <td style="text-align:right;">Rp. <?php echo rupiahFormat($d_pengeluaran_karyawan['TOTAL_UPAH']);?>,-</td>
                      <td></td>
                   </tr>
                   <?php
                     $urut = 2;
                     for ($i=0, $hitung = count($inputitem); $i < $hitung ; $i++) {
                        echo '<tr>';
                           echo '<td style="text-align:center;">'.$urut.'</td>';
                           echo '<td>'.$inputitem[$i].'</td>';
                           echo '<td></td>';
                           echo '<td style="text-align:right;">Rp. '.$inputmoney[$i].',-</td>';
                           echo '<td></td>';
                        echo '</tr>';
                        $pengeluaran = $pengeluaran + penghilangTitik($inputmoney[$i]);
                     }
                   ?>
                   <tr>
                      <td></td>
                      <td><b>Jumlah Pengeluaran</b></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;">Rp. <?php echo rupiahFormat($pengeluaran + $d_pengeluaran_karyawan['TOTAL_UPAH']) ?>,-</td>
                   </tr>
                   <tr>
                      <td>&nbsp</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                   </tr>
                   <tr>
                      <td></td>
                      <td><b>Saldo Akhir</b></td>
                      <td></td>
                      <td></td>
                      <td style="text-align:right;">Rp. <?php echo  rupiahFormat($jumlah_pemasukan-$pengeluaran-$d_pengeluaran_karyawan['TOTAL_UPAH'])?>,-</td>
                   </tr>
                </tbody>
             </table>
          </center>
          <br><br>
          <div class="">
             <center>
                <table style="width:19.5cm;">
                   <tr>
                      <td style="text-align:center;">&nbsp;</td>
                      <td style="text-align:center;">Surabaya, <?php echo tanggal_indo(date("Y-m-d")); ?></td>
                   </tr>
                   <tr>
                       <td style="text-align:center;">Kepala TKA/TPA/Diniyah "Al Mursyidien"</td>
                       <td style="text-align:center;">Penanggung Jawab Keuangan</td>
                   </tr>
                   <tr>
                       <td style="text-align:center;">&nbsp;</td>
                       <td style="text-align:center;">&nbsp;</td>
                   </tr>
                   <tr>
                       <td style="text-align:center;">&nbsp;</td>
                       <td style="text-align:center;">&nbsp;</td>
                   </tr>
                   <tr>
                      <td style="text-align:center;">&nbsp;</td>
                      <td style="text-align:center;">&nbsp;</td>
                   </tr>
                   <tr>
                       <td style="text-align:center;"><b><u><?php echo $d_kepala['NAMA_PENGAJAR']; ?></u></b></td>
                       <td style="text-align:center;"><b><u><?php echo $d_bendahara['NAMA_PENGAJAR']; ?></u></b></td>
                   </tr>
                </table>
             <center>
          </div>
      </div>
      <textarea id="printing-css" style="display:none;">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}table{border-collapse:collapse;border-spacing:0}body{font:normal normal .8125em/1.4 Arial,Sans-Serif;background-color:white;color:#333}strong,b{font-weight:bold}cite,em,i{font-style:italic}a{text-decoration:none}a:hover{text-decoration:underline}a img{border:none}abbr,acronym{border-bottom:1px dotted;cursor:help}sup,sub{vertical-align:baseline;position:relative;top:-.4em;font-size:86%}sub{top:.4em}small{font-size:86%}kbd{font-size:80%;border:1px solid #999;padding:2px 5px;border-bottom-width:2px;border-radius:3px}mark{background-color:#ffce00;color:black}p,blockquote,pre,table,figure,hr,form,ol,ul,dl{margin:1.5em 0}hr{height:1px;border:none;background-color:#666}h1,h2,h3,h4,h5,h6{font-weight:bold;line-height:normal;margin:1.5em 0 0}h1{font-size:200%}h2{font-size:180%}h3{font-size:160%}h4{font-size:140%}h5{font-size:120%}h6{font-size:100%}ol,ul,dl{margin-left:3em}ol{list-style:decimal outside}ul{list-style:disc outside}li{margin:.5em 0}dt{font-weight:bold}dd{margin:0 0 .5em 2em}input,button,select,textarea{font:inherit;font-size:100%;line-height:normal;vertical-align:baseline}textarea{display:block;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}pre,code{font-family:"Courier New",Courier,Monospace;color:inherit}pre{white-space:pre;word-wrap:normal;overflow:auto}blockquote{margin-left:2em;margin-right:2em;border-left:4px solid #ccc;padding-left:1em;font-style:italic}table[border="1"] th,table[border="1"] td,table[border="1"] caption{border:1px solid;padding:.5em 1em;text-align:left;vertical-align:top}th{font-weight:bold}table[border="1"] caption{border:none;font-style:italic}.no-print{display:none}</textarea>
      <iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
      <script type="text/javascript">
         function printDiv(elementId) {
            var a = document.getElementById('printing-css').value;
            var b = document.getElementById(elementId).innerHTML;
            window.frames["print_frame"].document.title = document.title;
            window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
            window.frames["print_frame"].window.focus();
            window.frames["print_frame"].window.print();
         }

         $(document).ready(function() {
           $(".add-more").click(function(){
               var html = $(".copy").html();
               $(".after-add-more").after(html);
           });
           $("body").on("click",".remove",function(){
               $(this).parents(".control-group").remove();
           });
         });
      </script>
   </body>
</html>

<?php
  session_start();
  include 'koneksi.php';
  include 'format_number.php';

  $user_online = $_SESSION['login_user'];
  var_dump($_SESSION);
  if(isset($_POST['submit_santri'])){

     $santri_id = $_POST['santri_id'];
     $santri_name = $_POST['santri_name'];
     $santri_walas = $_POST['santri_walas'];
     $santri_tingkatan = $_POST['santri_tingkatan'];

     $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO santri VALUES ('$santri_id','$santri_name','$santri_walas',0,'Aktif','$santri_tingkatan')");

     $log_file = fopen("log.txt","a");
     $date = tanggal_indo(date("Y-m-d"));
     $time = date("H:i:s");
     $log = "User \"$user_online\" melakukan input Data Santri pada $date $time \n";
     fwrite($log_file,$log);
     fclose($log_file);

     header('location: berhasil.php?status=Input Data Santri');
  }

  if(isset($_POST['submit_pengajar'])){

     $pengajar_id = $_POST['pengajar_id'];
     $pengajar_name = $_POST['pengajar_name'];
     $pengajar_jabatan = $_POST['pengajar_jabatan'];

     $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO pengajar VALUES ('$pengajar_id','$pengajar_name','$pengajar_jabatan',(SELECT YEAR(CURRENT_DATE())), NULL, NULL, 'Aktif')");

     $log_file = fopen("log.txt","a");
     $date = tanggal_indo(date("Y-m-d"));
     $time = date("H:i:s");
     $log = "User \"$user_online\" melakukan input Data Pengajar pada $date $time \n";
     fwrite($log_file,$log);
     fclose($log_file);

     header('location: berhasil.php?status=Input Data Pengajar');
  }

  if (isset($_POST['submit_spp'])) {

     $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM spp");
     $rows = mysqli_num_rows($q) + 1;

     $spp_id = "tpa-spp$rows";
     $spp_idname = $_POST['spp_cari'];
     $spp_name = $_POST['spp_name'];
     $spp_pay = $_POST['spp_pay'];
     $spp_pay = penghilangTitik($spp_pay);

     $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO spp VALUES ('$spp_id','$spp_idname','$spp_pay',(SELECT CURRENT_DATE()))");

     $log_file = fopen("log.txt","a");
     $date = tanggal_indo(date("Y-m-d"));
     $time = date("H:i:s");
     $log = "User \"$user_online\" melakukan input SPP pada $date $time \n";
     fwrite($log_file,$log);
     fclose($log_file);

     header("location: berhasil.php?status=Input Data SPP");
  }

  if (isset($_POST['submit_absensi'])) {

     $q = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ID_ABSENSI FROM absensi");
     $rows = mysql_num_rows($q) + 1;

     $absensi_id = "tpa-abs$rows";
     $absensi_aktivitas = $_POST['absensi_aktivitas'];
     $absensi_pengajar = $_POST['absensi_cari'];
     $query = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO absensi VALUES ('$absensi_id','$absensi_aktivitas','$absensi_pengajar',(SELECT CURRENT_DATE()))");

     $log_file = fopen("log.txt","a");
     $date = tanggal_indo(date("Y-m-d"));
     $time = date("H:i:s");
     $log = "User \"$user_online\" melakukan input Absensi pada $date $time \n";
     fwrite($log_file,$log);
     fclose($log_file);

     header("location: absensi.php");
  }

  if (isset($_POST['submit_aktivitas'])) {

     $q = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT ID_AKTIVITAS FROM aktivitas");
     $rows = mysqli_num_rows($q) + 1;

     $aktivitas_id = "tpa-aktv$rows";
     $aktivitas_name = $_POST['aktivitas_name'];
     $aktivitas_pay= $_POST['aktivitas_pay'];
     $aktivitas_pay = penghilangTitik($aktivitas_pay);
     $query = mysqli_query($GLOBALS["___mysqli_ston"],"INSERT INTO aktivitas VALUES ('$aktivitas_id','$aktivitas_name','$aktivitas_pay')");

     $log_file = fopen("log.txt","a");
     $date = tanggal_indo(date("Y-m-d"));
     $time = date("H:i:s");
     $log = "User \"$user_online\" melakukan input Aktivitas pada $date $time \n";
     fwrite($log_file,$log);
     fclose($log_file);

     header("location: setting.php");
  }
?>

<?php
   session_start();
   include 'koneksi.php';
   include 'format_number.php';
   $user_online = $_SESSION['login_user'];
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Edit Form - Sistem Informasi TPA Al Mursyidien</title>
   </head>
   <body>
      <?php
         if (isset($_GET['edt'])) {

            if ($_GET['edt'] == "aktivitas") {
               $id = $_GET['id'];
               $nama = $_GET['nama'];
               $honor = $_GET['honor'];

               echo '<div class="">';
                  echo '<form class="" action="edit.php" method="post">';
                  echo '<div class="">';
                     echo '<label for="">ID: </label>';
                     echo '<span>'.$id.'</span>';
                     echo '<input type="hidden" name="aktivitas_id" value="'.$id.'">';
                  echo '</div>';
                     echo '<div class="">';
                        echo '<label for="">Aktivitas</label>';
                        echo '<input type="text" name="aktivitas_name" value="'.$nama.'">';
                     echo '</div>';
                     echo '<div class="">';
                        echo '<label for="">Honor</label>';
                        echo '<input type="text" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" name="aktivitas_pay" value="'.rupiahFormat($honor).'">';
                     echo '</div>';
                     echo '<input type="submit" name="aktivitas_upd" value="Update">';
                  echo '</form>';
               echo '</div>';
            }

            if ($_GET['edt'] == "slist") {
               $id = $_GET['id'];
               $nama = $_GET['nama'];

               echo '<div class="">';
                  echo '<form class="" action="edit.php" method="post">';
                     echo '<div class="">';
                        echo '<label for="">ID: </label>';
                        echo '<input type="text" name="santri_id" value="'.$id.'" readonly="readonly">';
                     echo '</div>';
                     echo '<div class="">';
                        echo '<label for="">Nama: </label>';
                        echo '<input type="text" id="santri_name" name="santri_name" onFocus="this.select()" autofocus required value="'.$nama.'">';
                     echo '</div>';

                     echo '<div class="">';
                        echo '<label for="">Walas: </label>';
                        echo '<select class="" name="santri_walas">';
                           echo '<option selected="selected">--Pilih Walas--</option>';

                              $query = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT ID_PENGAJAR, NAMA_PENGAJAR FROM pengajar WHERE JABATAN = 'walas' ");
                              if (mysqli_num_rows($query) != 0) {
                                 while ($data = mysqli_fetch_assoc($query)) {
                                    echo '<option value="'.$data['ID_PENGAJAR'].'">'.$data['NAMA_PENGAJAR'].'</option>';
                                 }
                              }

                        echo '</select>';
                     echo '</div>';
                     echo '<div class="">';
                        echo '<label for="">Tingkatan: </label>';
                        echo '<select class="" name="santri_tingkatan">';
                           echo '<option selected="selected">--Pilih Tingkatan--</option>';
                           echo '<option value="TK Jilid 1">TK Jilid 1</option>';
                           echo '<option value="TK Jilid 2">TK Jilid 2</option>';
                           echo '<option value="TK Jilid 3">TK Jilid 3</option>';
                           echo '<option value="TK Jilid 4">TK Jilid 4</option>';
                           echo '<option value="TK Jilid 5">TK Jilid 5</option>';
                           echo '<option value="TK Jilid 6">TK Jilid 6</option>';
                           echo '<option value="TK Al-Quran">TK Al-Qur`an</option>';
                           echo '<option value="SD Jilid 1">SD Jilid 1</option>';
                           echo '<option value="SD Jilid 2">SD Jilid 2</option>';
                           echo '<option value="SD Jilid 3">SD Jilid 3</option>';
                           echo '<option value="SD Jilid 3">SD Jilid 3</option>';
                           echo '<option value="SD Jilid 4">SD Jilid 4</option>';
                           echo '<option value="SD Jilid 5">SD Jilid 5</option>';
                           echo '<option value="SD Jilid 6">SD Jilid 6</option>';
                           echo '<option value="SD Kls 1 Quran">SD Kls 1 Qur`an</option>';
                           echo '<option value="SD Kls 2 Quran">SD Kls 2 Qur`an</option>';
                           echo '<option value="SD Kls 3 Quran">SD Kls 3 Qur`an</option>';
                           echo '<option value="SD Kls 4 Quran">SD Kls 4 Qur`an</option>';
                           echo '<option value="SD Kls 5 Quran">SD Kls 5 Qur`an</option>';
                           echo '<option value="SD Kls 6 Quran">SD Kls 6 Qur`an</option>';
                           echo '<option value="Al-Quran">Al-Qur`an</option>';
                        echo '</select>';
                     echo '</div>';
                     echo '<div class="">';
                        echo '<label for="">Status: </label>';
                        echo '<select class="" name="santri_status">';
                           echo '<option value="Aktif" selected="selected">Aktif</option>';
                           echo '<option value="Tidak Aktif">Tidak Aktif</option>';
                        echo '</select>';
                     echo '</div>';
                     echo '<input type="submit" name="edit_santri" id="edit_santri" value="Update"/>';
                  echo '</form>';
               echo '</div>';
            }

            if ($_GET['edt'] == "plist") {
               $id = $_GET['id'];
               $nama = $_GET['nama'];
               $habdi = $_GET['habdi'];
               $hjabatan = $_GET['hjabatan'];

               echo '<form class="" action="edit.php" method="post">';
                  echo '<div class="">';
                     echo '<label for="">ID Pengajar: </label>';
                     echo '<input type="text" id="pengajar_id" name="pengajar_id" value="'.$id.'" readonly="readonly">';
                  echo '</div>';
                  echo '<div class="">';
                     echo '<label for="">Nama: </label>';
                     echo '<input type="text" id="pengajar_name" name="pengajar_name" onFocus="this.select();" value="'.$nama.'" required>';
                  echo '</div>';
                  echo '<div class="">';
                     echo '<label for="">Jabatan: </label>';
                     echo '<select class="" name="pengajar_jabatan">';
                        echo '<option selected="selected">--Pilih Jabatan--</option>';
                        echo '<option value="P.W">P.W</option>';
                        echo '<option value="Kepala">Kepala</option>';
                        echo '<option value="Kepala">WK</option>';
                        echo '<option value="Bendahara">Bendahara</option>';
                        echo '<option value="Walas">Walas</option>';
                     echo '</select>';
                  echo '</div>';
                  echo '<div class="">';
                     echo '<label for="">Tunjangan Abdi: </label>';
                     echo '<input type="text" id="pengajar_habdi" name="pengajar_habdi" onFocus="this.select();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="'.rupiahFormat($habdi).'" required>';
                  echo '</div>';
                  echo '<div class="">';
                     echo '<label for="">Tunjangan Jabatan: </label>';
                     echo '<input type="text" id="pengajar_hjabatan" name="pengajar_hjabatan" onFocus="this.select();" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" value="'.rupiahFormat($hjabatan).'" required>';
                  echo '</div>';
                  echo '<div class="">';
                     echo '<label for="">Status: </label>';
                     echo '<select class="" name="pengajar_status">';
                        echo '<option selected="selected" value="Aktif">Aktif</option>';
                        echo '<option value="Tidak Aktif">Tidak Aktif</option>';
                     echo '</select>';
                  echo '</div>';
                  echo '<input type="submit" name="edit_pengajar" id="edit_pengajar" value="Submit">';
               echo '</form>';
            }
         }

         if (isset($_POST['aktivitas_upd'])) {
            $id = $_POST['aktivitas_id'];
            $aktivitas_name = $_POST['aktivitas_name'];
            $aktivitas_pay= $_POST['aktivitas_pay'];
            $aktivitas_pay = penghilangTitik($aktivitas_pay);
            $query = mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE `aktivitas` SET `NAMA_AKTIVITAS` = '$aktivitas_name', `HONOR_AKTIVITAS` = '$aktivitas_pay' WHERE `aktivitas`.`ID_AKTIVITAS` = '$id';");

            $log_file = fopen("log.txt","a");
            $date = tanggal_indo(date("Y-m-d"));
            $time = date("H:i:s");
            $log = "User \"$user_online\" melakukan edit Aktivitas pada $date $time \n";
            fwrite($log_file,$log);
            fclose($log_file);

            header("location: setting_aktivitas.php");
         }
         if (isset($_POST['edit_santri'])) {
            $id = $_POST['santri_id'];
            $nama = $_POST['santri_name'];
            $walas = $_POST['santri_walas'];
            $tingkatan = $_POST['santri_tingkatan'];
            $status = $_POST['santri_status'];
            $query = mysqli_query($GLOBALS["___mysqli_ston"],"UPDATE `santri` SET `NAMA_SANTRI` = '$nama', `ID_PENGAJAR` = '$walas', `TINGKATAN` = '$tingkatan', `STATUS_SANTRI` = '$status' WHERE `santri`.`ID_SANTRI` = '$id'");

            $log_file = fopen("log.txt","a");
            $date = tanggal_indo(date("Y-m-d"));
            $time = date("H:i:s");
            $log = "User \"$user_online\" melakukan edit Data Santri pada $date $time \n";
            fwrite($log_file,$log);
            fclose($log_file);

            header("location: santri_list.php");
         }
         if (isset($_POST['edit_pengajar'])) {
            $id = $_POST['pengajar_id'];
            $nama = $_POST['pengajar_name'];
            $jabatan = $_POST['pengajar_jabatan'];
            $habdi = $_POST['pengajar_habdi'];
            $habdi = penghilangTitik($habdi);
            $hjabatan = $_POST['pengajar_hjabatan'];
            $hjabatan = penghilangTitik($hjabatan);
            $status = $_POST['pengajar_status'];
            $query = mysqli_query($GLOBALS["___mysqli_ston"],"UPDATE `pengajar` SET `NAMA_PENGAJAR` = '$nama', `JABATAN` = '$jabatan', `HONOR_ABDI` = '$habdi', `HONOR_JABATAN` = '$hjabatan', `STATUS_PENGAJAR` = '$status' WHERE `pengajar`.`ID_PENGAJAR` = '$id' ");

            $log_file = fopen("log.txt","a");
            $date = tanggal_indo(date("Y-m-d"));
            $time = date("H:i:s");
            $log = "User \"$user_online\" melakukan edit Data Pengajar pada $date $time \n";
            fwrite($log_file,$log);
            fclose($log_file);

            header("location: pengajar_list.php");
         }

         if (isset($_GET['hps'])) {
            if ($_GET['hps'] == "usr") {
               $id = $_GET['usr'];
               $query = mysqli_query($GLOBALS["___mysqli_ston"],"DELETE FROM user WHERE USERNAME = '$id'");

               $log_file = fopen("log.txt","a");
               $date = tanggal_indo(date("Y-m-d"));
               $time = date("H:i:s");
               $log = "User \"$user_online\" melakukan penghapusan Username pada $date $time \n";
               fwrite($log_file,$log);
               fclose($log_file);

               header("location: setting_user.php");
            }
         }
      ?>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>

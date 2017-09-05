<?php
//   include 'mysql.php';
  session_start();
  include 'koneksi.php';
  include 'format_number.php';
  //include 'format_number';

  $error = '';
  if (isset($_POST['submit'])) {
     $username = $_POST['username'];
     $password = $_POST['password'];

     $username = stripcslashes($username);
     $password = stripcslashes($password);
     $username = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $username);
     $password = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $password);

     $query = mysqli_query($GLOBALS["___mysqli_ston"], "select * from user where username = '$username' AND password = '$password'");
     $rows = mysqli_num_rows($query);
     if ($rows == 1) {
        $_SESSION['login_user'] = $username;

        $log_file = fopen("log.txt","a");
        $date = tanggal_indo(date("Y-m-d"));
        $time = date("H:i:s");
        $log = "User \"$username\" melakukan Login pada $date $time \n";
        fwrite($log_file,$log);
        fclose($log_file);

        header("location: menu.php");
     }
  }
?>

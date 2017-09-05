<?php
   include 'koneksi.php';
   include 'format_number.php';
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title></title>
   </head>
   <body>
      <!-- INPUT USER -->
      <div class="">
         <form class="" action="setting_user.php" method="post">
            <div class="">
               <label for="">Username: </label>
               <input type="text" name="username">
            </div>
            <div class="">
               <label for="">Password: </label>
               <input type="password" name="password">
            </div>
            <input type="submit" name="submit_user" value="submit">
         </form>
         <table border="1">
            <thead>
               <tr>
                  <th>#</th>
                  <th>USERNAME</th>
                  <th>Hapus</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  $q = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT USERNAME FROM user");
                  $i=1;
                  while ($d = mysqli_fetch_assoc($q)) {
                     echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo '<td>'.$d['USERNAME'].'</td>';
                        echo '<td><a href="edit.php?hps=usr&usr='.$d['USERNAME'].'">HAPUS</a></td>';
                     echo '</tr>';
                     $i++;
                  }
               ?>
            </tbody>
         </table>
         <?php
            if (isset($_POST['submit_user'])) {
               $username = $_POST['username'];
               $password = $_POST['password'];
               $check = mysqli_query($GLOBALS["___mysqli_ston"],"SELECT USERNAME from user where USERNAME = '$username'");

               if (mysqli_num_rows($check) == 0) {
                  $query = mysqli_query($GLOBALS["___mysqli_ston"],"INSERT INTO user VALUES ('$username','$password')");
                  header("location: setting_user.php");
               }
            }
         ?>
      </div>
      <script type="text/javascript" src="js/jquery-3.2.1.js"></script>
      <script type="text/javascript" src="js/jquery-ui.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
   </body>
</html>

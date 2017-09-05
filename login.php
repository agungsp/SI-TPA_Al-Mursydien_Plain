<?php
   include 'login_proses.php';

   if(isset($_SESSION['login_user'])){
      header("location: menu.php");
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Login - Sistem Informasi TPA Al Mursyidien</title>
   </head>
   <body>
      <form class="" action="" method="post">
         <div class="">
            <label for="">Username: </label>
            <input type="text" name="username" id="txt_username" placeholder="Username Anda..." required autofocus>
         </div>
         <div class="">
            <label for="">Password: </label>
            <input type="password" name="password" id="txt_password" placeholder="*****" required>
         </div>
         <input type="submit" name="submit" id="btnSubmit" value="Login">
      </form>
   </body>
</html>

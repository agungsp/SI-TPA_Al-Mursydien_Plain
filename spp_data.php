<?php
   include 'mysql.php';
   include 'koneksi.php';
   $term = trim(strip_tags($_GET['term']));

   $qstring = "SELECT * from santri where NAMA_SANTRI LIKE '".$term."%'";
   $result = mysqli_query($GLOBALS["___mysqli_ston"], $qstring);

   while ($row = mysqli_fetch_array($result)){
       $row['value']=htmlentities(stripslashes($row['NAMA_SANTRI']));
       $row['id']=htmlentities(stripslashes($row['ID_SANTRI']));

       $row_set[] = $row;
   }
   echo json_encode($row_set);
?>

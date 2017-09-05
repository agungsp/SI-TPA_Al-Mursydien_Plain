<?php
//   include 'mysql.php';
  include 'koneksi.php';
  $term = $_GET['term'];

  $query  = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri where NAMA_SANTRI like '".$term."%'");
  $json = array();

  while($santri = mysqli_fetch_array($query)){
      $json[] = array(
          'label' => $santri['ID_SANTRI'].' - '.$santri['NAMA_SANTRI'], // text sugesti saat user mengetik di input box
          'value' => $santri['NAMA_SANTRI'], // nilai yang akan dimasukkan diinputbox saat user memilih salah satu sugesti
          'id' => $santri['ID_SANTRI']
      );
  }
  header("Content-Type: text/json");
  echo json_encode($json);
?>

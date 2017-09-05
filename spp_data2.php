<?php
//   include 'mysql.php';
  include 'koneksi.php';
  include 'format_number.php';
  $term = $_GET['term'];

  $query  = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * from santri where NAMA_SANTRI like '".$term."%'");
  $json = array();

  while($santri = mysqli_fetch_array($query)){
      $json[] = array(
          'label' => $santri['ID_SANTRI'].' - '.$santri['NAMA_SANTRI'], // text sugesti saat user mengetik di input box
          'value' => $santri['ID_SANTRI'], // nilai yang akan dimasukkan diinputbox saat user memilih salah satu sugesti
          'nama' => $santri['NAMA_SANTRI'],
        'terakhir_bayar' => 'Rp. '.rupiahFormat($santri['TOTAL_SPP']).',-'
      );
  }
  header("Content-Type: text/json");
  echo json_encode($json);
?>

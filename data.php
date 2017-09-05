<?php
//include 'mysql.php';
//connect ke database
  ($GLOBALS["___mysqli_ston"] = mysqli_connect("localhost", "root", "root"));
  mysqli_select_db($GLOBALS["___mysqli_ston"], dbkota);
//harus selalu gunakan variabel term saat memakai autocomplete,
//jika variable term tidak bisa, gunakan variabel q
$term = trim(strip_tags($_GET['term']));

$qstring = "SELECT * FROM kota WHERE nama_kota LIKE '".$term."%'";
//query database untuk mengecek tabel anime
$result = mysqli_query($GLOBALS["___mysqli_ston"], $qstring);

while ($row = mysqli_fetch_array($result))
{
    $row['value']=htmlentities(stripslashes($row['nama_kota']));
    $row['id']=(int)$row['id'];
//buat array yang nantinya akan di konversi ke json
    $row_set[] = $row;
}
//data hasil query yang dikirim kembali dalam format json
echo json_encode($row_set);
?> 

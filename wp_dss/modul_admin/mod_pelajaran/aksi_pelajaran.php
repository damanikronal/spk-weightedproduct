<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
$jlhjurusan = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM jurusan"),0); // Jumlah Jurusan
$jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria

// Update nilai
if ($modul=='pelajaran' AND $act=='input'){
  // Simpan data penilaian dalam array m[i][j]
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$m[$i][$j] = $_POST['m'.$i.$j];
		$n = $m[$i][$j];
		mysql_query("INSERT INTO penjurusan(id_kelas, nis, id_jurusan, id_kriteria, nilai)
	    VALUES('$_POST[id_kelas]', '$_POST[nis]', '$i', '$j', '$n')");
	}
  } 
  mysql_query("UPDATE siswa SET sts = 'Y' WHERE  nis = '$_POST[nis]'");
  header('location:../../indexs.php?modul='.$modul);
}

?>


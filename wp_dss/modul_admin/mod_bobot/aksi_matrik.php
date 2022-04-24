<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
$jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria
$jlhjurusan = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM jurusan"),0); // Jumlah Jurusan
// Hitung Matrik Perbandingan
if ($modul=='bobot' AND $act=='normalisasi'){
	for ($i=1; $i<=$jlhjurusan; $i++){
	  // FISRT STEP : NORMALISATION BOBOT SCALE
		$jumlah=0;
		for ($j=1;$j<=$jlhkriteria;$j++){
			$w[$j] = $_POST['bobot'.$i.$j];
			$jumlah += $w[$j];
		}
		for ($j=1;$j<=$jlhkriteria;$j++){
			$nama_kriteria[$j] = $_POST['nama_kriteria'.$i.$j];
			$w[$j] = $_POST['bobot'.$i.$j];
			$wn[$j] = round(($w[$j]/$jumlah),2);
			mysql_query("INSERT INTO bobot_kriteria(id_jurusan,id_kriteria,nama_kriteria,bobot,norm_bobot) 
			VALUES('$i', '$j', '$nama_kriteria[$j]', '$w[$j]', '$wn[$j]')");
		}
	}
  header('location:../../indexs.php?modul='.$modul);
}
elseif ($modul=='bobot' AND $act=='hitungulang'){
  mysql_query("DELETE FROM bobot_kriteria");
  header('location:../../indexs.php?modul='.$modul);
}

?>


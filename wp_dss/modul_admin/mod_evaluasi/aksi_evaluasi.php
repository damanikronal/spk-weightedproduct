<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
$jlhjurusan = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM jurusan"),0); // Jumlah Jurusan
$jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria

// Update nilai
if ($modul=='evaluasi' AND $act=='input'){
  // Simpan data penilaian dalam array m[i][j]
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$m[$i][$j] = $_POST['m'.$i.$j];
		$n = $m[$i][$j];
		mysql_query("INSERT INTO penjurusan(id_kelas, nis, id_jurusan, id_kriteria, nilai)
	    VALUES('$_POST[id_kelas]', '$_POST[nis]', '$i', '$j', '$n')");
	}
  } 
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$cek=mysql_query("SELECT tipe FROM kriteria WHERE id_kriteria='$j'");
		$ccek=mysql_fetch_array($cek);
		$bot=mysql_query("SELECT norm_bobot FROM bobot_kriteria WHERE id_jurusan='$i' AND id_kriteria='$j' 
		ORDER BY id_jurusan,id_kriteria ASC");
		$wn=mysql_fetch_array($bot);
		if ($ccek[tipe]=="COST"){
			$s[$i][$j]=round((pow($m[$i][$j],-$wn[norm_bobot])),4);
		}
		elseif ($ccek[tipe]=="BENEFIT"){
			$s[$i][$j]=round((pow($m[$i][$j],$wn[norm_bobot])),4);
		}
	}
  } 
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	$total=1;
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$total = $total*$s[$i][$j];
	}
	$sum[$i] = round($total,4);
  } 
  // THIRD STEP : FIND VECTOR VALUES
  $tem=0;
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	$tem += $sum[$i];
  }
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	$v[$i] = round(($sum[$i] / $tem),4);
	$bobot = $v[$i];
	mysql_query("INSERT INTO hasil(id_kelas, nis, pil_jur, bobot_jur) VALUES('$_POST[id_kelas]','$_POST[nis]', '$i', '$bobot')");
  }
  mysql_query("UPDATE siswa SET sts = 'F' WHERE  nis = '$_POST[nis]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Update nilai
elseif ($modul=='evaluasi' AND $act=='update'){
  // Simpan data penilaian dalam array m[i][j]
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$x[$i][$j] = $_POST['m'.$i.$j];
		$y = $x[$i][$j];
		mysql_query("UPDATE penjurusan 
		SET id_kelas = '$_POST[id_kelas]', nis = '$_POST[nis]', id_jurusan = '$i', id_kriteria = '$j', nilai = '$y'  
		WHERE  nis = '$_POST[nis]' AND id_kelas = '$_POST[id_kelas]' AND id_jurusan = '$i' AND id_kriteria = '$j'");
	}
  } 
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$cek=mysql_query("SELECT tipe FROM kriteria WHERE id_kriteria='$j'");
		$ccek=mysql_fetch_array($cek);
		$bot=mysql_query("SELECT norm_bobot FROM bobot_kriteria WHERE id_jurusan='$i' AND id_kriteria='$j' 
		ORDER BY id_jurusan,id_kriteria ASC");
		$wn=mysql_fetch_array($bot);
		if ($ccek[tipe]=="COST"){
			$s[$i][$j]=round((pow($x[$i][$j],-$wn[norm_bobot])),4);
		}
		elseif ($ccek[tipe]=="BENEFIT"){
			$s[$i][$j]=round((pow($x[$i][$j],$wn[norm_bobot])),4);
		}
	}
  } 
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	$total=1;
	for ($j=1;$j<=$jlhkriteria;$j++){ // Criteria
		$total = $total*$s[$i][$j];
	}
	$sum[$i] = round($total,4);
  } 
  // THIRD STEP : FIND VECTOR VALUES
  $tem=0;
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	$tem += $sum[$i];
  }
  for ($i=1;$i<=$jlhjurusan;$i++){ // Alternative
	$v[$i] = round(($sum[$i] / $tem),4);
	$bobot = $v[$i];
	mysql_query("INSERT INTO hasil(id_kelas, nis, pil_jur, bobot_jur) VALUES('$_POST[id_kelas]','$_POST[nis]', '$i', '$bobot')");
  }
  mysql_query("UPDATE siswa SET sts = 'F' WHERE  nis = '$_POST[nis]'");
  header('location:../../indexs.php?modul='.$modul);
}

?>


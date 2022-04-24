<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus section
if ($modul=='kelas' AND $act=='hapus'){
  mysql_query("DELETE FROM kelas WHERE id_kelas='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input kriteria
elseif ($modul=='kelas' AND $act=='input'){
  if ($_POST[nama_kelas] !='' AND $_POST[wali_kelas] !='' AND $_POST[jlh_siswa] !=''){
  mysql_query("INSERT INTO kelas(id_kelas, nama_kelas, wali_kelas) 
  VALUES('$_POST[id_kelas]', '$_POST[nama_kelas]', '$_POST[wali_kelas]')");
  header('location:../../indexs.php?modul='.$modul);
  }
  else{
  	echo "
  		<script>
		alert('! Maaf Seluruh Field Harus Diisi')
		location = '../../indexs.php?modul=kelas&act=tambah';
		</script>
	";
  }
}

// Update kriteria
elseif ($modul=='kelas' AND $act=='update'){
  if ($_POST[id_kelas] !='' AND $_POST[nama_kelas] !='' AND $_POST[wali_kelas] !='' AND $_POST[jlh_siswa] !=''){
  mysql_query("UPDATE kelas SET id_kelas = '$_POST[id_kelas]', nama_kelas = '$_POST[nama_kelas]', wali_kelas = '$_POST[wali_kelas]'
  WHERE id_kelas = '$_POST[id_kelas]'");
  header('location:../../indexs.php?modul='.$modul);
  }
  else{
  	echo "
  		<script>
		alert('! Maaf Seluruh Field Harus Diisi')
		location = '../../indexs.php?modul=kelas&act=edit&id=$_POST[id]';
		</script>
	";
  }
}
?>

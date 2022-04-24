<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus section
if ($modul=='jurusan' AND $act=='hapus'){
  mysql_query("DELETE FROM jurusan WHERE id_jurusan='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input kriteria
elseif ($modul=='jurusan' AND $act=='input'){
  if ($_POST[nama_jurusan] !=''){
  mysql_query("INSERT INTO jurusan(id_jurusan, nama_jurusan) VALUES('$_POST[id_jurusan]', '$_POST[nama_jurusan]')");
  header('location:../../indexs.php?modul='.$modul);
  }
  else{
  	echo "
  		<script>
		alert('! Maaf Seluruh Field Harus Diisi')
		location = '../../indexs.php?modul=jurusan&act=tambah';
		</script>
	";
  }
}

// Update kriteria
elseif ($modul=='jurusan' AND $act=='update'){
  if ($_POST[id_jurusan] !='' AND $_POST[nama_jurusan] !=''){
  mysql_query("UPDATE jurusan SET id_jurusan = '$_POST[id_jurusan]', nama_jurusan = '$_POST[nama_jurusan]' WHERE id_jurusan = '$_POST[id_jurusan]'");
  header('location:../../indexs.php?modul='.$modul);
  }
  else{
  	echo "
  		<script>
		alert('! Maaf Seluruh Field Harus Diisi')
		location = '../../indexs.php?modul=jurusan&act=edit&id=$_POST[id]';
		</script>
	";
  }
}
?>

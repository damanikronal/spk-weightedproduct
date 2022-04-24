<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus Karyawan
if ($modul=='guru' AND $act=='hapus'){
  mysql_query("DELETE FROM guru WHERE nip='$_GET[id]'");
  mysql_query("DELETE FROM pengguna WHERE nip='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input Karyawan
elseif ($modul=='guru' AND $act=='input'){
  $pass=md5($_POST[password]);
  mysql_query("INSERT INTO guru(
  								 nip,	
  								 nama_guru
								 ) 
	                       VALUES(
						        '$_POST[nip]',
								'$_POST[nama_guru]'
								)");
  mysql_query("INSERT INTO pengguna(
								 nip,
  								 username,
								 password,
								 level
								 ) 
	                       VALUES('$_POST[nip]',
                                '$_POST[username]',
								'$pass',
								'$_POST[level]'
								)");
  header('location:../../indexs.php?modul='.$modul);
}

// Update Karyawan
elseif ($modul=='guru' AND $act=='update'){
  if (empty($_POST[password])) {
    mysql_query("UPDATE guru SET 
                                  nip   = '$_POST[nip]',
								  nama_guru	     = '$_POST[nama_guru]'
                           WHERE  nip        = '$_POST[id]'");
	 mysql_query("UPDATE pengguna SET level = '$_POST[level]' 
                           WHERE  username       = '$_POST[id1]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
	mysql_query("UPDATE guru SET 
                                  nip   = '$_POST[nip]',
								  nama_guru	     = '$_POST[nama_guru]'
                           WHERE  nip        = '$_POST[id]'");
    mysql_query("UPDATE pengguna SET password = '$pass', level = '$_POST[level]' 
                           WHERE  username       = '$_POST[id1]'");
  }
  header('location:../../indexs.php?modul='.$modul);
}
?>


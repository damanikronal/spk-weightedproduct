<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus Karyawan
if ($modul=='siswa' AND $act=='hapus'){
  mysql_query("DELETE FROM siswa WHERE nis='$_GET[id]'");
  mysql_query("DELETE FROM pengguna WHERE nip='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input Karyawan
elseif ($modul=='siswa' AND $act=='input'){
  $pass=md5($_POST[password]);
  mysql_query("INSERT INTO siswa(
  								 id_kelas,	
  								 nis,
                                 nama_siswa
								 ) 
	                       VALUES(
						        '$_POST[id_kelas]',
								'$_POST[nis]',
                                '$_POST[nama_siswa]'
								)");
  mysql_query("INSERT INTO pengguna(
								 nip,
  								 username,
								 password
								 ) 
	                       VALUES('$_POST[nis]',
                                '$_POST[username]',
								'$pass'
								)");
  header('location:../../indexs.php?modul='.$modul);
}

// Update Karyawan
elseif ($modul=='siswa' AND $act=='update'){
  if (empty($_POST[password])) {
    mysql_query("UPDATE siswa SET 
                                  id_kelas   = '$_POST[id_kelas]',
								  nis	     = '$_POST[nis]',
								  nama_siswa = '$_POST[nama_siswa]' 
                           WHERE  nis        = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
	mysql_query("UPDATE siswa SET
                                  id_kelas   = '$_POST[id_kelas]',
								  nis			 = '$_POST[nis]',
								  nama_siswa		 = '$_POST[nama_siswa]' 
                           WHERE  nis       = '$_POST[id]'");
    mysql_query("UPDATE pengguna SET password = '$pass'
                           WHERE  username       = '$_POST[id1]'");
  }
  header('location:../../indexs.php?modul='.$modul);
}
?>


<?php
include "config/koneksi.php";

if ($_SESSION[leveluser]=='admin'){
  $sql=mysql_query("select * from menu where aktif='y' and status='admin' order by urutan");
}
else if ($_SESSION[leveluser]=='wali_kelas'){
  $sql=mysql_query("select * from menu where status='wali_kelas' and aktif='y' or urutan='4' order by urutan"); 
} 
else if ($_SESSION[leveluser]=='kepsek'){
  $sql=mysql_query("select * from menu where status='kepsek' and aktif='y' or urutan='4' or urutan='9' order by urutan"); 
} 
else if ($_SESSION[leveluser]=='siswa'){
  $sql=mysql_query("select * from menu where status='admin' and aktif='y' AND urutan='3' or urutan='9' order by urutan"); 
} 
while ($m=mysql_fetch_array($sql)){  
  echo "<li><a href='$m[link]'>&#187; $m[menu]</a></li>";
}
?>

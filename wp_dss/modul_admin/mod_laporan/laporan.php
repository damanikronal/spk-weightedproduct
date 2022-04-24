<?php
$queri=mysql_query("SELECT * FROM hasil");
$hasil=mysql_num_rows($queri);
if ($hasil){
    echo "<h2>Laporan Hasil Penjurusan SMA Dengan Metode Weighted Product</h2>
          <table>
          <tr><th>kelas</th><th>nis</th><th>nama siswa</th><th>dapat memilih</th><th>disarankan memilih</th></tr>"; 
	// Paging
  	$hal = $_GET[hal];
	if(!isset($_GET['hal'])){ 
		$page = 1; 
		$hal = 1;
	} else { 
		$page = $_GET['hal']; 
	}
	$jmlperhalaman = 10;  // jumlah record per halaman
	$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
	if ($_SESSION[leveluser] == 'siswa'){
		$tampil=mysql_query("SELECT k.nama_kelas,s.nis,s.nama_siswa,s.id_kelas 
							 FROM siswa s, kelas k
							 WHERE s.sts='F' AND s.id_kelas=k.id_kelas AND s.nis='$_SESSION[namauser]'
							 ORDER BY s.id_kelas, s.nis ASC LIMIT $offset, $jmlperhalaman");
	}
	else{
		$tampil=mysql_query("SELECT k.nama_kelas,s.nis,s.nama_siswa,s.id_kelas 
							 FROM siswa s, kelas k
							 WHERE s.sts='F' AND s.id_kelas=k.id_kelas
							 ORDER BY s.id_kelas, s.nis ASC LIMIT $offset, $jmlperhalaman");
	}
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
             <td>$r[nama_kelas]</td>
             <td>$r[nis]</td>";
	   if ($_SESSION[leveluser] == 'admin'){
	   	echo "<td><a href=indexs.php?modul=evaluasi&act=edit&id=$r[nis]>$r[nama_siswa]</a></td>";
	   }
	   else{
	   	echo "<td>$r[nama_siswa]</td>";
	   }
	   if ($_SESSION[leveluser] == 'siswa'){
	   $ipa=mysql_query("SELECT h.bobot_jur 
	                     FROM hasil h, siswa s, kelas k
						 WHERE k.id_kelas = h.id_kelas AND h.nis=s.nis AND s.id_kelas=k.id_kelas AND s.nis=$_SESSION[namauser]
						 AND h.id_kelas = '$r[id_kelas]' AND h.nis = '$r[nis]' AND h.pil_jur = '1'");
	   $ips=mysql_query("SELECT h.bobot_jur 
	                     FROM hasil h, siswa s, kelas k
						 WHERE k.id_kelas = h.id_kelas AND h.nis=s.nis AND s.id_kelas=k.id_kelas AND s.nis=$_SESSION[namauser]
						 AND h.id_kelas = '$r[id_kelas]' AND h.nis = '$r[nis]' AND h.pil_jur = '2'");
	   }
	   else{
	   $ipa=mysql_query("SELECT h.bobot_jur 
	                     FROM hasil h, siswa s, kelas k
						 WHERE k.id_kelas = h.id_kelas AND h.nis=s.nis AND s.id_kelas=k.id_kelas 
						 AND h.id_kelas = '$r[id_kelas]' AND h.nis = '$r[nis]' AND h.pil_jur = '1'");
	   $ips=mysql_query("SELECT h.bobot_jur 
	                     FROM hasil h, siswa s, kelas k
						 WHERE k.id_kelas = h.id_kelas AND h.nis=s.nis AND s.id_kelas=k.id_kelas 
						 AND h.id_kelas = '$r[id_kelas]' AND h.nis = '$r[nis]' AND h.pil_jur = '2'");
	   }
	   $ripa = mysql_fetch_array($ipa);
	   $rips = mysql_fetch_array($ips);
	   $percenipa = $ripa[bobot_jur] * 100;
	   $percenips = $rips[bobot_jur] * 100;
	   if ($ripa[bobot_jur] > $rips[bobot_jur]){
	   		$choose = "$percenipa % Jurusan IPA";
	   }
	   elseif ($ripa[bobot_jur] < $rips[bobot_jur]){
	   		$choose = "$percenips % Jurusan IPS";
	   }
	   elseif ($ripa[bobot_jur] == $rips[bobot_jur]){
	   		$choose = "$percenipa % Jurusan IPA dan $percenips % Jurusan IPS";
	   }
	   echo "
	   <td>Dapat memilih $percenipa % Jurusan IPA dan $percenips % Jurusan IPS</td>
	   <td>$choose</td>
			 </tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	if ($_SESSION[leveluser] == 'siswa'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM siswa WHERE sts = 'F' AND nis='$_SESSION[namauser]'"),0);
	}
	else{
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM siswa WHERE sts = 'F'"),0);
	}
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=laporan&hal=$prev> << </a> "; 
	}
	if($total_halaman<=10){
	$hal1=1;
	$hal2=$total_halaman;
	}else{
	$hal1=$hal-$perhal;
	$hal2=$hal+$perhal;
	}
	if($hal<=5){
	$hal1=1;
	}
	if($hal<$total_halaman){
	$hal2=$hal+$perhal;
	}else{
	$hal2=$hal;
	}
	for($i = $hal1; $i <= $hal2; $i++){ 
		if(($hal) == $i){ 
			echo "[<b>$i</b>] "; 
			} else { 
		if($i<=$total_halaman){
				echo "<a href=indexs.php?modul=laporan&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=laporan&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
	
	if ($_SESSION[leveluser] == 'siswa'){
	}
	else{
	echo "<h2>Cetak Laporan Hasil Penjurusan SMA (PDF)</h2>
          <form method='POST' action='config/cetak.php'>
          <table>
		  ";?> 
		  
	<?
	echo "
		  <tr><td colspan=2><input type=submit name=submit value=Cetak ></td></tr>
          </table></form>"; 
	}
}
else {
	echo "Belum ada laporan";
}

?>

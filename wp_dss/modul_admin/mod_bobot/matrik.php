<?php
$aksi="modul_admin/mod_bobot/aksi_matrik.php";
switch($_GET[act]){
  // Tampil Matrik Perbandingan Kriteria
  default:
  	$tampil1=mysql_query("SELECT nama_kriteria, bobot FROM bobot_kriteria ORDER BY id_kriteria");
	$r1=mysql_num_rows($tampil1);
	if ($r1 > 0){
    	echo "<h2>Bobot Akhir Kriteria</h2>";
		echo "
			<table>
          <tr><th>jurusan</th><th>kriteria</th><th>bobot</th><th>normalisasi bobot</th></tr>"; 
		$tampil2=mysql_query("SELECT j.nama_jurusan, b.nama_kriteria, b.bobot, b.norm_bobot
		 FROM bobot_kriteria b, jurusan j
		 WHERE b.id_jurusan=j.id_jurusan
		 ORDER BY b.id_jurusan,b.id_kriteria");
		while ($r2=mysql_fetch_array($tampil2)){
		   echo "<tr>
		   		<td>$r2[nama_jurusan]</td>
				<td>$r2[nama_kriteria]</td>
				 <td>$r2[bobot]</td>
				 <td>$r2[norm_bobot]</td>
				 </tr>";
		}
		echo "</table>";
		echo "<br>";
		echo "<a href=$aksi?modul=bobot&act=hitungulang>Hitung ulang normalisasi bobot kriteria.</a>";
	}
	else{
		echo "Belum dilakukan normalisasi bobot kriteria. 
		<br><a href=?modul=bobot&act=normalisasi>Buat Normalisasi Bobot Kriteria</a>";
	}
    break;
  
  // Matrik Perbandingan
  case "normalisasi":
    echo "<h2>Normalisasi Bobot Kriteria</h2>";
    echo "<form method='post' action='$aksi?modul=bobot&act=normalisasi'>
		  <table>
          <tr><th>jurusan</th><th>kriteria</th><th>nilai (bobot kriteria)</th></tr>"; 
    $jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria
	$jlhjurusan = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM jurusan"),0); // Jumlah Jurusan
	for ($i=1; $i<=$jlhjurusan; $i++){
		$queri1=mysql_query("SELECT * FROM jurusan WHERE id_jurusan='$i' ORDER BY id_jurusan ASC");
		$r3=mysql_fetch_array($queri1);
		for ($j=1; $j<=$jlhkriteria; $j++){
			$queri2=mysql_query("SELECT * FROM kriteria WHERE id_kriteria='$j' ORDER BY id_kriteria ASC");
			$kriteria2=mysql_fetch_array($queri2);
			echo "<tr>";
			echo "
			<td>$r3[nama_jurusan]<input type=hidden name='id_jurusan".$i.$j."' value='$r3[id_jurusan]'></td>
			<td>$kriteria2[nama_kriteria]<input type=hidden name='id_kriteria".$i.$j."' value='$kriteria2[id_kriteria]'>
			<input type=hidden name='nama_kriteria".$i.$j."' value='$kriteria2[nama_kriteria]'></td>
			<td><input type=text name='bobot".$i.$j."'></td>
				 ";
			echo "</tr>";
		}
	}
    echo "</table>
	<input type='submit' name='Submit' value='Submit'><input type=button value=Batal onclick=self.history.back()></form>";
	break;
}
?>
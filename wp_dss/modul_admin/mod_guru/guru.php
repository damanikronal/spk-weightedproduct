<?php
$aksi="modul_admin/mod_guru/aksi_guru.php";
switch($_GET[act]){
  // Tampil Karyawan
  default:
    echo "<h2>Manajemen Data Guru</h2>";
	if ($_SESSION[leveluser] == 'admin'){
    	echo "<input type=button value='Tambah Guru' onclick=\"window.location.href='?modul=guru&act=tambah';\">";
	}
    echo "<table>
          <tr><th>nip</th><th>nama lengkap</th><th>jabatan</th><th>aksi</th></tr>"; 
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
	if ($_SESSION[leveluser] == 'admin'){
		$tampil=mysql_query("SELECT g.nip,g.nama_guru,p.level FROM guru g, pengguna p
		 WHERE g.nip=p.nip
		 ORDER BY g.nip,g.nama_guru ASC LIMIT $offset, $jmlperhalaman");
	}
	else if ($_SESSION[leveluser] == 'wali_kelas'){
		$tampil=mysql_query("SELECT g.nip,g.nama_guru,p.level FROM guru g, pengguna p
		 WHERE g.nip=p.nip AND p.level='wali_kelas' AND g.nip='$_SESSION[namauser]'
		 ORDER BY g.nip,g.nama_guru ASC LIMIT $offset, $jmlperhalaman");
	}
	else if ($_SESSION[leveluser] == 'kepsek'){
		$tampil=mysql_query("SELECT g.nip,g.nama_guru,p.level FROM guru g, pengguna p
		 WHERE g.nip=p.nip AND p.level='kepsek' AND g.nip='$_SESSION[namauser]'
		 ORDER BY g.nip,g.nama_guru ASC LIMIT $offset, $jmlperhalaman");
	}
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
			 <td>$r[nip]</td>
             <td>$r[nama_guru]</td>
			 <td>$r[level]</td>
		     <td><a href=?modul=guru&act=edit&id=$r[nip]>Edit</a> | ";
	               
?>
	   <a href="modul_admin/mod_guru/aksi_guru.php?modul=guru&act=hapus&id=<? echo "$r[nip]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- NIP  = $r[nip]"; ?> ' +  '\n'
							+ ' <?php echo "- Nama Lengkap  = $r[nama_guru]"; ?> ' +  '\n' 
							+ ' <?php echo "- Jabatan = $r[level]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	if ($_SESSION[leveluser] == 'admin'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM guru"),0);
	}
	else if ($_SESSION[leveluser] == 'wali_kelas'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM guru WHERE nip='$_SESSION[namauser]'"),0);
	}
	else if ($_SESSION[leveluser] == 'kepsek'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM guru WHERE nip='$_SESSION[namauser]'"),0);
	}
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=guru&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=guru&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=guru&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  case "tambah":
    echo "<h2>Tambah Guru</h2>
          <form method=POST action='$aksi?modul=guru&act=input'>
          <table>
          <tr><td>NIP</td>     <td> : <input type=text name='nip'></td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_guru' size=30></td></tr>
		  <tr><td>Username</td>   <td> : <input type=text name='username' size=20></td></tr>
		  <tr><td>Password</td>   <td> : <input type=password name='password' size=20></td></tr>
		  <tr><td>Level</td>     <td> : <input type=radio name='level' value='admin'> Admin   
                                           <input type=radio name='level' value='wali_kelas' checked> Wali Kelas
										   <input type=radio name='level' value='kepsek'> Kepala Sekolah  
                                           </td></tr>
		  <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
    
  case "edit":
    $edit=mysql_query("SELECT * FROM guru WHERE nip='$_GET[id]'");
    $r=mysql_fetch_array($edit);
	$edit1=mysql_query("SELECT * FROM pengguna WHERE nip='$_GET[id]'");
    $r1=mysql_fetch_array($edit1);

    echo "<h2>Edit Guru</h2>
          <form method=POST action=$aksi?modul=guru&act=update>
          <input type=hidden name=id value='$r[nip]'><input type=hidden name=id1 value='$r1[username]'>
          <table>
		  <tr><td>NIP</td> <td> : <input type=text readonly name='nip' size=30 value='$r[nip]'></td></tr>
		  <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_guru' size=30 value='$r[nama_guru]'></td></tr>
		  <tr><td>Username</td>     <td> : <input type=text readonly name='username' value='$r1[username]'></td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password'></td></tr>";

    if ($r1[level]=='admin'){
      echo "<tr><td>Level</td>     <td> : <input type=radio name='level' value='admin' checked> Admin   
                                           <input type=radio name='level' value='wali_kelas'> Wali kelas
										   <input type=radio name='level' value='kepsek'> Kepala Sekolah   
                                           </td></tr>";
    }
    else if ($r1[level]=='wali_kelas'){
      echo "<tr><td>Level</td>     <td> : <input type=radio name='level' value='admin'> Admin   
                                            <input type=radio name='level' value='wali_kelas' checked> Wali kelas
										   <input type=radio name='level' value='kepsek'> Kepala Sekolah
                                           </td></tr>";
    }
    else if ($r1[level]=='kepsek'){
      echo "<tr><td>Level</td>     <td> : <input type=radio name='level' value='admin'> Admin   
                                            <input type=radio name='level' value='wali_kelas'> Wali kelas
										   <input type=radio name='level' value='kepsek' checked> Kepala Sekolah
                                           </td></tr>";
    }
    echo "<tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

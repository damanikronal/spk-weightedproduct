<?php
$aksi="modul_admin/mod_siswa/aksi_siswa.php";
switch($_GET[act]){
  // Tampil Karyawan
  default:
    echo "<h2>Manajemen Data Siswa</h2>";
	if ($_SESSION[leveluser] == 'admin'){
    	echo "<input type=button value='Tambah Siswa' onclick=\"window.location.href='?modul=siswa&act=tambah';\">";
	}
    echo "<table>
          <tr><th>id_kelas</th><th>nis</th><th>nama lengkap</th><th>aksi</th></tr>"; 
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
    $tampil=mysql_query("SELECT s.nis,s.nama_siswa,k.nama_kelas FROM siswa s, kelas k
	 WHERE s.id_kelas=k.id_kelas ORDER BY k.id_kelas,s.nis ASC LIMIT $offset, $jmlperhalaman");
	}
	else if ($_SESSION[leveluser] == 'siswa'){
		$tampil=mysql_query("SELECT s.nis,s.nama_siswa,k.nama_kelas FROM siswa s, kelas k
	 WHERE s.id_kelas=k.id_kelas AND s.nis='$_SESSION[namauser]' ORDER BY k.id_kelas,s.nis ASC LIMIT $offset, $jmlperhalaman");
	}
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
			 <td>$r[nama_kelas]</td>
             <td>$r[nis]</td>
			 <td>$r[nama_siswa]</td>
		     <td><a href=?modul=siswa&act=edit&id=$r[nis]>Edit</a> | ";
	               
?>
	   <a href="modul_admin/mod_siswa/aksi_siswa.php?modul=siswa&act=hapus&id=<? echo "$r[nis]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Id Kelas  = $r[id_kelas]"; ?> ' +  '\n'
							+ ' <?php echo "- NIS  = $r[nis]"; ?> ' +  '\n' 
							+ ' <?php echo "- Nama Siswa = $r[nama_siswa]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	if ($_SESSION[leveluser] == 'admin'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM siswa"),0);
	}
	else if ($_SESSION[leveluser] == 'siswa'){
		$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM siswa WHERE nis='$_SESSION[namauser]'"),0);
	}
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=siswa&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=siswa&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=siswa&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  case "tambah":
    echo "<h2>Tambah Siswa</h2>
          <form method=POST action='$aksi?modul=siswa&act=input'>
          <table>
          ";
    $edit2=mysql_query("SELECT * FROM kelas ORDER BY id_kelas,nama_kelas ASC");
			echo "<tr><td>Id Kelas</td><td> : <select name='id_kelas'>";
			while ($r2=mysql_fetch_array($edit2)){
			echo "<option value='$r2[id_kelas]'>$r2[nama_kelas]</option>";
			}
	echo "</select></td><tr><td>NIS</td> <td> : <input type=text name='nis' size=30></td></tr>
		  <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_siswa' size=30></td></tr>
		  <tr><td>Username</td>   <td> : <input type=text name='username' size=20></td></tr>
		  <tr><td>Password</td>   <td> : <input type=password name='password' size=20></td></tr>
		  <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
    
  case "edit":
    $edit=mysql_query("SELECT s.nis,s.nama_siswa,k.nama_kelas,k.id_kelas FROM siswa s, kelas k
	 WHERE s.nis='$_GET[id]' AND s.id_kelas=k.id_kelas");
    $r=mysql_fetch_array($edit);
	$edit1=mysql_query("SELECT * FROM pengguna WHERE nip='$_GET[id]'");
    $r1=mysql_fetch_array($edit1);

    echo "<h2>Edit Siswa</h2>
          <form method=POST action=$aksi?modul=siswa&act=update>
          <input type=hidden name=id value='$r[nis]'><input type=hidden name=id1 value='$r1[username]'>
          <table>
		  <tr><td>Id_Kelas</td> <td> : <input type=hidden readonly name='id_kelas' size=30 value='$r[id_kelas]'>
		  $r[nama_kelas]
		  </td></tr>
		  <tr><td>NIS</td> <td> : <input type=text readonly name='nis' size=30 value='$r[nis]'></td></tr>
          <tr><td>Nama Lengkap</td> <td> : <input type=text name='nama_siswa' size=30  value='$r[nama_siswa]'></td></tr>
		  <tr><td>Username</td>     <td> : <input type=text readonly name='username' value='$r1[username]'></td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password'></td></tr>";
    echo "<tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

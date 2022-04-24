<?php
$aksi="modul_admin/mod_kelas/aksi_kelas.php";

switch($_GET[act]){
  // Tampil Kelas
  default:
    echo "<h2>Manajemen Data Kelas</h2>
          <input type=button value='Tambah Kelas' 
          onclick=\"window.location.href='?modul=kelas&act=tambah';\">
          <table>
          <tr><th>id kelas</th><th>nama kelas</th><th>wali kelas</th><th>aksi</th></tr>"; 
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
    $tampil=mysql_query("SELECT k.id_kelas,k.nama_kelas,g.nama_guru
	 FROM kelas k, guru g WHERE k.wali_kelas=g.nip ORDER BY k.id_kelas ASC LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[id_kelas]</td>
             <td>$r[nama_kelas]</td>
			 <td>$r[nama_guru]</td>
             <td><a href=?modul=kelas&act=edit&id=$r[id_kelas]>Edit</a> | ";
?>
	   <a href="modul_admin/mod_kelas/aksi_kelas.php?modul=kelas&act=hapus&id=<? echo "$r[id_kelas]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Id Kelas  = $r[id_kelas]"; ?> ' +  '\n' 
							+ ' <?php echo "- Kelas = $r[nama_kelas]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kelas"),0);
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=kelas&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=kelas&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=kelas&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
  include "config/otomasi.php";
    echo "<h2>Tambah Kelas</h2>
          <form method=POST action='$aksi?modul=kelas&act=input'>
          <table>
          <tr><td>Id Kelas</td><td> : <input readonly type=text name='id_kelas' value='$val_kel'></td></tr>
		  <tr><td>Nama Kelas</td><td> : <input type=text name='nama_kelas'></td></tr>";
		  $edit2=mysql_query("SELECT * FROM guru ORDER BY nip,nama_guru ASC");
			echo "<tr><td>Wali Kelas</td><td> : <select name='wali_kelas'>";
			while ($r2=mysql_fetch_array($edit2)){
			echo "<option value='$r2[nip]'>$r2[nama_guru]</option>";
			}
	echo "</select></td></tr>
		  <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM kelas WHERE id_kelas='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Kelas</h2>
          <form method=POST action=$aksi?modul=kelas&act=update>
          <input type=hidden name=id value='$r[id_kelas]'>
          <table>
          <tr><td>Id Kelas</td><td> : <input type=text readonly name='id_kelas' value='$r[id_kelas]'></td></tr>
		  <tr><td>Nama Kelas</td><td> : <input type=text name='nama_kelas' value='$r[nama_kelas]'></td></tr>";
		  $edit3=mysql_query("SELECT g.nama_guru FROM kelas k, guru g WHERE k.wali_kelas=g.nip AND k.id_kelas=$r[id_kelas]");
		  $r3=mysql_fetch_array($edit3);
		  $edit2=mysql_query("SELECT * FROM guru ORDER BY nip,nama_guru ASC");
			echo "<tr><td>Wali Kelas</td><td> : $r3[nama_guru] <select name='wali_kelas'>";
			while ($r2=mysql_fetch_array($edit2)){
			echo "<option value='$r2[nip]'>$r2[nama_guru]</option>";
			}
	echo "</select></td></tr>
		  <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
	
}
?>


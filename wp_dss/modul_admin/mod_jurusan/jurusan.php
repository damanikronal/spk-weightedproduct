<?php
$aksi="modul_admin/mod_jurusan/aksi_jurusan.php";

switch($_GET[act]){
  // Tampil Kriteria
  default:
    echo "<h2>Manajemen Data Jurusan SMA</h2>
          <input type=button value='Tambah Jurusan' 
          onclick=\"window.location.href='?modul=jurusan&act=tambah';\">
          <table>
          <tr><th>id jurusan</th><th>nama jurusan</th><th>aksi</th></tr>"; 
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
    $tampil=mysql_query("SELECT * FROM jurusan ORDER BY id_jurusan ASC LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[id_jurusan]</td>
             <td>$r[nama_jurusan]</td>
             <td><a href=?modul=jurusan&act=edit&id=$r[id_jurusan]>Edit</a> | ";
?>
	   <a href="modul_admin/mod_jurusan/aksi_jurusan.php?modul=jurusan&act=hapus&id=<? echo "$r[id_jurusan]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Id Jurusan  = $r[id_jurusan]"; ?> ' +  '\n' 
							+ ' <?php echo "- Jurusan = $r[nama_jurusan]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM jurusan"),0);
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=jurusan&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=jurusan&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=jurusan&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
  include "config/otomasi.php";
    echo "<h2>Tambah Jurusan SMA</h2>
          <form method=POST action='$aksi?modul=jurusan&act=input'>
          <table>
          <tr><td>Id Jurusan</td><td> : <input readonly type=text name='id_jurusan' value='$val_jur'></td></tr>
		  <tr><td>Nama Jurusan</td><td> : <input type=text name='nama_jurusan'></td></tr>
		  <tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM jurusan WHERE id_jurusan='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Jurusan SMA</h2>
          <form method=POST action=$aksi?modul=jurusan&act=update>
          <input type=hidden name=id value='$r[id_jurusan]'>
          <table>
          <tr><td>Id Jurusan</td><td> : <input type=text readonly name='id_jurusan' value='$r[id_jurusan]'></td></tr>
		  <tr><td>Nama Jurusan</td><td> : <input type=text name='nama_jurusan' value='$r[nama_jurusan]'></td></tr>
		  <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
	
}
?>


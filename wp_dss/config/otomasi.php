<?
// Otomasi Id Jurusan
// Cek apakah Id Jurusan sudah ada di tabel
$oto_jur=mysql_query("SELECT * FROM jurusan ORDER BY id_jurusan DESC LIMIT 1");
$rowsjur=mysql_num_rows($oto_jur);
if ($rowsjur >= 1) {
	$temjur=mysql_fetch_row($oto_jur);
	$val_jur = $temjur[0] + 1;
}else{
	$val_jur=1;
}

// Otomasi Kode Pelajaran
// Cek apakah Kode Pelajaran sudah ada di tabel
$tot_pelajaran=mysql_query("SELECT * FROM mata_pelajaran");
$num_pelajaran=mysql_fetch_array($tot_pelajaran);
if ($num_pelajaran){
	$oto_pelajaran=mysql_query("SELECT CONCAT('P',LPAD((RIGHT(MAX(kd_pelajaran),2)+1),2,'0')) FROM mata_pelajaran");
	$valpel=mysql_fetch_row($oto_pelajaran);
	$val_pel=$valpel[0];
}else{
	$val_pel='P01';
}

// Otomasi kelas
$tot_kelas=mysql_query("SELECT * FROM kelas ORDER BY id_kelas DESC LIMIT 1");
$num_kelas=mysql_num_rows($tot_kelas);
if ($num_kelas >= 1){
	$valkel=mysql_fetch_row($tot_kelas);
	$val_kel=$valkel[0]+1;
}else{
	$val_kel=1;
}

// Otomasi Kode Kriteria
$oto_cri=mysql_query("SELECT id_kriteria FROM kriteria ORDER BY id_kriteria DESC LIMIT 1");
$rows=mysql_num_rows($oto_cri);
if ($rows >= 1) {
	$temcri=mysql_fetch_row($oto_cri);
	$val_otocri = $temcri[0] + 1;
}
else{
	$val_otocri=1;
}

/*
// Otomasi Kode Customer
$oto_cus=mysql_query("SELECT CONCAT('C',LPAD((RIGHT(MAX(kd_cus),3)+1),3,'0')) FROM customer");
$val_otocus=mysql_fetch_row($oto_cus);

// Otomasi Kode Work Order
$oto_wo=mysql_query("SELECT CONCAT('W',LPAD((RIGHT(MAX(no_wo),3)+1),3,'0')) FROM work_orders");
$val_otowo=mysql_fetch_row($oto_wo);

// Otomasi Kode Work Order Execute
$oto_wox=mysql_query("SELECT CONCAT('WX',LPAD((RIGHT(MAX(no_wox),3)+1),3,'0')) FROM wo_execute");
$val_otowox=mysql_fetch_row($oto_wox);

// Otomasi Kode Kriteria
$oto_cri=mysql_query("SELECT id_kriteria FROM kriteria ORDER BY id_kriteria DESC LIMIT 1");
$rows=mysql_num_rows($oto_cri);
if ($rows >= 1) {
	$temcri=mysql_fetch_row($oto_cri);
	$val_otocri = $temcri[0] + 1;
}
else{
	$val_otocri=1;
}
*/
?>
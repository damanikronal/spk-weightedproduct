<?php
include "koneksi.php";
require("fpdf.php");

	//Variabel untuk iterasi
	$i = 0;
	$tampil=mysql_query("SELECT k.nama_kelas,s.nis,s.nama_siswa,s.id_kelas 
	                     FROM siswa s, kelas k
						 WHERE s.sts='F' AND s.id_kelas=k.id_kelas
						 ORDER BY s.id_kelas, s.nis ASC");


while($data=mysql_fetch_row($tampil)){
	$ipa=mysql_query("SELECT h.bobot_jur 
	                     FROM hasil h, siswa s, kelas k
						 WHERE k.id_kelas = h.id_kelas AND h.nis=s.nis AND s.id_kelas=k.id_kelas
						 AND h.id_kelas = '$data[3]' AND h.nis = '$data[1]' AND h.pil_jur = '1'");
	$ips=mysql_query("SELECT h.bobot_jur 
	                     FROM hasil h, siswa s, kelas k
						 WHERE k.id_kelas = h.id_kelas AND h.nis=s.nis AND s.id_kelas=k.id_kelas
						 AND h.id_kelas = '$data[3]' AND h.nis = '$data[1]' AND h.pil_jur = '2'");
	$ripa = mysql_fetch_array($ipa);
	$rips = mysql_fetch_array($ips);
	$percenipa = $ripa[bobot_jur] * 100;
	$percenips = $rips[bobot_jur] * 100;
	$req="Dapat memilih $percenipa % Jurusan IPA dan $percenips % Jurusan IPS";
	if ($ripa[bobot_jur] > $rips[bobot_jur]){
		$choose = "$percenipa % Jurusan IPA";
	}
	elseif ($ripa[bobot_jur] < $rips[bobot_jur]){
		$choose = "$percenips % Jurusan IPS";
	}
	elseif ($ripa[bobot_jur] == $rips[bobot_jur]){
		$choose = "$percenipa % Jurusan IPA dan $percenips % Jurusan IPS";
	}
	$cell[$i][0] = $data[0];
	$cell[$i][1] = $data[1];
	$cell[$i][2] = $data[2];
	$cell[$i][3] = $req;
	$cell[$i][4] = $choose;
	$i++;
}
//memulai pengaturan output PDF
class PDF extends FPDF
{
//untuk pengaturan header halaman
function Header()
{
//Pengaturan Font Header
$this->SetFont('Times','B',12); //jenis font : Times New Romans, Bold, ukuran 12

//Logo
$this->Image('img/head.png',2,1,26);

//untuk warna background Header
$this->SetFillColor(255,255,255);

//untuk warna text
$this->SetTextColor(0,0,0);
	
//Menampilkan tulisan di halaman
//$this->Cell(10,1,'Laporan Evaluasi Kinerja Karyawan PT.XXX','0',0,'C'); //TBLR (untuk garis)=> B = Bottom,
// L = Left, R = Right
//untuk garis, C = center
}
}

//pengaturan ukuran kertas P = Portrait
$pdf = new PDF('L','cm','A4');
$pdf->SetMargins(2,2,1.5,1.5); //membuat margin (kiri,atas,kanan)
$pdf->Open();
$pdf->AddPage();

//Ln() = untuk pindah baris
$pdf->Ln(3);
$pdf->Cell(7.6,1,'Laporan Hasil Penjurusan SMA Cinta Belajar.',0,0,'L');
$pdf->Ln(0.5);
$pdf->Cell(8.5,1,$total,0,0,'L');
$pdf->Ln(1.5);
//bagian untuk memasukkan keterangan tabel
$pdf->SetFont('Times','',11); //set font untuk keterangan tabel
$pdf->Cell(3,1,'Kelas',1,0,'C');
$pdf->Cell(3,1,'NIS',1,0,'C');	//(lebar ruangan,tinggi tulisan,teks,border,posisi baris			
												//berikutnya,align cell)
$pdf->Cell(4,1,'Nama Siswa',1,0,'C');
$pdf->Cell(10,1,'Dapat Memilih',1,0,'C');
$pdf->Cell(5,1,'Disarankan Memilih',1,0,'C');

$pdf->Ln();
	
//bagian untuk memasukkan isi tabel
for ($j=0;$j<$i;$j++)
{
	$pdf->SetFont('Times','',10);
	$pdf->Cell(3,0.7,$cell[$j][0],1,0,'L');
	$pdf->Cell(3,0.7,$cell[$j][1],1,0,'L');
	$pdf->Cell(4,0.7,$cell[$j][2],1,0,'L');
	$pdf->Cell(10,0.7,$cell[$j][3],1,0,'L');
	$pdf->Cell(5,0.7,$cell[$j][4],1,0,'L');
	$pdf->Ln();
}
	
$pdf->Output();

?>
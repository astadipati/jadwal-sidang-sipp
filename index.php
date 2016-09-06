<?php 
include "template/header.php";
include "connection.php" ;
$page = $_SERVER['PHP_SELF'];
$sec = "1000";

$queri_jumlah_sidang = mysql_query ("SELECT	COUNT(*)
FROM perkara_jadwal_sidang 
WHERE tanggal_sidang = DATE(NOW())");

$query = mysql_query("SELECT C.masuk AS masuk, C.minutasi as minutasi, C.sisa AS sisa,
(SELECT VALUE FROM sys_config WHERE id = 62) AS namaPN,
(SELECT VALUE FROM sys_config WHERE id = 80) AS versiSIPP,
@kinerjaPN := ROUND(SUM(C.minutasi)*100/(SUM(C.masuk)+SUM(C.sisa)),2) AS kinerjaPN,
(CASE WHEN @kinerjaPN < 50.00 THEN 'red' WHEN @kinerjaPN >=90 THEN 'green' ELSE '#def30c' END) AS warnaPN
FROM (SELECT
SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW())-1 AND (YEAR(B.tanggal_minutasi)>=YEAR(NOW()) OR (B.tanggal_minutasi IS NULL OR B.tanggal_minutasi='')) THEN 1 ELSE 0 END) AS sisa,
SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)=YEAR(NOW()) THEN 1 ELSE 0 END) AS masuk,
SUM(CASE WHEN YEAR(A.tanggal_pendaftaran)<=YEAR(NOW()) AND YEAR(B.tanggal_minutasi)=YEAR(NOW()) THEN 1 ELSE 0 END) AS minutasi
FROM perkara AS A LEFT JOIN perkara_putusan AS B ON A.perkara_id=B.perkara_id WHERE A.alur_perkara_id <> 114) AS C;
") or die("Query failed with error: ".mysql_error());
$row = mysql_fetch_assoc($query);
$namaPN = $row['namaPN'];
$versiSIPP = $row['versiSIPP'];
$kinerjaPN = $row['kinerjaPN'];
$warnaPN = $row['warnaPN'];
$sisa_tahun_lalu = $row['sisa'];
$masuk_tahun_ini = $row['masuk'];
$minutasi_tahun_ini = $row['minutasi']; 
$namaHari   = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");  
$namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"); 
$today = date('l, jS F Y');  
$sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y');  
?>
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
<div class="container home">
	<!-- <center><h3>PENGADILAN AGAMA TUBAN</h3></center> -->
	<center><img  width="70" src="images/patuban.jpg" /></center>
	<center><h3>Ratio Penanganan Perkara Pengadilan Agama Tuban</h3></center>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th width="20px">Perkara Sisa</th>
          <th width="20px">Perkara Masuk</th>
          <th width="20px">Perkara Minutasi</th>
          <th width="20px">Ratio</th>
        </tr>
        <tr>
          <th width="20px"><?=$sisa_tahun_lalu;?></th>
          <th width="20px"><?=$masuk_tahun_ini;?></th>
          <th width="20px"><?=$minutasi_tahun_ini;?></th>
          <th width="20px"><?=$kinerjaPN;?> %</th>
        </tr>
      </thead>
    </table>

    <!-- <b><?php echo $queri_jumlah_sidang ?><br></b> -->
	<center><h3>Jadwal Sidang Hari <?php echo $sekarang ?></h3></center>
	<table class="table table-bordered">
      <thead>
        <tr>
                  
                  <th width="20%">Nomor Perkara</th>
                  <th width="8%">Ruang Sidang</th>
                  <th width="15%">Agenda Sidang</th>
                  <th width="20%">Pihak 1</th>
                  <th width="20%">Pihak 2</th>
        </tr>
      </thead>
    </table>
    <marquee behavior="scroll" scrollamount="2" direction="up" onmouseover="this.stop();" onmouseout="this.start();">
		<table class="table table-bordered table-hover">
              <thead>
                <tr>
                  
                  <th width="20%">----</th>
                  <th width="8%">----</th>
                  <th width="15%">----</th>
                  <th width="20%">----</th>
                  <th width="20%">----</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
        $result = mysql_query("SELECT
        
        perkara.nomor_perkara AS noPerkara,
        jadwalSidang.ruangan AS ruangSidang, 
        jadwalSidang.agenda AS agendaSidang,
        perkara.pihak1_text AS pihak1,
        perkara.pihak2_text AS pihak2,
        perkara.para_pihak AS paraPihak
        FROM perkara_jadwal_sidang AS jadwalSidang
        LEFT JOIN perkara ON perkara.perkara_id=jadwalSidang.perkara_id
        WHERE jadwalSidang.tanggal_sidang=DATE(NOW());");			
				while($data = mysql_fetch_object($result) ):
			  ?>
      
                <tr>

                  <td><?php echo $data->noPerkara?></td>
                  <td><?php echo $data->ruangSidang?></td>
                  <td><?php echo $data->agendaSidang?></td>
                  <td><?php echo $data->pihak1?></td>
                  <td><?php echo $data->pihak2?></td>
                  <!-- <td><?php echo $data->paraPihak?></td> -->
                </tr>   
			  <?php
				endwhile;
			   ?>
        </tbody>
		</table>
		</marquee>
</div>	
</div>
</body>
</html>

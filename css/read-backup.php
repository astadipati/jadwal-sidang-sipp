<?php include 'template-parts/header.php' ?>	
<div class="container home">
		<h3> Data dan Nilai Peserta Lomba </h3>
		<?php include "connection.php"  ?>
		<table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th width="15px">ID</th>
                  <th >Nama Lengkap</th>
                  <th>Alamat</th>
                  <th>Jenis Kelamin</th>
		  <th>Alamat Situs</th>
                  <th width="50px">Nilai 1</th>
                  <th width="50px">Nilai 2</th>
                  <th width="50px">Nilai 3</th>
                  <th width="50px">Nilai 4</th>
                  <th width="50px">Nilai 5</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
			  <?php 
                          //======sniff=================
//                                $hasil=  mysql_query("SELECT nilai1,nilai2,(nilai1+nilai2)as total from lombacuy");
//                                //$alltotal = mysql_fetch_array($hasil);
//                                $alltotal = array();
//                                $alltotal = mysql_fetch_object($hasil);
                           //=====sniff tampil data==================
                                $result = mysql_query("SELECT id,namadepan,namaakhir,alamat,jeniskelamin,alamatsitus,nilai1,nilai2,nilai3,nilai4,nilai5,(nilai1+nilai2+nilai3+nilai4+nilai5)as total FROM lombacuy ORDER BY total DESC");			
				while($data = mysql_fetch_object($result) ):
			  ?>
                <tr>
                  <td><?php echo $data->id ?></td>
                  <td><?php echo $data->namadepan." ".$data->namaakhir ?></td>
                  <td><?php echo $data->alamat?></td>
		  <td><?php echo $data->jeniskelamin?></td>
                  <td><?php echo $data->alamatsitus?></td>
                  <td><?php echo $data->nilai1?></td>
                  <td><?php echo $data->nilai2?></td>
                  <td><?php echo $data->nilai3?></td>
                  <td><?php echo $data->nilai4?></td>
                  <td><?php echo $data->nilai5?></td>
                  <td><?php echo $data->total?></td>
                </tr>
                
			  <?php
				endwhile;
			   ?>
              </tbody>
		</table>
		
</div>	
</div>
</body>
</html>

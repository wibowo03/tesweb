<?php 
session_start();
include('koneksi.php');
?>

<?php 
	if(isset($_POST["tambah_pt"])){
		$nama       = $_POST["nama"];
		$akreditasi = $_POST["akreditasi"];
		$lokasi     = $_POST["lokasi"];
		$jenjang    = $_POST["jenjang"];
		$kuota      = $_POST["kuota"];
		$ipk        = $_POST["ipk"];
		
		$akreditasi_angka = $lokasi_angka = $jenjang_angka = $kuota_angka = $ipk_angka = 0;

		if($akreditasi  == "Unggul"){
			$akreditasi_angka = 5;
		} 
		elseif($akreditasi  == "Baik Sekali"){
			$akreditasi_angka = 3;
		}
		elseif($akreditasi  == "Baik / B"){
			$akreditasi_angka = 1;
		}

		if($lokasi  == "Sumatera, Jawa, Bali"){
			$lokasi_angka = 5;
		} 
		elseif($lokasi  == "Kalimantan & Sulawesi"){
			$lokasi_angka = 3;
		}
		elseif($lokasi  == "Nusa Tenggara, Maluku, Papua"){
			$lokasi_angka = 1;
		}

		if($jenjang  == "Akademik Vokasi"){
			$jenjang_angka = 5;
		} 
		elseif($jenjang  == "Akademik"){
			$jenjang_angka = 3;
		}
		elseif($jenjang  == "Vokasi"){
			$jenjang_angka = 1;
		}

		if($kuota > 225){
			$kuota_angka = 5;
		} 
		elseif($kuota <= 225 && $kuota >= 130){
			$kuota_angka = 3;
		}
		elseif($kuota <= 125 && $kuota == 50){
			$kuota_angka = 1;
		}

		if ($ipk > 3.5) {
			$ipk_angka = 5;
		} 
		elseif ($ipk <= 3.5 && $ipk >= 3.15) {
			$ipk_angka = 3;
		}
		 elseif ($ipk <= 3.15 && $ipk >= 2.75) {
			$ipk_angka = 1;
		}
		

		$sql = "INSERT INTO `data_pt` (`id_pt`, `nama_pt`, `akreditasi_pt`, `lokasi_pt`, `jenjang_pt`, `kuota_pt`, `ipk_pt`, `akreditasi_angka`, `lokasi_angka`, `jenjang_angka`, `kuota_angka`, `ipk_angka`) 
				VALUES (NULL, :nama_pt, :akreditasi_pt, :lokasi_pt, :jenjang_pt, :kuota_pt, :ipk_pt, :akreditasi_angka, :lokasi_angka, :jenjang_angka, :kuota_angka, :ipk_angka)";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':nama_pt', $nama);
		$stmt->bindValue(':akreditasi_pt', $akreditasi);
		$stmt->bindValue(':lokasi_pt', $lokasi);
		$stmt->bindValue(':jenjang_pt', $jenjang);
		$stmt->bindValue(':kuota_pt', $kuota);
		$stmt->bindValue(':ipk_pt', $ipk);
		$stmt->bindValue(':akreditasi_angka', $akreditasi_angka);
		$stmt->bindValue(':lokasi_angka', $lokasi_angka);
		$stmt->bindValue(':jenjang_angka', $jenjang_angka);
		$stmt->bindValue(':kuota_angka', $kuota_angka);
		$stmt->bindValue(':ipk_angka', $ipk_angka);
		$stmt->execute();
	}

	if(isset($_POST["hapus_pt"])){
		$id_hapus_pt = $_POST['id_hapus_pt'];
		$sql_delete = "DELETE FROM `data_pt` WHERE `id_pt` = :id_hapus_pt";
		$stmt_delete = $db->prepare($sql_delete);
		$stmt_delete->bindValue(':id_hapus_pt', $id_hapus_pt);
		$stmt_delete->execute();
		$query_reorder_id=mysqli_query($selectdb,"ALTER TABLE data_pt AUTO_INCREMENT = 1");
	}

	if(isset($_POST["edit_pt"])){
		$id_edit = $_POST['id_edit_pt'];
		$nama = $_POST['nama'];
		$akreditasi = $_POST['akreditasi'];
		$lokasi = $_POST['lokasi'];
		$jenjang = $_POST['jenjang'];
		$kuota = $_POST['kuota'];
		$ipk = $_POST['ipk'];
		
		$akreditasi_angka = $lokasi_angka = $jenjang_angka = $kuota_angka = $ipk_angka = 0;

		if($akreditasi  == "Unggul"){
			$akreditasi_angka = 5;
		} 
		elseif($akreditasi  == "Baik Sekali"){
			$akreditasi_angka = 3;
		}
		elseif($akreditasi  == "Baik / B"){
			$akreditasi_angka = 1;
		}

		if($lokasi  == "Sumatera, Jawa, Bali"){
			$lokasi_angka = 5;
		} 
		elseif($lokasi  == "Kalimantan & Sulawesi"){
			$lokasi_angka = 3;
		}
		elseif($lokasi  == "Nusa Tenggara, Maluku, Papua"){
			$lokasi_angka = 1;
		}

		if($jenjang  == "Akademik Vokasi"){
			$jenjang_angka = 5;
		} 
		elseif($jenjang  == "Akademik"){
			$jenjang_angka = 3;
		}
		elseif($jenjang  == "Vokasi"){
			$jenjang_angka = 1;
		}

		if($kuota > 225){
			$kuota_angka = 5;
		} 
		elseif($kuota <= 225 && $kuota >= 130){
			$kuota_angka = 3;
		}
		elseif($kuota <= 125 && $kuota == 50){
			$kuota_angka = 1;
		}

		if ($ipk > 3.5) {
			$ipk_angka = 5;
		} 
		elseif ($ipk <= 3.5 && $ipk >= 3.15) {
			$ipk_angka = 3;
		}
		 elseif ($ipk <= 3.15 && $ipk >= 2.75) {
			$ipk_angka = 1;
		}

		$sql = "UPDATE `data_pt` SET 
				`nama_pt` = :nama_pt,
				`akreditasi_pt` = :akreditasi_pt,
				`lokasi_pt` = :lokasi_pt,
				`jenjang_pt` = :jenjang_pt,
				`kuota_pt` = :kuota_pt,
				`ipk_pt` = :ipk_pt,
				`akreditasi_angka` = :akreditasi_angka,
				`lokasi_angka` = :lokasi_angka,
				`jenjang_angka` = :jenjang_angka,
				`kuota_angka` = :kuota_angka,
				`ipk_angka` = :ipk_angka
				WHERE `id_pt` = :id_pt";
		
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':nama_pt', $nama);
		$stmt->bindValue(':akreditasi_pt', $akreditasi);
		$stmt->bindValue(':lokasi_pt', $lokasi);
		$stmt->bindValue(':jenjang_pt', $jenjang);
		$stmt->bindValue(':kuota_pt', $kuota);
		$stmt->bindValue(':ipk_pt', $ipk);
		$stmt->bindValue(':akreditasi_angka', $akreditasi_angka);
		$stmt->bindValue(':lokasi_angka', $lokasi_angka);
		$stmt->bindValue(':jenjang_angka', $jenjang_angka);
		$stmt->bindValue(':kuota_angka', $kuota_angka);
		$stmt->bindValue(':ipk_angka', $ipk_angka);
		$stmt->bindValue(':id_pt', $id_edit);
		$stmt->execute();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>SPK Pemilihan Perguruan Tinggi Program Pertukaran Mahasiswa Merdeka</title>
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="assets/css/materialize.css"  media="screen,projection"/>
	<link rel="stylesheet" href="assets/css/table.css">
	<link rel="stylesheet" href="assets/css/style.css">

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Import jQuery before materialize.js-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/materialize.js"></script>
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Data Table -->
	<link rel="stylesheet" type="text/css" href="assets/dataTable/jquery.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="assets/dataTable/jquery.dataTables.min.js"></script>

</head>
<body>
	<div class="navbar-fixed">
	<nav>
    	<div class="container">
					
						<div class="nav-wrapper">
								<ul class="left" style="margin-left: -52px;">
									<li><a href="index.php">HOME</a></li>
									<li><a href="rekomendasi.php">REKOMENDASI</a></li>
									<li><a class="active" href="daftar_pt.php">DAFTAR PERGURUAN TINGGI</a></li>
									<li><a href="#about">TENTANG</a></li>
								</ul>
						</div>
					
        </div>
		</nav>
		</div>
		<!-- Body Start -->

		<!-- Daftar PT Start -->
	<div style="background-color: #efefef">
		<div class="container">
		    <div class="section-card" style="padding: 40px 0px 20px 0px;">
				<ul>
				    <li>
						<div class="row">
						<div class="card">
								<div class="card-content">
									<center><h4 style="margin-bottom: 0px; margin-top: -8px;">Daftar Perguruan Tinggi</h4></center>
									<table id="table_id" class="hover dataTablesCustom" style="width:100%">
											<thead style="border-top: 1px solid #d0d0d0;">
												<tr>
													<th><center>No </center></th>
													<th><center>Nama Universitas</center></th>
													<th><center>Akreditasi</center></th>
													<th><center>Lokasi</center></th>
													<th><center>Jenjang Pendidikan</center></th>
													<th><center>Kuota</center></th>
													<th><center>IPK</center></th>
													<th><center>Aksi</center></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$query=mysqli_query($selectdb,"SELECT * FROM data_pt");
												$no=1;
												while ($data=mysqli_fetch_array($query)) {
												?>
												<tr>
													<td><center><?php echo $no; ?></center></td>
													<td><center><?php echo $data['nama_pt'] ?></center></td>
													<td><center><?php echo $data['akreditasi_pt'] ?></center></td>
													<td><center><?php echo $data['lokasi_pt'] ?></center></td>
													<td><center><?php echo $data['jenjang_pt'] ?></center></td>
													<td><center><?php echo $data['kuota_pt'] ?></center></td>
													<td><center><?php echo $data['ipk_pt'] ?></center></td>
													<td>
														<center>
															<a href="#edit_<?php echo $data['id_pt'] ?>" style="height: 32px; width: 32px;" class="btn-floating btn-small waves-effect waves-light blue">
																<i style="line-height: 32px;" class="material-icons">edit</i>
															</a>
															<form method="POST">
																<input type="hidden" name="id_hapus_pt" value="<?php echo $data['id_pt'] ?>">
																<button type="submit" name="hapus_pt" style="height: 32px; width: 32px;" class="btn-floating btn-small waves-effect waves-light red">
  																<i style="line-height: 32px;" class="material-icons">delete</i>
																</button>
															</form>
														</center>
													</td>
												</tr>
												<?php
														$no++;}
												?>
											</tbody>
									</table>
									</div>
									
							</div>
							<a href="#tambah" class="btn-floating btn-large waves-effect waves-light teal btn-float-custom"><i class="material-icons">add</i></a>
						</div>
				    </li>
				</ul>	     
	    	</div>
		</div>
	</div>
	<!-- Daftar PT End -->

	<!-- Daftar PT Start -->
	<div style="background-color: #efefef">
		<div class="container">
		    <div class="section-card" style="padding: 1px 20% 24px 20%;">
				<ul>
				    <li>
						<div class="row">
							<div class="card">
								<div class="card-content" style="padding-top: 10px;">
									<center><h5 style="margin-bottom: 10px;">Analisa Perguruan Tinggi</h5></center>
									<table class="responsive-table">
									
											<thead style="border-top: 1px solid #d0d0d0;">
												<tr>
													<th><center>Alternatif</center></th>
													<th><center>C1 (Akreditasi)</center></th>
													<th><center>C2 (Lokasi)</center></th>
													<th><center>C3 (Jenjang Pendidikan)</center></th>
													<th><center>C4 (Kuota)</center></th>
													<th><center>C5 (IPK)</center></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$query=mysqli_query($selectdb,"SELECT * FROM data_pt");
												$no=1;
												while ($data=mysqli_fetch_array($query)) {
												?>
												<tr>
													<td><center><?php echo "A",$no ?></center></td>
													<td><center><?php echo $data['akreditasi_angka'] ?></center></td>
													<td><center><?php echo $data['lokasi_angka'] ?></center></td>
													<td><center><?php echo $data['jenjang_angka'] ?></center></td>
													<td><center><?php echo $data['kuota_angka'] ?></center></td>
													<td><center><?php echo $data['ipk_angka'] ?></center></td>
												</tr>
												<?php
														$no++;}
												?>
											</tbody>
									</table>
									</div>
							</div>
						</div>
				    </li>
				</ul>	     
	    	</div>
		</div>
	</div>
	<!-- Daftar PT End -->

	<!-- Modal Start -->
	<div id="tambah" class="modal" style="width: 40%; height: 100%;">
		<div class="modal-content">
			<div class="col s6">
					<div class="card-content">
						<div class="row">
							<center><h5 style="margin-top:-8px;">Masukkan Perguruan Tinggi</h5></center>
							<form method="POST" action="">
								<div class = "row">
									<div class="col s12">

										<div class="col s6" style="margin-top: 10px;">
										<b>Nama</b>
										</div>
										<div class="col s6">
											<input style="height: 2rem;" name="nama" type="text" required>
										</div>

										<div class="col s6" style="margin-top: 10px;">
										<b>Akreditasi</b>
										</div>
										<div class="col s6">
											<select style="display: block; margin-bottom: 4px;" required name="akreditasi">
												<!-- <option value = "" disabled selected>Kriteria Akreditasi</option>  -->
												<option value = "Baik / B">Baik / B</option>
												<option value = "Baik Sekali">Baik Sekali</option>
												<option value = "Unggul">Unggul</option>
											</select>
										</div>
										
										<div class="col s6" style="margin-top: 10px;">
										<b>Lokasi</b>
										</div>
										<div class="col s6">
											<select style="display: block; margin-bottom: 4px;" required name="lokasi">
												<!-- <option value = "" disabled selected>Kriteria lokasi</option>  -->
												<option value = "Nusa Tenggara, Maluku, Papua">Nusa Tenggara, Maluku, Papua</option>
                                                <option value = "Kalimantan & Sulawesi">Kalimantan & Sulawesi</option>
                                                <option value = "Sumatera, Jawa, Bali">Sumatera, Jawa, Bali</option>
											</select>
										</div>

										<div class="col s6" style="margin-top: 10px;">
											<b>Jenjang Pendidikan</b>
										</div>
										<div class="col s6">
											<select style="display: block; margin-bottom: 4px;" required name="jenjang">
												<!-- <option value = "" disabled selected>Kriteria Jenjang Pendidikan</option> -->
												<option value = "Vokasi">Vokasi</option>
                                                <option value = "Akademik">Akademik</option>
                                                <option value = "Akademik Vokasi">Akademik Vokasi</option>
											</select>
										</div>

										<div class="col s6" style="margin-top: 10px;">
										<b>Kuota</b>
										</div>
										<div class="col s6">
											<input style="height: 2rem;" name="kuota" type="text" required>
										</div>

										<div class="col s6" style="margin-top: 10px;">
										<b>IPK</b>
										</div>
										<div class="col s6">
											<input style="height: 2rem;" name="ipk" type="text" required>
										</div>

									</div>  
								</div> 
								<center><button name="tambah_pt" type="submit" class="waves-effect waves-light btn teal" style="margin-top: 0px;">Tambah</button></center>	
							</form>
						</div>
					</div>
				</div>
			</div>
		<div style="height: 0px; "class="modal-footer">
          <a style="margin-top: -30px;" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
        </div>
	</div>
	<!-- Modal End -->

	<!-- Edit Modals -->
	<?php
	$query=mysqli_query($selectdb,"SELECT * FROM data_pt");
	while ($data=mysqli_fetch_array($query)) {
	?>
	<div id="edit_<?php echo $data['id_pt'] ?>" class="modal" style="width: 40%; height: 100%;">
		<div class="modal-content">
			<div class="col s6">
				<div class="card-content">
					<div class="row">
						<center><h5 style="margin-top:-8px;">Edit Perguruan Tinggi</h5></center>
						<form method="POST" action="">
							<input type="hidden" name="id_edit_pt" value="<?php echo $data['id_pt'] ?>">
							<div class = "row">
								<div class="col s12">

									<div class="col s6" style="margin-top: 10px;">
									<b>Nama</b>
									</div>
									<div class="col s6">
										<input style="height: 2rem;" name="nama" type="text" value="<?php echo $data['nama_pt'] ?>" required>
									</div>

									<div class="col s6" style="margin-top: 10px;">
									<b>Akreditasi</b>
									</div>
									<div class="col s6">
										<select style="display: block; margin-bottom: 4px;" required name="akreditasi">
											<option value="Baik / B" <?php echo ($data['akreditasi_pt'] == 'Baik / B') ? 'selected' : '' ?>>Baik / B</option>
											<option value="Baik Sekali" <?php echo ($data['akreditasi_pt'] == 'Baik Sekali') ? 'selected' : '' ?>>Baik Sekali</option>
											<option value="Unggul" <?php echo ($data['akreditasi_pt'] == 'Unggul') ? 'selected' : '' ?>>Unggul</option>
										</select>
									</div>
									
									<div class="col s6" style="margin-top: 10px;">
									<b>Lokasi</b>
									</div>
									<div class="col s6">
										<select style="display: block; margin-bottom: 4px;" required name="lokasi">
											<option value="Nusa Tenggara, Maluku, Papua" <?php echo ($data['lokasi_pt'] == 'Nusa Tenggara, Maluku, Papua') ? 'selected' : '' ?>>Nusa Tenggara, Maluku, Papua</option>
											<option value="Kalimantan & Sulawesi" <?php echo ($data['lokasi_pt'] == 'Kalimantan & Sulawesi') ? 'selected' : '' ?>>Kalimantan & Sulawesi</option>
											<option value="Sumatera, Jawa, Bali" <?php echo ($data['lokasi_pt'] == 'Sumatera, Jawa, Bali') ? 'selected' : '' ?>>Sumatera, Jawa, Bali</option>
										</select>
									</div>
									
									<div class="col s6" style="margin-top: 10px;">
									<b>Jenjang Pendidikan</b>
									</div>
									<div class="col s6">
										<select style="display: block; margin-bottom: 4px;" required name="jenjang">
											<option value="Vokasi" <?php echo ($data['jenjang_pt'] == 'Vokasi') ? 'selected' : '' ?>>Vokasi</option>
											<option value="Akademik" <?php echo ($data['jenjang_pt'] == 'Akademik') ? 'selected' : '' ?>>Akademik</option>
											<option value="Akademik Vokasi" <?php echo ($data['jenjang_pt'] == 'Akademik Vokasi') ? 'selected' : '' ?>>Akademik Vokasi</option>
										</select>
									</div>

									<div class="col s6" style="margin-top: 10px;">
									<b>Kuota</b>
									</div>
									<div class="col s6">
										<input style="height: 2rem;" name="kuota" type="text" value="<?php echo $data['kuota_pt'] ?>" required>
									</div>

									<div class="col s6" style="margin-top: 10px;">
									<b>IPK</b>
									</div>
									<div class="col s6">
										<input style="height: 2rem;" name="ipk" type="text" value="<?php echo $data['ipk_pt'] ?>" required>
									</div>

								</div>  
							</div> 
							<center>
								<button name="edit_pt" type="submit" class="waves-effect waves-light btn teal" style="margin-top: 0px;">Simpan Perubahan</button>
								</center>	
						</form>
					</div>
				</div>
			</div>
		</div>
		<div style="height: 0px;" class="modal-footer">
			<a style="margin-top: -30px;" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
		</div>
	</div>
	<?php } ?>

	<!-- Modal Start -->
	<div id="about" class="modal">
		<div class="modal-content">
			<h4>Tentang</h4>
			<p>Sistem Pendukung Keputusan Pemilihan Perguruan Tinggi Program Pertukaran Mahasiswa Merdeka atau PMM ini menggunakan metode TOPSIS yang dibangun menggunakan bahasa PHP. Sistem ini dibuat sebagai Tugas Akhir / Skripsi Program Studi Teknik Informatika Universitas Islam Riau. </p>
				<br>
				Muhammad Mukhti Wibowo (213510329)</a><br>
			</p>
		</div>
		<div class="modal-footer">
			<a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
		</div>
	</div>
	<!-- Modal End -->

    <!-- Body End -->

    <!-- Footer Start -->
	<div class="footer-copyright" style="padding: 0px 0px; background-color: white">
      <div class="container">
        <p align="center" style="color: #999">&copy; Sistem Pendukung Keputusan Pemilihan Perguruan Tinggi Program PMM. 2025.</p>
      </div>
    </div>
    <!-- Footer End -->
    <script type="text/javascript">
	  	$(document).ready(function(){
		$('.parallax').parallax();
		$('.modal').modal();
		$('#table_id').DataTable({
    		"paging": false
		});
	    });
	</script>
</body>
</html>
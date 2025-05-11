<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pendukung Keputusan Pemilihan Perguruan Tinggi Program Pertukaran Mahasiswa Merdeka</title>
	<!--Import Google Icon Font-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="assets/css/materialize.css"  media="screen,projection"/>
	<link rel="stylesheet" href="assets/css/table.css">
	<link rel="stylesheet" href="assets/css/style.css">

	<link rel="apple-touch-icon" sizes="76x76" href="assets/image/apple-icon.png"> 	<link rel="icon" type="image/png" sizes="96x96" href="assets/image/favicon.png">

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<!--Import jQuery before materialize.js-->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/materialize.js"></script>
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
	<div class="navbar-fixed">
	<nav>
    	<div class="container">
					
						<div class="nav-wrapper">

								<ul class="left" style="margin-left: -52px;">
									<li><a href="index.php">HOME</a></li>
									<li><a class="active" href="rekomendasi.php">REKOMENDASI</a></li>
                                    <li><a href="daftar_pt.php">DAFTAR PERGURUAN TINGGI</a></li>
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
                <div class="section-card" style="padding: 32px 0px 20px 0px">
                    <ul>
                        <li>
                            <div class="row">
                                <div class="col s3">
                                </div>
                                <div class="col s6">      
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="row">
                                                <center><h4>Masukkan Bobot</h4></center>
                                                <br>
                                                <form class = "col s12" method="POST" action="hasil.php">
                                                    <div class = "row">
                                                        <div class="col s12">

                                                            <div class="col s6" style="margin-top: 10px;">
                                                                <b>Akreditasi</b>
                                                            </div>
                                                            <div class="col s6">
                                                                <select required name="akreditasi">
                                                                    <option value = "" disabled selected style="color: #eceff1;">Kriteria Akreditasi</option>
                                                                    <option value = "1">Baik / B</option>
                                                                    <option value = "3">Baik Sekali</option>
                                                                    <option value = "5">Unggul</option>
                                                                </select>
                                                            </div>

                                                            <div class="col s6" style="margin-top: 10px;">
                                                            <b>Lokasi</b>
                                                            </div>
                                                            <div class="col s6">
                                                                <select required name="lokasi">
                                                                    <option value = "" disabled selected>Kriteria Lokasi</option> 
                                                                    <option value = "1">Nusa Tenggara, Maluku, Papua</option>
                                                                    <option value = "3">Kalimantan & Sulawesi</option>
                                                                    <option value = "5">Sumatera, Jawa, Bali</option>
                                                                </select>
                                                            </div>

                                                            <div class="col s6" style="margin-top: 10px;">
                                                                <b>Jenjang Pendidikan</b>
                                                            </div>
                                                            <div class="col s6">
                                                                <select required name="jenjang">
                                                                    <option value = "" disabled selected>Kriteria Jenjang Pendidikan</option>
                                                                    <option value = "1">Diploma</option>
                                                                    <option value = "3">Sarjana</option>
                                                                    <option value = "5">Diploma & Sarjana</option>
                                                                </select>
                                                            </div>

                                                            <div class="col s6" style="margin-top: 10px;">
                                                                <b>Kuota</b>
                                                            </div>
                                                            <div class="col s6">
                                                                <select required name="kuota">
                                                                    <option value = "" disabled selected>Kriteria Kuota</option>
                                                                    <option value = "1">50 - 125</option>
                                                                    <option value = "3">130 - 225</option>
                                                                    <option value = "5">> 225</option>
                                                                </select>
                                                            </div>

                                                            <div class="col s6" style="margin-top: 10px;">
                                                                <b>IPK</b>
                                                            </div>
                                                            <div class="col s6">
                                                                <select required name="ipk">
                                                                    <option value = "" disabled selected>Kriteria IPK</option>
                                                                    <option value = "1">2,75 - 3,1</option>
                                                                    <option value = "3"> 3,15 - 3,5</option>
                                                                    <option value = "5">> 3,5</option>
                                                                </select>
                                                            </div>
                                                            
                                                        </div>  
                                                    <center><button type="submit" class="waves-effect waves-light btn" style="margin-bottom:-46px;">Hitung</button></center>	
                                                </form>       
                                            </div>
                                        </div>
                                    </div>                    
                                </div>
                                <div class="col s3">
                                </div>
                            </div>
                        </li>
                    </ul>	     
                </div>
            </div>
        </div>
        <!-- Rekomendasi PT End -->

    <!-- Modal Start -->
	<div id="about" class="modal">
        <div class="modal-content">
          <h4>Tentang</h4>
          <p>Sistem Pendukung Keputusan Pemilihan Perguruan Tinggi Program Pertukaran Mahasiswa Merdeka atau PMM ini menggunakan metode TOPSIS yang dibangun menggunakan bahasa PHP. Sistem ini dibuat sebagai Tugas Akhir / Skripsi Program Studi Teknik Informatika Universitas Islam Riau.</p>
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
        <p align="center" style="color: #999">&copy; Sistem Pendukung Keputusan Pemilihan Perguruan Tinggi Program PMM. 2025</p>
      </div>
    </div>
    <!-- Footer End -->
    <script type="text/javascript">
	  $(document).ready(function(){
	      $('.parallax').parallax();
          $('select').material_select();
          $('.modal').modal();
	    });
    </script>
</body>
</html>
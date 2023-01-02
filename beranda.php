<?php
	//Mengakses datalogin pada ambildata.php
	require "ambildata.php";
	//Ketika button POSTING diklik
	if(isset($_POST['POSTING'])){
		//Proses upload Gambar ke folder assets/posting
		$file = $_FILES["GAMBARPOSTING"]["name"];
        $tmp_name = $_FILES["GAMBARPOSTING"]["tmp_name"];
        move_uploaded_file($tmp_name, "assets/posting/".$file);

		//Jika gambar posting kosong
		if(empty($_FILES["GAMBARPOSTING"]["name"])){
			try{
				$kon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				//Mengatur IDPosting
				//Query mengecek IDPOSTING terbesar
				$queryIDPOSTING = $kon->prepare("SELECT MAX(IDPOSTING) FROM posting");
				$queryIDPOSTING->execute();
				//Mengambil data IDPOSTING terbesar
				foreach($queryIDPOSTING as $data){
					$urutan = (int) substr($data[0], 1, 3);
				}
				//Increment +1 IDPOSTING terbesar
				$urutan++;
				$huruf = "P";
				//Menambahkan kode P dan hasil increment
				$IDPOSTING = $huruf . sprintf("%03s", $urutan);
				
				//Query untuk menambahkan posting ke tabel posting
				$statement=$kon->prepare("INSERT INTO posting (IDPOSTING, PESAN) VALUES (:IDPOSTING, :PESAN)");
				$statement->bindValue(':IDPOSTING', $IDPOSTING);
				$statement->bindValue(':PESAN', $_POST['PESAN']);
				$statement->execute();
				
				//Query untuk menambahkan data ke tabel user_posting
				$statement=$kon->prepare("INSERT INTO user_posting (IDUSER, IDPOSTING) VALUES (:IDUSER, :IDPOSTING)");
				$statement->bindValue(':IDUSER', $IDUSER);
				$statement->bindValue(':IDPOSTING', $IDPOSTING);
				$statement->execute();
				
				//Menampilkan hasil eksekusi
				$error=false;
			}
			catch(PDOException $e){
				//Menampilkan Error
				echo $e->getMessage();
			}
		}
		//Jika ada gambar posting
		else{
			try{
				$kon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
				//Mengatur IDPosting
				//Query mengecek IDPOSTING terbesar
				$queryIDPOSTING = $kon->prepare("SELECT MAX(IDPOSTING) FROM posting");
				$queryIDPOSTING->execute();
				//Mengambil data IDPOSTING terbesar
				foreach($queryIDPOSTING as $data){
					$urutan = (int) substr($data[0], 1, 3);
				}
				//Increment +1 IDPOSTING terbesar
				$urutan++;
				$huruf = "P";
				//Menambahkan kode P dan hasil increment
				$IDPOSTING = $huruf . sprintf("%03s", $urutan);
				
				//Query untuk menambahkan posting ke tabel posting
				$statement=$kon->prepare("INSERT INTO posting (IDPOSTING, PESAN, GAMBARPOSTING) VALUES (:IDPOSTING, :PESAN, :GAMBARPOSTING)");
				$statement->bindValue(':IDPOSTING', $IDPOSTING);
				$statement->bindValue(':PESAN', $_POST['PESAN']);
				$statement->bindValue(':GAMBARPOSTING', $file);
				$statement->execute();

				//Query untuk menambahkan data ke tabel user_posting
				$statement=$kon->prepare("INSERT INTO user_posting (IDUSER, IDPOSTING) VALUES (:IDUSER, :IDPOSTING)");
				$statement->bindValue(':IDUSER', $IDUSER);
				$statement->bindValue(':IDPOSTING', $IDPOSTING);
				$statement->execute();
				
				//Menampilkan hasil eksekusi
				$error= false;
			}
			catch(PDOException $e){
				//Menampilkan Error
				echo $e->getMessage();
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Beranda</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styleBeranda.css" />
</head>

<body>
    <div class="body">
        <?php
			include "navbar.php";
		?>
        <br><br><br>
        <div class="container">
            <table>
                <tr>
                    <td colspan="2">
                        <h2><a href="ProfilUtama.php"><?php echo $NAMAUSER; ?></a></h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img class="fotoProfil" src="assets/images/<?php echo $PHOTO; ?>">

                    </td>
					<?php
					if($_SESSION['IDLEVEL']!='L001'){
						?>
						<td>
						<!-- Ketika tidak ada error atau berhasil insert tabel -->
						<?php if(isset($error)):?>
							<h4 style='color:green; font-style:italic;'>*Telah berhasil diposting</h4>
						<?php endif; ?>
                        <form class="posting" method="POST" enctype="multipart/form-data">
                            <input class="postBeranda" type="textarea" placeholder="Apa yang anda pikirkan....." name="PESAN"><br>
							
							<button id="posting" type="submit" name="POSTING"><img id="iconkirim" src="assets/icon/kirim.png"></button>
							
							<label for="file-input">
								<img id="upload" src="assets/icon/upload.png" title="Upload gambar" width="30" height="30" align="left">
							</label>
							<input id="file-input" type="file" name="GAMBARPOSTING" onchange="upload(this);" style="display: none;" />
					 
                        </form>
						
                    </td>
						<?php
					}
					?>
                </tr>
            </table>
        </div>
        <br>

		<!-- Pengaturan Tampilan Postingan -->
        <?php
		//Pengaturan Privacy

		//Ketika IDLEVEL=L001 (Admin)
		if($_SESSION['IDLEVEL']=="L001"){
			//Query untuk menampilkan semua postingan
			$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER=user.IDUSER GROUP BY user_posting.IDPOSTING DESC");
			$statementPOSTING->execute();
			//Mengambil data postingan berdasarkan query
			foreach($statementPOSTING as $dataPOSTING){
				$DataIDUSER = $dataPOSTING[0];
				$DataUSERNAME = $dataPOSTING[1];
				$DataPHOTO = $dataPOSTING[2];
				$DataPESAN = $dataPOSTING[3];
				$DataGAMBARPOSTING = $dataPOSTING[4];
			?>
			<div class="container">
				<table>
					<tr border="1">
						<td>
							<img class="imgmember" src="assets/images/<?php echo $DataPHOTO; ?>">
							<div class="garis_verikal"></div>
							<?php
							//Ketika akunnya sendiri
							if($DataIDUSER==$IDUSER){
								?>
								<h3><a href="profilUtama.php"><?php echo $DataUSERNAME; ?></a></h3>
								<?php
							}
							else{
								?>
								<h3><a href="profilMemberLain.php?&IDUSER=<?php echo $DataIDUSER; ?>"><?php echo $DataUSERNAME; ?></a></h3>
								<?php
							}
							?>                        
						</td>
					</tr>
					<?php
						if(!empty($DataGAMBARPOSTING)){
							?>
					<tr>
						<td>
							<img class="viewPosting" src="assets/posting/<?php echo $DataGAMBARPOSTING; ?>">
						</td>
					</tr>
					<?php
						}
						?>
					<tr>
						<td><?php echo $DataPESAN; ?></td>
					</tr>
				</table>

			</div>
        <?php
			}
		}
		//Ketika IDLEVEL=L002 (Member)
		else{
			//Query untuk menampilkan postingan sesuai dengan pertemanan
			$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user, user_pertemanan WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER =user.IDUSER AND (user_pertemanan.IDUSER=user.IDUSER OR user_pertemanan.IDUSER2=user.IDUSER) AND (user_pertemanan.IDUSER=:IDUSER OR user_pertemanan.IDUSER2=:IDUSER) AND user_pertemanan.IDPERTEMANAN='B001' GROUP BY user_posting.IDPOSTING DESC");
			$statementPOSTING->bindValue(':IDUSER', $IDUSER);
			$statementPOSTING->execute();
			//Mengambil data postingan berdasarkan query
			foreach($statementPOSTING as $dataPOSTING){
				$DataIDUSER = $dataPOSTING[0];
				$DataUSERNAME = $dataPOSTING[1];
				$DataPHOTO = $dataPOSTING[2];
				$DataPESAN = $dataPOSTING[3];
				$DataGAMBARPOSTING = $dataPOSTING[4];
			?>
			<div class="container">
				<table>
					<tr border="1">
						<td>
							<img class="imgmember" src="assets/images/<?php echo $DataPHOTO; ?>">
							<div class="garis_verikal"></div>
							<?php
							//Ketika menampilkan data postingan miliknya orang login, maka aka membuka profilUtama.php
							if($DataIDUSER==$IDUSER){
								?>
								<h3><a href="profilUtama.php"><?php echo $DataUSERNAME; ?></a></h3>
								<?php
							}
							//Jika data postingan orang lain maka akan membuka profil orang lain
							else{
								?>
								<h3><a href="profilMemberLain.php?&IDUSER=<?php echo $DataIDUSER; ?>"><?php echo $DataUSERNAME; ?></a></h3>
								<?php
							}
							?>                        
						</td>
					</tr>
					<?php
						//Ketika gambar tidak kosong maka akan menampilkan gambar
						if(!empty($DataGAMBARPOSTING)){
							?>
							<tr>
								<td>
									<img class="viewPosting" src="assets/posting/<?php echo $DataGAMBARPOSTING; ?>">
								</td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td><?php echo $DataPESAN; ?></td>
						</tr>
				</table>

			</div>
        <?php
			}
		}
		?>
		}
</body>
</html>

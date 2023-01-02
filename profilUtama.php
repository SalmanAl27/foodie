<?php
    require "ambildata.php";
    //kekita tombol posting di klik
	if(isset($_POST['POSTING'])){
        //mengatur upload gambar
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
		else{
			try{
				$kon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
				//Mengatur IDPosting
				//Query mengecek IDPOSTING terbesar
				$queryIDPOSTING = $kon->prepare("SELECT MAX(IDPOSTING) FROM posting");
				$queryIDPOSTING->execute();
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
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/styleBeranda.css" />
</head>

<body>
<?php
	if($_SESSION['IDLEVEL']=="L001"){
	?>
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

                    <td>
                        <table class="data" cellspacing="30">
							<tr>
                                <th>
                                    Username
                                </th>
                                <td>
                                    <?php echo $USERNAME; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tanggal Lahir
                                </th>
                                <td>
                                    <?php echo $TANGGALLAHIR; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email
                                </th>
                                <td>
                                    <?php echo $EMAIL; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    No.HP
                                </th>
                                <td>
                                    <?php echo $NOHP; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Jenis Kelamin
                                </th>
                                <td>
                                    <?php echo $JENISKELAMIN; ?>
                                </td>
                            </tr>
							<tr>
                                
                                <td colspan="2">
                                   <button class="buttoneditprofil"><a href="editprofil.php">Edit Profil</a></button>
								   
                                </td>
                            </tr>
                        </table>
                </tr>
            </table>
		</div>
        
        <?php
			$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER=user.IDUSER AND user.IDUSER='$IDUSER' GROUP BY user_posting.IDPOSTING DESC");
			$statementPOSTING->execute();
			foreach($statementPOSTING as $dataPOSTING){
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
                        <a href="profilUtama.php">
                            <h3><?php echo $DataUSERNAME; ?></h3>
                        </a>
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
		?>
	<?php
	}
	//Terdapat Daftar Teman
	else{
	?>
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

                    <td>
                        <table class="data" cellspacing="30">
							<tr>
                                <th>
                                    Username
                                </th>
                                <td>
                                    <?php echo $USERNAME; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tanggal Lahir
                                </th>
                                <td>
                                    <?php echo $TANGGALLAHIR; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email
                                </th>
                                <td>
                                    <?php echo $EMAIL; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    No.HP
                                </th>
                                <td>
                                    <?php echo $NOHP; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Jenis Kelamin
                                </th>
                                <td>
                                    <?php echo $JENISKELAMIN; ?>
                                </td>
                            </tr>
							<tr>
                                
                                <td colspan="2">
                                   <button class="buttoneditprofil"><a href="editprofil.php">Edit Profil</a></button>
								   <button class="buttondaftarteman"><a href="daftarTeman.php">Daftar Teman</a></button>
                                </td>
                            </tr>

                        </table>
                </tr>
            </table>
		</div>
        <br>
			<div class="container">
				<table>
					<tr>
						<td>
							<?php if(isset($error)):?>
								<h4 style='color:green; font-style:italic;'>*Telah berhasil diposting</h4>
							<?php endif; ?>
							<form class="posting" method="POST" enctype="multipart/form-data">
								<input class="postProfil" type="textarea" placeholder="Apa yang anda pikirkan....." name="PESAN"><br>
								<button id="posting" type="submit" name="POSTING"><img id="iconkirim" src="assets/icon/kirim.png"></button>
							
								<label for="file-input">
									<img id="upload" src="assets/icon/upload.png" title="Edit foto" width="30" height="30" align="left">
								</label>
								<input id="file-input" type="file" name="GAMBARPOSTING" onchange="upload(this);" style="display: none;" />
							</form>
						</td>
					<tr>
				</table>
			</div>
        <br>
        <?php
			$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER=user.IDUSER AND user.IDUSER='$IDUSER' GROUP BY user_posting.IDPOSTING DESC");
			$statementPOSTING->execute();
			foreach($statementPOSTING as $dataPOSTING){
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
                        <a href="profilUtama.php">
                            <h3><?php echo $DataUSERNAME; ?></h3>
                        </a>
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
		?>
	<?php
	}
	?>
    


</body>

</html>

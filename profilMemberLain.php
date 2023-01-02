<?php
	require "koneksi.php";
	session_start();
	//Mengambil IDUSER dari Session Login
	$IDUSER=$_SESSION['IDUSER'];
	//IDUSERLain dari data postingan Beranda
	if($IDUSERLain = $_REQUEST['IDUSER']){
		//Query Menampilkan user berdasarkan IDUSER yang dipilih
		$statementUser=$kon->prepare("SELECT*FROM user, level WHERE user.IDLEVEL=level.IDLEVEL AND IDUSER='$IDUSERLain'");
		$statementUser->execute();
		//Menampilkan User berdasarkan Query
		foreach($statementUser as $dataUser){
			$USERNAME = $dataUser[3];
			$NAMAUSER = $dataUser[5];
        	$TANGGALLAHIR = $dataUser[6];
        	$PHOTO = $dataUser[7];
			$EMAIL= $dataUser[8];
        	$NOHP = $dataUser[9];
			$IDLEVEL = $dataUser[10];
		}
		//Query untuk menampilkan jenis kelamin
		$statementJENISKELAMIN=$kon->prepare("SELECT jeniskelamin.JENISKELAMIN FROM jeniskelamin,user WHERE jeniskelamin.IDJENISKELAMIN=user.IDJENISKELAMIN AND user.IDUSER=:IDUSER");
		$statementJENISKELAMIN->bindValue(':IDUSER', $IDUSERLain);
		$statementJENISKELAMIN->execute();
		//Menampilkan jenis kelamin
		foreach($statementJENISKELAMIN as $dataJENISKELAMIN){
			$JENISKELAMIN = $dataJENISKELAMIN[0];
		}
	}
	
	//Untuk proses Follow
	//Ketika button Follow di klik
	if(isset($_POST['Follow'])){
		try{
			$kon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//Query untuk memasukkan data pertemanan ke tabel user_pertemanan
			$statement=$kon->prepare("INSERT INTO user_pertemanan (IDUSER, IDUSER2, IDPERTEMANAN) VALUES (:IDUSER, :IDUSER2, :IDPERTEMANAN)");
			$statement->bindValue(':IDUSER', $IDUSER);
			$statement->bindValue(':IDUSER2', $IDUSERLain);
			$statement->bindValue(':IDPERTEMANAN', 'B001');
			$statement->execute();
			//menampilkan pesan berhasil berteman
			$error=false;
			}
			catch(PDOException $e){
				//jika ada eror
				echo $e->getMessage();
			}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="assets/css/styleBeranda.css"/>
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
					<h2><a href="profilMemberLain.php?&IDUSER=<?php echo $IDUSERLain; ?>"><?php echo $NAMAUSER; ?></a></h2 >
				</td>
			</tr>
			<tr>
				<td>
					<img class="fotoProfil" src="assets/images/<?php echo $PHOTO; ?>">
                </td>
				
                <td>
					<table  class="data"  cellspacing="30" >
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
						<?php
						//Query Digunakan untuk mengecek pertemanan antara user login dengan akun yang dibukak
						$statementCekPertemanan=$kon->prepare("SELECT*FROM user_pertemanan WHERE (IDUSER='$IDUSER' AND IDUSER2='$IDUSERLain') OR (IDUSER='$IDUSERLain' AND IDUSER2='$IDUSER')");
						$statementCekPertemanan->execute();
						//Mengambil data
						foreach($statementCekPertemanan as $dataPertemanan){
							$IDUSER1 = $dataPertemanan[0];
							$IDUSER2 = $dataPertemanan[1];
							$IDPERTEMANAN = $dataPertemanan[2];
						}
						//Jika IDPERTEMANAN bukan B001 => Tidak Berteman dan Bukan Admin, akan menampilkan tombol Follow
						if(@$IDPERTEMANAN!="B001" AND $IDLEVEL!='L001'){
							?>
							<tr>
							<td>
								<form method="POST">
									<input type="submit" class="add" value="Follow" name="Follow">
								</form>
							</td>
						</tr>
							<?php
						}
						?>
                    </table>
					<!-- pesan berhasil berteman -->
					<?php if(isset($error)):?>
							<h4 style='color:green; font-style:italic;'>*Telah berhasil berteman</h4>
					<?php endif; ?>
                </td>       
				</td>
			</tr>			
		</table>
		</div>
		<br>
		<?php
		//Jika Admin maka akan menampilkan postingan tanpa privacy
		if($_SESSION['IDLEVEL']=="L001"){
			//Query menampilkan postingan tanpa privacy
			$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER=user.IDUSER AND user.IDUSER='$IDUSERLain' GROUP BY user_posting.IDPOSTING DESC");
			$statementPOSTING->execute();
			//menampilkan data postingan tanpa privasi
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
							<a href="profilMemberLain.php?&IDUSER=<?php echo $IDUSERLain; ?>"><h3><?php echo $DataUSERNAME; ?></h3></a>
						</td>
					</tr>
					<?php
					//jika tidak ada gambar yg di upload
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
		//Selain Admin maka akan ada privacy, jika sudah berteman maka akan ditampilkan postingannya
		else{
			//Query menampilkan postingan menggunakan privacy
			$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user, user_pertemanan WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER=user.IDUSER AND (user_pertemanan.IDUSER=user.IDUSER OR user_pertemanan.IDUSER2=user.IDUSER) AND (user_pertemanan.IDUSER='$IDUSER' OR user_pertemanan.IDUSER2='$IDUSER') AND user.IDUSER='$IDUSERLain' AND user_pertemanan.IDPERTEMANAN='B001' GROUP BY user_posting.IDPOSTING DESC");
			$statementPOSTING->execute();
			//menampilkan postingan menggunakan privacy
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
							<a href="profilMemberLain.php?&IDUSER=<?php echo $IDUSERLain; ?>"><h3><?php echo $DataUSERNAME; ?></h3></a>
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
	</body>
</html>


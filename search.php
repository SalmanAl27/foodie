<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="assets/css/styleBeranda.css" />
</head>

<body>
    <div class="body">
        <?php
            session_start();
            require "koneksi.php";
			include "navbar.php";
		?>
        <br><br><br>
        <div class="containerSearch">
        <?php
		//jika tombol search di klik
        if(isset($_POST['search'])){
			//mengambil kata kunci dari inputan dan disimpan di variabel $KUNCI
            $KUNCI=$_POST['KUNCI'];
			//query untuk mencari data 'Nama User' berdasarkan kata kunci
            $statementSearchNAMAUSER=$kon->prepare("SELECT IDUSER, NAMAUSER, PHOTO FROM user WHERE NAMAUSER LIKE '%$KUNCI%'");
            $statementSearchNAMAUSER->execute();
            echo '<h2>User</h2><br>';
			if($_SESSION['IDLEVEL']!='L001'){
				//menampilkan 'Nama User' berdasarkan kata kunci
				foreach($statementSearchNAMAUSER as $DataSearchNAMAUSER){
					?>
						<table>
							<tr>
								<td>
									<img class="imgmember" src="assets/images/<?php echo $DataSearchNAMAUSER[2]; ?>">
									<div class="garis_verikal"></div>
									<?php
									//jika id user yang login = id user yg di search, maka link profil member diarahkan ke profilUtama.php
									if($DataSearchNAMAUSER[0]==$_SESSION['IDUSER']){
										?>
										<h3><a href="profilUtama.php" target="_blank"><?php echo $DataSearchNAMAUSER[1]; ?></a></h3>
										<?php
									}
									//jika tidak sama, maka link profil member di arahkan ke profilMemberLain.php
									else{
										?>
										<h3><a href="profilMemberLain.php?&IDUSER=<?php echo $DataSearchNAMAUSER[0]; ?>" target="_blank"><?php echo $DataSearchNAMAUSER[1]; ?></a></h3>
										<?php
									}
									?>                        
								</td>
							</tr>
						</table>
					<?php
				}
				//query buat mencari data postingan berdasarkan kata kunci
				$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user, user_pertemanan WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER =user.IDUSER AND (user_pertemanan.IDUSER=user.IDUSER OR user_pertemanan.IDUSER2=user.IDUSER) AND (user_pertemanan.IDUSER=:IDUSER OR user_pertemanan.IDUSER2=:IDUSER) AND user_pertemanan.IDPERTEMANAN='B001' AND posting.PESAN LIKE '%$KUNCI%' GROUP BY user_posting.IDPOSTING DESC");
				$statementPOSTING->bindValue(':IDUSER', $_SESSION['IDUSER']);
				$statementPOSTING->execute();
				echo '<h2>Postingan</h2><br>';
				//menampilkan postingan
				foreach($statementPOSTING as $dataPOSTING){
					$DataIDUSER = $dataPOSTING[0];
					$DataUSERNAME = $dataPOSTING[1];
					$DataPHOTO = $dataPOSTING[2];
					$DataPESAN = $dataPOSTING[3];
					$DataGAMBARPOSTING = $dataPOSTING[4];
				?>
					<table>
						<tr border="1">
							<td>
								<img class="imgmember" src="assets/images/<?php echo $DataPHOTO; ?>">
								<div class="garis_verikal"></div>
								<?php
								//jika data id user = id user login, maka link profil member diarahkan ke profilUtama.php
								if($DataIDUSER==$_SESSION['IDUSER']){
									?>
									<h3><a href="profilUtama.php"><?php echo $DataUSERNAME; ?></a></h3>
									<?php
								}
								//jika tidak sama, maka link profil member diarahkan ke profilMemberLain.php
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
				<?php
				}
			}
			else{
				//menampilkan 'Nama User' berdasarkan kata kunci
				foreach($statementSearchNAMAUSER as $DataSearchNAMAUSER){
					?>
						<table>
							<tr>
								<td>
									<img class="imgmember" src="assets/images/<?php echo $DataSearchNAMAUSER[2]; ?>">
									<div class="garis_verikal"></div>
									<?php
									//jika id user yang login = id user yg di search, maka link profil member diarahkan ke profilUtama.php
									if($DataSearchNAMAUSER[0]==$_SESSION['IDUSER']){
										?>
										<h3><a href="profilUtama.php" target="_blank"><?php echo $DataSearchNAMAUSER[1]; ?></a></h3>
										<?php
									}
									//jika tidak sama, maka link profil member di arahkan ke profilMemberLain.php
									else{
										?>
										<h3><a href="profilMemberLain.php?&IDUSER=<?php echo $DataSearchNAMAUSER[0]; ?>" target="_blank"><?php echo $DataSearchNAMAUSER[1]; ?></a></h3>
										<?php
									}
									?>                        
								</td>
							</tr>
						</table>
					<?php
				}
				//query buat mencari data postingan berdasarkan kata kunci
				$statementPOSTING=$kon->prepare("SELECT user_posting.IDUSER, user.USERNAME, user.PHOTO, posting.PESAN, posting.GAMBARPOSTING FROM posting, user_posting, user WHERE posting.IDPOSTING=user_posting.IDPOSTING AND user_posting.IDUSER =user.IDUSER AND posting.PESAN LIKE '%$KUNCI%' GROUP BY user_posting.IDPOSTING DESC");
				$statementPOSTING->execute();
				echo '<h2>Postingan</h2><br>';
				//menampilkan postingan
				foreach($statementPOSTING as $dataPOSTING){
					$DataIDUSER = $dataPOSTING[0];
					$DataUSERNAME = $dataPOSTING[1];
					$DataPHOTO = $dataPOSTING[2];
					$DataPESAN = $dataPOSTING[3];
					$DataGAMBARPOSTING = $dataPOSTING[4];
				?>
					<table>
						<tr border="1">
							<td>
								<img class="imgmember" src="assets/images/<?php echo $DataPHOTO; ?>">
								<div class="garis_verikal"></div>
								<?php
								//jika data id user = id user login, maka link profil member diarahkan ke profilUtama.php
								if($DataIDUSER==$_SESSION['IDUSER']){
									?>
									<h3><a href="profilUtama.php"><?php echo $DataUSERNAME; ?></a></h3>
									<?php
								}
								//jika tidak sama, maka link profil member diarahkan ke profilMemberLain.php
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
				<?php
				}
			}
		}
			
        ?>
        </div>
</body>
</html>
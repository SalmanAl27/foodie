<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Daftar Teman</title>
		<link rel="stylesheet" type="text/css" href="assets/css/styleAdmin.css"/>
	</head>
	<body>
	<div class="body">
		<?php
			//Memulai Session
			session_start();
			//Menyimpan session ke $IDUSER
            $IDUSER=$_SESSION['IDUSER'];
			require "koneksi.php";
			include "navbar.php";
		?>
		<br><br><br><br>
		<div class="container">
		<h2>Daftar Pertemanan</h2><br><br>
			<table  border="" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No.</th>
					<th>Username</th>
					<th>Namauser</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no=1;
			//Query untuk menampilkan pertemanan
			$statement=$kon->prepare("SELECT user.IDUSER ,user.USERNAME, user.NAMAUSER FROM user, user_pertemanan WHERE (user_pertemanan.IDUSER=user.IDUSER OR user_pertemanan.IDUSER2=user.IDUSER) AND (user_pertemanan.IDUSER='$IDUSER' OR user_pertemanan.IDUSER2='$IDUSER') AND user_pertemanan.IDPERTEMANAN='B001' GROUP BY user.IDUSER");
            $statement->execute();
			//Mengambil data pertemanan berdasarkan query
			foreach($statement as $data){
				$DataIDUSER = $data[0];
				$DataUSERNAME = $data[1];
				$DataNAMAUSER = $data[2];
				//Jika IDUSER tidak sama dengan IDUSER yang login maka akan ditampilkan
				if($DataIDUSER!=$IDUSER){
					?>
					<tr>
						<td><?php echo $no++; ?></a></td>
						<td><?php echo $DataUSERNAME; ?></td>
						<td><a href="profilMemberLain.php?&IDUSER=<?php echo $DataIDUSER; ?>" target="_blank"><?php echo $DataNAMAUSER; ?></a></td>
					</tr>
				<?php
				}
			}
			?>
			</tbody>	
			</table>
		</div>
	</body>
</html>

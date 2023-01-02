<?php
session_start();
if($_SESSION['IDLEVEL']!='L001'){
	header('Location:beranda.php');
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Master Member</title>
		<link rel="stylesheet" type="text/css" href="assets/css/styleAdmin.css"/>
	</head>
	<body>
	<div class="body">
		<?php
			require "koneksi.php";
			include "navbar.php";
		?>
		<br><br><br><br>
		<div class="container">
		<h2>Data Member</h2><br><br>
			<table  border="" cellspacing="0" cellpadding="5">
			<thead>
				<tr>
					<th>No.</th>
					<th>Username</th>
					<th>Level</th>
					<th>Nama Lengkap</th>
                    <th>Tanggal Lahir</th>
					<th>PHOTO</th>
                    <th>Email</th>
                    <th>No.HP</th>
					<th>Jenis Kelamin</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no=1;
			//Query untuk menampilkan daftar pertemanan
			$statement=$kon->prepare("SELECT*FROM user, jeniskelamin, level WHERE user.IDJENISKELAMIN=jeniskelamin.IDJENISKELAMIN AND user.IDLEVEL=level.IDLEVEL");
			$statement->execute();
			//Menampilkan daftar pertemanan
			foreach($statement as $data){
				$IDUSER = $data[0];
				$USERNAME = $data[3];
				$NAMAUSER = $data[5];
				$TANGGALLAHIR = $data[6];
				$PHOTO = $data[7];
				$EMAIL= $data[8];
				$NOHP = $data[9];
				$JENISKELAMIN = $data[11];
				$LEVEL = $data[13];
			?>
				<tr>
					<td><?php echo $no++; ?></a></td>
					<td><?php echo $USERNAME; ?></td>
					<td><?php echo $LEVEL; ?></td>
					<td><a href="profilMemberLain.php?&IDUSER=<?php echo $IDUSER; ?>"><?php echo $NAMAUSER; ?></a></td>
					<td><?php echo $TANGGALLAHIR; ?></td>
					<td><img src="assets/images/<?php echo $PHOTO; ?>"></td>
					<td><?php echo $EMAIL; ?></td>
					<td><?php echo $NOHP; ?></td>
					<td><?php echo $JENISKELAMIN; ?></td>
				</tr>
			<?php
			}
			?>
			</tbody>	
			</table>
		</div>
	</body>
</html>

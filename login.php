<?php
  //Memulai Sesssion
  session_start();
  //Jika sudah login maka akan diarahkan ke beranda
  if(isset($_SESSION['IDUSER'])){
    header("Location:beranda.php");
  }
	
  //Jika tombol login di klik
  if(isset($_POST['Login'])){
    //mengambil nilai username dan password dari form
    $USERNAME=$_POST['USERNAME'];
    $PASSWORD=$_POST['PASSWORD'];
    //Function checkPassword untuk mengecek username dan password
    function checkPassword($USERNAME, $PASSWORD){
        require "koneksi.php";
        $statement=$kon->prepare("SELECT*FROM user WHERE USERNAME=:USERNAME and PASSWORD=:PASSWORD");
        $statement->bindValue(':USERNAME', $USERNAME);
        $statement->bindValue(':PASSWORD', MD5($PASSWORD));
        $statement->execute();
        foreach($statement as $data){
          $IDUSER = $data[0];
        }
        //Mengecek jumlah baris
        return $statement->rowCount()>0;
    }
    //Jika hasil true
    if(checkPassword($USERNAME, $PASSWORD)==true){
        //mulai session
        require "koneksi.php";
        //Mengset session diberikan nilai true
        $statement=$kon->prepare("SELECT*FROM user WHERE USERNAME=:USERNAME and PASSWORD=:PASSWORD");
        $statement->bindValue(':USERNAME', $USERNAME);
        $statement->bindValue(':PASSWORD', MD5($PASSWORD));
        $statement->execute();
        foreach($statement as $data){
          $IDUSER = $data[0];
          $IDEVEL = $data[2];
        }
        $_SESSION['IDUSER']=$IDUSER;
        $_SESSION['USERNAME']=$USERNAME;
        $_SESSION['IDLEVEL']=$IDEVEL;
        //Alihkan ke halaman beranda.php
        header('Location:beranda.php');
    }
    //Jika False
    $errorlogin=true;
  }
  //Ketika tombol DaftarAdmin diklik
  if(isset($_POST['DaftarAdmin'])){
    //Jika kodeAdminnya benar maka akan diarahkan ke halaman registerAdmin
    if($_POST['kodeAdmin']=="AdminkuFoodie"){
        header('Location:registerAdmin.php');
        $_SESSION['KodeAdmin']=$_POST['kodeAdmin'];
    }
    //Menampilkan pesan Kode Salah
    $erroradmin=true;
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="assets/css/styleLog.css">
</head>
<body>
	<div class="bg">
		<div class="center">
			<div class="card">
				<h1>Foodie</h1>
				<h1>Login</h1>
				
				<form method="POST">
					<div class="user">
						<br><br>
						<?php if(isset($errorlogin)):?>
							<h4 style='color:red; font-style:italic;'>*Username atau password salah</h4>
						<?php endif; ?>
						<label> Username</label>
						<input type="text" name="USERNAME">
					</div>
					<div class="user">
						<label> Password</label>
						<input type="password" name="PASSWORD">
					</div>
					<div class="user">
						<a href="#modal-opened"  id="modal-closed"><input type="submit" name="Login"></a>
					</div>
					<div class="user">
						<h4>Belum Punya akun? <a href="register.php">Daftar sekarang</a></h4>
						<br>
						
						<h4>Daftar sebagai Admin ?<a href="#modal-opened"  id="modal-closed">Klik disini</a></h4>
            
             <!-- Modal untuk memasukkan KodeAdmin -->
						<div class="modal-container" id="modal-opened">
						  <div class="modal">

							<div class="modal__details">
							  <h1 class="modal__title">Masukkan Kode Admin</h1>
							</div><br><br><br><br><br><br><br><br>
							<?php if(isset($erroradmin)):?>
								<h2 style='color:red; font-style:italic;'>*Kode salah, masukkan ulang kode</h2>
							<?php endif; ?>
							<form method="post">
								<input type="password" name="kodeAdmin"/>
								<button class="modal__btn" type="submit" name="DaftarAdmin"><b>Ok</b></button>
							</form>
							<a href="#modal-closed" class="link-2"></a>

						  </div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>


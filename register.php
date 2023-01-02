<?php
	require "koneksi.php";
	require 'validasi.php';
    //Set error dengan kosong
    $EMAIL = $EMAIL_err = $USERNAME = $USERNAME_err =  $PASSWORD = $PASSWORD_err =  $NAMAUSER = $NAMAUSER_err =  $JENISKELAMIN = $JENISKELAMIN_err = $TANGGALLAHIR = $TANGGALLAHIR_err = $NOHP = $NOHP_err = $PHOTO = $PHOTO_err = "";
    //Jumlah Validasi yang berhasil dilewati
    $a="";

    //ketika tombol SUBMIT di klik
	if(isset($_POST['SUBMIT'])){
        try{
            $kon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            //Mengatur IDUSER
            $queryIDUSER = $kon->prepare("SELECT MAX(IDUSER) FROM user");
            $queryIDUSER->execute();
            foreach($queryIDUSER as $data){
                $urutan = (int) substr($data[0], 1, 3);
            }
            $urutan++;
            $huruf = "U";
            $IDUSER = $huruf . sprintf("%03s", $urutan);

			//Mengatur Upload Gambar
            $file = $_FILES['PHOTO']['name'];
            $tmp_name = $_FILES["PHOTO"]["tmp_name"];
            move_uploaded_file($tmp_name, "Assets/images/".$file);

            //Validasi
            if (empty($_POST['EMAIL'])) {
                $EMAIL_err = "*EMAIL Harus diisi";
            } elseif (!is_email_valid($_POST['EMAIL'])) {
                $EMAIL_err = "*Format Email Salah!";
            }
            else {
                $a++;
            }
            if (empty($_POST['USERNAME'])) {
                $USERNAME_err = "*USERNAME Harus diisi";
            } elseif (!validateNameDanAngka($_POST, 'USERNAME')) {
                $USERNAME_err = "*USERNAME Harus Huruf atau angka!";
            } elseif (strlen($_POST['USERNAME'])<8) {
                $USERNAME_err = "*USERNAME Harus lebih dari 7 huruf atau angka!";
            }
            else {
                $USERNAME=$_POST['USERNAME'];
                $a++;
            }
            if (empty($_POST['PASSWORD'])) {
                $PASSWORD_err = "*PASSWORD Harus diisi";
            } elseif (!validateNameDanAngka($_POST, 'PASSWORD')) {
                $PASSWORD_err = "*PASSWORD Harus Huruf atau angka!";
            } elseif (strlen($_POST['PASSWORD'])<8) {
                $PASSWORD_err = "*PASSWORD Harus lebih dari 7 karakter";
            }
            else {
                $PASSWORD=$_POST['PASSWORD'];
                $a++;
            }
            if (empty($_POST['NAMAUSER'])) {
                $NAMAUSER_err = "*NAMAUSER Harus diisi";
            } elseif (!validateName($_POST, 'NAMAUSER')) {
                $NAMAUSER_err = "*NAMAUSER Harus Huruf!";
            }
            else {
                $NAMAUSER=$_POST['NAMAUSER'];
                $a++;
            }
            if (empty($_POST['TANGGALLAHIR'])) {
                $TANGGALLAHIR_err = "*TANGGALLAHIR Harus diisi";
            }
            else {
                $TANGGALLAHIR=$_POST['TANGGALLAHIR'];
                $a++;
            }
            if (empty($_POST['NOHP'])) {
                $NOHP_err = "*NOHP Harus diisi";
            } elseif (!is_numeric($_POST['NOHP'])) {
                $NOHP_err = "*Harus Angka!";
            } elseif (strlen($_POST['NOHP'])<11 || strlen($_POST['NOHP'])>12) {
                $NOHP_err = "*NOHP Harus 11 sampai 12 digit!";
            }
            else {
                $NOHP=$_POST['NOHP'];
                $a++;
            }
            if (empty($file)) {
                $PHOTO_err = "*PHOTO Harus diisi";
            }
            else {
                $a++;
            }
            //Ketika Validasi sudah 7 atau benar semua
            if ($a == 7){
                //Query untuk menambahkan USER
                $statement=$kon->prepare("INSERT INTO user (IDUSER, IDJENISKELAMIN, IDLEVEL, USERNAME, PASSWORD, NAMAUSER, TANGGALLAHIR, PHOTO, EMAIL, NOHP) VALUES (:IDUSER, :IDJENISKELAMIN, :IDLEVEL, :USERNAME, MD5(:PASSWORD), :NAMAUSER, :TANGGALLAHIR, :PHOTO, :EMAIL, :NOHP)");
                $statement->bindValue(':IDUSER', $IDUSER);
                $statement->bindValue(':IDJENISKELAMIN', $_POST['JENISKELAMIN']);
                $statement->bindValue(':IDLEVEL', "L002");
                $statement->bindValue(':USERNAME', $_POST['USERNAME']);
                $statement->bindValue(':PASSWORD', $_POST['PASSWORD']);
                $statement->bindValue(':NAMAUSER', $_POST['NAMAUSER']);
                $statement->bindValue(':TANGGALLAHIR', $_POST['TANGGALLAHIR']);
                $statement->bindValue(':PHOTO', $file);
                $statement->bindValue(':EMAIL', $_POST['EMAIL']);
                $statement->bindValue(':NOHP', $_POST['NOHP']);
                $statement->execute();
                
                //Menampilkan pesan berhasil
                $error=false;
            
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }	
    }	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="assets/css/styleReg.css">
</head>
<body>
	<div class="bg">
		<div class="card">
			<h1>Foodie</h1>
			<h1>Register</h1>
			<?php if(isset($error)):?>
				<h3 style='color:green; font-style:italic;'>*Data user berhasil ditambahkan</h3>
			<?php endif; ?>
			<form method="POST" enctype="multipart/form-data">
            <div class="user-box">
				<label>E-Mail</label>
				<span><?php echo $EMAIL_err; ?></span>
                <input type="text" name="EMAIL" value="<?php if(isset($_POST['EMAIL'])){echo $_POST['EMAIL'];} ?>">
                
                
            </div>
            <div class="user-box">
				<label>Username</label>
				<span><?php echo $USERNAME_err; ?></span>
                <input type="text" name="USERNAME" value="<?php if(isset($_POST['USERNAME'])){echo $_POST['USERNAME'];}?>">
                
                
            </div>
            <div class="user-box">
				<label>Password</label>
				<span><?php echo $PASSWORD_err; ?></span>
                <input type="password" name="PASSWORD" value="<?php if(isset($_POST['PASSWORD'])){echo $_POST['PASSWORD'];} ?>">
                
                
            </div>
            <div class="user-box">
				<label>Nama Pengguna</label>
				<span><?php echo $NAMAUSER_err; ?></span>
                <input type="text" name="NAMAUSER" value="<?php if(isset($_POST['NAMAUSER'])){echo $_POST['NAMAUSER'];} ?>">
                
                
            </div>
            <div class="user-box">
                <label>Jenis Kelamin</label><br>
                <select name="JENISKELAMIN">
                    <option value="J01">Laki-Laki</option>
                    <option value="J02">Perempuan</option>
                </select>
            </div>
            <div class="user-box">
				<label>Tanggal Lahir</label>
				<span><?php echo $TANGGALLAHIR_err; ?></span>
                <input type="date" name="TANGGALLAHIR" value="<?php if(isset($_POST['TANGGALLAHIR'])){echo $_POST['TANGGALLAHIR'];} ?>">
                
                
            </div>
            <div class="user-box">
				<label>NO.Hp</label>
				<span><?php echo $NOHP_err; ?></span>
                <input type="text" name="NOHP" value="<?php if(isset($_POST['NOHP'])){echo $_POST['NOHP'];} ?>">
                
                
            </div>
            <div class="user-box">
				<label>Foto</label>
				<span><?php echo $PHOTO_err; ?></span>
                <input type="file" name="PHOTO">
                
                
            </div>
            <div class="user-box">
                <input type="submit" name="SUBMIT">
            </div>

                <h4>Sudah punya akun? <a href="login.php">Login sekarang </a></h4>
                
           
        </form>
		</div>
	</div>
</body>
</html>
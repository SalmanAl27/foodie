<?php 
    require "ambildata.php";
    require "validasi.php";
    //Set error dengan kosong
    $USERNAME_err = $EMAIL_err = $PASSWORD_err = $NAMAUSER_err = $JENISKELAMIN_err = $TANGGALLAHIR_err = $NOHP_err = "";
    //Jumlah Validasi yang berhasil dilewati
    $a="";

    //ketika tombol update di klik
    if(isset($_POST['update'])){
        //Mengatur upload gambar
        $file = $_FILES["PHOTO"]["name"];
        $tmp_name = $_FILES["PHOTO"]["tmp_name"];
        move_uploaded_file($tmp_name, "assets/images/".$file);

        //validasi
        if (empty($_POST['USERNAME'])) {
            $USERNAME_err = "<p  style='color:red; float:left; margin-left:90px;'>*USERNAME Harus diisi</p>";
        } elseif (!validateNameDanAngka($_POST, 'USERNAME')) {
             $USERNAME_err = "<p  style='color:red; float:left; margin-left:90px;'>*USERNAME Harus Huruf atau angka</p>";
        } elseif (strlen($_POST['USERNAME'])<8 OR strlen($_POST['USERNAME'])>12) {
            $USERNAME_err = "<p  style='color:red; float:left; margin-left:90px;'>*USERNAME Harus lebih dari 7 dan kurang dari 13 huruf atau angka!</p>";
        }
        else {
            $a++;
        }

        if (empty($_POST['NAMAUSER'])) {
            $NAMAUSER_err = "<p style='color:red; float:left; margin-left:90px;'>*NAMA USER harus diisi</p><br>";
        } elseif (!validateName($_POST, 'NAMAUSER')) {
             $NAMAUSER_err = "<p  style='color:red; float:left; margin-left:90px;'>*NAMAUSER Harus Huruf!</p><br>";
        }
        else {
            $a++;
        }
		
        if (empty($_POST['TANGGALLAHIR'])) {
            $TANGGALLAHIR_err = "<p  style='color:red; float:left; margin-left:90px;'>*TANGGALLAHIR Harus diisi</p><br>";
        }
        else {
            $a++;
        }
        if (empty($_POST['EMAIL'])) {
            $EMAIL_err = "<p  style='color:red; float:left; margin-left:90px;'>*EMAIL Harus diisi</p><br>";
        } elseif (!is_email_valid($_POST['EMAIL'])) {
            $EMAIL_err = "<p  style='color:red; float:left; margin-left:90px;'>*Format Email Salah!</p><br>";
        }
        else {
            $a++;
        }
        if (empty($_POST['NOHP'])) {
            $NOHP_err = "<p  style='color:red; float:left; margin-left:90px;'>*NOHP Harus diisi</p><br>";
        } elseif (!is_numeric($_POST['NOHP'])) {
            $NOHP_err = "<p  style='color:red; float:left; margin-left:90px;'>*Harus Angka!</p><br>";
        } elseif (strlen($_POST['NOHP'])<11 || strlen($_POST['NOHP'])>12) {
            $NOHP_err = "<p  style='color:red; float:left; margin-left:90px;'>*NOHP Harus 11 sampai 12 digit!</p><br>";
        }
        else {
            $a++;
        }
        if (empty($_POST['PASSWORD'])) {
            $PASSWORD_err = "<p  style='color:red; float:left; margin-left:90px;'>*PASSWORD Harus diisi</p><br>";
        } elseif (!validateNameDanAngka($_POST, 'PASSWORD')) {
             $PASSWORD_err = "<p  style='color:red; float:left; margin-left:90px;'>*PASSWORD Harus Huruf atau angka!</p><br>";
        } elseif (strlen($_POST['PASSWORD'])<8) {
            $PASSWORD_err = "<p  style='color:red; float:left; margin-left:90px;'>*PASSWORD Harus lebih dari 7 karakter</p><br>";
        }
        else {
            $a++;
        }
        
        //Ketika Validasi sudah 6 atau benar semua
        if ($a == 6){
            //Ketika isian password masih sama dengan password di database, password tidak akan diupdate
            if($_POST['PASSWORD']==$PASSWORD){
                //Ketika gambarnya kosong, maka gambar tidak akan diupdate
                if(empty($_FILES["PHOTO"]["name"])){
                    $statement=$kon->prepare("UPDATE user SET IDJENISKELAMIN=:IDJENISKELAMIN, USERNAME=:USERNAME, NAMAUSER=:NAMAUSER, TANGGALLAHIR=:TANGGALLAHIR, EMAIL=:EMAIL, NOHP=:NOHP WHERE IDUSER=:IDUSER ");
                    $statement->bindValue(':IDJENISKELAMIN', $_POST['JENISKELAMIN']);
                    $statement->bindValue(':IDUSER', $IDUSER);
                    $statement->bindValue(':USERNAME', $_POST['USERNAME']);
                    $statement->bindValue(':NAMAUSER', $_POST['NAMAUSER']);
                    $statement->bindValue(':TANGGALLAHIR', $_POST['TANGGALLAHIR']);
                    $statement->bindValue(':EMAIL', $_POST['EMAIL']);
                    $statement->bindValue(':NOHP', $_POST['NOHP']);
                    $statement->execute();
                }
                //Ketika gambarnya diganti
                else{
                    $statement=$kon->prepare("UPDATE user SET IDJENISKELAMIN=:IDJENISKELAMIN, USERNAME=:USERNAME, NAMAUSER=:NAMAUSER, TANGGALLAHIR=:TANGGALLAHIR, PHOTO=:PHOTO, EMAIL=:EMAIL, NOHP=:NOHP WHERE IDUSER=:IDUSER ");
                    $statement->bindValue(':IDJENISKELAMIN', $_POST['JENISKELAMIN']);
                    $statement->bindValue(':IDUSER', $IDUSER);
                    $statement->bindValue(':PHOTO', $file);
                    $statement->bindValue(':USERNAME', $_POST['USERNAME']);
                    $statement->bindValue(':NAMAUSER', $_POST['NAMAUSER']);
                    $statement->bindValue(':TANGGALLAHIR', $_POST['TANGGALLAHIR']);
                    $statement->bindValue(':EMAIL', $_POST['EMAIL']);
                    $statement->bindValue(':NOHP', $_POST['NOHP']);
                    $statement->execute();
                }
            }
            //Ketika passwordnya di edit, maka akan mengupdate password
            else{
                //Ketika gambarnya kosong, maka gambar tidak akan diupdate
                if(empty($_FILES["PHOTO"]["name"])){
                    $statement=$kon->prepare("UPDATE user SET IDJENISKELAMIN=:IDJENISKELAMIN, PASSWORD=MD5(:PASSWORD), USERNAME=:USERNAME, NAMAUSER=:NAMAUSER, TANGGALLAHIR=:TANGGALLAHIR, EMAIL=:EMAIL, NOHP=:NOHP WHERE IDUSER=:IDUSER ");
                    $statement->bindValue(':IDJENISKELAMIN', $_POST['JENISKELAMIN']);
                    $statement->bindValue(':IDUSER', $IDUSER);
                    $statement->bindValue(':USERNAME', $_POST['USERNAME']);
                    $statement->bindValue(':PASSWORD', $_POST['PASSWORD']);
                    $statement->bindValue(':NAMAUSER', $_POST['NAMAUSER']);
                    $statement->bindValue(':TANGGALLAHIR', $_POST['TANGGALLAHIR']);
                    $statement->bindValue(':EMAIL', $_POST['EMAIL']);
                    $statement->bindValue(':NOHP', $_POST['NOHP']);
                    $statement->execute();
                }
                //Ketika gambarnya diganti
                else{
                    $statement=$kon->prepare("UPDATE user SET IDJENISKELAMIN=:IDJENISKELAMIN, PASSWORD=MD5(:PASSWORD), USERNAME=:USERNAME, NAMAUSER=:NAMAUSER, PHOTO=:PHOTO, TANGGALLAHIR=:TANGGALLAHIR, EMAIL=:EMAIL, NOHP=:NOHP WHERE IDUSER=:IDUSER ");
                    $statement->bindValue(':IDJENISKELAMIN', $_POST['JENISKELAMIN']);
                    $statement->bindValue(':IDUSER', $IDUSER);
                    $statement->bindValue(':PASSWORD', $_POST['PASSWORD']);
                    $statement->bindValue(':USERNAME', $_POST['USERNAME']);
                    $statement->bindValue(':NAMAUSER', $_POST['NAMAUSER']);
                    $statement->bindValue(':PHOTO', $file);
                    $statement->bindValue(':TANGGALLAHIR', $_POST['TANGGALLAHIR']);
                    $statement->bindValue(':EMAIL', $_POST['EMAIL']);
                    $statement->bindValue(':NOHP', $_POST['NOHP']);
                    $statement->execute();
                }
            }
            $error=false;
            //Mengambil updatean data
            @require "ambildata.php";
        }
       
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styleBeranda.css" />
</head>

<body>
    <?php
        //Include Navbar
		include "navbar.php";
	?>
    <br><br><br>
    <div class="container2">
        <fieldset>
            <legend align="center">
                <h1 align="center">Edit Profile</h1>
            </legend>
            <br>
            <br><br>
            <form class="edit" align="center" method="POST" action="" enctype="multipart/form-data">
                <img class="fotoProfil" src="assets/images/<?php echo $PHOTO; ?>"><br>
                <label for="file-input">
                    <img id="editfoto" src="assets/icon/editfoto.png" title="Edit foto">
                </label>
                <input id="file-input" type="file" name="PHOTO" onchange="editfoto(this);" style="display: none;" /><br>
                <br><br>
                <?php if(isset($error)):?>
                    <h3 style='color:green; font-style:italic;'>*Data berhasil diupdate</h3>
                <?php endif; ?>
				<span><?php echo $USERNAME_err; ?></span><br>
                <Label for="USERNAME">Username</Label><br>
                <input id="USERNAME" type="text" name="USERNAME" value="<?php echo $USERNAME; ?>">
                
                <br>
				<span><?php echo $NAMAUSER_err; ?></span><br>
                <Label for="NAMAUSER">Nama Lengkap</Label><br>
                <input id="NAMAUSER" type="text" name="NAMAUSER" value="<?php echo $NAMAUSER; ?>">
                
                <br>
                <Label>Jenis Kelamin</Label><br><br>
                <select name="JENISKELAMIN">
                    <option value="J01" <?=($JENISKELAMIN=='Laki-Laki')?'selected="selected"':''?>>Laki-Laki</option>
                    <option value="J02" <?=($JENISKELAMIN=='Perempuan')?'selected="selected"':''?>>Perempuan</option>
                </select>
                <br><br>
				<span><?php echo $TANGGALLAHIR_err; ?></span><br>
                <label>Tanggal Lahir</label><br><br>
                <input type="date" name="TANGGALLAHIR" value="<?php echo $TANGGALLAHIR; ?>">
               
                <br><br>
				<span><?php echo $EMAIL_err; ?></span><br>
                <Label for="EMAIL">E-mail</Label><br>
                <input id="EMAIL" type="text" name="EMAIL" value="<?php echo $EMAIL; ?>" />
                
                <br>
				<span><?php echo $NOHP_err; ?></span><br>
                <Label>NoHP</Label><br>
                <input type="text" name="NOHP" value="<?php echo $NOHP; ?>">
                
                <br>
				<span><?php echo $PASSWORD_err; ?></span><br>
                <Label for="PASSWORD">Password</Label><br>
                <input id="PASSWORD" type="password" name="PASSWORD" value="<?php echo $PASSWORD; ?>" />
                
                <br>
                <input class="buttoneditprofil" type="submit" name="update" value="Edit">
            </form>
            <br><br>
        </fieldset>
    </div>
</body>

</html>
<?php
  //Ketika belum login maka akan diarahkan ke login
    if(!isset($_SESSION['IDUSER'])){
        header("Location:login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styleBeranda.css" />
</head>
<body>
    <?php
    //Jika IDLEVEL="L001" (Admin), terdapat Master Member
    if($_SESSION['IDLEVEL']=="L001"){
        ?>
        <nav>
            <a href="beranda.php">
                <img class="foodie" src="assets/icon/foodiee.png" alt="logo">
            </a>
            <form class="cari" method="post" action="search.php">
                <input class="search" type="search" placeholder="Search....." name="KUNCI">
                <button class="button" type="submit" name="search"><img id="button" src="assets/icon/search.png"></button>
            </form>
            <a href="#modal-opened"  id="modal-closed"><img class="nav" src="assets/icon/logout.png" title="Logout"></a>

				<div class="modal-container" id="modal-opened">
				  <div class="modal">

					<div class="modal__details">
					  <h1 class="modal__title">Apakah anda yakin untuk logout ?</h1>
					</div><br><br><br><br><br><br><br><br>
					<b><a href="#modal-closed" class="modal__btnTidak">Tidak</a></b>
					<button class="modal__btnYa"><b><a href="logout.php">Ya</a></b></button>

					<a href="#modal-closed" class="link-2"></a>

				  </div>
				</div>
            <a href="masterMember.php"><img class="nav" src="assets/icon/masterMember.png"></a>
            <a href="profilUtama.php"><img class="nav" src="assets/icon/editprofil.png" title="My Profile"></a>
        </nav>
        <?php
    }
    //Jika selain L001, berarti akan memakai navbar berikut
    else{
        ?>
        <nav>
            <a href="beranda.php">
                <img class="foodie" src="assets/icon/foodiee.png" alt="logo">
            </a>
            <form class="cari" method="post" action="search.php">
                <input class="search" type="search" placeholder="Search....." name="KUNCI">
                <button class="button" type="submit" name="search"><img id="button" src="assets/icon/search.png"></button>
            </form>
            
			
				<a href="#modal-opened"  id="modal-closed"><img class="nav" src="assets/icon/logout.png" title="Logout"></a>

				<div class="modal-container" id="modal-opened">
				  <div class="modal">

					<div class="modal__details">
					  <h1 class="modal__title">Apakah anda yakin untuk logout ?</h1>
					</div><br><br><br><br><br><br><br><br>
					<b><a href="#modal-closed" class="modal__btnTidak">Tidak</a></b>
					<button class="modal__btnYa"><b><a href="logout.php">Ya</a></b></button>

					<a href="#modal-closed" class="link-2"></a>

				  </div>
				</div>
            <a href="profilUtama.php"><img class="nav" src="assets/icon/editprofil.png" title="My Profile"></a>
        </nav>
        <?php
    }
    ?>
</body>
</html>
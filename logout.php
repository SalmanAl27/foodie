<?php
//Memulai session
session_start();
//Mengakhiri session
unset($_SESSION['IDUSER']);
unset($_SESSION['USERNAME']);
unset($_SESSION['IDLEVEL']);
//Alihkan ke index.php
header("Location:index.php");
?>
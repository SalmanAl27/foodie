<?php
    //Mengakses file koneksi.php untuk koneksi ke database
	require "koneksi.php";
    //Memulai session
	session_start();
    //Mengakses Session IDUSER 
	$IDUSER=$_SESSION['IDUSER'];
    //Query menampilkan user berdasarkan IDUSER yang login
	$statement=$kon->prepare("SELECT*FROM user WHERE IDUSER=:IDUSER");
    $statement->bindValue(':IDUSER', $IDUSER);
    $statement->execute();
    //Mengakses data hasil query
    foreach($statement as $data){
        $USERNAME = $data[3];
        $PASSWORD = $data[4]; 
        $NAMAUSER = $data[5];
        $TANGGALLAHIR = $data[6];
        $PHOTO = $data[7];
		$EMAIL= $data[8];
        $NOHP = $data[9];
    }
    //Query untuk menampilkan jenis kelamin berdasarkan IDUSER yang login
    $statementJENISKELAMIN=$kon->prepare("SELECT jeniskelamin.JENISKELAMIN FROM jeniskelamin,user WHERE jeniskelamin.IDJENISKELAMIN=user.IDJENISKELAMIN AND user.IDUSER=:IDUSER");
    $statementJENISKELAMIN->bindValue(':IDUSER', $IDUSER);
    $statementJENISKELAMIN->execute();
    foreach($statementJENISKELAMIN as $dataJENISKELAMIN){
        $JENISKELAMIN = $dataJENISKELAMIN[0];
    }
?>
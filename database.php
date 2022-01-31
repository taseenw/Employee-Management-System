<?php

//This file is what provides my code access to the connected SQL database, making sure to also throw an error if it cannot connect

$mysql_hostname = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "twempsoftware";

$dsn = "mysql:host=".$mysql_hostname.";dbname=".$mysql_database;

$debug = false;

try{
	$pdo= new PDO($dsn, $mysql_username,$mysql_password, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

catch (PDOException $e){
	echo 'PDO error: could not connect to DB, error: '.$e;
}
?>
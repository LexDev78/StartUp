<?php 
try{
	$bdd = new PDO("mysql:host=localhost; dbname=gestiontransport", "root", "");
	$bdd -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo "Connexion établie";
}catch (Exception $e){
	echo "Erreur : ".$e->getMessage()."<br>";
	die();	
}

?>
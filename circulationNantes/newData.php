<?php

require("config.php")

header("Refresh:400"); //Rafraîchir toutes les 20 minutes

$file = "compte.log";
$res = intval(file_get_contents($file))+1;
file_put_contents($file,$res);

echo "C'est le ".strval($res)."ème enregistrement !";

//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//$bdd = new PDO('mysql:host=localhost;dbname=circulation;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//███████████████████████████████████████████████████ CONNEXION █████████████████████████████████████████████████████████████████████

//enregistrer le fichier csv

$ch = curl_init();
try {
	curl_setopt($ch, CURLOPT_URL, "https://data.nantesmetropole.fr/api/v2/catalog/datasets/244400404_fluidite-axes-routiers-nantes-metropole/exports/csv?select=*&limit=-1&timezone=UTC&delimiter=%2C");
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);   
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);         
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		echo curl_error($ch);
		die();
	}

	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if($http_code == intval(200)){
		file_put_contents("donnees.csv", $response);
	}
	else{
		echo "Ressource introuvable : " . $http_code;
	}
} catch (\Throwable $th) {
	throw $th;
} finally {
	curl_close($ch);
}

// Importer dans mysql

$file = fopen("donnees.csv", "r");
$entete = false;
$new = $bdd->prepare("INSERT INTO circulation VALUES (?,?,?,NOW(),?,?,?,?,?,?,?,?)");
$new->bindParam(1, $v1);
$new->bindParam(2, $v2);
$new->bindParam(3, $v3);
$new->bindParam(4, $v5);
$new->bindParam(5, $v6);
$new->bindParam(6, $v7);
$new->bindParam(7, $v8);
$new->bindParam(8, $v9);
$new->bindParam(9, $v10);
$new->bindParam(10, $v11);
$new->bindParam(11, $v12);

while (($column = fgetcsv($file, 100000, ",")) !== FALSE) {
	if ($entete){
		$v1 = $column[0];
		$v2 = $column[1];
		$v3 = $column[2];
		$v5 = $column[4];
		$v6 = $column[5];
		$v7 = $column[6];
		$v8 = $column[7];
		$v9 = $column[8];
		$v10 = $column[9];
		$v11 = str_replace('}"',"",str_replace('"{""type"": ""LineString"", ""coordinates"":',"",$column[10]));
		$v12 = $column[11];
		$new->execute();
	}
	else{
		$entete=true;
	}
}
?>

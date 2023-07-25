<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (!isset($_SESSION['pseudo'])){
	header('Location: /index.php');
}
if (!isset($_GET['id']) || !isset($_GET['participant'])){
	header('Location: /admin/espaceAdmin.php?but=evenement');
}

//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████
try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

$evenement = $bdd->query('
SELECT 	id, type, nom,
		DATE_FORMAT(date_dbt, \'le %d/%m/%Y dès %Hh%i\') AS date_dbt,
		DATE_FORMAT(date_fin, \'le %d/%m/%Y à %Hh%i\') AS date_fin,
		DATEDIFF(NOW(), date_limite) AS date_limite,
		lieu, explications, nb_places, id_participants
FROM 	evenements
WHERE 	id='.$_GET['id']);
$j=0;
$ligne = $evenement->fetch();
$j++;
//Compte inscrits
$id = $ligne['id_participants'];
echo $id;
$seqId = preg_replace('#\"'.$_GET["participant"].'\"#','"',$id);
echo $seqId;

//██████████████████████████████████████████████████ Récupération des valeurs des champs ███████████████████████████████████████████████████████

$bdd->exec("UPDATE evenements SET id_participants='$seqId' WHERE id =".$_GET['id']);

header('Location: /admin/espaceAdmin.php?but=evenement#nextEvent');
	
?>

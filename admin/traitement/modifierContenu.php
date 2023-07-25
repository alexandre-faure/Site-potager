<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (!isset($_SESSION['pseudo'])){
	header('Location: /index.php');
}

if (!isset($_GET['page'])){
	header('Location: /admin/espaceAdmin.php');
}

function genererChaineAleatoire($longueur = 10)
{
 $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $longueurMax = strlen($caracteres);
 $chaineAleatoire = '';
 for ($i = 0; $i < $longueur; $i++)
 {
 $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
 }
 return $chaineAleatoire;
}

//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████
try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//██████████████████████████████████████████████████ Récupération des valeurs des champs ███████████████████████████████████████████████████████
$page = $_GET['page'];
$pseudo = $_SESSION['pseudo'];


$pageExiste = $bdd->query("SELECT id FROM contenu WHERE page = '$page'");
// On compte le nombre d'itérations
$nbIterations = $pageExiste->rowCount();
$pageExiste->closeCursor();

if ($nbIterations<0){
	echo "Désolé, la page dont vous tentez de modifier le contenu n'est pas prévue à cet effet ou n'existe pas !";
}
else{
	$chaine = genererChaineAleatoire(40);
	$bdd->exec("UPDATE contenu SET pseudo_modif='$pseudo', chaine_modif='$chaine' WHERE page = '$page'");
}

header('Location: /admin/contenu.php?page='.$page.'&chaine='.$chaine);
	
?>

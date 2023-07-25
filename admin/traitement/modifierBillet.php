<?php

require("config.php")

//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████
try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//██████████████████████████████████████████████████ Récupération des valeurs des champs ███████████████████████████████████████████████████████
$titre = htmlspecialchars($_POST['titre']);
$contenu = htmlspecialchars($_POST['contenu']);
$numero = htmlspecialchars($_POST['numero']);

$contenu = preg_replace('#\&lt;#','<',$contenu);
$contenu = preg_replace('#\&gt;#','>',$contenu);
$titre = preg_replace('#\&lt;#','<',$titre);
$titre = preg_replace('#\&gt;#','>',$titre);

$titre = preg_replace('#\'#i','&apos;',$titre);
$contenu = preg_replace('#\'#i','&apos;',$contenu);



$bdd->exec("UPDATE blog SET titre='$titre', contenu='$contenu' WHERE numero ='$numero'");

header('Location: /admin/espaceAdmin.php');
	
?>

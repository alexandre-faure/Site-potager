<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (!isset($_SESSION['pseudo'])){
	header('Location: /index.php');
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
$id = htmlspecialchars($_POST['id']);
$type = htmlspecialchars($_POST['type']);
$nom = htmlspecialchars($_POST['nom']);
if (isset($_POST['nbPers'])){
	$nb_places = htmlspecialchars($_POST['nbPers']);
	$date_limite = htmlspecialchars($_POST['inscriJ']." ".$_POST['inscriH'].":00");
}
else{
	$nb_places="";
}
$date_dbt = htmlspecialchars($_POST['dbtJ']." ".$_POST['dbtH'].":00");
$date_fin = htmlspecialchars($_POST['finJ']." ".$_POST['finH'].":00");
$lieu = htmlspecialchars($_POST['lieu']);
$explications = htmlspecialchars($_POST['explications']);

$nom = preg_replace('#\&lt;#','<',$nom);
$nom = preg_replace('#\&gt;#','>',$nom);
$lieu = preg_replace('#\&lt;#','<',$lieu);
$lieu = preg_replace('#\&gt;#','>',$lieu);
$explications = preg_replace('#\&lt;#','<',$explications);
$explications = preg_replace('#\&gt;#','>',$explications);

$nom = preg_replace('#\'#i','&apos;',$nom);
$lieu = preg_replace('#\'#i','&apos;',$lieu);
$explications = preg_replace('#\'#i','&apos;',$explications);

if ($nb_places==""){
	$bdd->exec("UPDATE evenements SET type='$type', nom='$nom', date_dbt='$date_dbt', date_fin='$date_fin', lieu='$lieu', explications='$explications', nb_places=NULL, date_limite=NULL WHERE id ='$id'");
}
else{
	$bdd->exec("UPDATE evenements SET type='$type', nom='$nom', date_dbt='$date_dbt', date_fin='$date_fin', lieu='$lieu', explications='$explications', nb_places='$nb_places', date_limite='$date_limite' WHERE id ='$id'");
}

header('Location: /admin/espaceAdmin.php?but=evenement');
	
?>

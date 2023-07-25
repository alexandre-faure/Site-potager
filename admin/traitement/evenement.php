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
$type = htmlspecialchars($_POST['type']);
$nom = htmlspecialchars($_POST['nom']);
$date_dbt = htmlspecialchars($_POST['dbtJ']." ".$_POST['dbtH'].":00");
$date_fin = htmlspecialchars($_POST['finJ']." ".$_POST['finH'].":00");
if (isset($_POST['nbPers'])){
	$nb_places = htmlspecialchars($_POST['nbPers']);
	$date_limite = htmlspecialchars($_POST['inscriJ']." ".$_POST['inscriH'].":00");
}
else{
	$nb_places="";
}
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
	$a = $bdd->exec("INSERT INTO evenements (type, nom, date_dbt, date_fin, lieu, explications, id_participants) VALUES ('$type','$nom','$date_dbt','$date_fin','$lieu','$explications','\"')");
}
else{
	$a = $bdd->exec("INSERT INTO evenements (type, nom, date_dbt, date_fin, lieu, explications, nb_places, date_limite, id_participants) VALUES ('$type','$nom','$date_dbt','$date_fin','$lieu','$explications','$nb_places','$date_limite','\"')");
}

header('Location: /admin/espaceAdmin.php?but=evenement');
	
?>

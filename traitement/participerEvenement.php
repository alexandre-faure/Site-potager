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
$nom = strtoupper(htmlspecialchars($_POST['nom']));
$prenom = ucwords(strtolower(htmlspecialchars($_POST['prenom'])));
$class="";
if (isset($_POST['classe'])){$classe = strtoupper(htmlspecialchars($_POST['classe']));}
$date_naissance = htmlspecialchars($_POST['date']);
$mail="";
if (isset($_POST['mail'])){$mail = htmlspecialchars($_POST['mail']);}
$prio = 0;
if (isset($_POST['prio'])){$prio = 1;}
$idEvenement = htmlspecialchars($_POST['idEvenement']);

//Personne existe déjà?
$pseudoUnique = $bdd->query("SELECT id, mail, classe, prioritaire FROM participants WHERE prenom = '$prenom' AND date_naissance = '$date_naissance' AND nom = '$nom'");
$compte = $pseudoUnique->rowCount();

//Modifie paramètres si nécessaire
if ($compte){
	$ligne = $pseudoUnique->fetch();
	$id = $ligne['id'];
	if ($ligne['mail']!=$mail && $mail!=""){
		$bdd->exec("UPDATE participants SET mail='$mail' WHERE id ='$id'");
	}
	if ($ligne['classe']!=$classe && $classe!=""){
		$bdd->exec("UPDATE participants SET classe='$classe' WHERE id ='$id'");
	}
	if ($ligne['prioritaire']!=$prio && $prio!=""){
		$bdd->exec("UPDATE participants SET prioritaire='$prio' WHERE id ='$id'");
	}
	$pseudoUnique->closeCursor();
}
else{
	$bdd->exec("INSERT INTO participants (nom, prenom, classe, prioritaire, mail, date_naissance) VALUES ('$nom','$prenom','$classe','$prio','$mail','$date_naissance')");
	$pseudo = $bdd->query("SELECT id FROM participants WHERE prenom = '$prenom' AND date_naissance = '$date_naissance' AND nom = '$nom'");
	$ligne = $pseudo->fetch();
	$id = $ligne['id'];
	$pseudo->closeCursor();
}

$participants = $bdd->query("SELECT nb_places, id_participants FROM evenements WHERE id ='$idEvenement'");
$ligne = $participants->fetch();
$id_participants = $ligne['id_participants'];

$newId="";
$listeId=[];
for ($i=0;$i<strlen($id_participants);$i++){
	if($id_participants[$i]=="\"" && $newId==""){
		continue;
	}
	if($id_participants[$i]!="\""){
		$newId=$newId.$id_participants[$i];
	}
	else{
		$listeId[]=intval($newId);
		$newId="";
	}
}
$dejaInscrit = in_array($id,$listeId);
$nbInscrits = count($listeId);

if ($nbInscrits<$ligne['nb_places'] && !$dejaInscrit){
	$id_participants=$id_participants.$id."\"";
	
	$bdd->exec("UPDATE evenements SET id_participants='$id_participants' WHERE id ='$idEvenement'");
}


$participants->closeCursor();


header('Location: /projet.php?scroll=Evenements');
	
?>

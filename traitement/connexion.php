<?php
//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████
sleep(1.5);

require("config.php")

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//███████████████████████████████████████████████████ CONNEXION █████████████████████████████████████████████████████████████████████
$infosPseudo = $bdd->prepare('SELECT id, mdp, pseudo, validite FROM utilisateur WHERE pseudo = :pseudo');
$infosPseudo->execute(array(
    'pseudo' => htmlspecialchars($_POST['pseudo'])));
$infosPseudoF = $infosPseudo->fetch();

// Comparaison du pass envoyé via le formulaire avec la base
$mdpOK = password_verify(htmlspecialchars($_POST['mdp']), $infosPseudoF['mdp']);

if (!$infosPseudoF){
	header("Location: /administrateur.php?but=connexion&pb=1");
}
else
{
    if ($mdpOK && $infosPseudoF['validite']==1) {
        session_start();
        $_SESSION['id'] = $infosPseudoF['id'];
        $_SESSION['pseudo'] = $infosPseudoF['pseudo'];
		if(isset($_GET['validerCompte']) && isset($_GET['chaine'])){
			if($_GET['validerCompte']=="true"){
				$get="?chaine=".$_GET['chaine'];
			}
			else{$get="";}
		}
		else{$get="";}
		if ($get==""){
			header("Location: /admin/espaceAdmin.php");
		}
		else{
			header("Location: /admin/traitement/validerCompte.php".$get);
		}
    }
    else {
        header("Location: /administrateur.php?but=connexion&pb=1");
    }
}

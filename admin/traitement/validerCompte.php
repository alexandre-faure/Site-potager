<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if(!isset($_GET["chaine"])){
	header('Location: /index.php');
}

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

$infosPseudo = $bdd->query('SELECT pseudo FROM utilisateur WHERE chaine_validation = "'.$_GET["chaine"].'"');
// On compte le nombre de pseudo identiques
$compte = $infosPseudo->rowCount();
if($compte==0){
	echo "Le compte que vous tentez d'autoriser a déjà été confirmé par un autre administrateur ou n'existe pas.<br>";
	echo "<a href='/admin/espaceAdmin.php'>Retour vers l'espace administrateur</a>";
}
else{
	$infosPseudoF = $infosPseudo->fetch();

	if (!isset($_SESSION["pseudo"])){
		header('Location: /administrateur.php?but=connexion&validerCompte=true&chaine='.$_GET["chaine"]);
	}
	else if(!isset($_GET["confirmer"])){
		echo "<script>
		if (confirm('Voulez-vous valider la création d\'un compte administrateur pour ".$infosPseudoF["pseudo"]."?')){
			document.location.href='/admin/traitement/validerCompte.php?confirmer=true&chaine=".$_GET["chaine"]."';
		}
		else if(confirm('Voulez-vous supprimer la tentaive de création de compte de ".$infosPseudoF["pseudo"]."?')){
			document.location.href='/admin/traitement/validerCompte.php?confirmer=false&chaine=".$_GET["chaine"]."';
		}
		else{
			document.write('Aucune action n'a été effectuée.<br>')
			document.write('<a href=\"/admin/espaceAdmin.php\">Retour vers l'espace administrateur</a>')
		}
		</script>";
	}
	else if($_GET["confirmer"]=="true"){
		$bdd->query('UPDATE utilisateur SET validite=1, chaine_validation="" WHERE chaine_validation = "'.$_GET["chaine"].'"');
		
		echo "Le compte a été accepté avec succès.<br>";
		echo "<a href='/admin/espaceAdmin.php'>Retour vers l'espace administrateur</a>";
	}
	else if($_GET["confirmer"]=="false"){
		$bdd->query('DELETE FROM utilisateur WHERE chaine_validation = "'.$_GET["chaine"].'"');
		
		echo "Le compte a bien été supprimé.<br>";
		echo "<a href='/admin/espaceAdmin.php'>Retour vers l'espace administrateur</a>";
	}
	header('Location: /admin/espaceAdmin.php.php');
}
	
?>

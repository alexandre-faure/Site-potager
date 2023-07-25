<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (!isset($_SESSION["pseudo"])){
	header("Location: /administrateur.php");
}

if (!isset($_GET["but"])){
	header('Location: ?but=billet');
}
else if ($_GET["but"]!="billet" && $_GET["but"]!="evenement"){
	header('Location: ?but=billet');
}
else if (!isset($_GET["modifier"])){
	if ($_GET["but"]=="billet"){
		header('Location: ?but=billet&modifier=false');
	}
	else{
		header('Location: ?but=evenement&modifier=false');
	}
}

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

$billet = $bdd->query('SELECT id, numero, titre, DATE_FORMAT(date, \'le %d/%m/%Y à %Hh%i\') AS date, contenu FROM blog ORDER BY id DESC LIMIT 1');
$dernierBillet = $billet->fetch();
$billet->closeCursor();

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="/style/style.css" />
        <meta name="viewport" content="width=device-width" />
		<meta name="author" content="Jardin Solidaire">
        <meta name="description" content="Site officiel du potager du lycée René Cassin de Montfort sur Meu (35)." />
		<meta name="keywords" content="jardin, solidaire, potager, montfort sur meu, projet, écologie, nature, lycée, rené cassin">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="icon" type="image/png" href="/img/logo.png" />
        <title>Espace Administrateur</title>
    </head>
    <body>
		<?php include("/var/www/legtux.org/users/potager-lyceerenecassin/www/include/connecte.php"); ?>
		<?php include("traitement/renumerotation.php"); ?>
		<header>
			<div>
				<h2>Espace<br>Administrateur</h2>
			</div>
		</header>
		<?php include("/var/www/legtux.org/users/potager-lyceerenecassin/www/include/nav.php"); ?>
		<section class="liens">
			<a href="?but=billet&scroll=Blog">BILLETS DU BLOG</a>
			<a href="?but=evenement&scroll=Evenements">ÉVÉNEMENTS</a>
			<a onClick="scrollID('Photos')">IMPORTER DES PHOTOS</a>
		</section>
		
		<?php if ($_GET['but']=="billet"){
			include("include/billetAdmin.php");
		}
		else if ($_GET['but']=="evenement"){
			include("include/evenementAdmin.php");
		}
		?>
		
		<!--███████████████████████████████████ IMPORTER DES PHOTOS ██████████████████████████████-->
		<section id="Photos">
			<h2 id="Blog">SECTION PHOTOS</h2>
			<h3>Mettre une photo en ligne</h3>
			<form action="traitement/photo.php" method="post" enctype="multipart/form-data">
				<div id="importerPhoto">
					<br>
					<div class="center">
						<label id='logoPhoto' class='material-icons' onClick="newPhoto()">add_a_photo</label>
					</div>
					<div id="listePhotos"></div>
					<input required multiple style='display:none' id="photo" type="file" accept=".png, .jpg, .jpeg, .gif, .ico" name="photo[]"/>
					<div class='center'>
						<input name="submit" class="envoyer" disabled type="submit" id="submitPhoto" value="Aucune image sélectionée..." />
					</div>
				</div>
			</form>
		</section>
		
		
		<!--████████████████████████████████████████ SE DÉCONNECTER ███████████████████████████████████████████-->
		<section id="sectionDeconnexion">
			<span id="flecheDeconnexion" title="Se déconnecter" onClick="document.location.href='traitement/deconnexion.php'">
				<svg xmlns="http://www.w3.org/2000/svg" width="48" height="38">
					<rect x="4" y="4" width="40" height="30" rx="3" ry="3"/>
				</svg>
				<label>➔</label>
			</span>
			<br>
		</section>
		
		<!--████████████████████████████████████████████ FOOTER ████████████████████████████████████████████-->
		<?php include("/var/www/legtux.org/users/potager-lyceerenecassin/www/include/footer.php"); ?>
		<script src="script/outilsBlog.js"></script>
		<!-- Dialogue info outils -->
		<div class="dialog" style="display:none;">
			<div class="dialogContainer">
				<button onClick="fermerAlerte()" id="fermer">×</button>
				<h1>Information</h1>
				<h2></h2>
				<div id="dialogContent">
					<p id="pEcrit"></p>
					<em></em>
					<p id="pApercu"></p>
				</div>
				<button onClick="fermerAlerte()">J’ai compris</button>
			</div>
		</div>
		
		<!-- Dialogue confirmation modifier billet -->
		<div class="dialog" style="display:none;">
			<div class="dialogContainer">
				<button onClick="fermerAlerte(1)" id="fermer">×</button>
				<h1></h1>
				<p id="pConfirmation"></p>
				<button onClick="confirmer(<?php echo $dernierBillet["numero"]; ?>)">Confirmer</button>
			</div>
		</div>
		
		<!-- Dialogue confirmation modifier site -->
		<div class="dialog" style="display:none;">
			<div class="dialogContainer">
				<button onClick="fermerAlerte(2)" id="fermer">×</button>
				<h1></h1>
				<p id="pModifierPage"></p>
				<button onClick="confirmerPage()">Confirmer</button>
			</div>
		</div>
		
		<!-- Dialogue envoi d'une image -->
		<div class="dialog" style="display:none;">
			<div class="dialogContainer">
				<h1>Envoi d'une image</h1>
				<p id="pEnvoi">Votre image est en cours d'envoi.<br>Veuillez patienter quelques instants...</p>
				<img alt="chargement" src="img/loading.gif">
			</div>
		</div>
    </body>
</html>

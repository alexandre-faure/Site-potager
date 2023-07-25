<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

if (isset($_SESSION["pseudo"])){
	header('Location: /admin/espaceAdmin.php');
}

if (!isset($_GET["but"])){
	header('Location: administrateur.php?but=connexion');
}
else if ($_GET["but"]!="inscription" && $_GET["but"]!="connexion"){
	header('Location: administrateur.php?but=connexion');
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="style/style.css" />
        <meta name="viewport" content="width=device-width" />
		<meta name="author" content="Jardin Solidaire">
        <meta name="description" content="Site officiel du potager du lycée René Cassin de Montfort sur Meu (35)." />
		<meta name="keywords" content="jardin, solidaire, potager, montfort sur meu, projet, écologie, nature, lycée, rené cassin">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="icon" type="image/png" href="img/logo.png" />
        <title>Accès espace administrateur</title>
    </head>
    <body>
		<?php include("include/connecte.php"); ?>
		<header>
			<div>
				<h2>Espace<br>Administrateur</h2>
			</div>
		</header>
		<?php include("include/nav.php"); ?>
		
		<section class="liens">
			<a href="?but=inscription">S'INSCRIRE</a>
			<a href="?but=connexion">S'AUTHENTIFIER</a>
		</section>
		
		<!-- INSCRIPTION -->
		<section style="display:<?php if ($_GET["but"]!="inscription"){echo "none";} ?>;">
			<h3>Création d'un compte administrateur</h3>
			<form id="formInscription" action="traitement/inscription.php" method="post">
				<div>
					<b class="titreChamp">Pseudo</b><br>
					<input class="champ" placeholder="exemple" required="required" type="text" minlength="5" maxlength="255" name="pseudo" pattern="[a-zA-z0-9.-]{5,}" title="Lettres majuscules et minuscules, chiffres, point, tirets haut et bas exculsivement (4 caratères minimum)" onfocus="indicationsChamp(this)" onblur="indicationsChampF(this)">
					<span class="none detailChamp">Veuillez saisir un pseudo contenant exclusivement des lettres majuscules ou minuscules, des points ainsi que des tirets hauts ou bas. Tout pseudo de moins de <strong>5 caractères</strong> ou déjà attribué ne pourra vous être accordé.</span>
				</div>
				
				<div>
					<b class="titreChamp">Mot de passe</b><br>
					<input class="champ" id="inputMdpAdmin" title="Veuillez saisir un mot de passe sécurisé comprenant au moins 1 lettre minuscule, 1 lettre majuscule, 1 chiffre, 1 caractère spécial (minimum 8 caractères)" required="required" placeholder="•••••••••••" type="password" minlength="8" maxlength="255" name="mdp" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).{8,}" onfocus="indicationsChamp(this)" onblur="indicationsChampF(this)">
					<span class="none detailChamp">Veuillez saisir un mot de passe contenant au moins une lettre majuscule, une lettre minuscule, un chiffre et un caracère spécial. Tout mot de passe de moins de <strong>8 caractères</strong> ne pourra vous être attribué.</span>
				</div>
				<div>
					<b class="titreChamp">Confirmation du mot de passe</b><br>
					<input id="mdpInscription2" title="Veuillez saisir un mot de passe sécurisé comprenant au moins 1 lettre minuscule, 1 lettre majuscule, 1 chiffre, 1 caractère spécial (minimum 8 caractères)"class="champ" placeholder="•••••••••••" required minlength="8" type="password" maxlength="255" name="mdpConfirme" onfocus="indicationsChamp(this)" onblur="indicationsChampF(this)">
					<span class="none detailChamp">Veuillez saisir un pseudo <strong>identique</strong> au précédent.</span>
				</div>
				<input type="submit" class="envoyer" value="Valider l'inscription" />
			</form>
		</section>
		
		<!-- CONNEXION -->
		<?php if(isset($_GET['validerCompte']) && isset($_GET['chaine'])){if($_GET['validerCompte']=="true"){$get="?validerCompte=true&chaine=".$_GET['chaine'];}else{$get="";}}else{$get="";} ?>
		<section style="display:<?php if ($_GET["but"]!="connexion"){echo "none";} ?>;">
			<h3>Connexion en temps qu'administrateur</h3>
			<form id="formConnexion" action="traitement/connexion.php<?php echo $get;?>" method="post">
				<b class="titreChamp">Pseudo</b><br>
				<input class="champ" pattern="[a-zA-z0-9.-]+" placeholder="exemple" title="Lettres majuscules et minuscules, chiffres, point, tirets haut et bas exculsivement" required="required" type="text" maxlength="255" name="pseudo" /><br>
				<b class="titreChamp">Mot de passe</b><br>
				<input class="champ" required="required" placeholder="••••••••" type="password" minlength="6" maxlength="255" name="mdp" /><br>
				<input class="boutton envoyer" type="submit" value="Se connecter" /><br>
			</form>
		</section>
		
		<?php include("include/footer.php"); ?>
		
		<!-- TRAITEMENT PROBLÈMES -->
		<?php
		if (isset($_GET["pb"])){
			echo '<div class="dialog">
					<div class="dialogContainer">
					  <button onClick="fermerAlerte()" id="fermer">×</button>
					  <h1>Attention&nbsp;!</h1>
					  <p>';
			if ($_GET["but"]=="connexion"){
				if ($_GET["pb"]=="1"){
					echo 'Votre pseudo et/ou votre mot de passe est incorrect&nbsp;!';
				}
				else{
					header('Location: administrateur.php?but=connexion');
				}
			}
			else if ($_GET["but"]=="inscription"){
				echo '<script>$("body").addClass("blocScroll")</script>';
				if ($_GET["pb"]=="1"){
					echo 'Veuillez saisir 2 mots de passe identiques&nbsp;!';
				}
				else if ($_GET["pb"]=="2"){
					echo 'Le pseudo que vous venez de saisir a déjà été attribué&nbsp;!';
				}
				else if ($_GET["pb"]=="3"){
					echo 'L\'un des champs que vous avez saisi ne respecte pas les critères requis&nbsp;!';
				}
				else{
					header('Location: administrateur.php?but=inscription');
				}
			}
			echo '</p>
				  <button onClick="fermerAlerte()">J’ai compris</button>
				</div>
			  </div>
			  <script>ouvrirAlerte()</script>';
		}
		
		?>
    </body>
</html>


<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

//████████████████████████████████████████████ Connexion à la table ████████████████████████████████████████████████████
try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//Cherche le dernier billet si pas de billet demandé
$idBillet = $bdd->query('SELECT numero from blog ORDER BY id DESC LIMIT 1');
$idDernierBillet = $idBillet->fetch();
$idLastBillet = $idDernierBillet["numero"];
if (!isset($_GET["billet"])){
	header('Location: blog.php?billet='.$idLastBillet.'&scroll=Billet');
}

//Vérifie que le billet demandé est valable
$billetExiste = $bdd->query('SELECT COUNT(*) AS nb from blog WHERE numero='.$_GET['billet']);
$billetE = $billetExiste->fetch();
if (!$billetE['nb']){
	header('Location: blog.php?billet='.$idLastBillet.'&pb=1&scroll=Billet');
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
        <title>Blog du Potager</title>
    </head>
    <body>
		<?php include("include/connecte.php"); ?>
		<header>
			<div>
				<h1>Blog</h1>
				<h2>du Potager</h2>
			</div>
		</header>
		<?php include("include/nav.php"); ?>
		
		<section>
			<img alt="logo du blog du potager" id="logoBlog" src="img/logoBas.png">
			<h3>Blog</h3>
			<p>Bienvenue sur le blog !!!</p>
			<p>Vous pouvez consulter ici l'intégralité des billets postés sur le blog du site !</p>
			
			
			
			<?php
			//███████████████████████████████████████████████████ BLOG █████████████████████████████████████████████████████████
			$billets = $bdd->query('SELECT id, titre, DATE_FORMAT(date, \'le %d/%m/%Y à %Hh%i\') AS date, numero, contenu FROM blog WHERE numero='.$_GET['billet']);
			while ($ligne = $billets->fetch()) {
				echo "\t\t\t<aside id='Billet' class='Billet'>\n\t\t\t<div class='enteteBillet'>";
				echo "\t\t\t\t<h4 class='aTraduire'>".$ligne['titre']."</h4>\n\t\t\t\t<hr>";
				echo "\t\t\t\t<em class='dateB'>".$ligne['date']."</em>\n\t\t\t</div><br>";
				echo "\t\t\t<span class='spanContent aTraduire'>".$ligne['contenu']."</span>";
				echo "\t\t\t<img alt='logo du site' style='margin-bottom:10px; max-width:20%;' src='img/logoBas.png'>";
				echo "\t\t\t</aside>";
				if (isset($_SESSION["pseudo"])){
					echo "\t\t\t<input onClick='modifierBillet(".$ligne['numero'].")' class='envoyer' style='float:right;' value='Modifier' type=button>";
				}
				echo "\t\t\t<br>\n\n\n";
			}
			$billets->closeCursor();
			?>
			
			<form id="pagesBlog">
			<a <?php if ($_GET["billet"]!=1){echo 'href="?billet=1#Billet"';}else{echo 'class="lienGris"';} ?>><em class="material-icons">fast_rewind</em></a>
			<a <?php if ($_GET["billet"]!=1){echo 'href="?billet='.intval($_GET["billet"]-1).'#Billet"';}else{echo 'class="lienGris"';} ?>><em class="material-icons">skip_previous</em></a>
			
			<input readonly type='number' id='numBillet' value="<?php echo $_GET['billet']; ?>">
			
			<a <?php if ($_GET["billet"]!=$idLastBillet){echo 'href="?billet='.intval($_GET["billet"]+1) .'#Billet"';}else{echo 'class="lienGris"';} ?>><em class="material-icons">skip_next</em></a>
			<a <?php if ($_GET["billet"]!=$idLastBillet){echo 'href="?billet='.$idLastBillet.'#Billet"';}else{echo 'class="lienGris"';} ?>><em class="material-icons">fast_forward</em></a>
			</form>
			
		</section>
		
		<?php include("include/footer.php"); ?>
		
		
		<?php
		if (isset($_GET["pb"])){
			echo '<div class="dialog">
					<div class="dialogContainer">
					  <button onClick="fermerAlerte()" id="fermer">×</button>
					  <h1>Attention&nbsp;!</h1>
					  <p>';
			if ($_GET["pb"]=="1"){
				echo 'Le billet que vous recherchez n\'existe pas...<br>';
			}
			else{
				header('Location: blog.php');
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

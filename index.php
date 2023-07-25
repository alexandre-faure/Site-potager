<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
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
        <title>Jardin Solidaire - Lycée R. Cassin</title>
    </head>
    <body>
		<?php include("include/connecte.php")?>
		<header>
			<div>
				<h1>Potager</h1>
				<h2>- Lycée R. Cassin -</h2>
			</div>
		</header>
		<?php include("include/nav.php"); ?>
		
		<?php
			//███████████████████████████████████████████████████ SECTIONS █████████████████████████████████████████████████████████
			$contenu = $bdd->query('SELECT nom_section, contenu FROM contenu WHERE page="index" ORDER BY numero_section ASC');
			while ($section = $contenu->fetch()) {
				$texte = $section['contenu'];
				$nom_section = $section['nom_section'];
				$texte = preg_replace("#\[BR\]#","\n",$texte);
				$texte = preg_replace("#\[TAB\]#","\t",$texte);
				echo "<section id='".$nom_section."'>\n".$texte."\n\t\t\t<br><br>\n\t\t\t<hr>\n\t\t</section>";
			}
			$contenu->closeCursor();
		?>
		
		<section>
			<img alt="logo du site" style="margin-top:0;" id="logoBlog" src="img/logoBas.png">
			<h3>Dernières actualités...</h3>
			<p>
				Vous pouvez consulter ici les derniers événements en date&nbsp;! Pour consulter l'intégralité des actualités, rendez-vous sur le <a href="projet.php">blog</a>!
			</p>
			<br>
			<?php
			//███████████████████████████████████████████████████ BLOG █████████████████████████████████████████████████████████
			$billets = $bdd->query('SELECT id, titre, DATE_FORMAT(date, \'le %d/%m/%Y à %Hh%i\') AS date, numero, contenu FROM blog ORDER BY id DESC LIMIT 3');
			while ($ligne = $billets->fetch()) {
				echo "\t\t\t<a class='apercuBlog' href='blog.php?billet=".$ligne['numero']."&scroll=Billet'>\n";
				echo "\t\t\t\t<aside class='Billet' id='BilletIndex' style='overflow:hidden;'>\n";
				echo "\t\t\t\t\t<div class='enteteBillet'>\n";
				echo "\t\t\t\t\t\t<h4 class='aTraduire'>".$ligne['titre']."</h4>\n\t\t\t\t\t\t<hr>\n";
				echo "\t\t\t\t\t\t<em class='dateB'>".$ligne['date']."</em><br>\n";
				echo "\t\t\t\t\t</div><br>\n\n";
				echo "\t\t\t\t\t<div class='spanContent aTraduire'>\n".$ligne['contenu']."\n\t\t\t\t\t</div>\n";
				echo "\t\t\t\t\t<img alt='logo du site' style='margin-bottom:10px; max-width:20%;' src='img/logoBas.png'>\n";
				echo "\t\t\t\t</aside>\n\n";
				echo "\t\t\t\t<aside class='lirePlus'>\n";
				echo "\t\t\t\t\t<span>Lire la suite du billet...</span>\n";
				echo "\t\t\t\t</aside>\n";
				echo "\t\t\t</a><br>\n\n";
			}
			$billets->closeCursor();
			?>
			
		</section>
		
			<?php include("include/footer.php"); ?>
    </body>
</html>

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
        <title>Participer</title>
    </head>
    <body>
		<?php include("include/connecte.php"); ?>
		<header>
			<div>
				<h1>Participer</h1>
				<h2>au Projet</h2>
			</div>
		</header>
		<?php include("include/nav.php"); ?>
		
		<?php
			//███████████████████████████████████████████████████ SECTIONS █████████████████████████████████████████████████████████
			$contenu = $bdd->query('SELECT nom_section, contenu FROM contenu WHERE page="participer" ORDER BY numero_section ASC');
			while ($section = $contenu->fetch()) {
				$texte = $section['contenu'];
				$nom_section = $section['nom_section'];
				$texte = preg_replace("#\[BR\]#","\n",$texte);
				$texte = preg_replace("#\[TAB\]#","\t",$texte);
				echo "<section id='".$nom_section."'>\n".$texte."\n\t\t\t<br><br>\n\t\t\t<hr>\n\t\t</section>";
			}
			$contenu->closeCursor();
		?>
		
		<section id="Message">
			<h3>Laisser un message</h3>
			<form method="post" action="traitement/envoyerMessage.php">
				<label for="pseudo">De :</label><br>
				<input placeholder="Prénom NOM" id="pseudo" required minlength="3" maxlength="80" name="pseudo" type="text"><br>
				<input id="mail" placeholder="adresse@mail.com" required minlength="3" maxlength="80" name="mail" type="text"><br>
				
				<label>À :</label><br>
				<input value="potager.lyceerenecassin@gmail.com" disabled required minlength="3" maxlength="80" type="text"><br>
				<br>
				<label for="sujet">Objet : </label><br>
				<input id="sujet" required minlength="3" maxlength="80" name="sujet" type="text"><br>
				<label for="contenu">Contenu : </label><br>
				<textarea style="resize:vertical; min-height:150px;" id="contenu" required minlength="20" maxlength="7500" name="contenu"></textarea><br>
				
				<div class="center">
					<input value="Envoyer le message" class="envoyer" type="submit">
				</div>
			</form>
		</section>
		
		<?php include("include/footer.php"); ?>
		
    </body>
</html>

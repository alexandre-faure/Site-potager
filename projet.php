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
        <title>Le Projet</title>
    </head>
    <body>
		<?php include("include/connecte.php"); ?>
		<header>
			<div>
				<h1>Le Projet</h1>
			</div>
		</header>
		<?php include("include/nav.php"); ?>
		
		<?php
			//███████████████████████████████████████████████████ SECTIONS █████████████████████████████████████████████████████████
			$contenu = $bdd->query('SELECT nom_section, contenu FROM contenu WHERE page="projet" ORDER BY numero_section ASC');
			while ($section = $contenu->fetch()) {
				$texte = $section['contenu'];
				$nom_section = $section['nom_section'];
				$texte = preg_replace("#\[BR\]#","\n",$texte);
				$texte = preg_replace("#\[TAB\]#","\t",$texte);
				echo "<section id='".$nom_section."'>\n".$texte."\n\t\t\t<br><br>\n\t\t\t<hr>\n\t\t</section>";
			}
			$contenu->closeCursor();
		?>
		
		<section id="Evenements">
			<h3>Événements à venir...</h3>
			<?php
			
			//███████████████████████████████████████████████████ Événement █████████████████████████████████████████████████████████
			$evenement = $bdd->query('
			SELECT 	id, type, nom,
					DATE_FORMAT(date_dbt, \'le %d/%m/%Y à partir de %Hh%i\') AS date_dbt,
					DATE_FORMAT(date_fin, \'le %d/%m/%Y à %Hh%i\') AS date_fin,
					DATEDIFF(NOW(), date_limite) AS date_limite,
					lieu, explications, nb_places, id_participants, annulation
			FROM 	evenements
			WHERE 	DATEDIFF(NOW(), date_dbt)<0
			ORDER BY id DESC LIMIT 7');
			$j=0;
			while ($ligne = $evenement->fetch()) {
				$j++;
				//Compte inscrits
				$id = $ligne['id_participants'];
				$newId="";
				$listeId=[];
				for ($i=0;$i<strlen($id);$i++){
					if($id[$i]=="\"" && $newId==""){
						continue;
					}
					if($id[$i]!="\""){
						$newId=$newId.$id[$i];
					}
					else{
						$listeId[]=intval($newId);
						$newId="";
					}
				}
				$nbInscrits = count($listeId);
				
				//Rédige...	
				echo "\n\n\t\t\t<div class='divEvenement ".$ligne['type']."'>";
				echo "\n\t\t\t\t<div class='nomEvenement'>".ucfirst($ligne['type'])."</div>\n";
				if ($ligne['nb_places']!=NULL){echo "\t\t\t\t<strong class='places'>Nb. de places : ".$ligne['nb_places']."<br>(restantes : ". intval(intval($ligne['nb_places'])-$nbInscrits) .")</strong>\n";}
				echo "\t\t\t\t<h3>".$ligne['nom']."</h3>";
				echo "\n\t\t\t\t<img alt=\"date de l'evenement\" src='img/agenda.png'> <strong class='dateDbt'> ".$ligne['date_dbt']."</strong><br>";
				echo "\n\t\t\t\t<img alt=\"lieu de l'evenement\" src='img/lieu.png'> <em class='lieu'> ".$ligne['lieu']."</em>";
				echo "\n\t\t\t\t<span class='spanContent aTraduire'>".$ligne['explications']."</span>";
				if ($ligne['annulation']==1){
					echo "\n\t\t\t\t<br><span id='complet".$j."' class='spanComplet'>ANNULÉ !</span>";
				}
				else if ($ligne['nb_places']!=NULL){
					if($nbInscrits>=intval($ligne['nb_places'])){
						echo "\n\t\t\t\t<br><span id='complet".$j."' class='spanComplet'>COMPLET</span>";
					}
					else if($ligne['date_limite']<0){
						echo "\n\t\t\t\t<br><span id='complet".$j."' class='spanComplet'>Fin des<br>Inscriptions...</span>";
					} 
					else{
						echo "\n\n\t\t\t\t<div class='center'><input id='".$j."' class='bouttonParticiper' type='button' value='Participer'></div>";
						echo "\n\t\t\t\t<form id='form".$j."' method='post' action='traitement/participerEvenement.php'><fieldset><legend>INSCRIPTION</legend><div><div class='participerLeft'>";
						echo "\n\t\t\t\t\t<label class='obligatoire' for='nomParticiper".$j."'>Nom de famille</label><br>";
						echo "\n\t\t\t\t\t<input title='Veuillez saisir votre nom de famille (lettres et tirets autorisés)' pattern='[a-zA-Z\-]{2,}' minlength=3 maxlength=30 type='text' id='nomParticiper".$j."' name='nom' required placeholder='NOM DE FAMILLE'><br>";
						echo "\n\n\t\t\t\t\t<label class='obligatoire' for='prenomParticiper".$j."'>Prénom</label><br>";
						echo "\n\t\t\t\t\t<input minlength=3 maxlength=30 type='text' id='prenomParticiper".$j."' name='prenom' required placeholder='Prénom'><br>";
						echo "\n\n\t\t\t\t\t<label for='classeParticiper".$j."'>Classe (si lycéen à Montfort)</label><br>";
						echo "\n\t\t\t\t\t<input minlength=2 maxlength=10 type='text' id='classeParticiper".$j."' name='classe' placeholder='ex : 204 / 1G2...'><br>";
						echo "\n\n\t\t\t\t\t<label class='obligatoire' for='naissanceParticiper".$j."'>Date de naissance <em>(pour confirmer votre identité)</em></label><br>";
						echo "\n\t\t\t\t\t<input type='date' id='naissanceParticiper".$j."' required name='date'><br>";
						echo "\n\n\t\t\t\t\t<input type='text' value='".$ligne['id']."' style='display:none;opacity:0;z-index:-9999;' name='idEvenement'>";
						
						echo "\n\t\t\t\t</div>\n\n\t\t\t\t<div class='participerRight'>";
						echo "\n\t\t\t\t\t<strong>Par soucis d'organisation, ne cocher la case que si elle correspond à votre situation&nbsp;:</strong><br>";
						echo "\n\n\t\t\t\t\t<input type='checkbox' name='prio[]' value='1' id='membre".$j."'>";
						echo "\n\t\t\t\t\t<label for='membre".$j."'>Je fait parti du Club Nature, de la MDL, du CVL ou d'un autre organisme lié au potager.</label><br><br>";
						echo "\n\t\t\t\t\t<label for='mailParticiper".$j."'>Mail <em>(pour prévenir de toute annulation)</em></label><br>";
						echo "\n\n\t\t\t\t\t<input minlength=5 maxlength=50 type='text' id='mailParticiper".$j."' name='mail' placeholder='ex : mail@gmail.com'><br>";
						echo "\n\t\t\t\t</div>\n\n\t\t\t\t</div>";
						echo "\n\t\t\t\t<input type='submit' class='envoyer' value=\"S'inscrire\">";
						echo "\n\n\t\t\t\t<span style='float:right'><strong style='color:red;font-size:0.8em'>(*)</strong><em style='font-size:0.8em'>Champs obligatoires</em></span>";
						echo "\n\t\t\t</fieldset>\n\t\t</form>";
					}
				}
				echo "\n\t\t\t</div><br>\n\n";
			}
			if ($j==0){
				echo "<p><em>Aucun événements n'est prévu prochainement, mais ça ne saurait tarder... Alors revenez régulièrement !</em></p>";
			}
			$evenement->closeCursor();
			?>
			<br><br>
			<hr>
		</section>
		
		
		<section id="Photos">
			<h3>Le potager en photos...</h3>
			<?php
				//On compte le nb de photos
				$photos = glob("/var/www/legtux.org/users/potager-lyceerenecassin/www/images/mini*.*");/* $files pour "lister" les fichiers - Mise en place de *.* pour dire que ce dossier contient une extension (par exemple .jpg, .php, etc... */
				if ($photos!=""){
					$compteur = count($photos);/* Variable $compteur pour compter (count) les fichiers lister ($files) dans le dossier */

					// selon le serveur c'est fr ou fr_FR ou fr_FR.ISO8859-1 qui est correct.
					setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
					$date_image = "";
					for ($i=1;$i<$compteur+1;$i++){
						//On récupère la date
						$photos = glob('/var/www/legtux.org/users/potager-lyceerenecassin/www/images/mini'.$i.'-*.*');
						$longueur_dbt = strlen(strval($i))+4+1;
						$date_img = substr(pathinfo($photos[0])['filename'], $longueur_dbt);
						if (strftime("%A %d %B %Y",$date_img)!=$date_image){
							if ($date_image!=""){
								echo "</div>";
							}
							$date_image = strftime("%A %d %B %Y",$date_img);
							$vraie_date = preg_replace('#f(.)+vrier#','février',$date_image);
							$vraie_date = preg_replace('#ao(.)+t#','août',$vraie_date);
							$vraie_date = preg_replace('#d(.)+cembre#','décembre',$vraie_date);
							echo "<div class='photoJour'>";
							echo "<h4 class='datePhotos'>".$vraie_date."</h4>\n";
							echo "<hr class='hrPhotos'>\n";
						}
						echo "<a href='/images/full".$i."-".$date_img.".".pathinfo($photos[0])['extension']."' onclick='window.open(this.href); return false;'><img alt=\"miniature".$i."\" class='photos' src='/images/mini".$i."-".$date_img.".".pathinfo($photos[0])['extension']."'></a>";
					}
					echo "</div>";
				}
				else{
					echo "<h5>Aucune photo n'a encore été mise en ligne...<br>Repassez bientôt !</h5>";
				}
			?>
		</section>
		
		<script src="/script/scriptProjet.js"></script>
		<?php include("include/footer.php"); ?>
    </body>
</html>

<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (!isset($_SESSION["pseudo"])){
	header("Location: /administrateur.php");
}

if (!isset($_GET["page"])||!isset($_GET["chaine"])){
	header("Location: /admin/espaceAdmin.php");
}

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}
$page = $_GET["page"];
$pseudo = $_SESSION["pseudo"];
$chaine = $_GET["chaine"];
$infos = $bdd->query("SELECT pseudo_modif, chaine_modif FROM contenu WHERE page = '$page'");

$validite = 1;

while ($info = $infos->fetch()){
	if ($info["pseudo_modif"]!=$pseudo||$info["chaine_modif"]!=$chaine){
		echo "Désolé, vous n'êtes pas autorisé à modifier le contenu de la page ".$page."...";
		$validite = 0;
		break;
	}
}
if ($validite){
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
        <title>Modifier du contenu</title>
    </head>
    <body class="modifierContenu">
		<?php include("/var/www/legtux.org/users/potager-lyceerenecassin/www/include/connecte.php"); ?>
		<header>
			<div>
				<h1>Modifier la</h1>
				<h2>page : <?php echo $page; ?></h2>
			</div>
		</header>
		<?php include("/var/www/legtux.org/users/potager-lyceerenecassin/www/include/nav.php"); ?>
		
		<section id="information">
			<div id="outils">
				<h4>BOÎTE à OUTILS</h4>
				<strong>Nouvelle section</strong><br>
				<strong>Nouveau titre</strong><br>
				<strong>Nouveau paragraphe</strong><br>
				<strong>Nouvelle image</strong>
			</div>
			<br>
			<div>
				<script>
				function deroule(elem){
					if(elem.nextElementSibling.className=="none"){elem.nextElementSibling.className=""}
					else{elem.nextElementSibling.className="none"}
				}
				</script>
				
				<div onclick='deroule(this)'>
					<i>i</i>
					<h3>Informations</h3>
				</div>
				<div class='none'>
					Voilà <strong>quelques consignes</strong> pour modifier le contenu de la page <?php echo $page;?>&nbsp;:
					<br>
					Toute modification est irréversible&nbsp;! Alors ne modifiez qu'après y avoir mûrement réfléchi&nbsp;!
					<br>
					<br>
					Chaque <strong>section</strong> ne traite que d'un seul sujet. Elle commence par un <strong>titre</strong> (clair et concis), et est suivi de contenu (<strong>paragraphes</strong> ou encore <strong>images</strong>).
					<br>
					Certaines sections ont des particularités (exemple de la section "Témoignages" sur la page Index). Vous aurez accès à d'autres options présentées dans les points infos (i).
					<br>
					<br>
					<strong>Mettre le texte en forme</strong>&nbsp;:
					<ul>
						<li>Mettre en <strong>gras</strong>&nbsp;: <em>bla bla [GRAS]votre texte en gras[\GRAS] bla bla...</em></li>
						<li>Mettre en <strong>italique</strong>&nbsp;: <em>bla bla [ITALIQUE]votre texte en italique[\ITALIQUE] bla bla...</em></li>
						<li><strong>Souligner</strong>&nbsp;: <em>bla bla [SOULIGNER]votre texte souligné[\SOULIGNER] bla bla...</em></li>
						<li>Mettre un <strong>lien</strong>&nbsp;: <em>bla bla [LIEN url="https://blabla/votrelien"]votre lien[\LIEN] bla bla...</em></li>
					</ul>
					<strong>Insérer une image</strong>&nbsp;:
					<ul>
						<li>Saisissez l'url de l'image de votre choix (ex&nbsp;: https://blabla/votreimage.jpg). Vous pouvez aussi choisir une image du site internet. Pour consulter la manque d'image, <a href="https://potager-lyceerenecassin.legtux.org/img" target="_blank">cliquez-ici</a>. Une fois votre image choisie dans la banque d'image, saisissez l'url suivant : /img/votreimage.jpg</li>
						<li>Saisissez une description de l'image, brêve. N'utilisez ni accents, ni majuscules, ni caractères spéciaux&nbsp;!</li>
						<li>Saisissez votre préférence pour afficher l'image à gauche ou à droite de la page web.</li>
					</ul>
				</div>
			</div>
			<br>
		</section>
		
		<?php
			//███████████████████████████████████████████████████ SECTIONS █████████████████████████████████████████████████████████
			$contenu = $bdd->query('SELECT nom_section, contenu FROM contenu WHERE page="index" ORDER BY numero_section ASC');
			$i=0;
			while ($section = $contenu->fetch()) {
				$i++;
				$texte = $section['contenu'];
				$nom_section = $section['nom_section'];
				
				//pagination
				$texte = preg_replace("#\[BR\]#","\n",$texte);
				$texte = preg_replace("#\[TAB\]#","",$texte);
				$texte = preg_replace("#'#","&apos;",$texte);
				//h3
				$texte = preg_replace("#<h3>(.+)</h3>#sU","<fieldset><legend>Titre :</legend><input type='text' value='$1'></fieldset><br>",$texte);
				//img
				$texte = preg_replace("#\"img/#sU","\"/img/",$texte);
				$texte = preg_replace("#\"include/#sU","\"/include/",$texte);
				$texte = preg_replace("#<div class=\"centerPhoto\">(.+)</div>#sU","<fieldset><legend>Image :</legend>$1</fieldset><br>",$texte);
				$texte = preg_replace("#<a href=\"(.+)\" target=\"_blank\">(.+)</a>#sU","<label class='petit'>URL : </label><input type='text' value='$1'><br>$2",$texte);
				$texte = preg_replace("#<img alt=\"(.+)\" class=\"imgL\" (.+)>#","<label class='petit'>Description de l'image : </label><input type='text' value='$1'><br><label class='petit'>Position de l'image : </label><select><option value='L' selected>à gauche</option><option value='R'>à droite</option></select><br>",$texte);//cas L
				$texte = preg_replace("#<img alt=\"(.+)\" class=\"imgR\" (.+)>#","<label class='petit'>Description de l'image : </label><input type='text' value='$1'><br><label class='petit'>Position de l'image : </label><select><option value='L'>à gauche</option><option value='R' selected>à droite</option></select><br>",$texte);//cas R
				
				//p
				$texte = preg_replace("#<p>(.+)</p>#sU","<fieldset><legend>Paragraphe :</legend><textarea>$1</textarea></fieldset><br>",$texte);
				//a
				$texte = preg_replace("#<a href=\"(.+)\"[ ]?>(.+)</a>#","[LIEN url=\"$1\"]$2[/LIEN]",$texte);
				//b
				$texte = preg_replace("#<strong>(.+)</strong>#","[GRAS]$1[/GRAS]",$texte);
				//i
				$texte = preg_replace("#<em>(.+)</em>#","[ITALIQUE]$1[/ITALIQUE]",$texte);
				
				
				//Écrire
				echo "<section id='".$nom_section."' class='modif'><fieldset><legend>Section n°".$i."</legend>\n".$texte."\n\t\t</fieldset></section>";
			}
			$contenu->closeCursor();
		?>
		
		<?php include("/var/www/legtux.org/users/potager-lyceerenecassin/www/include/footer.php"); ?>
    </body>
</html>
<?php
}
?>

<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (!isset($_SESSION['pseudo']) OR !isset($_GET['id']) OR !isset($_GET['motif'])){
	header('Location: /index.php');
}

//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████
try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//██████████████████████████████████████████████████ Annulation dans la table ███████████████████████████████████████████████████████
$id = intval(htmlspecialchars($_GET['id']));
$motif = htmlspecialchars($_GET['motif']);

$bdd->exec("UPDATE evenements SET annulation='1' WHERE id ='$id'");

//██████████████████████████████████████████████████ Envoi d'un mail ███████████████████████████████████████████████████████

//Récupération des adresses
//███████████████████████████████████████████████████ BLOG █████████████████████████████████████████████████████████
$evenement = $bdd->query('SELECT DATE_FORMAT(date_dbt, \'le %d/%m/%Y à partir de %Hh%i\') AS date_dbt, nom, type, id_participants FROM evenements WHERE id='.$_GET['id']);
$j=0;
$ligne = $evenement->fetch();
$titreE = $ligne['nom'];
$dateE = $ligne['date_dbt'];
$typeE = $ligne['type'];

if ($typeE=="intervention"){
	$typeE="<strong>l'intervention est annulée</strong>";
}
else if ($typeE=="rendez-vous"){
	$typeE="<strong>le rendez-vous est annulé</strong>";
}
else if ($typeE=="reunion"){
	$typeE="<strong>la réunion est annulée</strong>";
}
else if ($typeE=="sortie"){
	$typeE="<strong>la sortie est annulée</strong>";
}

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
$nbInscrits = intval(count($listeId));

$listeMail=[];

for ($m=0;$m<$nbInscrits;$m++){
	$participants = $bdd->query('SELECT mail FROM participants WHERE id='.intval($listeId[$m]));
	$inscrits = $participants->fetch();
	if ($inscrits['mail']!=""){
		$listeMail[] = $inscrits['mail'];
	}
}

	
// Sujet
$sujet = "Annulation d'un événement - ".$titreE;
$email= 'Jardin Solidaire <potager.lyceerenecassin@gmail.com>';

// message
$message = '
<html>
	<head>
		<title>Annulation d\'un événement</title>
	</head>
	<body>
		<style>
body{
	background-color:rgba(220,220,220,1);
	margin:0;
	padding:0;
	top:0;
	font-family: Impact, "Arial Black", sans-serif;
	word-spacing:1.8px;
	letter-spacing:-0.5px;
}
img {
	top: 0.47em;
	left: 14.4%;
	position: absolute;
	height: 3.3em;
	width: auto;
	background-color: rgba(255,255,255,1);
	box-shadow: 2px 2px 5px rgba(0,0,0,0.6);
	border: 2px solid rgba(255,200,200,1);
	border-radius: 1px;
}
h1 {
	color: rgb(223, 223, 223);
	font-size: 200%;
	text-align: center;
	padding: 15px 0;
	margin: -15px -4.5% 15px -4.5%;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
	background-color: rgba(255, 51, 51, 0.97);
}
h2 {
	color: rgb(50, 142, 10);
	font-size: 150%;
	margin-top: 0;
	margin-bottom: 0;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
	text-decoration: underline;
	display:inline-block;
}
h3 {
	color: rgba(81, 179, 37);
	font-size: 125%;
	margin-top: 0;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
}
section{
	background-color:rgba(255,255,255,1);
	width:66.6666666%;
	margin:0 auto;
	padding:15px 3%;
	box-shadow:6px 0 20px rgba(0,0,0,0.5);
}
p{
	font-size:105%;
}
p a{
	font-family: Impact, "Arial Black", sans-serif;
	color:rgba(13,134,3,1);
	text-decoration:none;
	transition:0.3s;
	font-weight:0;
	text-align:left;
	display:inline;
	font-size:100%;
}
hr {
	border: none;
	border-top: 3px double rgba(175,175,175,1);
	overflow: visible;
	text-align: center;
	height: 5px;
	color:rgba(120,120,120,1);
	text-shadow:1px 1px 2px rgba(0,0,0,0.3);
	padding:0 4.5%;
	margin:15px 0 10px 0;
}

hr:after {
	font-family:Cantarell;
	background: #fff;
	content: "potager-lyceerenecassin.legtux.org";
	padding: 0 5px;
	position: relative;
	top: -13px;
	font-size:110%;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
}
a{
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
	font-weight:bold;
	color:rgba(13,134,3,1);
	text-decoration:none;
	transition:0.3s;
	display:block;
	text-align:center;
	font-size:150%;
}
a:hover{
	color:rgba(14,187,0,1);
}
footer{
	padding:2% 7px;
	margin:0 -4.5% -15px -4.5%;
	text-align:center;
	font-size:90%;
	background-color:rgba(23,23,23,1);
	color:rgba(244,244,244,0.7);
}
footer>p{
	text-align:center;
	padding:0;
	margin:0;
	text-indent:0;
}
footer em{
	font-size:1em;
	color:rgba(210,210,210,1);
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
	text-align:center;
	display:inline-block;
	font-weight:normal;
}
#lienFooter {
	font-family: ;
	color: rgb(14, 166, 31);
	transition: 0.1s;
	font-weight: 100;
	display: inherit;
	text-align: right;
	font-size: 100%;
}
#lienFooter:hover{
	color:rgba(32,255,57,1);
}
#contenu{
	border-radius:4px;
	background-color:rgba(255,210,210,1);
	margin:0 4%;
	padding:15px 30px;
	box-shadow:2px 2px 4px rgba(0,0,0,0.1);
}
#contenu p{
	text-indent:35px;
}
#pb{
	border-radius:50%;
	width:40px;
	height:40px;
	font-size:37px;
	text-align:center;
	font-weight:bolder;
	color:white;
	box-shadow:2px 2px 3.5px rgba(0,0,0,0.6);
	background-color:rgba(255,120,120,1);
	cursor:default;
	float:left;
	margin:25px 12px 12px 0;
}
		</style>
		<section>
			<img src="https:/-lyceerenecassin.legtux.org/img/logomini.png">
			<h1>— ANNULATION D\'UN ÉVÉNEMENT —</h1>
			<div id="contenu">
				<p>Suite à votre inscription à l\'événement : '.$titreE.', prévu à la date du '.$dateE.', nous sommes au regret de
					vous annoncer que '.$typeE.' en raison du motif suivant : '.$motif.'.</p>
				<p>Si l\'événement vient à être reporté à une date ultérieure, vous serez contacté(e) en premier lieu pour vous
					permettre de vous réinscrire prioritairement.</p>
				<p>Merci de votre de compréhension.</p>
				<br>
				<div id="pb">
					?
				</div>
				<p><em>Si vous ne reconnaissez pas ce message, et que vous ne vous êtes pas inscrit(e) à l\'événement suivant :
				"'.$titreE.'", vous pouvez simplement ignorer ce message ou en référer aux administrateurs du site à l\'adresse mail
				suivante : <a href="mailto:potager.lyceerenecassin@gmail.com">potager.lyceerenecassin@gmail.com</a>.</em></p>
			</div>
			<br>
			<hr>
			<footer>
				<em>Ceci est un message automatique, merci de ne répondre à ce message qu\'en cas de nécessité.</em>
				<p style="text-align:right; font-size:100%;">© Copyright 2020<br>
				<a id="lienFooter" href="https:/-lyceerenecassin.legtux.org">potager-lyceerenecassin.legtux.org</a></p>
			</footer>
		</section>
	</body>
</html>
';
$nbAdresse = sizeof($listeMail);

// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
$headers[] = 'MIME-Version: 1.0';
$headers[] = "Content-type: text/html; charset=UTF-8";

// En-têtes additionnels
$headers[] = 'From: Jardin Solidaire Lycée R. Cassin <potager.lyceerenecassin@gmail.com>';

// Envoi
for ($i=0;$i<$nbAdresse;$i++){
	mail($listeMail[$i], $sujet, $message, implode("\r\n", $headers));
}

header('Location: /admin/espaceAdmin.php');
	
?>

<?php

//paramètres date
// selon le serveur c'est fr ou fr_FR ou fr_FR.ISO8859-1 qui est correct.
setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');

// Sujet
$sujet = htmlspecialchars($_POST['sujet']);
$email= 'Jardin Solidaire <potager.lyceerenecassin@gmail.com>';

$contenu = htmlspecialchars($_POST['contenu']);

$contenu = stripslashes($_POST['contenu']); // On enlève les slashs qui se seraient ajoutés automatiquement
$contenu = htmlspecialchars($contenu); // On rend inoffensives les balises HTML que le visiteur a pu rentrer
$contenu = nl2br($contenu); // On crée des <br /> pour conserver les retours à la ligne

// On fait passer notre texte à la moulinette des regex
$contenu = preg_replace('#http(s)?://?[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $contenu);

$pseudo = htmlspecialchars($_POST['pseudo']);
$mail = htmlspecialchars($_POST['mail']);
$minutes = strval((time()/60)%60);
if (strlen($minutes)==1){$minutes = "0".$minutes;}
$date = strftime("%A %d %B %Y à %Hh").$minutes;

// message
$message = '
<html>
	<head>
		<title>'.$sujet.'</title>
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
	letter-spacing:-0.8px;
}
img {
	top: 0.47em;
	left: 14.4%;
	position: absolute;
	height: 3.3em;
	width: auto;
	background-color: rgba(255,255,255,1);
	box-shadow: 2px 2px 5px rgba(0,0,0,0.6);
	border: 2px solid rgba(200,255,200,1);
	border-radius: 1px;
}
h1 {
	color: rgb(223, 223, 223);
	font-size: 200%;
	text-align: center;
	padding: 15px 0;
	margin: -15px -4.5% 15px -4.5%;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
	background-color: rgb(39, 147, 30);
}
h2 {
	color: rgb(50, 142, 10);
	font-size: 170%;
	margin-top: 0;
	margin-bottom: 0;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
	text-decoration: underline;
	display:inline-block;
}
em{
	color: rgb(82, 202, 0);
	font-size: 160%;
	font-weight:bold;
	font-style:normal;
	font-family: Avantgarde, TeX Gyre Adventor, URW Gothic L, sans-serif;
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
#lien{
	position: relative;
	width:200px;
	height:50px;
	margin:0 auto;
}
svg{
	width:200px;
	height:50px;
}
rect {
	stroke-dasharray: 100 500;
	stroke-dashoffset: -300;
	stroke-width: 18px;
	fill: transparent;
	stroke: rgba(43,164,30,1);
	border-bottom: 5px solid black;
	transition: stroke-width .5s, stroke-dashoffset .5s, stroke-dasharray .5s;
	width: 200px;
	height: 50px;
}
#repondre {
	font-size: 1.3em;
	letter-spacing: 0;
	position: relative;
	width: 200px;
	display: inline-block;
	transform: translateY(-80%);
	height: 50px;
}
#lien:hover rect{
  stroke-width: 10px;
  stroke-dashoffset: 0;
  stroke-dasharray: 500;
}
#contenu{
	border-radius:2px;
	background-color:rgba(240,240,240,1);
	margin:0 2%;
	padding:15px 20px;
	box-shadow:2px 2px 4px rgba(0,0,0,0.1);
}
		</style>
		<section>
			<img src="https:/-lyceerenecassin.legtux.org/img/logomini.png">
			<h1>— NOUVEAU MESSAGE —</h1>
			<h2>Message de '.$pseudo.'</h2><em><color style="color:rgb(50, 142, 10)"> : </color>'.$sujet.'</em>
			<h3>envoyé le '.$date.'</h3>
			<div id="contenu"><p>'.$contenu.'</p></div>
			<br>
			<div id="lien">
				<svg xmlns="http://www.w3.org/2000/svg">
					<rect/>
				</svg>
				<a id="repondre" href="mailto:'.$mail.'">Répondre</a>
			</div>
			<br>
			<hr>
			<footer>
				<p style="text-align:right; font-size:100%;">© Copyright 2020<br>
				<a id="lienFooter" href="https:/-lyceerenecassin.legtux.org">potager-lyceerenecassin.legtux.org</a></p>
			</footer>
		</section>
	</body>
</html>
';

// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
$headers[] = 'MIME-Version: 1.0';
$headers[] = "Content-type: text/html; charset=UTF-8";

// En-têtes additionnels
$headers[] = 'From: '.$pseudo.'<'.$mail.'>';

// Envoi
mail($email, $sujet, $message, implode("\r\n", $headers));


header('Location: /participer.php?scroll=Message');
?>

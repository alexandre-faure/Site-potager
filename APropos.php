<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();
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
        <title>À Propos - Jardin Solidaire</title>
    </head>
    <body>
		<?php include("include/connecte.php")?>
		<header>
			<div>
				<h1>À Propos</h1>
			</div>
		</header>
		<?php include("include/nav.php"); ?>
		
		<section id="APropos">
			<h3>À Propos</h3>
			<p>
				Aujourd'hui, la très grande majorité des sites internet ont recours au <strong>stockage de données personnelles</strong> pour leur bon fonctionnement. Et le site du potager ne déroge pas à la règle.
			</p>
			<div class="centerPhoto">
				<img style="width:100px;" alt="image RGPD" src="img/rgpd.png" class="imgL">
			</div>
			<p>
				Néanmoins, en gage de <strong>transparence</strong> à votre égard, nous nous attacherons dans cette section à détailler les types de données récoltées et la manière dont elles sont stockées. Par ailleurs, nous vous présenterons les outils en votre possession pour faire usage de <strong>vos droits</strong> (<em>par exemple</em>&nbsp;: faire supprimer immédiatement des informations vous concernant).
			</p>
			<p>
				Vous pouvez consulter les 3 sections suivantes. Si nous ne sommes pas parvenu à répondre à vos questions après la lecture de ces sections, n'hésitez pas à nous faire part de vos interrogations par <a href="mailto:potager.lyceerenecassin@gmail.com">mail</a>.
				<ul class="plan">
					<li>
						<a onclick="scrollID('hebergeur')">INFORMATIONS SUR L'HÉBERGEUR</a>
					</li>
					<li>
						<a onclick="scrollID('donnees')">DONNÉES RECOLTÉES</a>
					</li>
					<li>
						<a onclick="scrollID('droits')">FAIRE USAGE DE VOS DROITS</a>
					</li>
				</ul>
			</p>
			<p>
				N'hésitez pas à vous rendre directement dans la section qui vous intéresse, bonne lecture&nbsp;!
			</p>
		</section>
		
		<section class="sousAPropos" id="hebergeur">
			<h4>INFORMATIONS SUR L'HÉBERGEUR</h4>
			<p>
				Avant toute chose, voici une brêve présentation de l'hébergeur de ce site&nbsp;: <a target="_blank" href="https://www.legtux.org">LegTux.org</a>.
			</p>
			<div class="centerPhoto">
				<img style="width:150px; border:2px solid rgba(150,150,150,1); border-radius:2px; padding:3px; background-color:rgba(255,255,255,.8); margin-top:5px;" alt="logo de LegTux" src="img/legtux.png" class="imgR">
			</div>
			<p>
				<strong>LegTux</strong> est un hébergeur dont les serveurs se trouvent en <strong>France</strong>, proposant des offres d'hébergement notamment aux particuliers et aux associations. L'équipe en charge de LegTux est constituée de quelques personnes motivées qui mettent tout en œuvre pour mettre à jour les services dédiés aux sites internet (<em>par exemple</em>&nbsp;: MySQL, PHP...). Ces mises à jour permettant de <strong>garantir la sécurité</strong> des informations circulant sur les sites internet.
			</p>
			<p>
				Pour finir, LegTux propose ses services à prix libre. C'est à dire que chaque organisation peut, si elle le souhaite, héberger son site internet gratuitement, ou participer financièrement avec le montant souhaité&nbsp;: le tout <strong>sans publicités</strong>.
			</p>
			<p>
				C'est pour l'ensemble de ses qualités que nous avons choisi LegTux&nbsp;!
			</p>
		</section>
		
		<section class="sousAPropos" id="donnees">
			<h4>DONNÉES RÉCOLTÉES</h4>
			<p>
				Les seules données récoltées sur le site internet concernent les événements. En effet, pour les <strong>Interventions</strong> et les <strong>Sorties</strong>, le nombre de place est limité&nbsp;: c'est pourquoi nous vous demandons de saisir quelques informations personnelles pour réserver votre place.
			</p>
			<p>
				Voici la liste des donées récoltées dans les champs du formulaire de réservation, et leurs fonctions (les <em class="obligatoire">astérisques</em> traduisant le caractère obligatoire du champ)&nbsp;:
				<ul>
					<li>
						Votre <strong class="obligatoire">prénom</strong>
					</li>
					<li>
						Votre <strong class="obligatoire">nom de famille</strong>
					</li>
					<li>
						Votre <strong class="obligatoire">classe</strong>
					</li>
					<li>
						Votre <strong class="obligatoire">date de naissance</strong>
					</li>
					<li>
						Votre <strong>adresse mail</strong>
					</li>
					<li>
						Votre <strong>statut (membre ou non du CVL, MDL ou Club Nature du lycée)</strong>
					</li>
				</ul>
			</p>
			<p>
				Les champs obligatoires nous permettent d'identifier la personne qui est à l'origine de la demande d'inscription. Ainsi, le <strong>prénom</strong>, le <strong>nom</strong> et la <strong>classe</strong> de l'élève permettent d'établir une liste pour la Vie Scolaire des participants. Par ailleurs, la <strong>date de naissance</strong> n'a pour seul objectif que de permettre à 2 élèves ayant le même prénom, nom et classe de s'inscire tous deux en les distinguant.
			</p>
			<p>
				Concernant le champ <strong>adresse mail</strong> facultatif, il permettera, en cas d'annulation d'un événement, de vous en avertir par mail et de vous proposer, dans la mesure du possible, de réserver à nouveau votre place en cas de report.
			</p>
			<p>
				Pour finir, le champ qui permet de préciser si vous faites parti du <strong>CVL / MDL / Club Nature</strong> ou non est lui aussi facultatif. Il nous permettera de déterminer quelles sont les personnes prioriataires, de part leur engagement, pour participer aux événements.
			</p>
			<br>
			<p>
				Si vous souhaitez <strong>annuler votre inscription</strong>, nous vous demandons de bien vouloir nous <a href="mailto:potager.lyceerenecassin@gmail.com">contacter par mail</a>. Par ailleurs si vous souhaitez faire supprimer toute information vous concernant que vous auriez saisi lors d'une précédente inscription, rendez-vous dans la section "<a onclick="scrollID('droits')">faire usage de vos droits</a>".
			</p>
		</section>
		
		<section class="sousAPropos" id="droits">
			<h4>FAIRE USAGE DE VOS DROITS</h4>
			<p>
				Le droit fondamental de tout internaute est de pouvoir à tout moment faire <strong>effacer les informations le concernant</strong> d'une base de donnée. C'est pourquoi nous vous présentons ici la démarche à suivre&nbsp;:
			</p>
			<p>
				<em>Les outils sont actuellement en cours de conception... Si vous souhaitez faire supprimer vos informations de la base de données, veuillez nous <a href="mailto:potager.lyceerenecassin@gmail.com">contacter par mail</a> (réponse dans un délai inférieur à 24h).</em>
			</p>
		</section>
		
			<?php include("include/footer.php"); ?>
    </body>
</html>

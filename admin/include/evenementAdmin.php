<section style="display:<?php if ($_GET["but"]!="evenement"){echo "none";} ?>;">
	<h2 id="Evenements">SECTION ÉVÉNEMENTS</h2>
	<br>
	<div id="outils">
		<h4>BOÎTE à OUTILS</h4>
		<strong class="formatageBlog" onClick="baliseGras(0)">Gras</strong>
		<strong class="formatageBlog" onClick="baliseItalique(0)">Italique</strong>
		<strong class="formatageBlog" onClick="baliseSouligne(0)">Souligné</strong>
		<strong class="formatageBlog" onClick="baliseImage(0)">Image</strong>
		<strong class="formatageBlog" id="baliseListe" onClick="baliseListeP(0)">Liste&nbsp;à&nbsp;puces</strong>
		<strong class="formatageBlog" id="baliseListe" onClick="baliseListeN(0)">Liste&nbsp;numérotée</strong>
		<strong class="formatageBlog" onClick="sautLigne(0)">Saut&nbsp;de&nbsp;ligne</strong>
	</div>
	
	<!--█████████████████████████████████████████████ Créer événement ███████████████████████████████████████████-->
	<h3 id="posterEvenement">Créer un événement</h3>
	
	<?php if ($_GET["modifier"]=="false"){?>
		<form action="traitement/evenement.php" method="post" id="formEvenement">
			<div class="flex">
				<div class="flexLeft">
					<label>Intitulé&nbsp;: </label>
				</div>
				<div class="flexRight">
					<input name="nom" required placeholder="Titre de l'événement" class="titre" minlength="5" maxlength="40" type="text">
				</div>
			</div>
			<br>
			<div class="flex">
				<div class="flexLeft">
					<label>Type&nbsp;: </label>
				</div>
				<div class="flexRight">
					<select name="type">
						<optgroup label="Ouvert à tous">
							<option value="rendez-vous">Rendez-vous</option>
							<option value="reunion">Réunion</option>
						</optgroup>
						<optgroup label="Nombre de place limité">
							<option value="intervention">Intervention</option>
							<option value="sortie">Sortie</option>
						</optgroup>
					</select>
				</div>
			</div>
			<br>
			<div class="flex">
				<div class="flexLeft">
					<label>Lieu&nbsp;: </label>
				</div>
				<div class="flexRight">
					<input name="lieu" required placeholder="Lieu de l'événement" class="lieuE" minlength="5" maxlength="40" type="text">
				</div>
			</div>
			<div class="flex">
				<div class="flexLeft">
					<label>Date&nbsp;: </label>
				</div>
				<div class="flexRight">
					du <input name="dbtJ" required class="dbtJ" type="date"> à <input name="dbtH" required class="dbtH" type="time"><br>
					au <input name="finJ" required class="titre" type="date"> à <input name="finH" required class="titre" type="time">
				</div>
			</div>
			<br>
			<div class="flex">
				<div class="flexLeft">
					<label>Informations&nbsp;: </label>
				</div>
				<div class="flexRight">
					<textarea  required rows="4" name="explications" class="contenu" minlength="20" maxlength="300" placeholder="Saisissez quelques informations pour présenter l'événement..."></textarea>
				</div>
			</div>
			<br>
			<div id="flexPers" class="flex">
				<div class="flexLeft">
					<label>Nombre de personnes<br>maximum&nbsp;: </label>
				</div>
				<div class="flexRight">
					<input id="nbPers" name="nbPers" class="nbPers" max="100" step="5" min="5" type="number">
				</div>
			</div>
			<div id="dateLimite" class="flex">
				<div class="flexLeft">
					<label>Date limite<br>d'inscription&nbsp;: </label>
				</div>
				<div class="flexRight">
					le <input name="inscriJ" required class="titre" type="date"> à <input name="inscriH" required class="titre" type="time"><br>
				</div>
			</div>
			<br>
			<input type="button" id="apercu" onClick="Rendu(75,55,'evenement')" value="GÉNÉRER l'APERÇU">
			<input style="float:right" class="envoyer" type="submit" value="Créer">
		</form>
	<?php }
	else{ ?>
		<p>Si vous souhaitez créer un nouvel événement, <a style="cursor:pointer;" href="?but=evenement&modifier=false&scroll=posterEvenement">cliquez-ici</a>!</p>
	<?php } ?>
	
	<br>
	
	<!--█████████████████████████████████████████████ Modifier événement ███████████████████████████████████████████-->
	<?php if (isset($_GET["modifier"])){if ($_GET["modifier"]=="true"){
		if (!isset($_GET["id"])){
			header('Location: ?but=evenement');
		}
		else{
			$billet = $bdd->query('SELECT id, type, nom, explications, nb_places, lieu,
									DATE_FORMAT(date_dbt, \'%Y-%m-%d\') AS date_dbtJ,
									DATE_FORMAT(date_dbt, \'%H:%i\') AS date_dbtH,
									DATE_FORMAT(date_fin, \'%Y-%m-%d\') AS date_finJ,
									DATE_FORMAT(date_fin, \'%H:%i\') AS date_finH,
									DATE_FORMAT(date_limite, \'%Y-%m-%d\') AS date_limiteJ,
									DATE_FORMAT(date_limite, \'%H:%i\') AS date_limiteH
									FROM evenements WHERE id='.$_GET['id']);
			$ligne = $billet->fetch();
		}?>
	<h3 id="modifierEvenement">Modifier un événement</h3>
	<h4 >Modification de l'événement n°<?php echo $_GET["id"]; ?></h4>
	<br>
	<form action="traitement/modifierEvenement.php" method="post" id="formEvenement">
		<div class="flex">
			<div class="flexLeft">
				<label>Intitulé&nbsp;: </label>
			</div>
			<div class="flexRight">
				<input name="nom" required placeholder="Titre de l'événement" value="<?php echo $ligne['nom'];?>" class="titre" minlength="5" maxlength="40" type="text">
			</div>
		</div>
		<br>
		<div class="flex">
			<div class="flexLeft">
				<label>Type&nbsp;: </label>
			</div>
			<div class="flexRight">
				<select name="type">
					<optgroup label="Ouvert à tous">
						<option <?php if($ligne['type']=="rendez-vous"){echo "selected";}?> value="rendez-vous">Rendez-vous</option>
						<option <?php if($ligne['type']=="reunion"){echo "selected";}?> value="reunion">Réunion</option>
					</optgroup>
					<optgroup label="Nombre de place limité">
						<option <?php if($ligne['type']=="intervention"){echo "selected";}?> value="intervention">Intervention</option>
						<option <?php if($ligne['type']=="sortie"){echo "selected";}?> value="sortie">Sortie</option>
					</optgroup>
				</select>
			</div>
		</div>
		<br>
		<div class="flex">
			<div class="flexLeft">
				<label>Lieu&nbsp;: </label>
			</div>
			<div class="flexRight">
				<input name="lieu" value="<?php echo $ligne['lieu'];?>" required placeholder="Lieu de l'événement" class="lieuE" minlength="5" maxlength="40" type="text">
			</div>
		</div>
		<div class="flex">
			<div class="flexLeft">
				<label>Date&nbsp;: </label>
			</div>
			<div class="flexRight">
				du <input value="<?php echo $ligne['date_dbtJ'];?>" name="dbtJ" required class="dbtJ" type="date"> à <input value="<?php echo $ligne['date_dbtH'];?>" name="dbtH" required class="dbtH" type="time"><br>
				au <input value="<?php echo $ligne['date_finJ'];?>" name="finJ" required class="date_finJ" type="date"> à <input value="<?php echo $ligne['date_finH'];?>" name="finH" required class="date_finH" type="time">
			</div>
		</div>
		<br>
		<div class="flex">
			<div class="flexLeft">
				<label>Informations&nbsp;: </label>
			</div>
			<div class="flexRight">
				<textarea required rows="4" class="contenu" name="explications" minlength="20" maxlength="300" placeholder="Saisissez quelques informations pour présenter l'événement..."><?php echo $ligne['explications'];?></textarea>
			</div>
		</div>
		<br>
		<div id="flexPers" class="flex">
			<div class="flexLeft">
				<label>Nombre de personnes<br>maximum&nbsp;: </label>
			</div>
			<div class="flexRight">
				<input id="nbPers" name="nbPers" class="nbPers" value="<?php echo $ligne['nb_places'];?>" max="100" step="5" min="5" type="number">
			</div>
		</div>
		<div id="dateLimite" class="flex">
			<div class="flexLeft">
				<label>Date limite<br>d'inscription&nbsp;: </label>
			</div>
			<div class="flexRight">
				le <input value="<?php echo $ligne['date_limiteJ'];?>" name="inscriJ" required class="date_limiteJ" type="date"> à <input value="<?php echo $ligne['date_limiteH'];?>" name="inscriH" required class="date_limiteH" type="time"><br>
			</div>
		</div>
		<br>
		<input type="number" style="display:none" readonly name="id" value="<?php echo $_GET["id"]; ?>">
		<input type="button" id="apercu" onClick="Rendu(75,55,'evenement')" value="GÉNÉRER l'APERÇU">
		<input style="float:right" class="envoyer" type="submit" value="Modifier">
		<input style="float:right" onclick="supprimerE(<?php echo $ligne['id'];?>)" class="supprimer" type="button" value="Annuler l'événement">
	</form>
	<br><br>
	<?php }} ?>
	
	
	<!--█████████████████████████████████████████ Consulter les infos événements ███████████████████████████████████████-->
	<h3 id="nextEvent">Récapitulatif des prochains événements</h3>
	<?php
	$evenement = $bdd->query('
	SELECT 	id, type, nom,
			DATE_FORMAT(date_dbt, \'le %d/%m/%Y dès %Hh%i\') AS date_dbt,
			DATE_FORMAT(date_fin, \'le %d/%m/%Y à %Hh%i\') AS date_fin,
			DATEDIFF(NOW(), date_limite) AS date_limite,
			lieu, explications, nb_places, id_participants
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
		$nbInscrits = intval(count($listeId));?>
		
		<div class="prochainEvenement">
			<input type="button" value="Modifier" style="float:right" class="envoyer" onclick="modifierE(<?php echo $ligne['id']; ?>)">
			<h4><?php echo $ligne['nom']." (".$ligne['type'];?>)</h4>
			<h5><strong><?php echo $ligne['date_dbt'].", ".$ligne['lieu'];?></strong></h5>
			<?php if ($ligne['nb_places']!=0){ ?>
				<h5><?php echo "Nombre de places (dont restantes) : <strong>".$ligne['nb_places']." (".intval(intval($ligne['nb_places'])-$nbInscrits);?>)</strong></h5>
			<?php } ?>
			
			<span class="tireVolet" onClick="tire('volet<?php echo $ligne["id"]; ?>',this)">
				⬇Voir les détails...⬇
			</span>
			<span class="voletCache" id="volet<?php echo $ligne["id"]; ?>">
					<?php if ($ligne['nb_places']!=0){ ?>
					<br>
					<h5>Tableau des inscrits</h5>
					<iframe onload="resizeIframe(this)" class="tableauInscrits" src="include/tableInscrits.php?id=<?php echo $ligne['id'];?>" width="100%" height="auto" frameborder="0"></iframe>
				<?php } ?>
				<h5>Texte descriptif de l'événement : </h5>
				<p class="explications aTraduire"><?php echo $ligne['explications']; ?></p>
			</span>
		</div>
		<br>
	<?php }
	
	if ($j==0){
		echo "<p>Aucun n'évenement n'est prévu pour le moment...</p>";
	}
	
	$evenement->closeCursor(); ?>
</section>

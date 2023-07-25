<section style="display:<?php if ($_GET["but"]!="billet"){echo "none";} ?>;">
	<h2 id="Blog">SECTION BLOG</h2>
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
	<!--███████████████████████████████ Nouveau billet ███████████████████████████████████████-->
	<h3 id="posterBillet">Poster un billet sur le blog</h3>
	
	<?php if ($_GET["modifier"]=="false"){?>
		<form action="traitement/publier.php" method="post" id="nouveauBillet">
			<em class="date" style="display:block; text-align:right;">le <?php echo date('d/m/Y à H\hi'); ?></em>
			<input name="titre" required placeholder="Saisissez ici le titre du billet..." class="titre" minlength="10" maxlength="50" type="text"><br>
			<textarea class="contenu" name="contenu" required rows="12" minlength="250" maxlength="2000" placeholder="Saisissez ici le contenu du billet..."></textarea>
			<input type="button" id="apercu" onClick="Rendu(75,55,'billet')" value="GÉNÉRER l'APERÇU">
			<input style="float:right;" class="envoyer" type="submit" value="Publier">
		</form>
	<?php }
	else{ ?>
		<p>Si vous souhaitez créer un nouveau billet, <a style="cursor:pointer;" href="?but=billet&modifier=false&scroll=posterBillet">cliquez-ici</a>!</p>
	<?php } ?>
	
	<br>
	<!--████████████████████████████████████ Modification d'un billet ███████████████████████████-->
	<h3 id="modifierBillet">Modifier un billet du Blog</h3>
	<?php if (isset($_GET["modifier"])){
		if ($_GET["modifier"]=="true"){
			if (!isset($_GET["numero"])){
				header('Location: ?but=billet&modifier=true&scroll=modifierBillet&numero='.$dernierBillet['numero']);
			}
			else{
				$billet = $bdd->query('SELECT id, titre, DATE_FORMAT(date, \'le %d/%m/%Y à %Hh%i\') AS date, contenu FROM blog WHERE numero='.$_GET['numero']);
				$ligne = $billet->fetch();
			}?>
			<h4 id="modifierBillet">Modification du billet n°<?php echo $_GET["numero"]; ?></h4>
			<form action="traitement/modifierBillet.php" method="post" id="billetModifie">
				<em class="date" style="display:block; text-align:right;"><?php echo $ligne["date"]; ?></em>
				<input name="titre" value="<?php echo $ligne["titre"]; ?>" required placeholder="Saisissez ici le titre du billet..." class="titre" minlength="10" maxlength="50" type="text"><br>
				<textarea class="contenu" name="contenu" required rows="12" minlength="250" maxlength="2000" placeholder="Saisissez ici le contenu du billet..."><?php echo $ligne["contenu"]; ?></textarea>
				<input type='number' name="numero" value='<?php echo $_GET['numero']; ?>' style='display:none'>
				
				<input type="button" id="apercu" onClick="Rendu(75,55,'billet')" value="GÉNÉRER l'APERÇU">
				<input style="float:right;" class="envoyer" type="submit" value="Modifier">
				<input onClick="supprimerBillet(<?php echo $_GET["numero"].",".$dernierBillet["numero"];?>)" type="button" class="supprimer" style="float:right;" value="Supprimer le billet">
			</form>
			<?php $billet->closeCursor();
		}
		else{?>
			<p>Si vous souhaitez modifier un billet de blog, <a style="cursor:pointer;" onClick="idChange(<?php echo $dernierBillet["numero"]; ?>)">cliquez-ici</a>!</p>
		<?php
	}}
	else{?>
		<p>Si vous souhaitez modifier un billet de blog, <a style="cursor:pointer;" onClick="idChange(<?php echo $dernierBillet["numero"]; ?>)">cliquez-ici</a>!</p>
	<?php } ?>
	<br>
</section>

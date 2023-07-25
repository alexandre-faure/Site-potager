<?php

//██████████████████████████████████████████████████ Renumérotation ███████████████████████████████████████████████████████

//nb de billets
$nbBillets = $bdd->query("SELECT COUNT(*) as nb from blog");
$nb = $nbBillets->fetch();
$nbBillets->closeCursor();
$nbB = $nb["nb"];

$bdd->exec("UPDATE blog SET numero='-1'");

for ($i=0;$i<$nbB;$i++){
	$valeurId = $bdd->query('SELECT id FROM blog WHERE numero="-1" ORDER BY id ASC LIMIT 1');
	$id = $valeurId->fetch();
	$valeurId->closeCursor();
	$bdd->exec("UPDATE blog SET numero='".intval($i+1)."' WHERE id ='".intval($id["id"])."'");
}



//██████████████████████████████████████████████████ Réattribution nom des photos █████████████████████████████████████████████████
//compte le nombre de fichiers
$photos = glob("/var/www/legtux.org/users/potager-lyceerenecassin/www/images/mini*-*.*");/* $files pour "lister" les fichiers - Mise en place de *.* pour dire que ce dossier contient une extension (par exemple .jpg, .php, etc... */
if ($photos!=""){
	$compteur = count($photos);/* Variable $compteur pour compter (count) les fichiers lister ($files) dans le dossier */

	//On fait une liste de toutes les photos
	$liste_dates = [];
	for ($n=0;$n<2;$n++){
		for ($i=0;$i<$compteur;$i++){
			
			$racine = '/var/www/legtux.org/users/potager-lyceerenecassin/www/images/';
			if ($n){$racine=$racine.'mini';}
			else{$racine=$racine.'full';}
			
			//On récupère la date
			$photos = glob($racine.'*-*.*')[$i];
			$nom = pathinfo($photos)['filename'];
			$ID = "";
			for ($k=4;$k<strlen($nom);$k++){
				if ($nom[$k]!="-"){
					$ID = $ID.$nom[$k];
				}else{break;}
			}
			$longueur_dbt = strlen($ID)+4+1;
			$date_img = substr(pathinfo($photos)['filename'], $longueur_dbt);
			
			$liste_dates[$ID] = $date_img;
		}
		arsort($liste_dates);
		
		$i=1;
		foreach ($liste_dates as $key => $value){
			if ($key!=$i){
				rename(glob($racine.$key.'-*.*')[0],$racine.$i.'-'.$value.'.'.pathinfo(glob($racine.$key.'-*.*')[0])['extension']);
			}
			$i++;
		}
	}
}

?>

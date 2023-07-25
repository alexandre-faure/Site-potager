<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

if (!isset($_SESSION["pseudo"])){
	header("Location: ");
}

try{
	$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', 'lePotager35160!', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e){
		die('Erreur : '.$e->getMessage());
}

//███████████████████████████████████████████████████ BLOG █████████████████████████████████████████████████████████
$evenement = $bdd->query('
SELECT 	id, type, nom,
		DATE_FORMAT(date_dbt, \'le %d/%m/%Y dès %Hh%i\') AS date_dbt,
		DATE_FORMAT(date_fin, \'le %d/%m/%Y à %Hh%i\') AS date_fin,
		DATEDIFF(NOW(), date_limite) AS date_limite,
		lieu, explications, nb_places, id_participants
FROM 	evenements
WHERE 	id='.$_GET['id']);
$j=0;
$ligne = $evenement->fetch();
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
?>

<!DOCTYPE html>
<html lang="fr" xml:lang="fr" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <link rel="icon" type="image/png" href="img/logo.png" />
        <link rel="stylesheet" type="text/css" href="/style/styleTable.css" />
        <meta name="viewport" content="width=device-width" />
        <title>Jardin solidaire</title>
    </head>
    <body>
		<table>
			<tr>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Classe</th>
				<th>Prioritaire</th>
				<th>Adresse mail</th>
				<th>Suppr.</th>
			</tr>
			<?php
				for ($m=0;$m<$nbInscrits;$m++){
					$participants = $bdd->query('SELECT id, prenom, nom, classe, mail, prioritaire, DATE_FORMAT(date_naissance, \'%d/%m/%Y\') AS date_naissance
					FROM participants
					WHERE id='.intval($listeId[$m]));
					while ($inscrits = $participants->fetch()) {?>
						<tr>
							<td><?php echo $inscrits['nom'];?></td>
							<td><?php echo $inscrits['prenom'];?></td>
							<td><?php if (isset($inscrits['classe'])){echo $inscrits['classe'];}else{echo "∅";}?></td>
							<td><em><?php if (!isset($inscrits['prioritaire'])){echo "";}else if ($inscrits['prioritaire']=="1"){echo "OUI";}else{echo "NON";}?></em></td>
							<td><?php if (isset($inscrits['mail'])){echo $inscrits['mail']."&nbsp;<a class='mail' href='mailto:".$inscrits['mail']."'>E</a>";}else{echo "∅";}?></td>
							<td><button onClick="suppr(<?php echo $_GET['id'].",".$inscrits['id'].",'".$inscrits['prenom']."'";?>)">×</button></td>
						</tr>
					<?php }
					$participants->closeCursor();
				}
			?>
		</table>
		<?php if($nbInscrits == 0){echo "<p style='font-size:1.1em; font-family:AvenirNormal; font-style:italic; text-align:center'>Aucun participants ne s'est encore inscrit à cet événement.</p>";}?>
		<script src="script/scriptTableau.js"></script>
	</body>
</html>

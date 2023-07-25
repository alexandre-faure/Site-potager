<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

require("config.php")

if (isset($_SESSION['pseudo']) && isset($_POST['submit'])&& isset($_FILES['photo']['name'])){

	//███████████████████████████████████████████████████ Connexion à la table █████████████████████████████████████████████████████████████████████
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=potager-lyceerenecassin;charset=utf8', 'potager-lyceerenecassin', $DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
		//$bdd = new PDO('mysql:host=localhost;dbname=potager;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch(Exception $e){
			die('Erreur : '.$e->getMessage());
	}

	//██████████████████████████████████████████████████ Récupération des valeurs des champs ███████████████████████████████████████████████████████

	//compte le nombre de fichiers
	$files = glob("/var/www/legtux.org/users/potager-lyceerenecassin/www/images/mini*.*");/* $files pour "lister" les fichiers - Mise en place de *.* pour dire que ce dossier contient une extension (par exemple .jpg, .php, etc... */

	if ($files==""){
		$compteur=0;
	}
	else{
		$compteur = count($files);/* Variable $compteur pour compter (count) les fichiers lister ($files) dans le dossier */
	}
	$compteur++;
	
	$countfiles=count($_FILES['photo']['name']);
	for($i=0;$i<$countfiles;$i++){
		// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
		if ($_FILES['photo']['error'][$i]==0){
			// Testons si le fichier n'est pas trop gros
			if ($_FILES['photo']['size'][$i] <= 8000000){
					// Testons si l'extension est autorisée
					$infosfichier = pathinfo($_FILES['photo']['name'][$i]);
					$extension_upload = $infosfichier['extension'];
					$extensions_autorisees = array('jpg', 'jpeg');
					if (in_array($extension_upload, $extensions_autorisees)){
						// On cherche la date
						$exif = exif_read_data($_FILES['photo']['tmp_name'][$i], 'IFD0');
						if (isset($exif['DateTime'])){$date_img = strtotime($exif['DateTime']);}
						else{$date_img = time()-$countfiles+$i;}
						
						$source = '/var/www/legtux.org/users/potager-lyceerenecassin/www/images/full'.$compteur.'-'.$date_img.'.'.$extension_upload;
						// On peut valider le fichier et le stocker définitivement
						move_uploaded_file($_FILES['photo']['tmp_name'][$i], $source);
						
						$imageSize = getimagesize($source) ;
						$imageRessource= imagecreatefromjpeg($source);
						if ($imageSize[0]>1500){
							$width = 1500;
							$height = $imageSize[1]*$width/$imageSize[0];
							if ($height>800){
								$height = 800;
								$width = $imageSize[0]*$height/$imageSize[1];
							}
						}
						else if ($imageSize[1]>800){
							$height = 800;
							$width = $imageSize[0]*$height/$imageSize[1];
						}
						if (isset($width) && isset($height)){
							$imageFinal = imagecreatetruecolor($width, $height);
							$final = imagecopyresampled($imageFinal, $imageRessource, 0,0,0,0, $width, $height, $imageSize[0], $imageSize[1]) ;
							imagejpeg($imageFinal, $source, 100) ;
						}
						//Enregistrement d'une version mini
						
						$height = 200;
						$width = $imageSize[0]*$height/$imageSize[1];
						
						$imageFinal2 = imagecreatetruecolor($width, $height);
						$final2 = imagecopyresampled($imageFinal2, $imageRessource, 0,0,0,0, $width, $height, $imageSize[0], $imageSize[1]) ;
						imagejpeg($imageFinal2, '/var/www/legtux.org/users/potager-lyceerenecassin/www/images/mini'.$compteur.'-'.$date_img.'.'.$extension_upload, 100) ;
					}
				}
				else{
					echo "Assurez vous que votre fichier ne dépasse pas 8Mo !<br><br>Si le problème subsiste, contactez le gérant du site pour résoudre le problème.";
					echo "<br><br>=> <a href='/espaceAdmin.php'>Retour vers l'espace administrateur</a>";
				}
		}
		else{
			echo "Une erreur est survenue !<br><br>Si le problème subsiste, contactez le gérant du site pour résoudre le problème.";
			echo "<br><br>=> <a href='/espaceAdmin.php'>Retour vers l'espace administrateur</a>";
		}
		$compteur++;
		echo "compteur : ".$compteur."<br>";
	}
	header('Location: /admin/espaceAdmin.php?scroll=Photos');
}
else{
	header('Location: /index.php');
}
?>

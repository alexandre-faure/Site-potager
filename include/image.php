<?php
if (isset($_GET['white'])){
	if ($_GET['white']=="true")
	header ("Content-type: image/png");

	$image = @ImageCreate (1, 1) or die ("Erreur lors de la création de l'image");
	
	$couleur_fond = ImageColorAllocate ($image, 255, 255, 255);
	
	ImagePng ($image);
}
else if (!isset($_GET['image'])||!isset($_GET['width'])||!isset($_GET['type'])){
	header ("Content-type: image/png");

	$image = @ImageCreate (200, 100) or die ("Erreur lors de la création de l'image");
	
	$couleur_fond = ImageColorAllocate ($image, 220, 220, 220);
	$noir = ImageColorAllocate($image, 0, 0, 0);
	
	ImageString($image, 4, 5, 5, "Aucune image disponible,", $noir);
	ImageString($image, 4, 5, 20, "url OU largeur OU type", $noir);
	ImageString($image, 4, 5, 35, "non saisi...", $noir);
	
	ImagePng ($image);
}
else if($_GET['type']!=("jpeg"&&"jpg")){
	header ("Content-type: image/png");

	$image = @ImageCreate (200, 100) or die ("Erreur lors de la création de l'image");
	
	$couleur_fond = ImageColorAllocate ($image, 220, 220, 220);
	$noir = ImageColorAllocate($image, 0, 0, 0);
	
	ImageString($image, 4, 5, 5, "La photo n'est pas du", $noir);
	ImageString($image, 4, 5, 20, "type .jpeg...", $noir);
	
	ImagePng ($image);
}
else{
	header ("Content-type: image/jpeg");
	
	$imageT = @ImageCreateFromJpeg($_GET["image"]);

	//Calcul de la taille
	list($width, $height) = getimagesize($_GET["image"]);
	$n_width = intval($_GET['width']);
	$n_height = $height*($n_width/$width);
	
	// Redimensionnement
	$image = @ImageCreateTrueColor($n_width, $n_height);
	ImageCopyreSampled($image, $imageT, 0, 0, 0, 0, $n_width, $n_height, $width, $height);

	// Affichage
	imagejpeg($image, null, 100);
}
?>

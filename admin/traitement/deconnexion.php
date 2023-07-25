<?php 
session_start();

if (!isset($_SESSION['pseudo'])){
	header("Location: /index.php");
}
else{
	// Suppression des variables de session et de la session
	$_SESSION = array();
	session_destroy();

	// Suppression des cookies de connexion automatique
	setcookie('pseudo', '');
	setcookie('mdp', '');
	header("Location: /index.php");
}
?>

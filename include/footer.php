<?php if (isset($_GET["scroll"])){
	echo "<script>setTimeout(function() {
			scrollID('".$_GET['scroll']."')
		},300)</script>";
}
?>
<footer>
	<div class="flexFooter">
		<div>
			<h4>Le lycée</h4>
			<br>
			<ul>
				<li>Lycée René Cassin</li>
				<li>Montfort-sur-Meu (35160)</li>
				<li><a href="http://www.lycee-rene-cassin-montfort-sur-meu.ac-rennes.fr">Site du lycée</a></li>
			</ul>
		</div>
		
		<div>
			<h4>Le site</h4>
			<br>
			<h5>Nous contacter</h5>
			<span id="banniereLogos">
				<a href="https://www.instagram.com/eco_cassin/?hl=fr" style="color:#ff009b" class="logoFooter">I</a>
				<a href="mailto:potager.lyceerenecassin@gmail.com" style="color:#a2a2a2" class="logoFooter">E</a>
				<a href="https://www.google.fr/maps/place/48%C2%B008'34.6%22N+1%C2%B057'44.9%22W/@48.142941,-1.9630382,127m/data=!3m2!1e3!4b1!4m6!3m5!1s0x0:0x0!7e2!8m2!3d48.1429412!4d-1.962472" style="color:#309700" class="logoFooter">M</a>
			</span>
			<br>
			<h5>À propos</h5>
			<a id="lienAPropos" href="/APropos.php?scroll=APropos">À Propos du site</a>
			<br>
			<h5>Espace Administrateur</h5>
			<a id="lienAdmin" href="/administrateur.php">Se Connecter</a>
		</div>
		
		<div>
			<h4>Copyright</h4>
			<p id="copyright">© Copyright 2020<br>
			All rights reserved</p>
		</div>
	</div>
</footer>
<script src="/script/script.js"></script>

		<div id="ombre"></div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.8.0/marked.min.js"></script>
		<script src='/script/scroll.js'></script>
		<script src='/script/image.js'></script>

		<?php $url = $_SERVER["PHP_SELF"]; ?>
		<p id="combleNav"></p>
		<nav>
			<div class="sousNav">
				<div id="spanTopNav">
					<div class="lienPage">
						<a <?php if($url!="/index.php"){echo "href='/index.php'";}?>>
							<span>
								Accueil
							</span>
						</a>
						<div class="sousLienNav">
							<a <?php if($url!="/index.php"){echo "href='/index.php?scroll=Presentation'";}else{echo "onclick='scrollID(\"Presentation\")'";}?>>
								<span>
									Présentation du projet
								</span>
							</a><br>
							<a <?php if($url!="/index.php"){echo "href='/index.php?scroll=Temoignages'";}else{echo "onclick='scrollID(\"Temoignages\")'";}?>>
								<span>
									Témoignages
								</span>
							</a>
						</div>
					</div>
					<em></em>
					<div class="lienPage">
						<a <?php if($url!="/projet.php"){echo "href='/projet.php'";}?>>
							<span>
								Le Projet
							</span>
						</a>
						<div class="sousLienNav">
							<a <?php if($url!="/projet.php"){echo "href='/projet.php?scroll=Evenements'";}else{echo "onclick='scrollID(\"Evenements\")'";}?>>
								<span>
									Événements à venir
								</span>
							</a><br>
							<a <?php if($url!="/projet.php"){echo "href='/projet.php?scroll=Photos'";}else{echo "onclick='scrollID(\"Photos\")'";}?>>
								<span>
									Le potager en photos
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<em></em>
			<div class="sousNav">
				<div>
					<div class="lienPage">
						<a <?php if($url!="/blog.php"){echo "href='/blog.php'";}?>>
							<span>
								Blog
							</span>
						</a>
						<div class="sousLienNav">
							<a <?php if($url!="/blog.php"){echo "href='/blog.php?scroll=Billet'";}else{echo "onclick='scrollID(\"Billet\")'";}?>>
								<span>
									Lire le dernier billet
								</span>
							</a>
						</div>
					</div>
					<em></em>
					<div class="lienPage">
						<a <?php if($url!="/participer.php"){echo "href='/participer.php'";}?>>
							<span>
								Participer
							</span>
						</a>
						<div class="sousLienNav">
							<a <?php if($url!="/participer.php"){echo "href='/participer.php?scroll=Message'";}else{echo "onclick='scrollID(\"Message\")'";}?>>
								<span>
									Laisser un message
								</span>
							</a>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<article id="meteo">
			<h3 style='display:none;'>Météo de Montfort sur Meu</h3>
			<img src="https://w.bookcdn.com/weather/picture/32_125436_1_3_34495e_250_2c3e50_ffffff_ffffff_1_2071c9_ffffff_0_6.png?scode=124&domid=581&anc_id=60191" alt="booked.net"/>
		</article>

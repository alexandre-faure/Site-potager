$("aside hr").addClass("none");

function dialog(i=0){
	$("#dialogContent i")[0].style.height="0";
	$("#dialogContent i")[0].style.height=$("#dialogContent")[0].offsetHeight-20+"px";
}

function baliseGras(i=0){
	$("textarea")[i].value += "**Texte à mettre en gras**";
	$(".dialogContainer h2")[0].innerHTML = "Mettre du texte en gras";
	$(".dialogContainer p")[0].innerHTML = "Voilà du **texte en gras**!";
	$(".dialogContainer p")[1].innerHTML = marked($(".dialogContainer p")[0].innerHTML);
	ouvrirAlerte();
	dialog();
}

function baliseItalique(i=0){
	$("textarea")[i].value += "*Texte à mettre en italique*";
	$(".dialogContainer h2")[0].innerHTML = "Mettre du texte en italique";
	$(".dialogContainer p")[0].innerHTML = "Voilà du *texte en italique*!";
	$(".dialogContainer p")[1].innerHTML = marked($(".dialogContainer p")[0].innerHTML);
	ouvrirAlerte();
	dialog();
}

function baliseSouligne(i=0){
	$("textarea")[i].value += "<u>Texte à souligner</u>";
	$(".dialogContainer h2")[0].innerHTML = "Souligner du texte";
	$(".dialogContainer p")[0].innerHTML = "Voilà du &lt;u&gt;texte souligné&lt;/u&gt;!";
	$(".dialogContainer p")[1].innerHTML = "<p>Voilà du <u>texte souligné</u>!</p>";
	ouvrirAlerte();
	dialog();
}

function baliseListeP(i=0){
	$("textarea")[i].value += "\n\n- Élément 1\n	- Sous-élément\n- Élément 2\n- Élément 3";
	$(".dialogContainer h2")[0].innerHTML = "Faire une liste";
	$(".dialogContainer p")[0].innerHTML = "Liste des fruits :<br><br>- Pommes<br>&emsp;&emsp;- Golden<br>&emsp;&emsp;&emsp;&emsp;- du jardin<br>- Cerises";
	$(".dialogContainer p")[1].innerHTML = marked("Liste des fruits :\n- Pommes\n	- Golden\n		- du jardin\n- Cerises");
	ouvrirAlerte();
	dialog();
}

function baliseListeN(i=0){
	$("textarea")[i].value += "\n\n1. Élément 1\n	1. Sous-élément\n2. Élément 2\n3. Élément 3";
	$(".dialogContainer h2")[0].innerHTML = "Faire une liste";
	$(".dialogContainer p")[0].innerHTML = "Liste des légumes :<br><br>1. Choux<br>&emsp;&emsp;1. Fleur<br>2. Courgettes";
	$(".dialogContainer p")[1].innerHTML = marked("Liste des légumes :\n1. Choux\n	1. Fleur\n2. Courgettes");
	ouvrirAlerte();
	dialog();
}

function sautLigne(i=0){
	$("textarea")[i].value += "\n\n";
	$(".dialogContainer h2")[0].innerHTML = "Sauter une ligne";
	$(".dialogContainer p")[0].innerHTML = "Pour sauter une ligne, faites 2 retours à la ligne !";
	$(".dialogContainer p")[1].innerHTML = "<p style='text-align:center;'><em>Aucun aperçu disponible</em></p>";
	ouvrirAlerte();
	dialog();
}

function baliseImage(i=0){
	$("textarea")[i].value += "![Description de l'image](img/logomini.png)\n";
	$(".dialogContainer h2")[0].innerHTML = "Insérer une image";
	$(".dialogContainer p")[0].innerHTML = "![Logo du site](/img/logomini.png)";
	$(".dialogContainer p")[1].innerHTML = marked($(".dialogContainer p")[0].innerHTML);
	ouvrirAlerte();
	dialog();
}








//Permettre les tabulations

if(window.addEventListener)
    window.addEventListener("load", tabulation, false);
else
    window.attachEvent("onload", tabulation);
    
function tabulation(){
    var textareas = document.getElementsByTagName("textarea");
    for(var i = 0, t = textareas.length; i < t; i++){
        textareas[i].onkeydown = function(e){
            var tab = (e || window.event).keyCode == 9;
            if(tab){
                var tabString = String.fromCharCode(9);
                var scroll = this.scrollTop;
                
                if(window.ActiveXObject){
                    var textR = document.selection.createRange();
                    var selection = textR.text;
                    textR.text = tabString + selection;
                    textR.moveStart("character",-selection.length);
		    textR.moveEnd("character", 0);
                    textR.select();
                }
                else {
                    var beforeSelection = this.value.substring(0, this.selectionStart);
                    var selection = this.value.substring(this.selectionStart, this.selectionEnd);
                    var afterSelection = this.value.substring(this.selectionEnd);
                    this.value = beforeSelection + tabString + selection + afterSelection;
                    this.setSelectionRange(beforeSelection.length + tabString.length, beforeSelection.length + tabString.length + selection.length);
                }                
                this.focus();
                this.scrollTop = scroll;
                return false;
            }
        };		
    }
}





//////////////////////////////////////////////Modifier / Supprimer un billet///////////////////////////////////////////////////////////////////


function idChange(max){
	$(".dialogContainer h1")[1].innerHTML = "Numéro du billet";
	$(".dialogContainer #pConfirmation")[0].innerHTML = "Modifier le billet numéro : <input max="+max+" min=1 value="+max+" type='number'>";
	ouvrirAlerte(1);
}

function confirmer(max){
	val = $(".dialogContainer input")[0].value;
	if (val>0 && val<=max){
		document.location.href="/admin/espaceAdmin.php?but=billet&modifier=true&numero="+val+"&scroll=modifierBillet";
	}
}

function supprimerBillet(num,max){
	if (num>0 && num<=max){
		if (confirm("Êtes-vous sûr de vouloir supprimer définitivement le billet n°"+num+" ?")){
			document.location.href="/admin/traitement/supprimerBillet.php?numero="+num;
		}
	}
}


///////////////////////////////////Envoi de photos/////////////////////////////////////////////////////////////////////

$("#submitPhoto").click(function(){
	ouvrirAlerte(2);
});

//////////////////////////////Événements////////////////////////////////////////////////////////////////////

$("select[name='type']").change(function(){
	nbPers();
});

function nbPers(){
	select = $("select[name='type']")[0];
	if(select.value=="rendez-vous" || select.value=="reunion"){
		$("#flexPers")[0].style.opacity="0.4";
		$("#flexPers input")[0].setAttribute("disabled","disabled");
		$("#flexPers input")[0].removeAttribute("required");
		$("#flexPers input")[0].value="";
		
		$("#dateLimite")[0].style.opacity="0.4";
		$("#dateLimite input")[0].setAttribute("disabled","disabled");
		$("#dateLimite input")[0].removeAttribute("required");
		$("#dateLimite input")[0].value="";
		$("#dateLimite input")[1].setAttribute("disabled","disabled");
		$("#dateLimite input")[1].removeAttribute("required");
		$("#dateLimite input")[1].value="";
	}
	else{
		$("#flexPers")[0].style.opacity="1";
		$("#flexPers input")[0].removeAttribute("disabled");
		$("#flexPers input")[0].setAttribute("required","required");
		$("#flexPers input")[0].value="20";
		
		$("#dateLimite")[0].style.opacity="1";
		$("#dateLimite input")[0].removeAttribute("disabled");
		date = $("input[name='dbtJ']")[0].value;
		var now = new Date()
		if (date==""){
			jour=now.getDate();
			mois = now.getMonth()+1;
			if (mois<10){mois="0"+mois;}
			if (jour<10){jour="0"+jour;}
			date=now.getFullYear()+"-"+mois+"-"+jour;
		}
		$("#dateLimite input")[0].value=date;
		$("#dateLimite input")[0].setAttribute("required","required");
		$("#dateLimite input")[1].removeAttribute("disabled");
		$("#dateLimite input")[1].setAttribute("required","required");
		$("#dateLimite input")[1].value="00:00";
	}
}

if ($("select[name='type']").length>0){
	nbPers();
}

////////////////////////////////////// taille iframe ////////////////////////////////////////////////////////////////////

$(function() {
	$(window).resize(function() {
		if ($(".tableauInscrits").length>0){
			for (i=0;i<$(".tableauInscrits").height;i++){
				resizeIframe($(".tableauInscrits")[i]);
			}
		}
	});        
});

function Rendu(w,h,type){
	w*=screen.width/100;
	h*=screen.height/100;
	fenetre = open("","apercu", "toolbar=no, ,location=no, status=no, scrollbars=yes, resizable=no, width="+w+", height="+h+", left="+(screen.width-w)/2+", top="+(screen.height-h)/2);
	if (type=="billet"){
		contenu = marked($(".contenu")[0].value)
		titre = marked($(".titre")[0].value).replace('<p>','').replace('</p>','')
		date = $(".date")[0].innerHTML
		
		fenetre.document.write("<head>")
		fenetre.document.write("<title>Aperçu du billet</title>")
		fenetre.document.write("<link rel='stylesheet' type='text/css' href='/style/style.css' />")
		fenetre.document.write("</head>")
		fenetre.document.write("<body><section style='height:95%'>")
		fenetre.document.write("<aside id='Billet' class='Billet'>\n<span class='enteteBillet'>")
		fenetre.document.write("<h4>"+titre+"</h4>\n<hr>")
		fenetre.document.write("<em class='dateB'>"+date+"</em>\n</span>\n<br>")
		fenetre.document.write("<span class='spanContent'>"+contenu+"</span>")
		fenetre.document.write("<img style='margin-bottom:10px; max-width:20%;' src='/img/logoBas.png'>")
		fenetre.document.write("</aside>")
		fenetre.document.write("</section></body>")
	}
	else if (type=="evenement"){
		titre = marked($(".titre")[0].value).replace('<p>','').replace('</p>','')
		contenu = marked($(".contenu")[0].innerHTML)
		type = $("select[name='type']")[0].value.charAt(0).toUpperCase()+$("select[name='type']")[0].value.substring(1)
		lieu = marked($(".lieuE")[0].value).replace('<p>','').replace('</p>','')
		//Date
		J = $(".dbtJ")[0].value
		H = $(".dbtH")[0].value
		date = "le "+J[8]+J[9]+"/"+J[5]+J[6]+"/"+J[0]+J[1]+J[2]+J[3]+" à partir de "+H[0]+H[1]+"h"+H[3]+H[4]
		nbPlaces = $(".nbPers")[0].value
		
		fenetre.document.write("<head>")
		fenetre.document.write("<title>Aperçu de l'événement</title>")
		fenetre.document.write("<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script><script src='script/scriptProjet.js'></script>")
		fenetre.document.write("<link rel='stylesheet' type='text/css' href='style/style.css' />")
		fenetre.document.write("</head>")
		fenetre.document.write("<body><section style='height:95%'>")
		fenetre.document.write("<div class='divEvenement "+type+"'>")
		fenetre.document.write("<div class='nomEvenement'>"+type+"</div>")
		if (nbPlaces!=""){
			fenetre.document.write("<strong class='places'>Nb. de places : "+nbPlaces+"<br>(restantes : "+nbPlaces+")</strong>")
		}
		fenetre.document.write("<h3>"+titre+"</h3>")
		fenetre.document.write("<img src='img/agenda.png'> <strong class='dateDbt'> "+date+"</strong><br>")
		fenetre.document.write("<img src='img/lieu.png'> <em class='lieu'> "+lieu+"</em>")
		fenetre.document.write("<span class='spanContent'>"+contenu+"</span>")
		if (nbPlaces!=""){
			fenetre.document.write("<center><input class='bouttonParticiper' type='button' value='Participer'></center>")
			fenetre.document.write("<form method='post' action='traitement/participerEvenement.php'><fieldset><legend>INSCRIPTION</legend><div><div class='participerLeft'>")
			fenetre.document.write("<label class='obligatoire' for='nomParticiper'>Nom de famille</label><br>")
			fenetre.document.write("<input minlength=3 maxlength=30 type='text' id='nomParticiper' name='nom' required placeholder='NOM DE FAMILLE'><br>")
			fenetre.document.write("<label class='obligatoire' for='prenomParticiper'>Prénom</label><br>")
			fenetre.document.write("<input minlength=3 maxlength=30 type='text' id='prenomParticiper' name='prenom' required placeholder='Prénom'><br>")
			fenetre.document.write("<label for='classeParticiper'>Classe (si lycéen à Montfort)</label><br>")
			fenetre.document.write("<input minlength=2 maxlength=10 type='text' id='classeParticiper' name='classe' placeholder='ex : 204 / 1G2...'><br>")
			fenetre.document.write("<label class='obligatoire' for='naissanceParticiper'>Date de naissance <em>(pour confirmer votre identité)</em></label><br>")
			fenetre.document.write("<input type='date' id='naissanceParticiper' required name='date'><br>")
			
			fenetre.document.write("</div><div class='participerRight'>")
			fenetre.document.write("<strong>Par soucis d'organisation, ne cocher la case que si elle correspond à votre situation&nbsp;:</strong><br>")
			fenetre.document.write("<input type='checkbox' name='prio[]' value='1' id='membre'>")
			fenetre.document.write("<label for='membre'>Je fait parti du Club Nature, de la MDL, du CVL ou d'un autre organisme lié au potager.</label><br><br>")
			fenetre.document.write("<label for='mailParticiper'>Mail <em>(pour prévenir de toute annulation)</em></label><br>")
			fenetre.document.write("<input minlength=5 maxlength=50 type='text' id='mailParticiper' name='mail' placeholder='ex : mail@gmail.com'><br>")
			fenetre.document.write("</div></div>")
			fenetre.document.write("<input type='button' value=\"S'inscrire\">")
			fenetre.document.write("<span style='float:right'><strong style='color:red;font-size:0.8em'>(*)</strong><em style='font-size:0.8em'>Champs obligatoires</em></span>")
			fenetre.document.write("</fieldset></form>")
		}
		fenetre.document.write("</div><br>")
		fenetre.document.write("</section></body>")
	}
	fenetre.document.close()
}


//////Volet aperçu événement
function tire(id,elem){
	if ($("#"+id).hasClass('voletOuvert')){
		$("#"+id).removeClass('voletOuvert')
		$("#"+id).addClass('voletCache')
		elem.innerHTML="⬇Voir les détails...⬇";
	}
	else{
		$("#"+id).addClass('voletOuvert')
		$("#"+id).removeClass('voletCache')
		elem.innerHTML="⬆Masquer les détails...⬆";
	}
	if ($("#"+id+" iframe").length==1){
		resizeIframe($("#"+id+" iframe")[0])
	}
}

/////////////////photo
function newPhoto(){
	$("input[id='photo'][type='file']")[0].click();
}

$("input[id='photo'][type='file']").change(function(){
	photos=this.files
	if (photos.length>0){
		$(".lienPhoto").removeClass("none")
		$("#submitPhoto")[0].removeAttribute("disabled")
		if(photos.length==1){
			$("#submitPhoto")[0].value="Envoyer l'image";
		}
		else{
			$("#submitPhoto")[0].value="Envoyer les image";
		}
		$("#listePhotos")[0].innerHTML=""
		tailleTotale = 0
		for (i=0;i<photos.length;i++){
			taille = photos[i].size
			tailleTotale=tailleTotale+taille
			$("#listePhotos")[0].innerHTML+="<input class='lienPhoto' value='"+photos[i].name+" ("+tailleFichier(taille)+")' id='lienPhoto"+i+"' type='text' class='none' disabled>"
		}
		$("#listePhotos")[0].innerHTML+="<p style='text-align:right'>Nombre de photo(s) : <strong>"+photos.length+"</strong><br>Taille totale : <strong>"+tailleFichier(tailleTotale)+"</strong></p>";
	}
	else{
		$(".lienPhoto").addClass("none")
		$("#submitPhoto")[0].setAttribute("disabled","disabled")
		$("#submitPhoto")[0].value="Aucune image sélectionée...";
		$("#listePhotos")[0].innerHTML="";
	}
})


function tailleFichier(taille){
	if (taille<1000000){
		tailleP=Math.round(taille/100)/10+"Ko"
	}
	else{
		tailleP=Math.round(taille/100000)/10+"Mo"
	}
	tailleP=tailleP.replace("\.",",")
	return tailleP
}

function modifierPage(){
	$(".dialogContainer h1")[2].innerHTML = "Page à modifier";
	$(".dialogContainer #pModifierPage")[0].innerHTML = "Modifier la page suivante : <select id='pageAModifier'><option value='index'>index.php</option><option value='blog'>blog.php</option><option value='participer'>participer.php</option></select>";
	ouvrirAlerte(2);
}


function confirmerPage(){
	valeur = $("#pageAModifier")[0].value
	document.location.href="/admin/traitement/modifierContenu.php?page="+valeur;
}

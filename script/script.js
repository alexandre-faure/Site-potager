//Variables de la fenêtre
var hauteurEcran = window.innerHeight;
var largeurEcran = window.innerWidth;
var posTopNav = 0;

//Variables divers
param()

window.onload = function() {
	for (i=0;i<$(".aTraduire").length;i++){
		$(".aTraduire")[i].innerHTML = marked($(".aTraduire")[i].innerHTML)
		if ($(".aTraduire")[i]==$("aside h4")[0]){
			$(".aTraduire")[i].innerHTML = $(".aTraduire")[i].innerHTML.replace('<p>','').replace('</p>','')
		}
	}
	cacheApercus();
}


//Paramètrages
function param(){
	$('#combleNav')[0].style.height=$('nav')[0].offsetHeight+"px";
	$('#copyright')[0].style.marginTop=0+"px"
	$('#copyright')[0].style.marginTop=$('footer .flexFooter>div')[2].offsetHeight-$('#copyright')[0].offsetHeight-$('footer h4')[2].offsetHeight+"px";
	if (posTopNav==0 || hauteurEcran==window.innerWidth || (largeurEcran>887 && window.innerWidth<887) || (largeurEcran<887 && window.innerWidth>887)){
		posTopNav = $('nav')[0].offsetTop;
	}
	fixedNav()
}

$(function() {
	$(window).resize(function() {
		param()
		hauteurEcran = window.innerHeight;
		largeurEcran = window.innerWidth;
		cacheApercus()
	});  
});

$(window).scroll(function(){
	fixedNav()
});

function fixedNav(){
	var scrollTop = $(this).scrollTop();
	if (scrollTop > posTopNav){
		$('nav').addClass("navFixed");
		$('#combleNav')[0].style.display="block";
	}
	else{
		$('nav').removeClass("navFixed");
		$('#combleNav')[0].style.display="none";
	}
}

function scrollBas(){
	if (i==0){
		i=1
		etage=etage+1
		$('html, body').animate( { scrollTop: 0}, 900 );
		setTimeout(function() {
			i=0
		},1500)
	}
}

function scrollHaut(){
	if (i==0){
		i=1
		etage=etage-1
		$('html, body').animate( { scrollTop: 0.944*etage*window.innerHeight}, 900 );
		setTimeout(function() {
			i=0
		},1500)
	}
}

function fermerAlerte(i=0){
	$(".dialog .dialogContainer")[0].style.transform="translateY(-30%)";
	$(".dialog")[i].style.opacity="0";
	setTimeout(function() {
		$(".dialog")[i].style.display="none";
		$(".dialog .dialogContainer")[i].style.transform="translateY(0)";
		$(".dialog")[i].style.opacity="1";
	},500)
}

function ouvrirAlerte(i=0){
	$(".dialog")[i].style.display="block";
	setTimeout(function() {
		$(".dialog .dialogContainer")[i].style.opacity="1";
		$(".dialog .dialogContainer")[i].style.transform="translateY(15%)";
	},200)
	
}

//Fixer entete des billets
$(".Billet").scroll(function(){
	hauteurTop = $(".enteteBillet")[0].offsetHeight;
	var scrollAside = $(this).scrollTop();
	if (scrollAside > hauteurTop && !$(".enteteBillet").hasClass("enteteFixed")){
		entete=true
		$(".enteteBillet")[0].style.transition=".8s";
		$(".enteteBillet")[0].style.transform="translateY(-100%)";
		setTimeout(function() {
			$(".enteteBillet").addClass("enteteFixed");
			$(".enteteBillet")[0].style.transform="translateY(0)";
		},250)
	}
	else if (scrollAside < hauteurTop && $(".enteteBillet").hasClass("enteteFixed")){
		entete=false
		$(".enteteBillet")[0].style.transform="translateY(-100%)";
		$(".enteteBillet")[0].style.transition=".3s";
		setTimeout(function() {
			$(".enteteBillet")[0].style.transform="translateY(0)";
			$(".enteteBillet").removeClass("enteteFixed");
		},100)
	}
});


//
//Préparer :hover apercu billets (lire la suite)
function cacheApercus(){
	var nbApercu = $(".apercuBlog").length;
	for (i=0;i<nbApercu;i++){
		$(".lirePlus")[i].style.width = $(".Billet")[i].offsetWidth-6+"px";
		$(".lirePlus")[i].style.height = $(".Billet")[i].offsetHeight-6+"px";
	}
}

function modifierBillet(num){
	document.location.href="/espaceAdmin.php?but=billet&modifier=true&numero="+num+"#modifierBillet";
}


//////////////////////////IFrame

function resizeIframe(obj){
	obj.style.height = obj.contentWindow.document.documentElement.scrollHeight+20 + 'px';
}

////////////////////// Écran tactile
var is_touch_device = function(){  
	try{  
		document.createEvent("TouchEvent");  
		return true;  
	} catch(e){  
		return false;  
	}  
}

if (is_touch_device()){
	for (i=0;i<$(".lienPage>a").length;i++){
		$(".lienPage>a")[i].removeAttribute('href');
	}
}

//////////////////////Modifier E
function modifierE(id){
	document.location.href="?but=evenement&modifier=true&id="+id+"&scroll=modifierEvenement";
}

function supprimerE(id){
	if (confirm("Étes-vous certain(e) de vouloir annuler l'événement n°"+id+" ?")){
		motif=""
		while(motif==""){
			motif=prompt("Veuillez saisir le motif de l'annulation de l'événement pour en informer les personnes inscrites :")
		}
		document.location.href="/traitement/supprimerEvenement.php?motif="+motif+"&id="+id;
	}
}

$("#inputMdpAdmin").onchange = function(){
	$("#mdpInscription2")[0].setAttribute("pattern",this.value)
}

function indicationsChamp(elem){
	elem.nextElementSibling.classList.remove("none")
	elem.nextElementSibling.style.transition="1s"
	elem.nextElementSibling.style.opacity=".9"
}

function indicationsChampF(elem){
	elem.nextElementSibling.classList.add("none")
	elem.nextElementSibling.style.opacity="0"
}

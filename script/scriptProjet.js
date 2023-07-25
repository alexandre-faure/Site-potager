//Variables de la fenêtre
var hauteurEcran = window.innerHeight;
var largeurEcran = window.innerWidth;
var posTopNav = 0;



//Participer à un événement
for (i=0;i<$("form").length;i++){
	$("form")[i].setAttribute("style","display:none;");
}

$(".bouttonParticiper").click(function(){
	form = $("#form"+this.id)[0];
	if (form.getAttribute("style")=="display:none;"){
		form.setAttribute("style","display:visible;");
		setTimeout(function() {
			form.style.opacity="1";
			form.style.transform="translateY(0)";
		},20)
	}
	else{
		form.setAttribute("style","display:none;");
	}
});

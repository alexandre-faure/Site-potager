function image(elem){
	lien = elem.parentNode.href
	width = Math.round(window.getComputedStyle(elem,null).getPropertyValue("width").replace("px",""))+100
	type = lien.match('\.[a-z]{2,}$',"$1")[0].replace("\.","")
	
	elem.removeAttribute("onload")
	elem.setAttribute("src","/include/image.php?image="+lien+"&width="+width+"&type="+type)
	if (width>800){width=800}
	elem.parentNode.setAttribute("href",lien)
}

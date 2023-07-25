function suppr(evenement, participant, nom){
	if (confirm("Voulez-vous vraiment supprimer "+nom+" des inscriptions ? Si oui, n'oubliez pas de contacter la personne concernée pour l'en informer !")){
		top.location.href="/admin/traitement/supprimerParticipant.php?id="+evenement+"&participant="+participant;
	}
}


console.log('root: '+ROOT)
var Soccer = Soccer || {};
Soccer.afficher_joueur = function (joueurs, idContent, addBtn, className, title){
	//console.debug('payers : '+JSON.stringify(joueurs));
	//console.debug('taille : '+joueurs.length);
	let html = '';
	html+= '<ul class="list-unstyled top_profiles scroll-view">'
	for(let i = 0; i<joueurs.length; i++) {
		 html+= '<li class="media event" >'
		html+= '<a class="pull-left border-green profile_thumb">'
		  html+= '<i class="fa fa-user '+joueurs[i]['couleur']+'"></i>'
		html+= '</a>'
		html+= '<div class="media-body">'
		  html+= '<a class="title" href="#">'+joueurs[i]['nom']+'</a>';
		  if(joueurs[i]['telephone'])
		  html+= '<p>'+joueurs[i]['telephone']+'</p>';
		  html+= '</p>';
		  
		html+= '</div>';
		if(addBtn){
			html+= '<button data-id="'+joueurs[i]['id']+'" type="submit" class="btn btn-default pull-right '+className+'">'+title+'</button>';
		}
		
	  html+= '</li>';
	} 
	  
	html+= '</ul>';
	//console.log(html);
	$('#'+idContent).html(html);
	
	return html;
};

Soccer.genererEquipe = function (){
	
 $.ajax({
       url : ROOT+"joueur/team",
       type : 'GET',
       success : function(result){
	   
           console.log("Appel réussi : ",result);
		   let teamplayers = JSON.parse(result);
		   Soccer.teamplayers = teamplayers;
		   Soccer.afficher_joueur(teamplayers['verte'], 'content-team-verte');
		   Soccer.afficher_joueur(teamplayers['orange'], 'content-team-orange');
       },

       error : function(resultat, statut, erreur){
			console.log("Échec");
       }

    });
};
Soccer.afficherEquipe = function (){
	
 $.ajax({
       url : ROOT+"joueur/equipe",
       type : 'GET',
       success : function(result){
	   
           console.log("Appel réussi : ",result);
		   let teamplayers = JSON.parse(result);
		   Soccer.teamplayers = teamplayers;
		   Soccer.afficher_joueur(teamplayers['verte'], 'content-team-verte');
		   Soccer.afficher_joueur(teamplayers['orange'], 'content-team-orange');
       },

       error : function(resultat, statut, erreur){
			console.log("Échec");
       }

    });
};
Soccer.loadJoueursAbsent = function (){
	
 $.ajax({
       url : ROOT+"joueur/joueurs_absents",
       type : 'GET',
       success : function(result){
	   
           console.log("Appel joueur absent réussi : ",result);
		   let joueurs = JSON.parse(result);
		   let idContent = 'list-joueurs-non-confirme';
		   let addBtn = true;
		   let className = 'confirmation';
		   let title = 'Confirmer présence';
		   Soccer.afficher_joueur(joueurs, idContent, addBtn, className, title);
		   Soccer.absents = joueurs;
		   Soccer.confirmationHandler();
		   
       },

       error : function(resultat, statut, erreur){
			console.log("Échec");
       }

    });
};
Soccer.loadJoueursPresent = function (){
	
 $.ajax({
       url : ROOT+"joueur/joueurs_presents",
       type : 'GET',
       success : function(result){
	   
           console.log("Appel joueur présent réussi : ",result);
		   let joueurs = JSON.parse(result);
		   let idContent = 'list-joueurs-confirme';
		   let addBtn = true;
		   let className = 'desister';
		   let title = 'Désister';
		   
		   Soccer.afficher_joueur(joueurs, idContent, addBtn, className, title);
		   Soccer.absents = joueurs;
		   Soccer.desisterHandler();
       },

       error : function(resultat, statut, erreur){
			console.log("Échec");
       }

    });
};
Soccer.ajaxCall = function(url, type, data){
	
	 $.ajax({
       url : url,
       type : type,
	   data:data,
       success : function(result, statut){ 
	   
           console.log("Appel réussi : "+statut);
		   location.reload(true);
       },

       error : function(resultat, statut, erreur){
			console.log("Échec");
       }

    });

}
Soccer.genererEquipeHandler = function(){
$('#btn-generer-equipe').click(function(e){
	console.log('generer equipe click');
	Soccer.genererEquipe();
	$('#equipe-generer').removeClass('hidden');
});
}

Soccer.afficherEquipeHandler = function(){
$('#btn-afficher-equipe').click(function(e){
	console.log('afficher-equipe click');
	Soccer.afficherEquipe();
	$('#equipe-generer').removeClass('hidden');
});
}

Soccer.confirmationHandler = function(){
	$('.confirmation').click(function(){
	var id = $(this).data('id');
	var date = $('#date_prochaine').text();
	console.log(id);
	console.log(date);
	let url = ROOT+"presence/confirme";
    let type = 'POST';
	let data={id_joueur:id, date_match:date};
	Soccer.ajaxCall(url, type, data);
	
});
}

Soccer.desisterHandler = function(){
	$('.desister').click(function(){
	let id = $(this).data('id');
	let date = $('#date_prochaine').text();
	console.log(id);
	console.log(date);
	let url = ROOT+"presence/desister";
    let type = 'POST';
	let data={id_joueur:id, date_match:date};
	Soccer.ajaxCall(url, type, data);
	
});
}



Soccer.loadJoueursAbsent();
Soccer.loadJoueursPresent();
Soccer.genererEquipeHandler();
Soccer.afficherEquipeHandler();
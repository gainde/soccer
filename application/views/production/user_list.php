
<div class="col-md-4 col-sm-6 col-xs-6">
  <div>
	<div class="x_title">
	  <h3>Joueurs non présent</h3>
	  
	  <div class="clearfix"></div>
	</div>
	<ul class="list-unstyled top_profiles scroll-view">
	<?php foreach($joueurs_absent as $index => $joueur) {?>
		 <li class="media event" >
		<a class="pull-left border-green profile_thumb">
		  <i class="fa fa-user green"></i>
		</a>
		<div class="media-body">
		  <a class="title" href="#"><?=$joueur['nom']?></a>
		  <p><?=($joueur['telephone'])?></p>
		  </p>
		  
		</div>
		<button data-id="<?=$joueur['id']?>" type="submit" class="btn btn-default pull-right confirmation">Confirmer présence</button>

		
	  </li>
	<?php } ?>
	  
	</ul>
  </div>
</div>
<script>
$('.confirmation').click(function(){
	var id = $(this).data('id');
	var date = $('#date_prochaine').text();
	console.log(id);
	console.log(date);
	 $.ajax({
       url : "<?=ROOT?>/presence/confirme",
       type : 'POST',
	   data:{id_joueur:id, date_match:date},
       success : function(result, statut){ // success est toujours en place, bien sûr !
	   
           console.log("Appel réussi : "+statut);
       },

       error : function(resultat, statut, erreur){
			console.log("Échec");
       }

    });
	
});
</script>
<div class="col-md-4 col-sm-6 col-xs-6">
  <div>
	<div class="x_title">
	  <h3>Joueurs Présence confirmé</h3>
	  
	  <div class="clearfix"></div>
	</div>
	<ul class="list-unstyled top_profiles scroll-view team">
	<?php foreach($joueurs_presents as $index => $joueur) {?>
		 <li class="media event" >
		<a class="pull-left border-green profile_thumb">
		  <i class="fa fa-user green"></i>
		</a>
		<div class="media-body">
		  <a class="title" href="#"><?=$joueur['nom']?></a>
		  <p><?=($joueur['telephone'])?></p>
		  </p>
		  
		</div>
		<button data-id="<?=$joueur['id']?>" type="submit" class="btn btn-default pull-right desister">Désister</button>
		
	  </li>
	<?php } ?>
	  
	</ul>
	
	<button  id="btn-generer-equipe" class="btn btn-primary generer">Generer Equipe</button>
  </div>
</div>
<script>

</script>
<!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total inscrit</span>
              <div class="count"><?=$nbJoueursTotal?></div>
              <!--span class="count_bottom"><i class="green">4% </i> From last Week</span-->
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total joueur confirmés</span>
              <div class="count"><?=$nbJoueursPresent?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Dernier score</span>
              <div class="score"> <span class="green-team"><?=$dernierScore['score_verte']?></span> - <span class="orange-team"><?=$dernierScore['score_orange']?></span></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total victoire</span>
              <div class="score"><span class="green-team"><?=$statsVictoire['verte']?></span> - <span class="orange-team"><?=$statsVictoire['orange']?></span></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"> </i> Prochaine rencontre</span>
              <div id="date_prochaine" class="date_prochaine"><?=$prochaineRencontre['date_match']?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            </div>
          </div>
          <!-- /top tiles -->

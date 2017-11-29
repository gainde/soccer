
    <div>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="<?=ROOT?>user/connexion" method="post" novalidate>
              <h1>Connexion</h1>
              <div>
                <input type="text" class="form-control" name="username" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <input type="submit" class="btn btn-default submit" name="connexion" value="Se connecter"/>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Nouveau dans le site?
                  <a href="<?=ROOT?>user/register" class="to_register"> Creer profil </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <p>©2017 Andalous soccer team</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        
    </div>


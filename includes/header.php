<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">Chaudoudoux App</a>
    </div>
    <ul class="nav navbar-nav">
    <?php
        if (isset($_SESSION['username'])){
          echo '<li><a href="/home.php"><span class="glyphicon glyphicon-home"></span> Accueil</a></a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon glyphicon-th"></span> Tableau de Bord
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="/dashboard.php">Planning</a></li>
            </ul>
          </li>';
        } else {
          echo '<li><a href="/home.php"><span class="glyphicon glyphicon-home"></span> Accueil</a></a></li>';
        }
      ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <?php
        if (isset($_SESSION['username'])){
          echo '<li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon glyphicon-user"></span> Profil
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="profile.php">Coordonnées</a></li>
                    <li><a href="settings.php">Paramètres</a></li>
                  </ul>
                </li>';
          echo '<li><a href="signout.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>';
        } else {
          echo '<li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Créer un compte</a></li>';
          echo '<li><a href="signin.php"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>';
        }
      ?>
    </ul>
  </div>
</nav>
<span><div id="update"></div></span>

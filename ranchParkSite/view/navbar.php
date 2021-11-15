<nav class="navbar container-fluid navbar-expand-lg navbar-light bg-white text-dark ">
        <div class="container-fluid">
          <a class="navbar-brand" href="./index.php"><img class="logoAccueil" src="./image/RanchLogoTranspGroupAccueil.png" alt="" ></a>
          <!--<a class="navbar-brand" href="#"><?php echo $title ?> RanchPark</a>-->
          <?php if(!isset($_SESSION['user'])){ ?>
                    <a class="navbar-brand" href="#"><?php echo $title ?> RanchPark</a>
          <?php }else{ ?>
                    <a class="navbar-brand" href="#"><?php echo $title ?> RanchPark</a>
                    <div class="text-center">
                        <?php echo $_SESSION['user']['name_user'] . " " . $_SESSION['user']['first_name_user']; ?>
                    </div>
          <?php
               } 
          ?>
                      
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav navbar-right mb-20">
                <a class="navbar-brand ml-20" href="#"><h3>Attractions</h3></a>
                <a class="navbar-brand" href="#"><h3>Activités</h3></a>
                <a class="navbar-brand" href="#"><h3>Animations</h3></a>
                <a class="navbar-brand" href="#"><h3>Spectacles</h3></a>
                
                <?php
                    if(!isset($_SESSION['user'])){
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="createUser.php" >Inscription</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="connectionUser.php">Connexion</a>
                        </li>
                    <?php
                    }else{
                    ?>
                    <li class="nav-item">
                            <a class="nav-link" href="profil.php">Mon profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnection.php">Déconnexion</a>
                        </li>
                    <?php
                    } 
                ?>
            </ul>
          </div>
        </div>
</nav>
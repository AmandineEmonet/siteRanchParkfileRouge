<!DOCTYPE html>
<html lang="fr">
  <!----------- header ----------->
  <?php include("head.php") ?>
  <!------------------------------>

    <body>
    <!----------- navbar ----------->
    <?php include("navbar.php") ?>
    <!------------------------------>

        <div class="container" id="bodyWithoutFooter">
            <div class="row">   
                <div class="col-0 col-sm-0 col-md-2 col-lg-3"></div>
                <div class="col-12 col-sm-12 col-md-8 col-lg-6">
                    <div class="text-center">
                        <h1>Se connecter</h1>
                    </div>    
                    <form action="./connectionUser.php" method="post">
                        
                        <div class="mb-3">
                            <label for="mail_user">Email</label>
                            <input class="form-control" type="email" id="mail_user" placeholder="Adresse mail" name="mail_user" value="<?php if(isset($mail_user)){ echo $mail_user; }?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_user">Mot de passe</label>
                            <input class="form-control" type="password" id="password_user" placeholder="Mot de passe" name="password_user"  value="<?php if(isset($password_user)){ echo $password_user; }?>" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success" name="connection">Se connecter</button>
                        </div>
                        <div class="mb-3">
                        <div class="text-center">
                        <?php if(!isset($_SESSION['id_user'])): ?> <!-- Si on ne détecte pas de session alors on verra le lien ci-dessous -->
                            <a href="motdepasse.php">Mot de passe oublié</a>
                        <?php endif; ?>
                    </div>
                        <?php if(isset($_SESSION['messageOK'])): ?>
                                <div id="messageOK" class="text-center text-success fs-5"> 
                                    <?php
                                        echo $_SESSION['messageOK'];
                                        unset($_SESSION['messageOK']);
                                        unset($_SESSION['messageKO']);
                                    ?> 
                                </div>
                            <?php else : ?>
                                <div id="messageKO" class="text-center text-danger fs-5"></div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!----------- footer ----------->
        <?php include("footer.php") ?>
        <!------------------------------>
    </body>
</html>
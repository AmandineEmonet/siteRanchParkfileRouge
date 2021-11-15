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
                        <h1>Inscription</h1>
                    </div>  
                    <form action="./createUser.php" method="post">

                        <div class="mb-3">
                            <label for="name_user">Nom</label>
                            <input class="form-control" type="text" placeholder="Votre nom" name="name_user" id="name_user" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="first_name_user">Prénom</label>
                            <input class="form-control" type="text" placeholder="Votre prénom" name="first_name_user" id="first_name_user" required>
                        </div>
                       
                        <div class="mb-3">
                            <label for="mail">Email</label>
                            <input class="form-control" type="email" placeholder="Adresse mail" name="mail_user" id="mail_user" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password">Mot de passe</label>
                            <input class="form-control" type="password" placeholder="Mot de passe - 8 caractères minimum" name="password_user" id="password_user" required>
                        </div>
                        <div class="mb-3">
                            <label for="confpwd">Confirmation mot de passe</label>
                            <input class="form-control" type="password" placeholder="Confirmer le mot de passe" name="confpwd" id="confpwd" required> 
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success" name="inscription">Envoyer</button>
                        </div>
                        <div class="mb-3">
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
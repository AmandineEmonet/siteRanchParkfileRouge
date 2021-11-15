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
              <h1 class="mb-4">Profil de <?php echo $_SESSION['user']['name_user'] . " " . $_SESSION['user']['first_name_user'] ?></h1>
              <div class="mb-2">
              <div>Quelques informations sur vous : </div>
              </div>
              <ul>
                <li class="mb-2">Votre id est : <?php echo $_SESSION['user']['id_user'] ?></li>
                <li class="mb-2">Votre mail est : <?php echo $_SESSION['user']['mail_user'] ?></li>
                <li class="mb-2">Votre compte a été crée le : <?php echo $_SESSION['user']['creation_date_user'] ?></li>
              </ul>
              <div class="col-12">
              <button type="submit" onclick="location.href='./changeProfil.php';" class="btn btn-success" name="changeprofil">Modifier profil</button>
              <button type="submit" onclick="location.href='./deleteUser.php';" class="btn btn-success" name="deleuser">Supprimer profil</button>
              <button type="submit" onclick="location.href='./changePassword.php';" class="btn btn-success" name="changepwd">Changer le mot de passe</button>  
            </div> 
            </div>
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
        <!----------- footer ----------->
        <?php include("footer.php") ?>
        <!------------------------------>
    </body>
</html>

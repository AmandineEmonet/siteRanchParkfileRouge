<?php
    /*-----------------------------------------------------
                        Imports :
    -----------------------------------------------------*/
    //fichier à appeler pour ajouter un utilisateur en base de données

    //ajout du model (class user)
    include('./model/user.php');
    //ajout du fichier de connexion 
    include('./utils/connectionbdd.php');
    //import de la vue connection.php (formulaire de connexion d'un utilisateur)
    include('./view/view_connection.php');   

    /*-----------------------------------------------------
                            Tests :
    -----------------------------------------------------*/
    // test si déjà connecté on redirige vers la page accueil
    if (isset($_SESSION['id_user'])){
        header('Location: ./view/view_index.php'); 
        exit;
        } else{

        //test si le formualire a était envoyé
        if(!empty($_POST)){
            extract($_POST);


            //test si les champs sont remplis, différents de nul et non vide (isset -> exist et différent de null !empty -> non vide)
            if(isset($_POST['mail_user'], $_POST['password_user']) 
            && !empty($_POST['mail_user']) && !empty($_POST['password_user'])) { 
    
                //création des variables de connexion en les sécurisant
                $mail_user = htmlspecialchars(strtolower(trim($_POST['mail_user']))); // On récupère le mail (strlolower pour forcer la minuscule)
                $password_user = htmlspecialchars(trim($_POST['password_user'])); // On récupère le mot de passe 

                //chiffrage du mot de passe viaBCRYPT
                $password_user=password_hash($password_user, PASSWORD_BCRYPT);

                // On fait une requête pour savoir si le couple mail / mot de passe existe bien 
                $sql = 'SELECT * FROM user WHERE mail_user = :mail_user AND password_user = :password_user';
                $check = $bdd->query($sql,
                array($mail_user, $password_user));

                //stockage dans user le résultat de la requête
                $user = $check->fetch();
                $row = $check->rowCount();

                //On créé un objet 
                $userLog = new User("", "", $mail_user, $password_user);

                //test si le compte existe (login)
                if($userLog->userExist($bdd))
                {   
                    //test si le login et le mot de passe correspondent
                    if($userLog->userConnnected($bdd))
                    {
                
                    //test login et mot de passe correct
                    if($userLog->logUser($bdd) === true)
                    {
                        echo "<script>let message = document.getElementById('messageOK')</script>";
                        echo "<script>message.innerHTML='Vous êtes connecté !!!'</script>";
                        //redirection vers page accueil
                        //header('Location:index.php'); 
                        // arrête le traitement
                    }
                }
                //test mot de passe incorrect
                else
                {
                    echo "<script>let message = document.getElementById('messageKO')</script>";
                    echo "<script>message.innerHTML='Le mot de passe ou le login est incorrect !!!'</script>";
                }                  
            }
            //test le compte n'existe pas
            else
            {
                echo "<script>let message = document.getElementById('messageKO')</script>";
                echo "<script>message.innerHTML='Le compte n\'existe pas !!!'</script>";
            }
                               
        }
        //test si les champs de formulaire ne sont pas remplis 
        else {
            echo "<script>let message = document.getElementById('messageKO')</script>";
            echo '<script>message.innerHTML = "Veuillez remplir tout les champs de formulaire.";</script>';
        }    
    }
}
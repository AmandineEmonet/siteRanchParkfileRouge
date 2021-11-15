<?php
    //demarrage de la session pour accéder à la session user
    session_start();

/*-----------------------------------------------------
                    protection de déconnexion :
-----------------------------------------------------*/
    //Si on est pas connecté, on retourne sur le formulaire de connexion
    if(!isset($_SESSION['user'])){
        header('Location: connectionUser.php');
        exit;
    }
/*-----------------------------------------------------
                    Session :
-----------------------------------------------------*/
    //deconnexion suppression des varaibles
    //session_destroy();
    unset($_SESSION["user"]);

/*-----------------------------------------------------
                    Redirection :
-----------------------------------------------------*/
    //redirection vers la page Acceuil  
    header('Location: index.php');
<?php
session_start();

$title = "Profil";
    /*-----------------------------------------------------
                        Imports :
    -----------------------------------------------------*/
    //fichier à appeler pour ajouter un utilisateur en base de données

    //ajout du model (class user)
    include('./model/User.php');
    //ajout du fichier de connexion 
    include('./utils/connectionbdd.php');
    //import de la vue logUser.php (formulaire d'insertion d'un utilisateur)
    include('./view/view_profil.php'); 

    /*-----------------------------------------------------
                            Tests :
    -----------------------------------------------------*/

    if(!isset($_SESSION['user'])){
        header('Location: index.php');
        exit;
    }
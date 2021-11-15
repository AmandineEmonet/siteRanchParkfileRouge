<?php

$title = 'Accueil';

    //création de la session
    session_start();

    /*-----------------------------------------------------
                        Imports :
    -----------------------------------------------------*/        
    //import du model
    include('./model/User.php');
    //import de la connexion à la bdd
    include('./utils/connectionbdd.php');    
    //import de la vue index
    include('./view/view_index.php');
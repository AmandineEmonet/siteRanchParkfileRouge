<?php   
    //connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=ranchpark', 'root','', 
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); // pour afficher les erreurs de connexion à la bdd

    //Mode de fetch par défaut
    $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

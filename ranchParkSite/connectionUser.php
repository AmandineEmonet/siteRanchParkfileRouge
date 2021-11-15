<?php
    //création de la session
    session_start();
    // test s'il y a une session on protège l'inscription en redirigeant sur profil
    if (isset($_SESSION['user'])){
        header('Location: profil.php'); 
        exit;
    } 

    $title = "Connection";
    /*-----------------------------------------------------
                        Imports :
    -----------------------------------------------------*/
    //fichier à appeler pour ajouter un utilisateur en base de données

    //ajout du model (class user)
    include('./model/User.php');
    //ajout du fichier de connexion 
    include('./utils/connectionbdd.php');
    //import de la vue connection.php (formulaire de connexion d'un utilisateur)
    include('./view/view_connection.php');   

    /*-----------------------------------------------------
                            Tests :
    -----------------------------------------------------*/
    // test s'il y a une session on protège la connecxion en redirigeant sur profil
    if (isset($_SESSION['user'])){
        header('Location: profil.php'); 
        exit;
    } else {

        //On vérifie si le formulaire a été envoyé
        if(!empty($_POST)){
        //le formulaire a été envoyé

            //on vérifie que tous les champs sont remplis
            if(isset($_POST["mail_user"], $_POST["password_user"])
            && !empty($_POST["mail_user"]) && !empty($_POST["password_user"])){
                //Le formulaire est complet
                
                //Filtrage par le Back-end du format email (plus sûr qu'en JS car peut-être js peut être désactivé)
                if(!filter_var($_POST["mail_user"], FILTER_VALIDATE_EMAIL)){
                    echo '<script>let message = document.getElementById("messageKO");';
                    echo 'message.innerHTML = "Veuillez entrer une adresse email correcte";</script>';
                } 

                //création des 2 variables qui vont récupérer le contenu des super globales post
                $mail_user = htmlspecialchars($_POST['mail_user']);
                $password_user = htmlspecialchars($_POST['password_user']);

                //On créé un objet 
                $user = new User("", "", "$mail_user", "$password_user");
                $user->cryptPwd();

                //Vérif sur l'utilisateur est existant
                if($user->userExist($bdd)){

                    //L'utilisateur existe, on appelle la fonction de login
                    if($user->logUser($bdd)){
                        //insertion message dans session car redirection
                        $_SESSION["messageOK"] = "Vous êtes connecté!";

                        //Redirection vers page profil
                        header("Location: ./profil.php");
                    } else {

                        //Insertion message erreur pas de redirection dans ce cas
                        echo '<script>let message = document.getElementById("messageKO");';
                        echo 'message.innerHTML = "L\'application a rencontré un problème!";</script>';
                    } 

                } else {                    
                    echo '<script>let message = document.getElementById("messageKO");';
                    echo 'message.innerHTML = "Vous n\'avez pas de compte";</script>';
                }    
                
            } else {
                echo '<script>let message = document.getElementById("messageKO");';
                echo 'message.innerHTML = "Le formulaire est incomplet";</script>';
            }
        
        } else {
            echo '<script>let message = document.getElementById("messageKO");';
            echo 'message.innerHTML = "Veuillez compléter le formulaire";</script>';
        }
    } 


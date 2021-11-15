<?php
//On démarre la session
session_start();

$title = "Inscription";
    /*-----------------------------------------------------
                        Imports :
    -----------------------------------------------------*/
    //fichier à appeler pour ajouter un utilisateur en base de données

    //ajout du fichier de connexion 
    include('./utils/connectionbdd.php');
    //ajout du model (class user)
    include('./model/User.php');

    /*-----------------------------------------------------
                            Tests :
    -----------------------------------------------------*/
    // test s'il y a une session on protège l'inscription en redirigeant sur profil
    if (isset($_SESSION['user'])){
        header('Location: /profil.php'); 
        exit;
    } 

    //test si le formualire a était envoyé
    if(!empty($_POST)){
        //Le formaulaire a été envoyé
        $valid = true;

        //test si les champs sont remplis, différents de nul et non vide (isset -> exist et différent de null !empty -> non vide)
        if(isset($_POST['name_user'], $_POST['first_name_user'], $_POST['mail_user'], $_POST['password_user'], $_POST['confpwd']) &&
        !empty($_POST['name_user']) && !empty($_POST['first_name_user']) && !empty($_POST['mail_user']) && !empty($_POST['password_user']) && !empty($_POST['confpwd']) ) { 
            // Le formulaire est complet

            //on récupère les données en les sécurisant
            $name_user = strip_tags(trim($_POST['name_user'])); // On récupère le nom (trim pour enlever les espaces avant et après) // strip_tags -> supprime les balises HTML et PHP
            $first_name_user = strip_tags(trim($_POST['first_name_user'])); // on récupère le prénom
            $mail_user = htmlspecialchars(strtolower(trim($_POST['mail_user']))); // On récupère le mail (strlolower pour forcer la minuscule)
            $password_user = htmlspecialchars(trim($_POST['password_user'])); // On récupère le mot de passe 
            $confpwd = trim($_POST['confpwd']); //  On récupère la confirmation du mot de passe

            //On initialise les super global pour les messages d'erreurs
            $_SESSION['messageOK'] = "";//afin d'insérer un message vert quelques soit la page php chargée
            $_SESSION['messageKO'] = "";//afin d'insérer un message rouge quelques soit la page php chargée

            // On vérifit que le mail est dans le bon format
            //Filtrage par le backend du format email
            if(!filter_var($mail_user, FILTER_VALIDATE_EMAIL)){ //filter_var —> Filtre une variable avec un filtre spécifique ici Email
                $valid = false;
                echo "<script>let message = document.querySelector('#messageKO')</script>";
                echo "<script>message.innerHTML='Le mail n'est pas valide'</script>";
            }
         
            //test correspondance des password
            if($password_user != $confpwd){
                $valid = false;
                echo "<script>let message = document.querySelector('#messageKO')</script>";
                echo "<script>message.innerHTML='La confirmation du mot de passe ne correspond pas'</script>";
            }
        
            //test longueur du mot de passe
            if(strlen($password_user)<=7){
                $valid = false;
                echo "<script>let message = document.querySelector('#messageKO')</script>";
                echo "<script>message.innerHTML='Le mot de passe doit comporter minimum 8 caractères'</script>";
            }
               
            //création d'un objet depuis les valeurs contenues dans le formulaire
            $user = new User($name_user, $first_name_user, $mail_user, $password_user);        

            //test si l'utilisateur existe déjà en bdd fonction userExist()
            if($user->userExist($bdd) == true){
                $valid = false;
                echo "<script>let message = document.querySelector('#messageKO')</script>";
                echo "<script>message.innerHTML='Ce mail appartient déjà à un compte'</script>";
            } 
            //L'utilisateur n'existe pas on peux le créer
            if($valid) {             
                //appel de la méthode encodage password, on hash le password (BCRYPT 60 caractères)
                $user->cryptPwd();

                //set la date de création
                $date = date('Y-m-d h:i:s');
                $user->setCreationDateUser($date);
                //On créer l'utilisateur grace à la méthode createUser($bdd)
                $user->createUser($bdd);
                //$_SESSION["messageOK"] ="OK";
                $_SESSION["messageOK"] = 'L\'utilisateur <span> '. $_POST['name_user'] .' </span> <span> '. $_POST['first_name_user'] .' </span> a été ajouté !!!';
                //echo "<script>let message = document.getElementById('messageOK')</script>";
                //echo '<script>message.innerHTML = "L\'utilisateur <span>'.$_POST['name_user'].'</span> <span>'.$_POST['first_name_user'].'</span> a été ajouté !!!";</script>';
                //echo '<script>message.innerHTML = "Nouveau compte créé !!!";</script>';
                header("Location: ./profil.php");
            }        
        }
        //test si les champs de formulaire ne sont pas remplis 
        else {
            $valid = false;
            echo "<script>let message = document.querySelector('#messageKO')</script>";
            echo '<script>message.innerHTML = "Veuillez remplir tout les champs de formulaire.";</script>';
        }    
    }



    /*-----------------------------------------------------
                        Imports de la vue html:
    -----------------------------------------------------*/
    //fichier à appeler pour ajouter un utilisateur en base de données
    //import de la vue logUser.php (formulaire d'insertion d'un utilisateur)
    include('./view/view_signUp.php'); 
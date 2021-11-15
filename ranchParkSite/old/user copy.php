<?php
    class User
    {
        /*-----------------------------------------------------
                            Attributs :
        -----------------------------------------------------*/  
        private $id_user;
        private $name_user;
        private $first_name_user;
        private $mail_user;
        private $password_user;
        private $creation_date_user;
        /*-----------------------------------------------------
                            Constucteur :
        -----------------------------------------------------*/        
        public function __construct($name_user, $first_name_user, $mail_user, $password_user)
        {   $this->name_user = $name_user;
            $this->first_name_user = $first_name_user;
            $this->mail_user = $mail_user;
            $this->password_user = $password_user;
        }
        /*-----------------------------------------------------
                        Getter and Setter :
        -----------------------------------------------------*/
        //id_user Getter and Setter
        public function getIdUser(){
            return $this->id_user;
        }
        public function setIdUser($newIdUser){
            $this->id_user = $newIdUser;
        }
        //name_user Getter and Setter
        public function getNameUser(){
            return $this->name_user;
        }
        public function setNameUser($newNameUser){
            $this->name_user = $newNameUser;
        }
        //first_name_user Getter and Setter
        public function getFirstNameUser(){
            return $this->first_name_user;
        }
        public function setFirstNameUser($newFirstNameUser){
            $this->first_name_user = $newFirstNameUser;
        }
        //login_user Getter and Setter
        public function getMailUser(){
            return $this->mail_user;
        }
        public function setMailUser($newMail_user){
            $this->mail_user = $newMail_user;
        }
        //password_user Getter and Setter
        public function getPasswordUser(){
            return $this->password_user;
        }
        public function setPasswordUser($newPasswordUser){
            $this->password_user = $newPasswordUser;
        }
        //creation_date_user Getter and Setter
        public function getCreationDateUser(){
            return $this->creation_date_user;
        }
        public function setCreationDateUser($newCreation_date_user){
            $this->creation_date_user = $newCreation_date_user;
        }
        /*-----------------------------------------------------
                            Fonctions :
        -----------------------------------------------------*/

/************** Méthode ajout d'un utilisateur en bdd **************/

        public function createUser($bdd){   
            //récupération des valeurs de l'objet
            $name_user = $this->getNameUser();
            $first_name_user = $this->getFirstNameUser();
            $mail_user = $this->getMailUser();
            $password_user = $this->getPasswordUser();        
            $creation_date_user = $this->getCreationDateUser();        
      
            try {   
                //requête sql creation d'un utilisateur
               $sql = 'INSERT INTO user(name_user, first_name_user, mail_user, password_user, creation_date_user ) 
                VALUES (:name_user, :first_name_user, :mail_user, :password_user, :creation_date_user )';

                //requete prepare pour protéger des injections SQL
                $req = $bdd->prepare($sql);

                //éxécution de la requête SQL
                $req->execute(array(
                'name_user' => $name_user,
                'first_name_user' => $first_name_user,
                'mail_user' => $mail_user,
                'password_user' => $password_user, 
                'creation_date_user' => $creation_date_user,
                ));
                
                //On récupère l'id du nouvel utilisateur afin de se connecter automatiquement apèrs création du compte
                $id_user = $bdd->lastInsertId();

               //stockage dans $SESSION des informations de l'utilisateur
                $_SESSION['user'] = [
                    'id_user' => $id_user,
                    'name_user' => $name_user,
                    'first_name_user' => $first_name_user,
                    'mail_user' => $mail_user,
                    'password_user' => $password_user,
                ];
                $_SESSION['messageOK'] = "";//afin d'insérer un message vert quelques soit la page php chargée
                $_SESSION['messageKO'] ="";//afin d'insérer un message rouge quelques soit la page php chargée
                
                return true;
            }
            catch(Exception $e) {
            //affichage d'une exception en cas d’erreur
            die('Erreur : '.$e->getMessage());
            }        
        }

/************** Méthode afin de contrôler si un utilisateur existe en bdd **************/

public function userExist($bdd): bool {
    //récuparation des valeurs de l'objet
    $mail_user = $this->getMailUser();


    try{
        //requête SQL afin de stocker le contenu de toute la table dans le tableau $req 
        $sql = 'SELECT * FROM user WHERE mail_user = :mail_user';

        //requete prepare pour protéger des injections SQL
        $req = $bdd->prepare($sql);

        //bindValue -> prevent SQL injection
        $req->bindValue(':mail_user', $mail_user, PDO::PARAM_STR); //PDO::PARAM_STR->valeur uniquement en STRING
        $req->execute();

        //stockage dans user le résultat de la requête
        $user = $req->fetch();

        if(!$user){
            //l'utilisateur n'existe pas
            return false;
        } else {
            //l'utilisateur existe
            return true;
        }
    }
    catch(Exception $e) {
        //affichage d'une exception en cas d’erreur
        die('Erreur : '.$e->getMessage());
    }
}



/************** Méthode afin d'afficher un utilisateur **************/
        public function updateUser($bdd) {
            //Récupération de des valeurs de l'objet
            $id_user = $this->getIdUser();
            $name_user = $this->getNameUser();
            $first_name_user = $this->getFirstNameUser();
            $mail_user = $this->getMailUser();
            $password_user = $this->getPasswordUser();

            try {
                //requête update utilisateur
                $sql = 'UPDATE user SET name_user = :name_user, first_name_user = :first_name_user, mail_user = :mail_user WHERE id_user = :id_user';

                $req = $bdd->prepare ($sql);
                
                //execution de la requête 
                $req->execute(array(
                    'id_user' => $id_user,
                    'name_user' => $name_user,
                    'first_name_user' => $first_name_user,
                    'mail_user' => $mail_user,
                    'password_user' => $password_user
                ));
            }
                catch(Exception $e) {
                    //affichage d'une exception en cas d’erreur
                    die('Erreur : '.$e->getMessage());
                }
            }      
        

/************** Méthode afin de supprimer un utilisateur **************/

        public function deleteUser($bdd) {
            //Récupération de des valeurs de l'objet
                //id utilisateur
            $id_user = $this->getIdUser();
                //affichage message
            $name_user = $this->getNameUser();
            $first_name_user = $this->getFirstNameUser();

            try {
                //requête SQL suppression
                $sql = 'DELETE FROM user WHERE id_user = :id_user';

                $req = $bdd->prepare($sql);
                $req->bindValue(':id_user', $id_user);
                $req->execute();
            } 
            catch(Exception $e) {
                //affichage d'une exception en cas d’erreur
                die('Erreur : '.$e->getMessage());
            }
        }



/************** Méthode afin de connecter un utilisateur **************/

        public function logUser($bdd){
            //récuparation des valeurs de l'objet
            $mail_user = $this->getMailUser();
            $password_user = $this->getPasswordUser();

            try {
                //Requête SQL
                $sql = 'SELECT * FROM user WHERE mail_user = :mail_user';
                //requete prepare pour protéger des injections SQL
                $req = $bdd->prepare($sql);
                //bindValue -> prevent SQL injection
                $req->bindValue(':mail_user', $mail_user, PDO::PARAM_STR); //PDO::PARAM_STR->valeur uniquement en STRING
                $req->execute();
                //stockage dans user le résultat de la requête
                $user = $req->fetch();

                //l'utilisateur est déjà créé en bdd->contrôle du password
                if(!password_verify($password_user, $user['password_user'])){
                    echo '<script>let message = document.querySelector(".errMssg");';
                    echo 'message.innerHTML = "email ou mot de passe incorrect";<script';
                } else {
                    //le couple mail/mot de passe sont correct
                    //stockage dans $_SESSION des informations de l'utilisateur
                    $_SESSION['user'] = [
                        'id_user' => $user['id_user'],
                        'name_user' => $user['name_user'],
                        'first_name_user' => $user['first_name_user'],
                        'mail_user' => $user['mail_user'],
                        'password_user' => $user['password_user'],
                        'creation_date_user' => $user['creation_date_user'],
                    ];
                    $_SESSION['messageOK'];
                    $_SESSION['messageKO'];
                    return true;
                }

            }
            catch(Exception $e) {
                //affichage d'une exception en cas d’erreur
                die('Erreur : '.$e->getMessage());
            }
        }

/************** Méthode afin de générer les super globales avec les valeurs d'attributs d'un utilisateur en bdd **************/
/*
//super globales, utilisable quelque soit la page
        public function generateSuperGlobale($bdd)
        {
            //récuparation des valeurs de l'objet       
            $mail_user = $this->getMailUser();        
            $password_user = $this->getPasswordUser();        
            try
            {                   
               //requête pour stocker le contenu de toute la table dans le tableau $reponse
               $sql = 'SELECT * FROM user WHERE mail_user = :mail_user AND password_user = :password_user LIMIT 1';
               $reponse = $bdd->query($sql);
               //parcours du résultat de la requête
               while($donnees = $reponse->fetch())
               {   
                  //return $donnees['password_user'];
                   if($mail_user == $donnees['mail_user'] AND $password_user == $donnees['password_user'])
                   {
                        $id_user =  $donnees['id_user'];
                        $name_user =  $donnees['name_user'];
                        $first_name_user =  $donnees['first_name_user'];
                        $mail_user =  $donnees['mail_user'];
                        $password_user =  $donnees['password_user'];
                        //création des super globales Session                
                        $_SESSION['id_user'] =  $id_user;
                        $_SESSION['name_user'] = $name_user;
                        $_SESSION['first_name_user'] =  $first_name_user;
                        $_SESSION['mail_user'] = $mail_user;
                        $_SESSION['password_user'] = $password_user;
                        $_SESSION['connected'] = true;
                   }
               }                
            }
            catch(Exception $e)
            {
            //affichage d'une exception en cas d’erreur
            die('Erreur : '.$e->getMessage());
            }   
        }
       */  
/************** Méthode afin de tester la connexion d'un utilisateur **************/

        public function userConnnected($bdd)
        {
             //récuparation des valeurs de l'objet    
             $id_user = $this->getIdUser();   
             $mail_user = $this->getMailUser();        
             $password_user = $this->getPasswordUser();        
             try
             {                   
                //requête pour stocker le contenu de toute la table le contenu est stocké dans le tableau $reponse
                //$reponse = $bdd->query('SELECT * FROM user WHERE mail_user = "'.$mail_user.'" 
                $sql = 'SELECT * FROM user WHERE mail_user = :mail_user AND password_user = :password_user LIMIT 1';
                $reponse = $bdd->query($sql);
                //parcours du résultat de la requête
                while($donnees = $reponse->fetch())
                {   
                   //si le mail et le mot de passe correspondent
                    if($mail_user == $donnees['mail_user'] AND $password_user == $donnees['password_user'])
                    {
                        /*if($reponse['n_pwd_user'] == 1){ // On remet à zéro la demande de nouveau mot de passe s'il y a bien un couple mail / mot de passe
                            $sql = "UPDATE user SET _user = 0 WHERE id_user = $id_user";
                            //requete prepare pour protéger des injections SQL
                            $user = $bdd->prepare($sql);
                            $user->execute(array($reponse['id_user']));
                        }*/
                        //retourne true si user existe (mail et passeword)
                        return true;
                    }
                    else
                    {//reourne false si user n'existe pas
                        return false;
                    }
                }                
             }
             catch(Exception $e)
             {
             //affichage d'une exception en cas d’erreur
             die('Erreur : '.$e->getMessage());
             }        
        }

/************** Méthode afin de mettre à jours le password **************/

        public function updatePwd($bdd) {
            $password_user = $this->getPasswordUser();
            $mail_user = $this->getMailUser();

            try {
                //Requête SQL
                $sql = 'UPDATE user SET password_user = :password_user WHERE mail_user = :mail_user';
                //requete prepare pour protéger des injections SQL
                $user = $bdd->prepare($sql);
                $user->execute(array(
                    'password_user' => $password_user,
                    'mail_user' => $mail_user
                ));
            }
                catch(Exception $e) {
                    //affichage d'une exception en cas d’erreur
                    die('Erreur : '.$e->getMessage());
                }            
        }

/************** Méthode hiffrage d'un mot du mot de passe **************/

        public function cryptPwd()
        {
            $this->setPasswordUser(password_hash($this->getPasswordUser(), PASSWORD_BCRYPT));
        }
       
    }
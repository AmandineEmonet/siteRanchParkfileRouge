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
        private $admin_user;
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

/************** M??thode ajout d'un utilisateur en bdd **************/

        public function createUser($bdd){   
            //r??cup??ration des valeurs de l'objet
            $name_user = $this->getNameUser();
            $first_name_user = $this->getFirstNameUser();
            $mail_user = $this->getMailUser();
            $password_user = $this->getPasswordUser();        
            $creation_date_user = $this->getCreationDateUser();        
      
            try {   
                //requ??te sql creation d'un utilisateur
               $sql = 'INSERT INTO user(name_user, first_name_user, mail_user, password_user, creation_date_user ) 
                VALUES (:name_user, :first_name_user, :mail_user, :password_user, :creation_date_user )';

                //requete prepare pour prot??ger des injections SQL
                $req = $bdd->prepare($sql);

                //??x??cution de la requ??te SQL
                $req->execute(array(
                'name_user' => $name_user,
                'first_name_user' => $first_name_user,
                'mail_user' => $mail_user,
                'password_user' => $password_user, 
                'creation_date_user' => $creation_date_user,
                ));
                
                //On r??cup??re l'id du nouvel utilisateur afin de se connecter automatiquement ap??rs cr??ation du compte
                $id_user = $bdd->lastInsertId();

               //stockage dans $SESSION des informations de l'utilisateur
                $_SESSION['user'] = [
                    'id_user' => $id_user,
                    'name_user' => $name_user,
                    'first_name_user' => $first_name_user,
                    'mail_user' => $mail_user,
                    'password_user' => $password_user,
                    'creation_date_user' => $creation_date_user,
                ];
                $_SESSION['connected']=true;
                $_SESSION['messageOK'] = "";
                $_SESSION['messageKO'] = "";
                return true;
            }
            catch(Exception $e) {
            //affichage d'une exception en cas d???erreur
            die('Erreur : '.$e->getMessage());
            }        
        }

/************** M??thode afin de contr??ler si un utilisateur existe en bdd **************/

public function userExist($bdd): bool {
    //r??cuparation des valeurs de l'objet
    $mail_user = $this->getMailUser();


    try{
        //requ??te SQL afin de stocker le contenu de toute la table dans le tableau $req 
        $sql = 'SELECT * FROM user WHERE mail_user = :mail_user';

        //requete prepare pour prot??ger des injections SQL
        $req = $bdd->prepare($sql);

        //bindValue -> prevent SQL injection
        $req->bindValue(':mail_user', $mail_user, PDO::PARAM_STR); //PDO::PARAM_STR->valeur uniquement en STRING
        $req->execute();

        //stockage dans user le r??sultat de la requ??te
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
        //affichage d'une exception en cas d???erreur
        die('Erreur : '.$e->getMessage());
    }
}



/************** M??thode afin d'afficher un utilisateur **************/
        public function updateUser($bdd) {
            //R??cup??ration de des valeurs de l'objet
            $id_user = $this->getIdUser();
            $name_user = $this->getNameUser();
            $first_name_user = $this->getFirstNameUser();
            $mail_user = $this->getMailUser();
            $password_user = $this->getPasswordUser();

            try {
                //requ??te update utilisateur
                $sql = 'UPDATE user SET name_user = :name_user, first_name_user = :first_name_user, mail_user = :mail_user WHERE id_user = :id_user';

                $req = $bdd->prepare ($sql);
                
                //execution de la requ??te 
                $req->execute(array(
                    'id_user' => $id_user,
                    'name_user' => $name_user,
                    'first_name_user' => $first_name_user,
                    'mail_user' => $mail_user,
                    'password_user' => $password_user
                ));
            }
                catch(Exception $e) {
                    //affichage d'une exception en cas d???erreur
                    die('Erreur : '.$e->getMessage());
                }
            }      
        

/************** M??thode afin de supprimer un utilisateur **************/

        public function deleteUser($bdd) {
            //R??cup??ration de des valeurs de l'objet
                //id utilisateur
            $id_user = $this->getIdUser();
                //affichage message
            $name_user = $this->getNameUser();
            $first_name_user = $this->getFirstNameUser();

            try {
                //requ??te SQL suppression
                $sql = 'DELETE FROM user WHERE id_user = :id_user';

                $req = $bdd->prepare($sql);
                $req->bindValue(':id_user', $id_user);
                $req->execute();
            } 
            catch(Exception $e) {
                //affichage d'une exception en cas d???erreur
                die('Erreur : '.$e->getMessage());
            }
        }



/************** M??thode afin de connecter un utilisateur **************/

        public function logUser($bdd){
            //r??cuparation des valeurs de l'objet
            $mail_user = $this->getMailUser();
            $password_user = $this->getPasswordUser();

            try {
                //Requ??te SQL
                $sql = "SELECT * FROM user WHERE mail_user = ? AND password_user = ?";
                //requete prepare pour prot??ger des injections SQL
                $req = $bdd->prepare($sql);
                //bindValue -> prevent SQL injection
                $req->bindValue(':mail_user', $mail_user, PDO::PARAM_STR); //PDO::PARAM_STR->valeur uniquement en STRING
                $req->execute(array(
                    $mail_user,
                    $password_user 
                    ));
                //stockage dans user le r??sultat de la requ??te
                $user = $req->fetch();

                //l'utilisateur est d??j?? cr???? en bdd->contr??le du password
                if(!password_verify($password_user, $user['password_user'])){
                    echo '<script>let message = document.querySelector(".errMssg");';
                    echo 'message.innerHTML = "email ou mot de passe incorrect";<script';
                } else {
                    //le couple mail/mot de passe sont correct
                    //On va pouvoir "connecter" l'utilisateur
                    //stockage dans $_SESSION des informations de l'utilisateur pour cel?? la session doit ??tre d??marr??e

                    $_SESSION['user'] = [
                        'id_user' => $user['id_user'],
                        'name_user' => $user['name_user'],
                        'first_name_user' => $user['first_name_user'],
                        'mail_user' => $user['mail_user'],
                        'password_user' => $user['password_user'],
                        'creation_date_user' => $user['creation_date_user'],
                    ];
                    $_SESSION['connected'] = true;
                    return true;
                }

            }
            catch(Exception $e) {
                //affichage d'une exception en cas d???erreur
                die('Erreur : '.$e->getMessage());
            }
        }

/************** M??thode afin de g??n??rer les super globales avec les valeurs d'attributs d'un utilisateur en bdd **************/

//super globales, utilisable quelque soit la page
        public function generateSuperGlobale($bdd)
        {
            //r??cuparation des valeurs de l'objet       
            $mail_user = $this->getMailUser();        
            $password_user = $this->getPasswordUser();        
            try
            {                   
               //requ??te pour stocker le contenu de toute la table dans le tableau $reponse
               $sql = 'SELECT * FROM user WHERE mail_user = :mail_user AND password_user = :password_user LIMIT 1';
               $reponse = $bdd->query($sql);
               //parcours du r??sultat de la requ??te
               while($user = $reponse->fetch())
               {   
                  //return $donnees['password_user'];
                   if($mail_user == $user['mail_user'] AND $password_user == $user['password_user'])
                   {
                        //cr??ation des super globales Session 

                        $_SESSION['user'] = [
                            'id_user' => $user['id_user'],
                            'name_user' => $user['name_user'],
                            'first_name_user' => $user['first_name_user'],
                            'mail_user' => $user['mail_user'],
                            'password_user' => $user['password_user'],
                            'creation_date_user' => $user['creation_date_user'],
                        ];
                        $_SESSION['connected'] = true;
                   }
               }                
            }
            catch(Exception $e)
            {
            //affichage d'une exception en cas d???erreur
            die('Erreur : '.$e->getMessage());
            }   
        }

/************** M??thode afin de tester la connexion d'un utilisateur **************/

        public function userConnnected($bdd)
        {
             //r??cuparation des valeurs de l'objet    
             $mail_user = $this->getMailUser();        
             $password_user = $this->getPasswordUser();     
             var_dump($password_user);   
             var_dump($mail_user);   
             try
             {                   
                //requ??te pour stocker le contenu de toute la table le contenu est stock?? dans le tableau $reponse
                //$reponse = $bdd->query('SELECT * FROM user WHERE mail_user = "'.$mail_user.'" 
                $sql = 'SELECT * FROM user WHERE mail_user = ? AND password_user = ?';
                $reponse = $bdd->prepare($sql);
                $reponse->execute(array(
                    $mail_user,
                    $password_user 
                    ));
                //parcours du r??sultat de la requ??te
                $donnees = $reponse->fetch();
                 var_dump(($donnees));
                   //si le mail et le mot de passe correspondent
                    if(!$donnees)
                    {
                        /*if($reponse['n_pwd_user'] == 1){ // On remet ?? z??ro la demande de nouveau mot de passe s'il y a bien un couple mail / mot de passe
                            $sql = "UPDATE user SET _user = 0 WHERE id_user = $id_user";
                            //requete prepare pour prot??ger des injections SQL
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
             catch(Exception $e)
             {
             //affichage d'une exception en cas d???erreur
             die('Erreur : '.$e->getMessage());
             }        
        }

/************** M??thode afin de mettre ?? jours le password **************/

        public function updatePwd($bdd) {
            $password_user = $this->getPasswordUser();
            $mail_user = $this->getMailUser();

            try {
                //Requ??te SQL
                $sql = 'UPDATE user SET password_user = :password_user WHERE mail_user = :mail_user';
                //requete prepare pour prot??ger des injections SQL
                $user = $bdd->prepare($sql);
                $user->execute(array(
                    'password_user' => $password_user,
                    'mail_user' => $mail_user
                ));
            }
                catch(Exception $e) {
                    //affichage d'une exception en cas d???erreur
                    die('Erreur : '.$e->getMessage());
                }            
        }

/************** M??thode hiffrage d'un mot du mot de passe **************/

        public function cryptPwd()
        {
            $this->setPasswordUser(password_hash($this->getPasswordUser(), PASSWORD_BCRYPT));
        }
       
    }
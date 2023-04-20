
<?php 
    session_start(); // Démarrage de la session
    include_once 'connexion.inc.php'; // On inclut la connexion à la base de données
    // Si les variables existent et qu'elles ne sont pas vides
    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['mdp']) && !empty($_POST['mdp_retape']))
    {
        // Patch XSS
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $mdp_retape = htmlspecialchars($_POST['mdp_retape']);

        // On vérifie si l'utilisateur existe
        $check = $cnx->prepare('SELECT pseudo, email, mdp FROM utilisateur WHERE pseudo = ?');
        $check->execute(array($pseudo));
        $data = $check->fetch();
        $row = $check->rowCount();
        
        $pseudo = strtolower($pseudo); // on transforme toute les lettres majuscule en minuscule pour éviter que Foo@gmail.com et foo@gmail.com soient deux compte différents ..
        
        // Si la requete renvoie un 0 alors l'utilisateur n'existe pas 
        if($row == 0){ 
            if(strlen($pseudo) <= 100){ // On verifie que la longueur du pseudo <= 100
                if(strlen($email) <= 100){ // On verifie que la longueur du mail <= 100
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){ // Si l'email est de la bonne forme
                        if(trim($mdp) === trim($mdp_retape)){ // si les deux mdp saisis sont bon
                            
                            // On insère dans la base de données
                            $insert = $cnx->prepare('INSERT INTO utilisateur(pseudo, email, mdp) VALUES(:pseudo, :email, :mdp)');
                            $insert->execute(array(
                                'pseudo' => $pseudo,
                                'email' => $email,
                                'mdp' => $mdp,
                            ));
                            // On redirige avec le message de succès
                            $_SESSION['pseudo'] = $data['pseudo'];

                            header('Location: index.php?');
                            die();

                            die();
                        }else{ header('Location: inscription.php?reg_err=password'); die();}
                    }else{ header('Location: inscription.php?reg_err=email'); die();}
                }else{ header('Location: inscription.php?reg_err=email_length'); die();}
            }else{ header('Location: inscription.php?reg_err=pseudo_length'); die();}
        }else{ header('Location: inscription.php?reg_err=already'); die();}
    }
?>
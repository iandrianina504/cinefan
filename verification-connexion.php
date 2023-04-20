<?php 
    session_start(); // Démarrage de la session
    include_once 'connexion.inc.php'; // On inclut la connexion à la base de données


    if(isset($_POST['pseudo']) && isset($_POST['mdp'])) // Si il existe les champs email, password et qu'il sont pas vident
    {
        // Patch XSS

        $pseudo = htmlspecialchars($_POST['pseudo']); 
        $mdp = htmlspecialchars($_POST['mdp']);
                
        // On regarde si l'utilisateur est inscrit dans la table utilisateurs
        $check = $cnx->prepare('SELECT pseudo, mdp, moderateur FROM utilisateur WHERE pseudo = ?');
        $check->execute(array($pseudo));
        $data = $check->fetch();
        print_r($data);
        $row = $check->rowCount();
        
        
        // Si > à 0 alors l'utilisateur existe
        if($row == 1)
        {
            // Si le mot de passe est le bon
            if(trim($mdp) == trim($data['mdp']))
            {
                // On créer la session et on redirige sur index.php
                $_SESSION['pseudo'] = $data['pseudo'];
                

                header('Location: index.php?');
                die();
            }
            else
            { header('Location: compte.php?login_err=password'); die(); }
        }
        else { echo $_POST['mdp'].$_POST['pseudo']; } // si le formulaire est envoyé sans aucune données
    }        
?>
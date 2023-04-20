<?php 

    include_once 'connexion.inc.php'; // On inclu la connexion à la bdd
    include_once 'fonction.php'; 

    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['nationalite']) && !empty($_POST['date_naissance']))
    {
        // Patch XSS
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $nationalite = htmlspecialchars($_POST['nationalite']);
        $date_naissance = htmlspecialchars($_POST['date_naissance']);

        // On insert la personne.
        $insert_personne = $cnx->prepare('INSERT INTO acteurrealisateur(nom, prenom, nationalite,date_naissance) VALUES(:nom, :prenom, :nationalite, :date_naissance)');
        $insert_personne->execute(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'nationalite' => $nationalite,
            'date_naissance' => $date_naissance,
        ));
        if(isset($_FILES['portrait'])){

            $select_id_personne = $cnx->prepare('SELECT id_personne FROM acteurrealisateur WHERE nom = :nom AND prenom = :prenom AND date_naissance = :date_naissance');
            $select_id_personne->execute(array(
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $date_naissance,
            ));
            $resultat_id_personne = $select_id_personne->fetch();
            $id_personne_ajout = $resultat_id_personne['id_personne'];

            $chemin = ajout_image('portrait');
            $insert_image = $cnx->prepare('INSERT INTO galerie(id_saisonvolet, id_personne, lien) VALUES(NULL, :id_personne, :chemin)');
            $insert_image->execute(array(
                'id_personne' => $id_personne_ajout,
                'chemin' => $chemin,
            ));
        }
    }
    header('Location: index.php');
?>
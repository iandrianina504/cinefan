<?php
    include_once 'connexion.inc.php'; // On inclu la connexion à la bdd
    include_once 'fonction.php';
    if (isset($_POST['acteur']) && isset($_POST['acteur_role'])){
       // On insert les acteurs.
        $insert_acteur = $cnx->prepare('INSERT INTO jouer(id_saisonvolet, id_personne,id_oeuvre, acteur_role) VALUES(:id_saisonvolet, :id_personne, :id_oeuvre, :acteur_role)');
        $insert_acteur->execute(array(
        'id_saisonvolet' => $_GET['id_saisonvolet'],
        'id_personne' => $_POST['acteur'],
        'id_oeuvre' => $_GET['id_oeuvre'],
        'acteur_role' => $_POST['acteur_role'],
    )); 
    }
    elseif (isset($_POST['acteur']) && empty($_POST['acteur_role'])) {
        echo "Veuiller donner un role à l'acteur";
    }
    elseif (empty($_POST['acteur']) && isset($_POST['acteur_role'])) {
        echo "Veuiller donner un  acteur";
    }
    if (isset($_POST['realisateur'])){
        // On insert les réalisateurs dans oeuvre.
        $insert_realisateur = $cnx->prepare('INSERT INTO realiser(id_personne,id_oeuvre) VALUES(:id_personne, :id_oeuvre)');
        $insert_realisateur->execute(array(
            'id_personne' => $_POST['realisateur'],
            'id_oeuvre' => $_GET['id_oeuvre'],
        ));
    }
    if (isset($_POST['genre'])){
        // On insert les genres
        $insert_genre = $cnx->prepare('INSERT INTO oeuvreappartientgenre(nomgenre,id_oeuvre) VALUES(:nomgenre, :id_oeuvre)');
        $insert_genre->execute(array(
            'nomgenre' => $_POST['genre'],
            'id_oeuvre' => $_GET['id_oeuvre'],
        ));
    }
    header('Location: affiche-oeuvre.php?id_saisonvolet='.$_GET['id_saisonvolet'].'&id_oeuvre='.$_GET['id_oeuvre']);
?>
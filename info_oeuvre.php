
<?php 
    include_once 'connexion.inc.php'; // On inclu la connexion à la bdd
    include_once 'fonction.php';

    // Si les variables existent et qu'elles ne sont pas vides
   
    // Patch XSS
    // Donnée insert oeuvre
    $titre = htmlspecialchars($_POST['titre']);
    $date_sortie = htmlspecialchars($_POST['date_sortie']);
    $type =  htmlspecialchars($_POST['type']);
    $dure = htmlspecialchars($_POST['dure']);
    $descriptif = htmlspecialchars($_POST['descriptif']);
    $genre = htmlspecialchars($_POST['genre']);
    // Donnée insert personne
    $realisateur = htmlspecialchars($_POST['realisateur']);
    $acteur = htmlspecialchars($_POST['acteur']);
    $acteur_role = htmlspecialchars($_POST['acteur_role']);

    
    switch($_GET['type']){
        // Si il l'oeuvre n'est pas encore dans la base de donnée.
        case 'nouveau':
        if (empty($_POST['idoeuvre_prec'])){
            $idoeuvre_prec = NULL;
        }
        else{
            $idoeuvre_prec = htmlspecialchars($_POST['idoeuvre_prec']);
        }

        // On insert l'oeuvre.
        
        $insert_oeuvre = $cnx->prepare('INSERT INTO filmserie(titre, dure, date_sortie,type_oeuvre, descriptif,idoeuvre_prec) VALUES(:titre, :dure, :date_sortie, :type_o, :descriptif, :idoeuvre_prec)');
        $insert_oeuvre->execute(array(
            'titre' => $titre,
            'dure' => $dure,
            'date_sortie' => $date_sortie,
            'descriptif' => $descriptif,
            'type_o' => $type,
            'idoeuvre_prec' => $idoeuvre_prec,
        ));
        // On reprend l'ID de l'oeuvre.
        $select_id_oeuvre = $cnx->prepare('SELECT id_oeuvre FROM filmserie WHERE titre = :titre AND date_sortie = :date_sortie');
        $select_id_oeuvre->execute(array(
            'titre' => $titre,
            'date_sortie' => $date_sortie,
        ));
        $resultat_id_oeuvre = $select_id_oeuvre->fetch();
        $id_oeuvre_ajout = $resultat_id_oeuvre['id_oeuvre'];

        // On l'insert dans saison/volet il sera seul jusu'a un nouveau ajout;
        $insert_saisonvolet = $cnx->prepare('INSERT INTO saisonvolet(titre_saisonvolet, date_sortie, dure, id_oeuvre, descriptif) VALUES(:titre, :date_sortie, :dure, :id_oeuvre, :descriptif)');
        $insert_saisonvolet->execute(array(
            'titre' => $titre,
            'date_sortie' => $date_sortie,
            'dure' => $dure,
            'id_oeuvre' => $id_oeuvre_ajout,
            'descriptif' => $descriptif,
        ));

        // ----------------- INSERTION Acteur et image --------------------------//

        // On reprend l'ID de la saison/volet.
        $select_id_SaisonVolet = $cnx->prepare('SELECT id_saisonvolet FROM saisonvolet WHERE titre_saisonvolet = :titre AND date_sortie = :date_sortie');
        $select_id_SaisonVolet->execute(array(
            'titre' => $titre,
            'date_sortie' => $date_sortie,
        ));
        $resultat_id_SaisonVolet = $select_id_SaisonVolet->fetch();
        $id_saisonvolet_ajout = $resultat_id_SaisonVolet['id_saisonvolet'];

        // In insert la photo si il y en a une.
        if(isset($_FILES['photo'])){
            $chemin = ajout_image('photo');
            $insert_image = $cnx->prepare('INSERT INTO galerie(id_personne, id_saisonvolet, lien) VALUES(NULL, :id, :chemin)');
            $insert_image->execute(array(
                'id' => $id_saisonvolet_ajout,
                'chemin' => $chemin,
            ));
        }
        // On insert les acteurs.
        $insert_acteur = $cnx->prepare('INSERT INTO jouer(id_saisonvolet, id_personne,id_oeuvre, acteur_role) VALUES(:id_saisonvolet, :id_personne, :id_oeuvre, :acteur_role)');
        $insert_acteur->execute(array(
            'id_saisonvolet' => $id_saisonvolet_ajout,
            'id_personne' => $acteur,
            'id_oeuvre' => $id_oeuvre_ajout,
            'acteur_role' => $acteur_role,
        ));

        // On insert les réalisateurs dans oeuvre.
        $insert_realisateur = $cnx->prepare('INSERT INTO realiser(id_personne,id_oeuvre) VALUES(:id_personne, :id_oeuvre)');
        $insert_realisateur->execute(array(
            'id_personne' => $realisateur,
            'id_oeuvre' => $id_oeuvre_ajout,
        ));

        // On insert les genres
        $insert_genre = $cnx->prepare('INSERT INTO oeuvreappartientgenre(nomgenre,id_oeuvre) VALUES(:nomgenre, :id_oeuvre)');
        $insert_genre->execute(array(
            'nomgenre' => $genre,
            'id_oeuvre' => $id_oeuvre_ajout,
        ));

        break;

        case('suite'):
        // Donnée insert saison
        $titre_saisonvolet = htmlspecialchars($_POST['titre_saisonvolet']);
        $appartien_oeuvre = htmlspecialchars($_POST['appartien_oeuvre']);
        // Si c'est une suite alors on insère que dans saison volet car l'oeuvre existe deja.
        $insert_saisonvolet = $cnx->prepare('INSERT INTO saisonvolet(titre_saisonvolet, date_sortie, dure, descriptif,id_oeuvre) VALUES(:titre_saisonvolet, :date_sortie, :dure, :descriptif, :appartien_oeuvre)');
        $insert_saisonvolet->execute(array(
            'titre_saisonvolet' => $titre_saisonvolet,
            'date_sortie' => $date_sortie,
            'dure' => $dure,
            'descriptif' => $descriptif,
            'appartien_oeuvre' => $appartien_oeuvre,

        ));
        // On reprend l'ID de la saison/volet.
        $select_id_SaisonVolet = $cnx->prepare('SELECT id_saisonvolet FROM saisonvolet WHERE titre_saisonvolet = :titre AND date_sortie = :date_sortie');
        $select_id_SaisonVolet->execute(array(
            'titre' => $titre,
            'date_sortie' => $date_sortie,
        ));
        $resultat_id_SaisonVolet = $select_id_SaisonVolet->fetch();
        $id_saisonvolet_ajout = $resultat_id_SaisonVolet['id_saisonvolet'];
        // On insert la photo si il y en a une.
        if(isset($_FILES['photo'])){
            $chemin = ajout_image('photo');
            $insert_image = $cnx->prepare('INSERT INTO galerie(id_saisonvolet, id_personne, lien) VALUES(:id_oeuvre, NULL, :chemin)');
            $insert_image->execute(array(
            'id_oeuvre' => $id_saisonvolet_ajout,
            'chemin' => $chemin,
            ));
        }

        // On insert les acteurs. v   
        $insert_acteur = $cnx->prepare('INSERT INTO jouer(id_saisonvolet,id_personne,id_oeuvre,acteur_role) VALUES(:id_saisonvolet, :id_personne, :id_oeuvre, :acteur_role)');
        $insert_acteur->execute(array(
            'id_saisonvolet' => $id_saisonvolet_ajout,
            'id_personne' => $acteur,
            'id_oeuvre' => $id_saisonvolet_ajout,
            'acteur_role' => $acteur_role,
        ));
        break;    
    }
    header('Location: index.php');

?>
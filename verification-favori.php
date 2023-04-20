<?php 
    session_start(); // Démarrage de la session
    include_once 'connexion.inc.php'; // On inclut la connexion à la base de donnéesù
    $insert_image = $cnx->prepare('INSERT INTO favoris(id_saisonvolet, pseudo) VALUES(:id, :ps)');
    $insert_image->execute(array(
        'id' => $_GET['id'],
        'ps' => $_SESSION['pseudo'],
    ));
/*
    echo $_GET['id'];
    echo $_GET['titre'];
    echo $_SESSION['pseudo'];
*/
?>

<?php
    header('Location: mesfavoris.php');
?>

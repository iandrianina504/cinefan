<?php 
session_start(); // Démarrage de la session
?>

<nav class = "navbar">
    <div class = "container">
        <a href = "index.php" class = "navbar-brand">CINEFAN</a>
        <div class = "navbar-nav">
        <a href = "index.php">home</a>
        <a href = "ajout-oeuvre.php">Ajout Oeuvre</a>
        <a href = "ajout-personne.php">Ajout Personne</a>
        <a href = "mesfavoris.php">Mes Favoris</a>
        <a href = "affiche-artiste.php">Liste Artiste</a>
        <a href = "deconnexion.php"> Deconexion </a>
        <a><?php echo $_SESSION['pseudo'] ?></a>
        </div>
    </div>
</nav>
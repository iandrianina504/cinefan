<!DOCTYPE html>
<html>
    <?php
    session_start();
    include_once("meta.php");
    include_once("connexion.inc.php");
    include_once("fonction.php");
    include_once("variables.php");
    ?>

    <body>
        <div class="wrapper">
            <?php 
            if(!empty($_SESSION['pseudo'])){
                include_once("navbar-connect.php");
            }
            else{
                include_once("navbar-disconnect.php");
            }
            include_once("erreur-inscription.php")
            ?>
            <div class="title">Choix Ajout </div>
            <h2 class="title"><a href="ajout-oeuvre.php?type=nouveau"> Nouveau Film/série </a></h2>
            <h2 class="title"><a href="ajout-oeuvre.php?type=suite"> Ajout Volet/Saison </a></h2>
            <?php if(isset($_GET["type"])) { ?>
            <div class="ajout">
            
                <form method="post" action=<?php echo $_GET['type'] == ('nouveau') ? "info_oeuvre.php?type=nouveau" : "info_oeuvre.php?type=suite" ?> enctype="multipart/form-data">
        
                <div class="inputs">
                    <?php 
                    $liste_personne_opt = liste_option_personne($ActeurRealisateur);
                    if($_GET['type'] != 'suite'){
                        echo liste_personne("realisateur",$liste_personne_opt);
                        echo liste_genre($genre);

                    } 
                    echo liste_personne("acteur",$liste_personne_opt);
                    ?>
                    <label>Role</label>
                    <input type="text" name="acteur_role" placeholder="ex : Spiderman" required="required" autocomplete="off" />
                    <label> Type Oeuvre</label>
                    <select name='type'>
                        <option value="film">Film</option>
                        <option value="serie">Serie</option>
                    </select>
                    <?php if($_GET['type'] != 'suite') : ?>
                        <label>Titre</label>
                        <input type="text" name="titre" placeholder="ex : Spiderman No Way home" required="required" autocomplete="off" />  
                    <?php endif; ?>
                    <?php if($_GET['type'] == 'suite') : ?>
                        <label>Saison/Volet</label> 
                        <input type="text" name="titre_saisonvolet" placeholder="Saison/Volet" required="required" autocomplete="off">
                        <?php echo liste_oeuvre($filmserie)?> 
                    <?php endif; ?>
                    <label> Synopsis </label>
                    <input type="text" name="descriptif" placeholder="ex : Pour la première fois dans son histoire cinématographique, Spider-Man,..." required="required" autocomplete="off" />
                    <label> Durée du film </label>
                    <input type="time" name="dure" placeholder="Durée" min="00:20" max="04:00" required="required" autocomplete="off"/>
                    <label> Date de sortie </label>
                    <input type="date" name="date_sortie" placeholder="Date de sortie" required="required" autocomplete="off">
                    <label> Image film </label>
                    <input type="file" name="photo">
                </div>
                <br>
                <div align="center">
                <button type="submit">Ajouter</button>
                </div>
                </form>
            </div>
        </div>
        <?php include_once("footer.php");?>
        <?php }
        else{
            ?>
        <div class="ajoutx">
        <?php include_once("footer.php");?>
        </div>
        <?php
        }
        ?>
    </body>
</html>
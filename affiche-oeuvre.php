<?php 
session_start(); // Démarrage de la session
?>

<!DOCTYPE html>
<html>
  <?php
  include_once("meta.php");
  include_once("connexion.inc.php");
  include_once("variables.php");
  include_once("fonction.php");
  session_start(); // Démarrage de la session
  if(!empty($_SESSION['pseudo'])){
    include_once("navbar-connect.php");
    }
  else{
    include_once("navbar-disconnect.php");
    }

  // REQUETTE SAISON VOLET 
  $saisonvolet_donne = $cnx->prepare('SELECT * FROM saisonvolet WHERE id_saisonvolet = :id_saisonvolet');
  $saisonvolet_donne->execute(array(
  'id_saisonvolet' => $_GET['id_saisonvolet'],
  ));

  // Table associatifs
  $resultat_saison_volet = $saisonvolet_donne->fetch();
  // Table associatifs

  //REQUETTE  REALISATEUR
  $select_realisateur_id = $cnx->prepare('SELECT id_personne FROM realiser WHERE id_oeuvre = :id_oeuvre');
  $select_realisateur_id->execute(array(
  'id_oeuvre' => $_GET['id_oeuvre'],
  ));

  // Table associatifs
  $realisateur_id = $select_realisateur_id->fetchAll(PDO::FETCH_ASSOC);
  // Table associatifs

  //REQUETTE  ACTEUR 

  $select_acteur_id = $cnx->prepare('SELECT id_personne FROM jouer WHERE id_oeuvre = :id_oeuvre');
  $select_acteur_id->execute(array(
  'id_oeuvre' => $_GET['id_oeuvre'],
  ));

  // Table associatifs
  $acteur_id = $select_acteur_id->fetchAll(PDO::FETCH_ASSOC);
  // Table associatifs

  // REQUETTE IMAGE 
  $select_lien = $cnx->prepare('SELECT lien FROM galerie LEFT JOIN saisonvolet ON galerie.id_saisonvolet = saisonvolet.id_saisonvolet WHERE galerie.id_saisonvolet = :id_saisonvolet');
  $select_lien->execute(array(
  'id_saisonvolet' =>  $_GET['id_saisonvolet'],
  ));
  $resultat_select_lien = $select_lien->fetch();
  $lien = $resultat_select_lien['lien'];

  // REQUETTE GENRE
  $select_genre = $cnx->prepare('SELECT nomgenre FROM oeuvreappartientgenre WHERE id_oeuvre = :id_oeuvre');
  $select_genre->execute(array(
  'id_oeuvre' => $_GET['id_oeuvre'],
  ));

  // Table associatifs
  $nom_genre = $select_genre->fetchAll(PDO::FETCH_ASSOC);
  // Table associatifs

  // VARIABLES
  $titre = $resultat_saison_volet['titre_saisonvolet'];
  $descritif = $resultat_saison_volet['descriptif'];
  $date_sortiee = $resultat_saison_volet['date_sortie'];
  $maj_path = 'mise-a-jour.php?id_oeuvre='.$_GET['id_oeuvre'].'&id_saisonvolet='.$_GET['id_saisonvolet'];

  
?>

  <body>
<!-- blog -->
    <section class = "about" id = "about">
      <div class = "container">
        <div class = "about-content">
        <div class = "blog-item">
            <img src = '<?php echo $lien ?>'class = "affiche">
            <div class="blog-text">

                <span><?php echo $date_sortiee ?></span>
                <h2>Genre</h2>
                <div>

                <?php foreach ($nom_genre as $type_genre): ?>
                  <?php
                  echo($type_genre['nomgenre']);
                  ?>
                <?php endforeach; ?>
                <form method="post" action="<?php echo $maj_path ?>">
                <?php 
                $liste_personne_opt = liste_option_personne($ActeurRealisateur);
                echo liste_personne("realisateur",$liste_personne_opt)."<br>";
                echo liste_personne("acteur",$liste_personne_opt)."<br>";
                echo liste_genre($genre)."<br>";
                ?>
                <label>Role</label>
                    <input type="text" name="acteur_role" placeholder="ex : Spiderman" autocomplete="off" />
                <p class="inscription">Si vous souhaitez ajouter un artiste qui n'est pas dans la liste veuillez les rajouter<span> <a href="ajout-personne.php">ici</a></span></p>
                <button type="submit">Ajouter</button>
                </div> 
                

            </div>
            
            
            
          </div>
          <div class = "about-text">
            <div class = "title">
              <h2><?php echo $titre ?> </h2>
              
              <!-- Affichage des realisateur -->
              <?php foreach ($realisateur_id as $realisateur): ?>
                <?php
                $realisateur_donne = $cnx -> prepare('SELECT nom,prenom FROM acteurrealisateur WHERE id_personne = :id');
                $realisateur_donne->execute(array(
                  'id' =>  $realisateur['id_personne'],
                ));
                $resultat_realisateur = $realisateur_donne->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <p>De <?php echo($resultat_realisateur[0]['nom'].' '.$resultat_realisateur[0]['prenom'])?></p>
              <?php endforeach; ?>
              <!-- Affichage des realisateur -->

            </div>
            <div class = "blog-text">
              <p><?php echo $descritif ?></p>
            <!-- Affichage des realisateur -->
            <?php foreach ($acteur_id as $acteur): ?>
                <?php
                $acteur_donne = $cnx -> prepare('SELECT nom,prenom FROM acteurrealisateur WHERE id_personne = :id');
                $acteur_donne->execute(array(
                  'id' =>  $acteur['id_personne'],
                ));
                $resultat_acteur = $acteur_donne->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <p>Avec <?php echo($resultat_acteur[0]['nom'].' '.$resultat_acteur[0]['prenom'])?></p>
              <?php endforeach; ?>
            <div class = "blog-text">
              <h2> <?php echo $titre_saisonvolet ?></h2>
              <p><?php echo $descriptif ?></p>
            </div>
              <!-- Affichage des realisateur -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end of about -->
  </body>
  <?php include_once("footer.php")?>
</html>
<?php 
session_start(); // Démarrage de la session
?>

<!DOCTYPE html>
<html>
  <?php
  include_once("meta.php");
  include_once("connexion.inc.php");
  include_once("variables.php");
  session_start(); // Démarrage de la session
  ?>
  <body>
    <header>
      <?php 
      if(!empty($_SESSION['pseudo'])){
        include_once("navbar-connect.php");
      }
      else{
        include_once("navbar-disconnect.php");
      }
      ?>
<!-- blog -->
    <section class = "blog" id = "blog">
      <div class = "container">
        <div class = "title">
          <h2>Liste artiste</h2>
          <p>Les Artiste ajoutées récemment</p>
        </div>
        <div class = "blog-content">
          <?php foreach($ActeurRealisateur as $item): ?>
            <div class = "blog-item">
            <div class = "blog-img">
            <?php
            $select_lien = $cnx->prepare('SELECT lien FROM galerie LEFT JOIN acteurrealisateur ON galerie.id_personne = acteurrealisateur.id_personne WHERE galerie.id_personne = :id_personne');
            $select_lien->execute(array(
            'id_personne' => $item['id_personne'],
            ));
            $resultat_select_lien = $select_lien->fetch();
            $lien = $resultat_select_lien['lien'];
            $lien_no = 'images/no-image.png';
            $nom = $item['nom'];
            $prenom = $item['prenom'];
            $Nationnalite = $item['nationalite'];
            $date_naissance = $item['date_naissance']
            ?>
            <?php if($lien != NULL) :?>
                <img src = <?php echo $lien ?>  class = "portrait">
            <?php endif;?>
            <?php if($lien == NULL) :?>
                <img src = <?php echo $lien_no ?>  class = "portrait">
            <?php endif;?>
            </div>
            <div class = "blog-text">
              <h2> <?php echo $nom.' '.$prenom ?></h2>
              <span><?php echo $date_naissance ?></span>
              <span><?php echo $Nationnalite ?></span>
            </div>
          </div>
          <?php endforeach; ?>
          
        </div>
      </div>
    </section>
    <!-- end of blog -->
  <?php include_once("footer.php")?>
  </body>
</html>
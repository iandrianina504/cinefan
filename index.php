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
      <div class = "banner">
        <div class = "container">
          <h1 class = "banner-title">
            <span>Fan</span> de Cinema
          </h1>
          <p>Pour les addicts de cinéma</p>
        </div>
      </div>
    </header>
<!-- end of header -->
<!-- blog -->
    <section class = "blog" id = "blog">
      <div class = "container">
        <div class = "title">
          <h2>Liste Films / Séries</h2>
          <p>Les Oeuvres ajoutées récemment</p>
        </div>
        <div class = "blog-content">
          <?php foreach($saisonvolet as $item): ?>
            <div class = "blog-item">
            <div class = "blog-img">
            <?php
            $select_lien = $cnx->prepare('SELECT lien FROM galerie LEFT JOIN saisonvolet ON galerie.id_saisonvolet = saisonvolet.id_saisonvolet WHERE galerie.id_saisonvolet = :id_saisonvolet');
            $select_lien->execute(array(
            'id_saisonvolet' => $item['id_saisonvolet'],
            ));
            $resultat_select_lien = $select_lien->fetch();
            $lien = $resultat_select_lien['lien'];
            $id_oeuvre = $item['id_oeuvre'];
            $id_saisonvolet = $item['id_saisonvolet'];
            $date_sortiee = $item['date_sortie'];
            $descriptif = $item['descriptif'];
            $titre_saisonvolet = $item['titre_saisonvolet'];
            $redirection = "affiche-oeuvre.php?id_saisonvolet=".$id_saisonvolet."&"."id_oeuvre=".$id_oeuvre;
            ?>

              <img src = <?php echo $lien ?>  alt = "">
              <span><a href="verification-favori.php?id=<?=$id_saisonvolet?>&titre=<?=$titre_saisonvolet?>"><i class="fa fa-heart" id="wishlist"></i></a></span>
            </div>
            <div class = "blog-text">
              <span><?php echo $date_sortiee ?></span>
              <h2> <?php echo $titre_saisonvolet ?></h2>
              <p><?php echo $descriptif ?></p>
              <a href = <?php echo $redirection ?>>Plus d'info</a>
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
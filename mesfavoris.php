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
          <h2>Mes favoris</h2>
          <p>La liste de mes favoris</p>
        </div>
        <div class = "blog-content">
          <?php foreach($favoris as $item): ?>
            <div class = "blog-item">
            <div class = "blog-img">
            <?php
            $select_lien = $cnx->prepare('SELECT lien FROM galerie LEFT JOIN favoris ON galerie.id_saisonvolet = favoris.id_saisonvolet WHERE galerie.id_saisonvolet = :id_saisonvolet AND favoris.pseudo = :pseudo');
            $select_lien->execute(array(
                'id_saisonvolet' => $item['id_saisonvolet'],
                'pseudo' => $_SESSION['pseudo']));
            $resultat_select_lien = $select_lien->fetch();
            $lien = $resultat_select_lien['lien'];

            $select_l2 = $cnx->prepare('SELECT * FROM saisonvolet LEFT JOIN favoris ON saisonvolet.id_saisonvolet = favoris.id_saisonvolet WHERE saisonvolet.id_saisonvolet = :id_saisonvolet AND favoris.pseudo = :pseudo');
            $select_l2->execute(array(
                'id_saisonvolet' => $item['id_saisonvolet'],
                'pseudo' => $_SESSION['pseudo']));
            $resultat_select = $select_l2->fetch();
            

            $id_oeuvre = $resultat_select['id_oeuvre'];
            $id_saisonvolet = $resultat_select['id_saisonvolet'];
            $date_sortiee = $resultat_select['date_sortie'];
            $descriptif = $resultat_select['descriptif'];
            $titre_saisonvolet = $resultat_select['titre_saisonvolet'];
            $redirection = "affiche-oeuvre.php?id_saisonvolet=".$id_saisonvolet."&"."id_oeuvre=".$id_oeuvre;
            ?>

              <img src = <?php echo $lien ?>  alt = "">
              <span><i class="fa fa-heart" style="color:yellow;" id="wishlist"></i></span>
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
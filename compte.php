<!DOCTYPE html>
<html>
    <?php
    include_once("meta.php");
    include_once("connexion.inc.php");
    ?>

    <body>
        <?php include_once("navbar-disconnect.php"); ?>
        <div class="compte">
            <form method="post" action="verification-connexion.php">
            
            <h1>Se connecter</h1>
            
            <div class="inputs">
                <input type="text" name="pseudo" placeholder="Pseudo *" />
                <input type="password" name="mdp" placeholder="Mot de passe *">
            </div>
            
            <p class="inscription">Je n'ai pas de <span>compte</span>. <span> Je m'en <a href="inscription.php">crée</a></span> un.</p>
                <div align="center">
            <button type="submit">Se connecter</button>
                </div>
            </form>
        </div>
        <div class="comptefory">
        <?php include_once("footer.php")?>
        </div>
    </body>
</html>
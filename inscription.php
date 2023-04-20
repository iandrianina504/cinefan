
<!DOCTYPE html>
<html>
    <?php
    include_once("meta.php");
    include_once("connexion.inc.php");
    ?>

    <body>
        <?php 
        include_once("navbar-disconnect.php"); 
        include_once("erreur-inscription.php")
        ?>
        
        <div class="compte">
            
            <form method="post" action="verification-inscription.php">
            <h1>S'inscrire</h1>
            
            <div class="inputs">
                <input type="text" name="pseudo" placeholder="Pseudo *" required="required" autocomplete="off" />
                <input type="email" name="email" placeholder="Email" required="required" autocomplete="off"/>
                <input type="password" name="mdp" placeholder="Mot de passe" required="required" autocomplete="off">
                <input type="password" name="mdp_retape" placeholder="Mot de passe" required="required" autocomplete="off">

            </div>
            
            <p class="inscription">J'ai un <span>compte</span>. Je me <a href="compte.php">connecte</a> un.</p>
                <div align="center">
                    <button type="submit">S'Inscrire</button>
                </div>
            </form>
        </div>
        <?php include_once("footer.php")?>
    </body>
</html>
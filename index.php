<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Créer Mdp</title>
    </head>
    <body>
        <form action="index.php" method="post">
            utilisateur <input type="text" name="utilIns" placeholder="Inserer user"><br />
            Inserer mdp <input type="password" name="mdpIns" placeholder="Inserer mdp"><br />
            Verifier mdp<input type="password" name ="mdpVerif" placeholder="Verifier mdp"><br />
            <input type="submit" name="valid" value="Valider">
        </form>
        <?php
        include_once 'monCrypteur.php';
        $monTesteur = new monCrypteur();
        if((isset($_POST['utilIns']) && $_POST['utilIns'] != null) && (isset($_POST['mdpIns']) && $_POST['mdpIns'] != null))
        {
            $monTesteur->ecrireMdp($_POST['utilIns'],$_POST['mdpIns']);

        }
        elseif(isset($_POST['mdpVerif']) && $_POST['mdpVerif'] != null)
        {
            if(isset($_POST['mdpIns']) && $_POST['mdpIns'] != null)
            {
                $monTesteur->ecrireMdp($_POST['utilIns'],$_POST['mdpIns']);
            }
            $monTesteur->verifierMdp($_POST['utilIns'],$_POST['mdpVerif']);
        }
        ?>
    </body>
</html>

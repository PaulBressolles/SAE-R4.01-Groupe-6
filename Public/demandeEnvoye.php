<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    if(isset($_POST['boutonAccueil'])){
        header('location:accueil.php');
    }
?>

<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body class="pageUnique">   
        <section class="sectionUnique">
            <h1 class="petit animationTitre">Réussite</h1>
            <?php
                echo'
                    <h4 class="reponse">'."Votre demande a bien été envoyé au coordinateur. Vous serez informé de sa réponse par une notification.".'</h4>
                ';
            ?>
            <div class="espaceBlanc30"></div>
            <img class="validation" src="../SVG/objectifValide.svg">
            <div class="espaceBlanc30"></div>
            <div class="espaceBlanc100"></div>
            <form action="" method="POST">
                    <input type="submit" name="boutonAccueil" value="Accueil">
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

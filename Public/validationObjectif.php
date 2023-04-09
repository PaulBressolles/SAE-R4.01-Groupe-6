<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $recompense = rechercheLiaison($_SESSION['objectifEnCours']);
    $recompenseInformation = recompenseParId($recompense[1]);
    if(isset($_POST['boutonRecompense'])){
        header('location:objectif.php');
    }
    objectifTravaille($_SESSION['objectifEnCours']);
?>
<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body class="pageUnique">  
        <?php require'chuteImage.php'; ?>
        <section class="sectionUnique">
            <a class="boutonRondRetourArriere" href="objectif.php"></a>
            <h1 class="petit animationTitre">Félicitations !</h1>
            <?php
                echo'
                    <h2 class="nomPrenomEnfant">'.$enfant[2].'</h2>
                ';
            ?>
            <div class="espaceBlanc30"></div>
            <img class="validation" src="../SVG/objectifValide.svg">
            <div class="espaceBlanc30"></div>
            <?php
                echo'
                    <p class="televerserFichier">Voici la récompense pour <b>'.$enfant[2].'</b>.</p>
                ';
            ?>
            <div class="espaceBlanc100"></div>
            <?php 
                echo'
                <div class="afficageImageRecompense">
                <img class="" id="afficheImage" src="'.$recompenseInformation[1].'">
                </div>
                
                <div class="espaceBlanc30"></div>
                <h2 class="sousTitreMoyenne">'.$recompenseInformation[0].'</h2>
                ';
            ?>
            
            <div class="espaceBlanc100"></div>
            <div class="espaceBlanc30"></div>
            <form action="" method="POST">
                    <input type="submit" name="boutonRecompense" value="Valider">
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

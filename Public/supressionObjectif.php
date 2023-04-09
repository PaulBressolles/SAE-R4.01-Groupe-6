<?php
session_start();
include '../PHP/fonction.php';
if(!isset($_SESSION['coordinateur'])){
    header('location:index.php');
}
$objectif = rechercheObjectif($_SESSION['objectifEnCours']);
if(isset($_POST['boutonAnnule'])){
    header('location:ajoutObjectif.php');
}

if(isset($_POST['boutonValide'])){
    supprimeObjectif($_SESSION['objectifEnCours']);
    header('location:objectif.php');
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
            <h1 class="connexion animationTitre">Supression</h1>
            <div class="espaceBlanc30"></div>
            <?php
                echo'
                    <p class="texteClassique">'."Souhaitez vous réellement supprimer l'objectif :<p><br>".
                    '<h4 class="titreh4 objectif"><b>'.$objectif[0].'</b></h4>
                ';
            ?>
            <form class="basSection" method=POST action="">
                <div class="ligneBoutonRond">
                    <input class="boutonRond annuler" type="submit" name="boutonAnnule" value="">
                    <input class="boutonRond valider" type="submit" name="boutonValide" value="">
                </div>
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

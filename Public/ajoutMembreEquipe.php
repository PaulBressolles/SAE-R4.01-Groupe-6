<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $suivi = listeEquipe($_SESSION['idEnfantSuivi']);
    $membre = rechercheMembreParId($_SESSION['membreCible']);
    $enfant = rechercheEnfantId( $_SESSION['idEnfantSuivi']);

    if(isset($_POST['boutonAjout'])){
        suiviAjoutCoordinateur($_SESSION['membreCible'], $_SESSION['idEnfantSuivi'], $_POST['fonction']);
        header('location:gestionEquipe.php');
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
            <a class="boutonRondRetourArriere" href="gestionEquipe.php"></a>
            <h1 class="headerTitre animationTitre">Ajout du membre</h1> 
            <div class="espaceBlanc30"></div>
            <h2 class="titreSection">Membre</h2>
            <div class="espaceBlanc10">
            </div>
            <?php   
                echo'
                    <p class="televerserFichier">Souhaitez vous ajouter le membre :</p>
                    <div class="espaceBlanc10"></div>
                    <p class="sousTitreH1 epais">
                        '.$membre[1].' <b>'.$membre[0].'</b>
                    </p>
                    <div class="espaceBlanc10"></div>
                    <p class="televerserFichier">'."à l'équipe de :".'</p>
                    <div class="espaceBlanc10"></div>
                    <p class="sousTitreH1 epais">
                        '.$enfant[2].' <b>'.$enfant[1].'</b>
                    </p>
                ';
            ?>
            <div class="espaceBlanc30"></div>
            <h2 class="titreSection">Rôle</h2>
            <div class="espaceBlanc10">

            <form class="choixSuiviObjectif suivi" action="" method="POST">
            
                <div class="espaceBlanc10"></div>
                <div class="boiteSelecteur">
                        <div class="selecteurDate demandeSuivi">
                                <div class="selecteur demandeSuivi">
                                    <div class="flecheSelecteur">
                                        <img class="flecheSelecteurImage" src="../SVG/flecheSelecteur.svg">
                                    </div>
                                    <select class="demandeSuivi" name="fonction">
                                        <option value="parent">Parent</option>
                                        <option value="enseignant">Enseignant</option>
                                    </select>
                                </div>
                        </div>
                </div>
                <div class="espaceBlanc30"></div>
                <div class="boutonValidation">
                    <input type="submit" name="boutonAjout" value="Ajouter">
                </div>
            </form> 
            <div class="espaceBlanc30"></div>
        </section>
    </body>

    <footer>
    </footer>

</html>

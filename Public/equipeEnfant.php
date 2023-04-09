<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $suivi = listeEquipe($_SESSION['idEnfantSuivi']);
?>

<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body>  
        <section>
            <a class="boutonRondRetourArriere" href="compteEnfant.php"></a>
            <h1>Equipe</h1>
            <h1 class="connexion enfantNomPrenom animationTitre"><?php echo $enfant[2].' '.$enfant[1];?></h1>
            <div class="espaceBlanc50"></div>
            <h2 class="titreSection">Equipe actuelle</h2>
            <div class="espaceBlanc30"></div>
            <?php
                if($suivi != FALSE){
                    for($i=0; $i<count($suivi); $i++){
                        $membre = rechercheMembreParId($suivi[$i]);
                        echo'
                            <div class="ligneMembreEquipe">
                                <img class="logoMembre" src="../SVG/personne.svg">
                                <p class="sousTitreH1">
                                    '.$membre[1].' <b>'.$membre[0].'</b>
                                </p>
                                <p>
                                    '.roleEquipe($suivi[$i], $_SESSION['idEnfantSuivi']).'
                                </p>
                            </div>
                            <div class="espaceBlanc30"></div>
                        ';
                    }
                }else{
                    echo'
                        <p class="texteFormulaire"> Aucun membre dans cette équipe actuellement<p>
                    ';
                }
            ?>
        </section>
    </body>

    <footer>
    </footer>

</html>
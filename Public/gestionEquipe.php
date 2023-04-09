<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $suivi = listeEquipe($_SESSION['idEnfantSuivi']);
    if(isset($_POST['boutonRecherche'])){
        $listeMembre = rechercheMembreParNom($_POST['nomMembre']);
    }

    if(isset($_POST['boutonAnnule'])){
        suppressionSuivi($_POST['idMembre'], $_SESSION['idEnfantSuivi']);
        header('location:gestionEquipe.php');
    }

    if(isset($_POST['boutonAjout'])){
        $_SESSION['membreCible'] = $_POST['idMembre'];
        header('location:ajoutMembreEquipe');
    }
?>

<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body>  
        <section>
            <a class="boutonRondRetourArriere" href="equipe.php"></a>
            <h1 class="connexion animationTitre">Recherche</h1>    
            <div class="espaceBlanc30"></div>
            <h2 class="titreSection">Ajouter un membre</h2>
            <div class="espaceBlanc10">
            </div>
            <form class="champDeSaisi rechercheEnfant" action="" method="POST">
                <div class="inputChamp recherche">
                    <input type="text" name="nomMembre" placeholder="Recherche nom" value="">
                </div>
                <input type="submit" class="boutonRond recherche" name="boutonRecherche" value="">
            </form>
            <div class="espaceBlanc30"></div>
            <?php
                if(isset($listeMembre) OR isset($membreAjout)){
                    for($i=0; $i<count($listeMembre); $i++){
                        $membre = rechercheMembreParId($listeMembre[$i]);
                        echo'
                            <div class="ligneMembreEquipe">
                            <div class="boiteNomRole">
                                <p class="sousTitreH1 epais">
                                    '.$membre[1].' <b>'.$membre[0].'</b>
                                </p>
                            </div>
                            <form action="" method=POST>
                                <input class="boutonRond valider petit" type="submit" name="boutonAjout" value="">
                                <input type="hidden" name="idMembre" value="'.$listeMembre[$i].'">
                            </form>
                        </div>
                        <div class="espaceBlanc30"></div>
                        ';
                    }
                }
            ?>
            <div class="espaceBlanc30"></div>
            <h2 class="titreSection">Equipe actuelle</h2>
            <div class="espaceBlanc30"></div>
            <?php
                if($suivi != FALSE){
                    for($i=0; $i<count($suivi); $i++){
                        $membre = rechercheMembreParId($suivi[$i]);
                        echo'
                            <div class="ligneMembreEquipe">
                                <img class="logoMembre" src="../SVG/personne.svg">
                                <div class="boiteNomRole">
                                    <p class="sousTitreH1 epais membre">
                                        '.$membre[1].' <b>'.$membre[0].'</b>
                                    </p>
                                    <p class="sousTitreH1 membre">
                                    '.roleEquipe($suivi[$i], $_SESSION['idEnfantSuivi']).'
                                    </p>
                                </div>
                                <form action="" method=POST>
                                    <input class="boutonRond annuler petit" type="submit" name="boutonAnnule" value="">
                                    <input type="hidden" name="idMembre" value="'.$suivi[$i].'">
                                </form>
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

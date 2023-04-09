<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $objectifEnCours = listeObjectifEnCours($_SESSION['idEnfantSuivi']);
    $objectifTermine = listeObjectifTermine($_SESSION['idEnfantSuivi']);
    array_multisort($objectifTermine, SORT_DESC);
    $_SESSION['intituleCreation'] = null;
    if(isset($_POST['boutonDetail'])){
        $_SESSION['objectifEnCours'] = $_POST['valeurId'];
        header('location:ajoutObjectif.php');
    }

    if(isset($_POST['boutonRate'])){
        $_SESSION['objectifEnCours'] = $_POST['valeurId'];
        header('location:objectifEchoue.php');
    }

    if(isset($_POST['boutonReussi'])){
        $_SESSION['objectifEnCours'] = $_POST['valeurId'];
        header('location:objectifReussi.php');
    }
    if(isset($_POST['boutonRetry'])){
        $_SESSION['intituleCreation'] = $_POST['valeurId'];
        header('location:creationObjectif.php');
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
            <a class="boutonRondRetourArriere" href="listeEnfant.php"></a>
            <h1> Objectifs </h1>
            <div class="espaceBlanc10"></div>
            <h2 class="nomPrenomEnfant"><?php echo $enfant[2].' '.$enfant[1];?></h2>
            <div class="espaceBlanc30"></div>
            <div class="boutonCreationObjectif">
                <a class="lienCache" href="creationObjectif.php"></a>
                <p class="creationObjectif">Formuler une demande de création d'objectif</p>
                <img class="creationObjectif" src="../SVG/creationObjectif.svg">
            </div>
            <div class="espaceBlanc30"></div>
            <h2 class="titreSection">En cours</h2>
            <div class="espaceBlanc50"></div>
            <?php
                if($objectifEnCours == FALSE){
                    echo'
                        <p>Aucun objectif en cours</p>
                    ';
                }else{
                    for($i=0; $i<count($objectifEnCours); $i++){
                        $objectifCours = rechercheObjectif($objectifEnCours[$i]);
                        $nombreJeton = nombreJetonObjectif($objectifEnCours[$i]);
                        $nombreJetonActuel = $nombreJeton-1;
                        if(nombreJetonObjectif($objectifEnCours[$i]) != FALSE){
                            $jetonObjectifEnCours = listeJetonPourObjectif($objectifEnCours[$i]);
                            array_multisort($jetonObjectifEnCours[0], SORT_ASC);
                            echo'
                            <div class="boitePresentationObjectif">
                                    <form class ="oeilFormulaire" action="" method=POST>
                                        <input name="valeurId" type="hidden" value="'.$objectifEnCours[$i].'">
                                        <input class="oeilRond" type="submit" name="boutonDetail" value="">
                                    </form>   
                                    <img class="etatObjectif" src="../SVG/etatEnCours.svg">
                                    <div class="boiteSectionObjectif titreObjectif">
                                        <div class="titreObjectifDuree">
                                            <h1 class="titreObjectifListe">'.$objectifCours[0].'</h1>
                                            <p class="etatDureeObjectif rouge">'.conversionDureeTexte($tempRestant).'</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="espaceBlanc30"></div>
                            ';
                        }else{
                            echo'
                            <div class="boitePresentationObjectif">
                                    <form class ="oeilFormulaire" action="" method=POST>
                                        <input name="valeurId" type="hidden" value="'.$objectifEnCours[$i].'">
                                        <input class="oeilRond" type="submit" name="boutonDetail" value="">
                                    </form>   
                                    <img class="etatObjectif" src="../SVG/etatObjectifPasCommence.svg">
                                    <div class="boiteSectionObjectif titreObjectif">
                                        <div class="titreObjectifDuree">
                                            <h1 class="titreObjectifListe">'.$objectifCours[0].'</h1>
                                            <p class="etatDureeObjectif">Non commencé</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="espaceBlanc30"></div>
                            ';
                        }
                        echo'
                            <div class="espaceBlanc50"></div>
                        ';
                    }
                }
            ?>
            <div class="espaceBlanc50"></div>
            <h2 class="titreSection">Terminés</h2>
            <div class="espaceBlanc50"></div>
            <?php
                if($objectifTermine == FALSE){
                    echo'
                        <p>Aucun objectif terminé</p>
                    ';
                }else{
                    for($i=0; $i<count($objectifTermine); $i++){
                        $termine = rechercheObjectif($objectifTermine[$i]);
                        if($termine[4] == 1){
                            echo'
                            <div class="boitePresentationObjectif">
                                    <form class ="oeilFormulaire" action="" method=POST>
                                        <input name="valeurId" type="hidden" value="'.$objectifTermine[$i].'">
                                        <input class="oeilRond" type="submit" name="boutonReussi" value="">
                                    </form> 
                                    <form class ="retry" action="" method=POST>
                                        <input name="valeurId" type="hidden" value="'.$objectifTermine[$i].'">
                                        <input class="boutonRetry" type="submit" name="boutonRetry" value="">
                                    </form>   
                                    <img class="etatObjectif" src="../SVG/boutonRondValider.svg">
                                    <div class="boiteSectionObjectif titreObjectif">
                                        <div class="titreObjectifDuree">
                                            <h1 class="titreObjectifListe">'.$termine[0].'</h1>
                                            <p class="etatDureeObjectif">'.conversionDureeFini(conversionDureeHeure($termine[3])).'</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="espaceBlanc30"></div>
                            ';
                            echo'
                                <div class="espaceBlanc50"></div>
                            ';
                        }else{
                            echo'
                            <div class="boitePresentationObjectif">
                                    <form class ="oeilFormulaire" action="" method=POST>
                                        <input name="valeurId" type="hidden" value="'.$objectifTermine[$i].'">
                                        <input class="oeilRond" type="submit" name="boutonRate" value="">
                                    </form>   
                                    <form class ="retry" action="" method=POST>
                                        <input name="valeurId" type="hidden" value="'.$objectifTermine[$i].'">
                                        <input class="boutonRetry" type="submit" name="boutonRetry" value="">
                                    </form> 
                                    <img class="etatObjectif" src="../SVG/boutonAnnuler.svg">
                                    <div class="boiteSectionObjectif titreObjectif">
                                        <div class="titreObjectifDuree">
                                            <h1 class="titreObjectifListe">'.$termine[0].'</h1>
                                            <p class="etatDureeObjectif">'.conversionDureeFini(conversionDureeHeure($termine[3])).'</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="espaceBlanc30"></div>
                            ';
                            echo'
                                <div class="espaceBlanc50"></div>
                            ';
                        }
                        
                        }
                        
                }
            ?>
        </section>
    </body>

    <footer>
    </footer>

</html>
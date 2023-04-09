<?php
    session_start();
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    include '../PHP/fonction.php';
    $objectifTermineUniqueTableau = [];
    if(isset($_POST['objectifRecherche'])){
        $objectifTermineUniqueListe = listeObjectifParNom($_POST['objectifRecherche']);
        array_push($objectifTermineUniqueTableau, $objectifTermineUniqueListe[0]);
        $objectifTermineUnique = $objectifTermineUniqueTableau;
    }else{ 
        $objectifTermineUnique = listeObjectifTermineUnique($_SESSION['idEnfantSuivi']);
    }
    $objectifTermine = listeObjectifTermine($_SESSION['idEnfantSuivi']);
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $compteurValide = 0;
    $compteurInvalide = 0;
    if($objectifTermine != FALSE){
        for($i=0; $i<count($objectifTermine); $i++){
            $termine = rechercheObjectif($objectifTermine[$i]);
            if($termine[4] == 1){
                $compteurValide += 1;
            }else{
                $compteurInvalide += 1;
            }
        }
        $moyenne = round(($compteurValide / count($objectifTermine)) * 100, 1);
    }else{
        $moyenne = 0;
        $compteurInvalide = 0;
        $compteurValide = 0;
    }
    
    if(isset($_POST['boutonDetail'])){
        $_SESSION['intituleObjectif'] = $_POST['intituleObjectif'];
        header('location:detailStatistique');
    }
    
?>
<!doctype html>
<html lang="fr">
    
    <?php
    
        require '../Extension/header.php';
        require '../Extension/head.html';
    ?>

    <body>  
        <section>
            <a class="boutonRondRetourArriere" href="compteEnfant.php"></a>
            <h1 class="connexion">Statistiques</h1>
            
            <?php
                echo'
                    <h2 class="nomPrenomEnfant">'.$enfant[2].' <b>'.$enfant[1].'</b></h2>
                    <div class="espaceBlanc30"></div>
                    <h2 class="titreSection">Tous les objectifs</h2>
                    <h2 class="moyenne">'.$moyenne.' %</h2>
                    <h2 class="sousTitreMoyenne">de réussite</h2>
                    <div class="espaceBlanc10"></div>
                    <div class="progressbar-wrapper">
                        <div title="downloaded" class="progressbar" value="'.$moyenne.'" id="barre"></div>
                    </div>
                    <div class="espaceBlanc10"></div>
                    <h2 class="nomPrenomEnfant compteur">'.$compteurValide.' réussis - '.$compteurInvalide.' non terminés</h2>
                    <div class="espaceBlanc30"></div>
                    <h2 class="titreSection">Cas par cas</h2>
                    <div class="espaceBlanc10">
                    </div>
                    <form class="champDeSaisi rechercheEnfant" action="" method="POST">
                        <div class="inputChamp recherche">
                            <input type="text" name="objectifRecherche" placeholder="Recherche" value="">
                        </div>
                        <input type="submit" class="boutonRond recherche" name="boutonRecherche" value="">
                    </form>
                    <div class="espaceBlanc50"></div>
                ';
                if($objectifTermineUnique != FALSE){
                    for($i=0; $i<count($objectifTermineUnique); $i++){
                        $objectifCours = rechercheObjectif($objectifTermineUnique[$i]);
                        $listeTitre = listeObjectifParNom($objectifCours[0]);
                        $compteurValideListe = 0;
                        for($j=0; $j<count($listeTitre); $j++){
                            $termineListe = rechercheObjectif($listeTitre[$j]);
                            if($termineListe[4] == 1){
                                $compteurValideListe += 1;
                            }
                        }
                        $moyenneUnique = round(($compteurValideListe / count($listeTitre)) * 100, 1);
                        array_multisort($listeTitre, SORT_DESC);
                            echo'
                            <div class="boitePresentationObjectif statistiques">
                                    <form class ="oeilFormulaire" action="" method=POST>
                                        <input type="hidden" value="'.$objectifCours[0].'" name="intituleObjectif">
                                        <input class="oeilRond" type="submit" name="boutonDetail" value="">
                                    </form>   
                                    <div class="etatObjectif">
                                        '.count($listeTitre).'
                                    </div>
                                    <div class="boiteSectionObjectif titreObjectif">
                                        <div class="titreObjectifDuree statistiques">
                                            <h1 class="titreObjectifListe">'.$objectifCours[0].'</h1>
                                            <p><b>'.$moyenneUnique.' %</b> de réussite</p>
                                            <div class="lignePointObjectif">
                                                ';
                                                for($h=0; $h<count($listeTitre) AND $h <5; $h++){
                                                    $objectifEtatRond = rechercheObjectif($listeTitre[$h]);
                                                    if($objectifEtatRond[4]==1){
                                                        echo'
                                                             <div class="rondObjectifStatistique">
                                                            </div>
                                                        ';
                                                    }else{
                                                        echo'
                                                             <div class="rondObjectifStatistique rouge">
                                                            </div>
                                                        ';
                                                    }
                                                }

                            echo'
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="espaceBlanc50"></div>
                            ';
                        }
                        echo'
                            <div class="espaceBlanc50"></div>
                        ';
                }
            ?>
                
        </section>
    </body>
    
    <footer>
    </footer>
    <script src="../JS/progressBar.js"></script>
</html>

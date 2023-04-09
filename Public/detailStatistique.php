<?php
 session_start();
 if(!isset($_SESSION['id'])){
     header('location:index.php');
 }
 include '../PHP/fonction.php'; 
 $objectifTermineUniqueTableau = [];
 $objectifTermineUnique = listeObjectifParNom($_SESSION['intituleObjectif']);
 $compteurValideListe = 0;
 $compteurValide = 0;
 $compteurInvalide = 0;
 for($i=0; $i<count($objectifTermineUnique); $i++){
    $termine = rechercheObjectif($objectifTermineUnique[$i]);
    if($termine[4] == 1){
        $compteurValide += 1;
    }else{
        $compteurInvalide += 1;
    }
}
 for($i=0; $i<count( $objectifTermineUnique); $i++){
    $termineListe = rechercheObjectif( $objectifTermineUnique[$i]);
    if($termineListe[4] == 1){
        $compteurValideListe += 1;
    }
}
 $moyenneUnique = round(($compteurValideListe / count($objectifTermineUnique)) * 100, 1);
 $objectif = rechercheObjectif($objectifTermineUnique[0]);
?>

<!doctype html>
<html lang="fr">
    
    <?php
    
        require '../Extension/header.php';
        require '../Extension/head.html';
    ?>

    <body>  
        <section>
            <a class="boutonRondRetourArriere" href="statistique.php"></a>
            <h1 class="connexion">Statistiques</h1>
            
            <?php
                echo'
                    <h2 class="nomPrenomEnfant">'.$_SESSION['intituleObjectif'].'</b></h2>
                    <div class="espaceBlanc30"></div>
                    <img class="imageRecompenseObjectif" id="afficheImage" src="'.$objectif[1].'">
                    <div class="espaceBlanc30"></div>
                    <h2 class="titreSection">Tous les objectifs</h2>
                    <h2 class="moyenne">'.$moyenneUnique.' %</h2>
                    <h2 class="sousTitreMoyenne">de réussite</h2>
                    <div class="espaceBlanc10"></div>
                    <div class="progressbar-wrapper">
                        <div title="downloaded" class="progressbar" value="'.$moyenneUnique.'" id="barre"></div>
                    </div>
                    <div class="espaceBlanc10"></div>
                    <h2 class="nomPrenomEnfant compteur">'.$compteurValide.' réussis - '.$compteurInvalide.' non terminés</h2>
                    <div class="espaceBlanc30"></div>
                    <label class="labelChampDeSaisi"> Résultats des dernières tentatives</label>     
                    <div class="espaceBlanc10"></div> 
                    <div class="lignePointObjectif">               
                ';
                for($h=0; $h<count($objectifTermineUnique) AND $h <5; $h++){
                    $objectifEtatRond = rechercheObjectif($objectifTermineUnique[$h]);
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
                    <div class="espaceBlanc100"></div>
                    <div class="boiteProgressBar">
                        <div class="progressbar-wrapper hauteur">
                            <div title="bleu" class="progressbar" value="80" id="barreTempsRequis"></div>
                        </div>

                        <div class="progressbar-wrapper hauteur">
                            <div title="orange" class="progressbar" value="20" id="barreTempsRequis2"></div>
                        </div>
                    </div>
                ';

                ?>
        </section>
</body>
<footer>
    </footer>
    <script src="../JS/progressBar.js"></script>
    <script src="../JS/barreVerticale.js"></script>
</html>
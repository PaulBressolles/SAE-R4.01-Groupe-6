<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $recompense = recuperationToutesRecompenses();
    $_SESSION['objectifEnCours'] = rechercheObjectifAjout($_SESSION['titreObjectifEnCours'], $_SESSION['idEnfantSuivi'], $_SESSION['id']);
    if(isset($_POST['boutonRecompense'])){
        $idRecompense = recompenseParImage($_POST['lienImage']);
        lierRecompenseObjectif($_SESSION['objectifEnCours'], $idRecompense);
        if($_SESSION['coordinateur'] == 1){
            header('location:objectif.php');
        }else{
            header('location:demandeEnvoye.php');
        }
            
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
            <a class="boutonRondRetourArriere" href="objectif.php"></a>
            <div class="espaceBlanc30"></div>
            <h1> Récompense </h1>
            <div class="espaceBlanc10"></div>
            <p class="sousTitreH1 epais">Choisir une récompense pour<br><b><?php echo $enfant[2].' '.$enfant[1];?></b></p>
            <div class="espaceBlanc30"></div>
            <form class="creationObjectifFormulaire" onsubmit="recuperationValeur()" id="formulaireHoraire" method="POST" action="">	
                <label class="labelChampDeSaisi"> Choix de la récompense : </label> 
                <div class="espaceBlanc10"></div>
                <div class="ajoutImage">
                    <a class="boutonAjoutImage recompense"></a>
                    <img class="imageRecompense" id="afficheImage" src="">
                </div>
                <div class="espaceBlanc50"></div>
                <input type="hidden" name="lienImage" id="lienImage" value="">
                <input type="submit" name="boutonRecompense" value="Valider">
    	    </form> 
            <div class="overlayJS">
                <div class="espaceBlanc30"></div>
                <h2 class="titreSection">Choix de l'image</h2>
                <div class="choixImage objectif recompense">
                <?php
                    for($i=0; $i<count($recompense); $i++){
                        $recompenseEnCours = recompenseParId($recompense[$i]);
                        echo'   
                            <div class="boiteObjectifRecompense">
                                <img class="imageObjectif" src="'.$recompenseEnCours[1].'">
                                <div class="espaceBlanc10"></div>
                                <p class="televerserFichier">'.$recompenseEnCours[0].'</p>
                                <button id="boutonCache" name="boutonCache" class="boutonCacheRecompense" onclick="recuperation(`'.$recompenseEnCours[1].'`)"></button>
                            </div> 
                        ';
                    }
                ?>
                <div class="espaceBlanc50"></div>
                </div>
            </div>
        </section>
    </body>

    <footer>
    </footer>
    <script src="../JS/recupSVG.js"></script>
</html>
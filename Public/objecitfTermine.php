<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $recompense = recuperationToutesRecompenses();
    if(isset($_POST['boutonObjectifDemande'])){
        demandeCreationObjectif($_SESSION['id'], $_SESSION['idEnfantSuivi'], $_POST['titreObjectif'], $_POST['valeurJetonCache'], $_POST['valeurSemaineCache'], $_POST['valeurJourCache'], $_POST['valeurHeureCache']);

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
            <h1> Objectifs </h1>
            <div class="espaceBlanc10"></div>
            <p class="sousTitreH1 epais">Création d'objectif pour<br><b><?php echo $enfant[2].' '.$enfant[1];?></b></p>
            <div class="espaceBlanc50"></div>
            <form class="creationObjectifFormulaire" onsubmit="recuperationValeur()" id="formulaireHoraire" method="POST" action="">	
                <div class="champDeSaisi">
                    <div class="inputChamp">
                        <input type="text" name="titreObjectif" placeholder="Titre de l'objectif" value="">
                    </div>
                </div>
                <div class="espaceBlanc30"></div>
                <label class="labelChampDeSaisi"> Nombre de jetons : </label> 
                <div class="espaceBlanc10"></div>
                <div class="boiteChoix">
                    <input class="boutonPlusMoins" type="button" value="-" id="button-1" onclick="valeurJetons(-1)"/>
                    <div class="champNombrePlusMoins">
                        <span id="nombreJeton"></span>
                    </div>
                    <input class="boutonPlusMoins" type="button" value="+" id="button-2" onclick="valeurJetons(1)"/>
                </div>
                <div class="espaceBlanc30"></div>
                <label class="labelChampDeSaisi"> Choix de la récompense : </label> 
                <div class="espaceBlanc10"></div>
                <div class="ajoutImage">
                    <a class="boutonAjoutImage recompense"></a>
                    <img class="imageRecompense" id="afficheImage" src="">
                </div>
                <div class="espaceBlanc30"></div>
                <label class="labelChampDeSaisi"> Durée : </label> 
                <div class="espaceBlanc10"></div>
                <div class="petitCentre">
                <p>Semaine</p>
                </div>

                <div class="boiteChoix">
                    <input class="boutonPlusMoins" type="button" value="-" id="button-1" onclick="valeurSemaines(-1) "/>
                    <div class="champNombrePlusMoins">
                        <span id="nombreSemaine"></span>
                    </div>
                    <input class="boutonPlusMoins" type="button" value="+" id="button-2" onclick="valeurSemaines(1) "/>
                </div>
                <div class="espaceBlanc30"></div>

                <div class="petitCentre">
                    <p>Jour</p>
                </div>

                <div class="boiteChoix">
                    <input class="boutonPlusMoins" type="button" value="-" id="button-1" onclick="valeurJours(-1) "/>
                    <div class="champNombrePlusMoins">
                        <span id="nombreJour"></span>
                    </div>
                    <input class="boutonPlusMoins" type="button" value="+" id="button-2" onclick="valeurJours(1) "/>
                </div>
                <div class="espaceBlanc30"></div>

                <div class="petitCentre">
                    <p>Heure</p>
                </div>

                <div class="boiteChoix">
                    <input class="boutonPlusMoins" type="button" value="-" id="button-1" onclick="valeurHeures(-1) "/>
                    <div class="champNombrePlusMoins">
                        <span id="nombreHeure" name="nombreHeure"></span>
                    </div>
                    <input class="boutonPlusMoins" type="button" value="+" id="button-2" onclick="valeurHeures(1) "/>
                </div>
                <div class="espaceBlanc50"></div>
            
                <input type="hidden" name="valeurHeureCache" id="valeurHeureCache" value="">
                <input type="hidden" name="valeurJourCache" id="valeurJourCache" value="">
                <input type="hidden" name="valeurSemaineCache" id="valeurSemaineCache" value="">
                <input type="hidden" name="valeurJetonCache" id="valeurJetonCache" value="">
                <input type="hidden" name="idRecompenseChoisi" id="idRecompenseChoisi" value="">
                <input type="submit" name="boutonObjectifDemande" value="Valider">
    	    </form> 
            <div class="overlayJS">
                <div class="espaceBlanc30"></div>
                <?php
                    for($i=0; $i<count($recompense); $i++){
                        $recompenseEnCours = recompenseParId($recompense[$i]);
                        echo'
                            <div class="presentationRecompense">
                                    <img class="recompenseChoix" src="'.$recompenseEnCours[1].'">
                                    <div class="espaceBlanc10"></div>
                                    <p>'.$recompenseEnCours[0].'</p>
                                    <button id="boutonCache" name="boutonCache" class="boutonCacheRecompense" onclick="recuperationRecompense(`'.$recompenseEnCours[1].'`,'.$recompense[$i].')"></button>
                            </div>
                            <div class="espaceBlanc30"></div>
                            
                        ';
                    }
                ?>
            </div>
        </section>
    </body>

    <footer>
    </footer>
    <script src="../JS/poppup.js"></script>
    <script src="../JS/boutonPlusOuMoins.js"></script>
</html>
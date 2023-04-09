<?php
    session_start();
    include '../PHP/fonction.php';
    $logMessage = '<p class="sousTitreH1"> Veuillez renseigner vos informations </p>';
    $erreurPrenom = FALSE;
    $erreurNom = FALSE;
    $prenom = "";
    $nom = "";
    if (isset($_POST['boutonDemande'])){
        $prenom = $_POST['prenomEnfant'];
        $nom = $_POST['nomEnfant'];
        if (!empty($_POST['prenomEnfant']) && !empty($_POST['nomEnfant']) && !empty($_POST['fonction'])){
            $enfant = rechercheEnfantNomPrenom($_POST['nomEnfant'], $_POST['prenomEnfant']);
            if($enfant != FALSE){
                if(demandeSuivi($_SESSION['id'], $enfant, $_POST['fonction']) == TRUE){
                    notificationCoordinateur($_SESSION['id'], "demandeSuivi", "NULL", $enfant);
                    header('location:demandeEnvoye.php');
                }else{
                    $logMessage = '<p class="sousTitreH1 rouge"> Aucun enfant n a pu être trouvé ou une demande est déja en cours </p>';
                }
            }
        }else{
            $erreurPrenom = TRUE;
            $erreurNom = TRUE; 
            $logMessage = '<p class="sousTitreH1 rouge"> Veillez à renseigner tout <b>les champs</b> </p>';
        }
    }
?>
<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
    ?>

    <header>
        <div class="ombreVague">
        </div>
        <div class="fondVague">
        </div>
    </header>

    <body class="pageUnique">  
        <section class="sectionUnique">
            <a class="boutonRondRetourArriere" href="accueil.php"></a>
            <h1 class="connexion">Suivi</h1>
            <?php echo $logMessage ?>
            <div class="espaceBlanc30"></div>
            <form action="" method="POST">
                <?php
                    if($erreurPrenom == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" name="prenomEnfant" placeholder="Prénom" value="'.$prenom.'">
                                    <div class="croixRouge">
                                        <img class="croix" src="../SVG/croixRouge.svg">
                                    </div>
                                </div>   
                            </div>
                        ';
                    }else{
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp">
                                    <input type="text" name="prenomEnfant" placeholder="Prénom" value="'.$prenom.'">
                                </div>
                            </div>
                        ';
                    }

                    if($erreurNom == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" name="nomEnfant" placeholder="Nom" value="'.$nom.'">
                                    <div class="croixRouge">
                                        <img class="croix" src="../SVG/croixRouge.svg">
                                    </div>
                                </div>   
                            </div>
                        ';
                    }else{
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp">
                                    <input type="text" name="nomEnfant" placeholder="Nom" value="'.$nom.'">
                                </div>
                            </div>
                        ';
                    }
                    
                    
                ?>    
                <div class="espaceBlanc10"></div>
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
                <div class="espaceBlanc30"></div>
                <div class="boutonValidation">
                    <input type="submit" name="boutonDemande" value="Demande">
                </div>
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

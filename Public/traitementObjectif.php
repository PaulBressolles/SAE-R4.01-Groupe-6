<?php
    session_start();
    include '../PHP/fonction.php';
    if($_SESSION['coordinateur'] != 1){
        header('location:index.php');
    }
    $notification = informationNotification($_SESSION['notificationEnCours']);
    $idObjectif = objectifNotification($notification[4], $notification[2]);
    $objectif = rechercheObjectif($idObjectif[0]);
    if(isset($_POST['boutonAnnule'])){
        supprimeObjectif($idObjectif[0]);
        notificationMembre($notification[0],"demandeObjectif", $objectif[0], $notification[4], 0);
        supprimeNotification($_SESSION['notificationEnCours']);
        header('location:notificationObjectif.php');
    }

    if(isset($_POST['boutonValide'])){
        $notification = informationNotification($_SESSION['notificationEnCours']);
        validationObjectif($idObjectif[0]);
        notificationMembre($notification[0],'demandeObjectif', $objectif[0], $notification[4], 1);
        supprimeNotification($_SESSION['notificationEnCours']);
        header('location:notificationObjectif.php');
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
            <a class="boutonRondRetourArriere" href="notificationObjectif.php"></a>
            <h1 class="headerTitre animationTitre">Création d'objectif</h1>
            <div class="espaceBlanc30"></div>
            
            <?php
                    $notification = informationNotification($_SESSION['notificationEnCours']);
                    $enfant = rechercheEnfantId($notification[4]);
                    $membre = rechercheMembreParId($notification[0]);
                    $suivi = roleEquipe($notification[0], $notification[4]);
                    echo'
                        <div class="contenuNotification">
                            <div class="espaceBlanc10"></div>
                            <p><b>'.$membre[1].' '.$membre[0].'</b></h4>
                            <div class="espaceBlanc10"></div>
                            <p>'."Souhaite créer un objectif pour :".'</p>
                            <div class="espaceBlanc10"></div>
                            <p class="televerserFichier grand"><b>'.$enfant[2].' '.$enfant[1].'</b></p>
                            <div class="espaceBlanc10"></div>
                        </div> 
                        <div class="espaceBlanc30"></div>
                        <h1 class="titreObjectif grand">'.$objectif[0].'</h1>
                        <div class="espaceBlanc10"></div>
                        <div class ="compteurNombreJeton">
                            <img class="etatObjectif image" src="'.$enfant[4].'">
                            <p class="compteurJeton"><b>'.$objectif[2].' jetons</b></p>
                        </div>
                        
                    ';
                    $compteur = 0;
                    echo'<div class="boiteCompteurJeton">';
				    echo'<div class="ligneCompteurJeton">';
                    for ($i = 0; $i < $objectif[2]; $i++) {
                        if($i % 5 == 0 AND $i != 0){
                          echo'
                              </div>
                              <div class="ligneCompteurJeton">
                          ';
                          if($compteur > 0){
                               echo '<div class="imageJetonCompteur">
                                        <img class="logoCompteur" src="'.$enfant[4].'" alt="Image attente"/>
                                    </div>
                              ';
                                $compteur -= 1;
                          }else{
                                echo '<div class="imageJetonCompteur">
                                          <img class="logoCompteur noirBlanc" src="'.$enfant[4].'" alt="Image attente"/>
                                    </div>
                              ';
                          }
                        }else{
                          if($compteur > 0){
                                echo '<div class="imageJetonCompteur '.$commence.'">
                                        <img class="logoCompteur" src="'.$enfant[4].'" alt="Image attente"/>
                                    </div>
                              ';
                                $compteur -= 1;
                          }else{
                                echo '<div class="imageJetonCompteur">
                                        <img class="logoCompteur noirBlanc" src="'.$enfant[4].'" alt="Image attente"/>
                                    </div>
                              ';
                          }
                        }
                  }
                  echo'</div></div>';
                  echo'
                        <div class="espaceBlanc30"></div>
                        <label class="labelChampDeSaisi">Durée initiale : <b>'.conversionDureeFini(conversionDureeHeure($objectif[3])).'</b></label> 
                        <div class="espaceBlanc30"></div>
                            <img class="imageRecompenseObjectif" id="afficheImage" src="'.$objectif[1].'">
                    ';
            ?>
            <div class="espaceBlanc100"></div>
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
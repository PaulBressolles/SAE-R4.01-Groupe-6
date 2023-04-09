<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }

    if(isset($_POST['traite'])){
        supprimeNotification($_POST['idNotification']);
        header('location:notificationMembre.php');
    }
    $notificationObjectif = 0;
?>

<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body>  
        <section>
            <a class="boutonRondRetourArriere" href="accueil.php"></a>
            <h1 class="petit animationTitre">Notifications</h1>
            <h2 class="titreSection">Réponses</h2>
            <div class="espaceBlanc30"></div>
            <?php
                    $notification = listeNotificationMembre($_SESSION['id']);
                    if($notification != FALSE){  
                        for($i=0; $i<count($notification); $i++){
                                $enfant = rechercheEnfantId($notification[$i][4]);
                                $membre = rechercheMembreParId($notification[$i][0]);
                                if($notification[$i][3] == 0){
                                    $etat = "refusé";
                                    $reponse = "boutonAnnuler.svg";
                                }else{
                                    $etat = "accepté";
                                    $reponse = "boutonRondValider.svg";
                                }
                                if($notification[$i][1]=="demandeSuivi"){
                                    echo'
                                    
                                    <div class="contenuNotification membre">
                                        <img class="reponseNotification" src="../SVG/'.$reponse.'">
                                        <div class="espaceBlanc30"></div>
                                        <p class="televerserFichier grand"><b>'.$enfant[2].' '.$enfant[1].'</b></p>
                                        <div class="espaceBlanc10"></div>
                                        <p class="sousTitreH1 membre">'."Votre demande de suivi a été <b>".$etat.'</b></p>
                                        <div class="espaceBlanc10"></div>
                                        <form class="choixSuiviObjectif" action="" method=POST>
                                            <input type="submit" class="traiter" name="traite" value="Lu">
                                            <input type="hidden" value="'.$notification[$i][5].'" name="idNotification">
                                        </form>
                                    </div>
                                    <div class="espaceBlanc50"></div>
                                ';
                                }elseif($notification[$i][1]=="demandeObjectif"){
                                    echo'
                                    
                                    <div class="contenuNotification membre">
                                        <img class="reponseNotification" src="../SVG/'.$reponse.'">
                                        <div class="espaceBlanc30"></div>
                                        <p class="televerserFichier grand"><b>'.$enfant[2].' '.$enfant[1].'</b></p>
                                        <div class="espaceBlanc10"></div>
                                        <p class="sousTitreH1 membre">'."Votre demande d'objectif a été <b>".$etat.'</b></p>
                                        <div class="espaceBlanc10"></div>
                                        <form class="choixSuiviObjectif" action="" method=POST>
                                            <input type="submit" class="traiter" name="traite" value="Lu">
                                            <input type="hidden" value="'.$notification[$i][5].'" name="idNotification">
                                        </form>
                                    </div>
                                    <div class="espaceBlanc50"></div>
                                ';
                                }
                        }
                    }else{
                        echo'
                            <p> Aucune notification actuellement.</p>
                        ';
                    }
            ?>
        </section>
    </body>

    <footer>
    </footer>

</html>
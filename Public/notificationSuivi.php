<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    
    if(isset($_POST['objectif'])){
        header('location:notificationObjectif.php');
    }

    if(isset($_POST['traite'])){
        $_SESSION['notificationEnCours'] = $_POST['idNotification'];
        header('location:traitementSuivi.php');
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
            
            <?php
                if($_SESSION['coordinateur'] == 1){
                    echo'
                        <form class="choixSuiviObjectif" action="" method=POST>
                            <div class="boutonNotificationChoix">
                                <input type="submit" class="choixNotification gauche actif" value="Suivi" name="suivi">
                                <input type="submit" class="choixNotification droite " value="Objectif" name="objectif">
                            </div>
                        </form>           
                    ';
                    $notification = listeNotificationMembre($_SESSION['id']);
                    if($notification != FALSE){  
                        for($i=0; $i<count($notification); $i++){
                            if($notification[$i][1]=="demandeSuivi"){
                                $enfant = rechercheEnfantId($notification[$i][4]);
                                $membre = rechercheMembreParId($notification[$i][0]);
                                echo'
                                    <h4 class="titreMembreDemande">'.$membre[1].' '.$membre[0].'</h4>
                                    <div class="contenuNotification">
                                        <div class="espaceBlanc10"></div>
                                        <p>Demande de suivi pour :</p>
                                        <div class="espaceBlanc10"></div>
                                        <p class="televerserFichier grand"><b>'.$enfant[2].' '.$enfant[1].'</b></p>
                                        <div class="espaceBlanc30"></div>
                                        <form class="choixSuiviObjectif" action="" method=POST>
                                            <input type="submit" class="traiter" name="traite" value="Traiter">
                                            <input type="hidden" value="'.$notification[$i][5].'" name="idNotification">
                                        </form>
                                    </div>
                                    <div class="espaceBlanc30"></div>
                                    
                                ';
                                // var_dump($enfant);
                                // var_dump($membre);
                            }else{
                                $notificationObjectif = 1;
                            }
                        }
                    }else{
                        echo'
                            <p> Aucune demande de suivi actuellement.</p>
                        ';
                    }
                    if($notification != FALSE AND $notificationObjectif == 1){
                        echo'
                            <p class="televerserFichier">'."Vous avez des demandes de création d'objectifs".'</p>
                        ';
                    }
                }  
            ?>
        </section>
    </body>

    <footer>
    </footer>

</html>
<?php
    session_start();
    include '../PHP/fonction.php';
    if($_SESSION['coordinateur'] != 1){
        header('location:index.php');
    }
    if(isset($_POST['boutonAnnule'])){
        $notification = informationNotification($_SESSION['notificationEnCours']);
        suppressionSuivi($notification[0], $notification[4]);
        notificationMembre($notification[0],"demandeSuivi", "", $notification[4], 0);
        supprimeNotification($_SESSION['notificationEnCours']);
        header('location:notificationSuivi.php');
    }

    if(isset($_POST['boutonValide'])){
        $notification = informationNotification($_SESSION['notificationEnCours']);
        validationSuivi($notification[0], $notification[4]);
        notificationMembre($notification[0],"demandeSuivi", "", $notification[4], 1);
        supprimeNotification($_SESSION['notificationEnCours']);
        header('location:notificationSuivi.php');
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
            <a class="boutonRondRetourArriere" href="notificationSuivi.php"></a>
            <h1 class="headerTitre animationTitre">Demande de suivi</h1>
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
                            <p>'."Souhaite rejoindre l'équipe de l'enfant suivant :".'</p>
                            <div class="espaceBlanc10"></div>
                            <p class="televerserFichier grand"><b>'.$enfant[2].' '.$enfant[1].'</b></p>
                            <div class="espaceBlanc10"></div>
                            <p>En tant que :</p>
                            <div class="espaceBlanc10"></div>
                            <p class="televerserFichier grand"><b>'.$suivi.'</b></p>
                        </div> 
                        <div class="espaceBlanc30"></div>
                        <h2 class="titreSection">Equipe actuelle</h2>
                        <div class="espaceBlanc30"></div>
                        ';
                            $suiviEquipe = listeEquipe($notification[4]);
                            if($suiviEquipe != FALSE){
                                for($i=0; $i<count($suiviEquipe); $i++){
                                    $membreEquipe = rechercheMembreParId($suiviEquipe[$i]);
                                    echo'
                                        <div class="ligneMembreEquipe">
                                            <img class="logoMembre" src="../SVG/personne.svg">
                                            <p class="sousTitreH1">
                                                '.$membreEquipe[1].' <b>'.$membreEquipe[0].'</b>
                                            </p>
                                            <p>
                                                '.roleEquipe($suiviEquipe[$i], $notification[4]).'
                                            </p>
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
<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    if($_SESSION['coordinateur'] == 1){
        $enfantSuivi = ensembleEnfants();
    }else{
        $enfantSuivi = enfantSuivi($_SESSION['id']);
    }
    if(isset($_POST['boutonRecherche']) AND isset($_POST['nomEnfant'])){
        $enfantSuivi = rechercheEnfantSuiviParNom($_POST['nomEnfant'], $_SESSION['id'], $_SESSION['coordinateur']);
    }
    if(isset($_POST['boutonListe'])){
        header('location:listeEnfant.php');
    }
    if(isset($_POST['boutonSuivi'])){
        header('location:demandeSuivi.php');
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
            <a class="boutonRondRetourArriere" href="accueil.php"></a>
            <h1 class="connexion animationTitre">Recherche</h1>    
            <?php
                if($enfantSuivi  != FALSE ){
                    echo'
                        <div class="espaceBlanc10">
                        </div>
                        <form class="champDeSaisi rechercheEnfant" action="" method="POST">
                            <div class="inputChamp recherche">
                                <input type="text" name="nomEnfant" placeholder="Recherche nom" value="">
                            </div>
                            <input type="submit" class="boutonRond recherche" name="boutonRecherche" value="">
                        </form>
                    ';
                    for($i=0; $i<count($enfantSuivi); $i++){
                        $enfant = rechercheEnfantId($enfantSuivi[$i]);
                        $nombreObjectif = nombreObjectifEnCours($enfantSuivi[$i]);
                        if($nombreObjectif == 1){
                            $objectif = "<b>".$nombreObjectif."</b> objectif en cours";
                        }elseif($nombreObjectif > 1){
                            $objectif = "<b>".$nombreObjectif."</b> objectifs en cours";
                        }else{
                            $objectif = "aucun objectif en cours";
                        }
                        if(isset($_POST['boutonCompte'])){
                            $_SESSION['idEnfantSuivi'] = $_POST['valeurId'];
                            header('location:compteEnfant.php');
                        }
                        if(isset($_POST['boutonObjectif'])){
                            $_SESSION['idEnfantSuivi'] = $_POST['valeurId'];
                            header('location:objectif.php');
                        }
                        echo'
                            <div class="espaceBlanc30">
                            </div>
                            <div class="enfantListe">
                                <div class="enfantListeNom">
                                    <h2 class="nomPrenomEnfant">'.$enfant[2].' <b>'.$enfant[1].'</b><h2>
                                    <p>'.$objectif.'</p>
                                </div>
                                <form class ="enfantListeChoix" action="" method=POST>
                                    <input name="valeurId" type="hidden" value="'.$enfantSuivi[$i].'">
                                    <input class="boutonAfficherCompte" type="submit" name="boutonCompte" value="Compte">
                                    <input  class ="boutonAfficherObjectif" type="submit" name="boutonObjectif" value="Objectif">
                                </form>   
                            </div>
                        ';
                    }
                    if(isset($_POST['boutonRecherche'])){
                        echo'
                            <div class="espaceBlanc30">
                            </div>
                            <form action="" method=POST>
                                <input type="submit" name="boutonListe" value="Retour">
                            </form>
                            <div class="espaceBlanc30">
                            </div>
                        ';
                    }
                    
                }else{
                    echo'
                        <div class="espaceBlanc10">
                        </div>
                        <form class="champDeSaisi rechercheEnfant" action="" method="POST">
                            <div class="inputChamp recherche">
                                <input type="text" name="nomEnfant" placeholder="Recherche nom" value="">
                            </div>
                            <input type="submit" class="boutonRond recherche" name="boutonRecherche" value="">
                        </form>
                        <div class="espaceBlanc30">
                        </div>
                        <div class="champDeTexte"> 
                            <p class="texteFormulaire">Vous ne suivez aucun enfant actuellement, veuillez faire une demande au près du coordinateur en suivant le lient ci-dessous.</p>    
                        </div>
                        <div class="espaceBlanc100">
                        </div>
                        <form action="" method=POST>
                            <input type="submit" name="boutonSuivi" value="Suivi">
                        </form>
                        <div class="espaceBlanc30">
                        </div>
                    ';
                }
            
            ?>
        </section>
    </body>

    <footer>
    </footer>

</html>

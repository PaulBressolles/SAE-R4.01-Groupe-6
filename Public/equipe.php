<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    if($_SESSION['coordinateur'] == 1){
        $enfantSuivi = ensembleEnfants();
    }

    if(isset($_POST['boutonRecherche']) AND isset($_POST['nomEnfant'])){
        $enfantSuivi = rechercheEnfantSuiviParNom($_POST['nomEnfant'], $_SESSION['id'], $_SESSION['coordinateur']);
    }

    if(isset($_POST['boutonObjectif'])){
        $_SESSION['idEnfantSuivi'] = $_POST['valeurId'];
        header('location:gestionEquipe.php');
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
                        $nombreMembre = nombreMembreEquipe($enfantSuivi[$i]);
                        if($nombreMembre > 0){
                            $texteNombreMembre = '<b>'.$nombreMembre." </b>membres dans son équipe";
                        }else{
                            $texteNombreMembre = "Aucune équipe n'a encore été crée";
                        }
                        echo'
                            <div class="espaceBlanc30">
                            </div>
                            <div class="enfantListe">
                                <div class="enfantListeNom">
                                    <h2 class="nomPrenomEnfant">'.$enfant[2].' <b>'.$enfant[1].'</b><h2>
                                    <p>'.$texteNombreMembre.'</p>
                                </div>
                                <form class ="enfantListeChoix" action="" method=POST>
                                    <input name="valeurId" type="hidden" value="'.$enfantSuivi[$i].'">
                                    <input  class ="boutonAfficherObjectif" type="submit" name="boutonObjectif" value="Administrer">
                                </form>   
                            </div>
                        ';
                    }                    
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
            ?>
        </section>
    </body>

    <footer>
    </footer>

</html>

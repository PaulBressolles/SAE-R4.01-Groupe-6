<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }

    if(isset($_POST['boutonEnfant'])){
        header('location:listeEnfant.php');
    }
    
    if(isset($_POST['boutonEquipe'])){
        header('location:equipe.php');
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

    <body class="pageUnique">  
        <section class="sectionUnique">
            <h1 class="connexion animationTitre">Bonjour !</h1>
            <?php
                $membreEnCours = rechercheMembreParId($_SESSION['id']);
                echo '<h3 class="animationSousTitre">'.$membreEnCours['1'].' '.$membreEnCours['0'].'</h3>';
            ?>
            <div class="espaceBlanc50">
            </div>
            <div class="choixAccueil animationAccueil">
                <h4>
                    Rechercher un enfant
                </h4>
                <div class="boutonRondConteneur animationFleche">
                    <form action="" method="POST">
                        <img class="flecheBouton" src="../SVG/flecheBouton.svg" alt="Valide"/>
                        <input class="boutonRond" type="submit" name="boutonEnfant" value="">
                    </form>    
                </div>
            </div>
            <div class="espaceBlanc30">
            </div>
            <?php
                if($_SESSION['coordinateur'] == 0){
                    echo'
                        <div class="choixAccueil animationAccueil">
                            <h4>
                                Demande de suivi pour un enfant
                            </h4>
                            <div class="boutonRondConteneur animationFleche">
                                <form action="" method="POST">
                                    <img class="flecheBouton" src="../SVG/flecheBouton.svg" alt="Valide"/>
                                    <input class="boutonRond" type="submit" name="boutonSuivi" value="">
                                </form>    
                            </div>
                        </div>
                    ';
                }elseif($_SESSION['coordinateur'] == 1){
                    echo'
                        <div class="choixAccueil animationAccueil">
                            <h4>
                                Organisation des équipes
                            </h4>
                            <div class="boutonRondConteneur animationFleche">
                                <form action="" method="POST">
                                <img class="flecheBouton" src="../SVG/flecheBouton.svg" alt="Valide"/>
                                <input class="boutonRond" type="submit" name="boutonEquipe" value="">
                                </form>    
                            </div>
                        </div>
                        <div class="espaceBlanc30"></div>
                        <div class="choixAccueil animationAccueil">
                            <h4>
                                Création des récompenses
                            </h4>
                            <div class="boutonRondConteneur animationFleche">
                                <form action="" method="POST">
                                <img class="flecheBouton" src="../SVG/flecheBouton.svg" alt="Valide"/>
                                <input class="boutonRond" type="submit" name="boutonFleche" value="">
                                </form>    
                            </div>
                        </div>
                    ';
                }
                
            ?>

            
        </section>
    </body>

    <footer>
    </footer>

</html>

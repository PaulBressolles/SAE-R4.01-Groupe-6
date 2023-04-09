<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $nombreObjectif = nombreObjectifEnCours($_SESSION['idEnfantSuivi']);
    if($nombreObjectif == 1){
        $objectif = "<b>".$nombreObjectif."</b> objectif en cours";
    }elseif($nombreObjectif > 1){
        $objectif = "<b>".$nombreObjectif."</b> objectifs en cours";
    }else{
        $objectif = "aucun objectif en cours";
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
            <a class="boutonRondRetourArriere" href="listeEnfant.php"></a>
            <a class="boutonRondModification" href="modificationCompteEnfant.php"></a>
            <h1 class="connexion enfantNomPrenom animationTitre"><?php echo $enfant[2].' '.$enfant[1];?></h1>
            <p><?php echo $objectif;?></p>   
            <div class="espaceBlanc30"></div>
            <a class="boutonAfficherObjectifCompte" href="objectif.php">Objectif</a>
            <div class="espaceBlanc50"></div>
            <img class="grandJeton" src=<?php echo '"'.$enfant[4].'"';?>>
            <div class="espaceBlanc10"></div>
            <p>Jeton actuel de <b><?php echo $enfant[2]?></b></p>
            <div class="espaceBlanc30"></div>
            <h2 class="titreSection">Suivi de l'enfant</h2>
            <div class="espaceBlanc10"></div>
            <p class="texteFormulaire">Vous pouvez consulter l'équipe qui suit <b><?php echo $enfant[2].' '.$enfant[1];?></b></p>
            <div class="espaceBlanc30"></div>
            <a class="boutonAfficherObjectifCompte" href="equipeEnfant.php">Equipe</a>
            <div class="espaceBlanc30"></div>
            <p class="texteFormulaire">Vous pouvez consulter le statistique de <b><?php echo $enfant[2].' '.$enfant[1];?></b></p>
            <div class="espaceBlanc30"></div>
            <a class="boutonAfficherObjectifCompte" href="statistique.php">Statistiques</a>

        </section>
    </body>

    <footer>
    </footer>

</html>
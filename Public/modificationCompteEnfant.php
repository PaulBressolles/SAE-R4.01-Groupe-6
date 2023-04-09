<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $jeton = listerTousJetons();
?>

<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body>  
        <section>
            <a class="boutonRondRetourArriere" href="compteEnfant.php"></a>
            <h1 class="connexion enfantNomPrenom animationTitre">Modifier le jeton</h1> 
            <div class="espaceBlanc50"></div>
            <img class="grandJeton" src=<?php echo '"'.$enfant[4].'"';?>>
            <div class="espaceBlanc10"></div>
            <p>Jeton actuel de <b><?php echo $enfant[2]?></b></p>
            <div class="espaceBlanc50"></div>
            <p class="texteFormulaire"> Vous pouvez changer le logo. Choississez dans la liste ci dessous.</p>
            <div class="contenuJeton">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="choixImage">
                        <a href=#popup class="boutonAjoutImage"></a>
                        <p class="televerserFichier">Téléverser un fichier</p>
                    </div>
                </form>
            <?php 
                for($i=0; $i<count($jeton); $i++){
                    if(isset($_POST['boutonCache'])){
                        changerJeton($_POST['jeton'], $_SESSION['idEnfantSuivi']);
                        header('location:compteEnfant.php');
                    }
                    echo'
                        <div class="choixImage">
                            <form class="boutonCache" action="" method=POST>
                                <input name="jeton" type="hidden" value="'.$jeton[$i].'">
                                <input type="submit" name="boutonCache" class="boutonCache">
                            </form>
                            <img class="grandJeton" src="../Image/Jeton/'.$jeton[$i].'">
                        </div>
                    ';
                }
            ?>
            </div>
            <div id="popup" class="overlay">
                <h1 class="tresPetit">Télécharger une image</h1>
                <div class="espaceBlanc10"></div>
                <p class="sousTitreH1">
                    Ajouter une image au format JPG, JPEG ou PNG 
                </p>
                <div class="espaceBlanc50"></div>
                <div class="ajoutImage">
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="boutonRondAjoutImage">
                        <input class="boutonRondAjout" type="file" name="fileToUpload" id="fileToUpload">
                    </div>
                    <img class="grandJeton" id="afficheImage">
                </div>
                <div class="espaceBlanc50"></div>
                <p class="texteFormulaire">
                    Souhaitez-vous faire de cette image un nouveau jeton ? 
                </p>
                <div class="espaceBlanc30"></div>
                <div class="ligneBoutonRond">
                    <input class="boutonRond annuler" type="submit" name="boutonAnnule" value="">
                    <input class="boutonRond valider" type="submit" name="boutonValide" value="">
                </div>
                </form>
            </div>
        </section>

        
    </body>

    <footer>
    </footer>

    <script>
        const imageTelecharge = document.getElementById('fileToUpload');
        const affichageImage = document.getElementById('afficheImage');

        imageTelecharge.addEventListener('change', function(){
            const file = this.files[0];
            const objectURL = URL.createObjectURL(file);
            affichageImage.src = objectURL;
        });
    </script>

</html>

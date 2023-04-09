<?php
    session_start();
    include '../PHP/fonction.php';
    $logMessage = '';
    $erreurEmail = FALSE;
    $email = "";
    if (isset($_POST['boutonChangementMotDePasse'])){
        if(!empty($_POST['emailUtilisateur'])){
            $email = $_POST['emailUtilisateur'];
            if(verificationPremiereInscription($email) == FALSE){

            }else{
                $logMessage = '<p class="sousTitreH1 rouge"> Cette adresse mail ne correspond à aucun compte </p>';
                $erreurEmail = TRUE;
            }
        }else{
            $logMessage = '<p class="sousTitreH1 rouge"> Veuillez saisir une adresse mail </p>';
            $erreurEmail = TRUE;
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
            <a class="boutonRondRetourArriere" href="index.php"></a>
            <h1 class="connexion petit">Mot de passe oublié ?</h1>
            <?php echo $logMessage ?>
            <div class="espaceBlanc30"></div>
            <form action="" method="POST">
                <?php
                    if($erreurEmail == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="email" name="emailUtilisateur" placeholder="Adresse mail" value="'.$email.'">
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
                                    <input type="email" name="emailUtilisateur" placeholder="Adresse mail" value="'.$email.'">
                                </div>
                            </div>
                        ';
                    }
                ?>
                <div class="champDeTexte"> 
                    <p class="texteFormulaire">Un mot de passe provisoire vous sera transmis sur votre <b>boite mail</b>.</p>    
                </div>
                <div class="espaceBlanc50"></div>
                <div class="boutonValidation">
                    <input type="submit" name="boutonChangementMotDePasse" value="Récupérer">
                </div>
                <div class="espaceBlanc100"></div>
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

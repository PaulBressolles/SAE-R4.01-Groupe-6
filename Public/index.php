<?php
    session_start();
    include '../PHP/fonction.php';
    $logMessage = '<p class="sousTitreH1"> Veuillez renseigner vos informations </p>';
    $erreurEmail = FALSE;
    $erreurMotDePasse = FALSE;
    $email = "";
    if (isset($_POST['boutonConnexion'])){
        $email = $_POST['emailUtilisateur'];
        if (!empty($_POST['emailUtilisateur']) && !empty($_POST['motDePasseUtilisateur'])){
            $identiteUtilisateur = array('0' => $email, '1' => $_POST['motDePasseUtilisateur']);
            if(connexionUtilisateur($identiteUtilisateur) == TRUE){
                header('location:accueil.php');
            }else{
                $erreurEmail = TRUE;
                $erreurMotDePasse = TRUE; 
                $logMessage = '<p class="sousTitreH1 rouge"> Votre email ou votre mot de passe est incorrect </p>';
            }
        }else{
            if (empty($_POST['emailUtilisateur']) && empty($_POST['motDePasseUtilisateur'])){
                $erreurEmail = TRUE;
                $erreurMotDePasse = TRUE; 
                $logMessage = '<p class="sousTitreH1 rouge"> Veillez à renseigner tout <b>les champs</b> </p>';
            }elseif(empty($_POST['emailUtilisateur'])){ 
                $erreurEmail = TRUE;
                $logMessage = '<p class="sousTitreH1 rouge"> Veillez à renseigner votre <b>email</b> </p>';
            }else{
                $erreurMotDePasse = TRUE; 
                $logMessage = '<p class="sousTitreH1 rouge"> Veillez à renseigner votre <b>mot de passe</b> </p>';
            }
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
            <h1 class="connexion">Bienvenue</h1>
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
                    
                    if($erreurMotDePasse == TRUE){
                        echo'
                            <div class="champDeSaisi lien">
                                <div class="inputChamp erreur">
                                    <input type="password" class="erreur" name="motDePasseUtilisateur" placeholder="Mot de passe">
                                    <div class="croixRouge">
                                        <img class="croix" src="../SVG/croixRouge.svg">
                                    </div>
                                </div>
                                <a class="lienConnexion" href="">mot de passe oublié ?</a>
                            </div>
                        ';
                    }else{
                        echo'
                            <div class="champDeSaisi lien">
                                <div class="inputChamp">
                                    <input type="password" name="motDePasseUtilisateur" placeholder="Mot de passe">
                                </div>
                                <a class="lienConnexion" href="changementMotDePasse.php">mot de passe oublié ?</a>
                            </div>
                        ';
                    }
                ?>                
                <div class="espaceBlanc30"></div>
                
                <div class="boutonValidation">
                    <input type="submit" name="boutonConnexion" value="Se connecter">
                    <a class="lienConnexion" href="inscription.php">créer un compte</a>
                </div>
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

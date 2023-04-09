<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $objectif =  rechercheObjectif($_SESSION['objectifEnCours']);
    if(rechercheMessage($_SESSION['objectifEnCours']) != FALSE) {
        $listeMessage = rechercheMessage($_SESSION['objectifEnCours']);
        array_multisort($listeMessage, SORT_DESC);
    }  
    $valeurMessage = "";
    if(isset($_POST['boutonEnvoie'])){
        if(!empty($_POST['message'])){
            envoiMessage($_SESSION['objectifEnCours'], $_SESSION['id'],$_POST['message']);
            header('location:message.php');
        }
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
            <a class="boutonRondRetourArriere" href="ajoutObjectif.php"></a>
            <h1 class="petit animationTitre">Messagerie</h1>
            <?php
                echo'    
                    <h1 class="tresPetit">'.$objectif[0].'</h1>
                ';
            ?>
            <div class="espaceBlanc30"></div>
            <div class="champDeSaisi">
                <form action="" method=POST>
                    <div class="inputChamp message">
                        <input type="submit" name="boutonEnvoie" class="boutonEnvoie" value="<?php echo $valeurMessage; ?>">
                        <input type="text" class="message" name="message" placeholder="Rédiger votre message" value="" size="20">
                    </div>
                </form>
            </div>
            <div class="filDiscussion">
                <h2 class="filDiscussion">Fil de la discussion</h2>
            </div>
            <div class="espaceBlanc10"></div>
            <div class="boiteMessagerie">
                <?php
                    $listeMessageMembre = rechercheDernierMessage($_SESSION['id'], $_SESSION['objectifEnCours']);
                    if($listeMessageMembre != FALSE){
                        echo'
                            <a class="boutonRondRetourSupprime" href="supprimeMessage.php"></a>
                        ';
                    }
                ?>
                <div class="espaceBlanc30"></div>
                <?php
                    if(rechercheMessage($_SESSION['objectifEnCours']) != FALSE) {
                        $dateComparaison = date('Y:m:d');
                        for($i=0; $i<count($listeMessage); $i++){
                            $membre = rechercheMembreParId($listeMessage[$i][2]);
                            $dateJour = date('Y:m:d', strtotime($listeMessage[$i][0]));
                            if($dateJour < $dateComparaison){
                                echo '
                                    <div class="espaceBlanc30"></div>
                                    <p class="ligneDateJour">'.date('d / m / Y', strtotime($listeMessage[$i][0])).'</p>
                                    <div class="espaceBlanc30"></div>
                                ';
                                $dateComparaison = $dateJour;
                            }
                            if($_SESSION['id'] == $listeMessage[$i][2]){
                                echo'
                                    <h6 class="emetteur">Vous</h6>
                                    <div class="boiteMessage droite">
                                        <p class="message">'.$listeMessage[$i][1].'</p>
                                        <p class="dateMessage">'.date('H:i', strtotime($listeMessage[$i][0])).'</p>
                                    </div>
                                    <div class="espaceBlanc30"></div>
                                ';
                            }else{
                                echo'
                                    <h6 class="emetteur gauche">'.$membre[1].' '.$membre[0].'</h6>
                                    <div class="boiteMessage">
                                        <p class="dateMessage">'.date('H:i', strtotime($listeMessage[$i][0])).'</p>
                                        <p class="message autreUser">'.$listeMessage[$i][1].'</p>
                                    </div>
                                    <div class="espaceBlanc30"></div>
                                ';
                            }
                        }     
                    }else{
                        echo'
                            <p>Aucun message posté actuellement</p>
                            <div class="espaceBlanc100"></div>
                        ';
                    }           
                ?>
            </div>
        </section>
    </body>

    <footer>
    </footer>

</html>
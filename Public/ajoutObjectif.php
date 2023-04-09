<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $objectif =  rechercheObjectif($_SESSION['objectifEnCours']);
        
    
    if(listeJetonPourObjectif($_SESSION['objectifEnCours']) != FALSE){
        $jetonEnCours = count(listeJetonPourObjectif($_SESSION['objectifEnCours']));
    }else{
        $jetonEnCours = FALSE;
    }
    if(isset($_POST['boutonAjoutJeton'])){
        if($jetonEnCours == FALSE){
            ajoutJeton($_SESSION['objectifEnCours'], $_SESSION['id']);
            $_POST['boutonAjoutJeton'] = null;
            header('location:ajoutObjectif.php');
        }
        if($jetonEnCours < $objectif[2] + 1){
            ajoutJeton($_SESSION['objectifEnCours'], $_SESSION['id']);
            $_POST['boutonAjoutJeton'] = null;
            header('location:ajoutObjectif.php');
        }
    }

    if($jetonEnCours == $objectif[2] + 1){
        header('location:validationObjectif.php');
    }
?>

<!doctype html>
<html lang="fr">
    
    <?php
        require'../Extension/head.html';
        require'../Extension/header.php';
    ?>

    <body>  
        <section class="objectif">
            <a class="boutonRondRetourArriere" href="objectif.php"></a>
            <a class="boutonRondModification message" href="message.php"></a>
            <?php
                if($_SESSION['coordinateur']==1){
                    echo'
                        <a class="boutonRondModification suppression" href="supressionObjectif.php"></a>
                    ';
                }
                echo'    
                    <h1 class="titreObjectif">'.$objectif[0].'</h1>
                ';
				if(listeJetonPourObjectif($_SESSION['objectifEnCours']) != FALSE){
                    $compteur = count(listeJetonPourObjectif($_SESSION['objectifEnCours']));
                    $compteur -= 1;
                    $jetonTexte = "Ajouter un nouveau jeton";
                    $commence = "";
                }else{
                    $compteur = 0;
                    $jetonTexte = "Débuter l'évaluation de cet objectif";
                    $commence = "commence";
                }
                $nbJeton = $objectif[2];
				echo'<div class="boiteCompteurJeton">';
				echo'<div class="ligneCompteurJeton">';
				for ($i = 0; $i < $nbJeton; $i++) {
	  				if($i % 5 == 0 AND $i != 0){
	    				echo'
	        				</div>
	        				<div class="ligneCompteurJeton">
	        			';
	    				if($compteur > 0){
	     					echo '<div class="imageJetonCompteur">
	              					<img class="logoCompteur" src="'.$enfant[4].'" alt="Image attente"/>
	            				  </div>
	            			';
	      					$compteur -= 1;
	    				}else{
	      					echo '<div class="imageJetonCompteur">
	              				  	<img class="logoCompteur noirBlanc" src="'.$enfant[4].'" alt="Image attente"/>
	            				  </div>
	            			';
	    				}
	  				}else{
	    				if($compteur > 0){
	      					echo '<div class="imageJetonCompteur '.$commence.'">
	              					<img class="logoCompteur" src="'.$enfant[4].'" alt="Image attente"/>
	            				  </div>
	            			';
	      					$compteur -= 1;
	    				}else{
	      					echo '<div class="imageJetonCompteur">
	              					<img class="logoCompteur noirBlanc" src="'.$enfant[4].'" alt="Image attente"/>
	            				  </div>
	            			';
	    				}
	  				}
				}
				echo'</div></div>';
                echo'
                    <div class="espaceBlanc30"></div>
                    <div class="boutonAjoutJeton '.$commence.'">
                    <form class="boutonCacheAbsolu" action="" method=POST>
                        <input class="boutonCacheAbsolu" type="submit" name="boutonAjoutJeton">
                    </form>
                    <p class="creationObjectif">'.$jetonTexte.'</p>
                    <img class="ajoutJeton" src="../SVG/creationObjectif.svg">
                    </div>
                    <div class="espaceBlanc30"></div>
                    <label class="labelChampDeSaisi">Durée initiale : <b>'.conversionDureeFini(conversionDureeHeure($objectif[3])).'</b></label> 
                    <div class="espaceBlanc30"></div>
                        <img class="imageRecompenseObjectif" id="afficheImage" src="'.$objectif[1].'">
                ';
			?>
            <div class="espaceBlanc30"></div>
            <div class="filDiscussion">
                <h2 class="filDiscussion">Historique des ajouts</h2>
                 <?php   
                    $jetonEnCoursMembre = listeJetonMembreObjectif($_SESSION['objectifEnCours'], $_SESSION['id']);
                    if($jetonEnCoursMembre > 1 AND $commence == "" ){
                        echo'
                            <a class="boutonRondRetourSupprime" href="supprimeJeton.php"></a>
                        ';
                    }
                ?>
            </div>
            <div class="espaceBlanc10"></div>
            <?php
                $listeJeton = listeJetonPourObjectif($_SESSION['objectifEnCours']);
                if($listeJeton != FALSE){
                    unset($listeJeton[0]);
                    array_multisort($listeJeton, SORT_DESC);
                }    
                if($listeJeton != FALSE){
                    if(count($listeJeton) > 0){
                        for ($i = 0; $i < count($listeJeton); $i++) {
                            $membre = rechercheMembreParId($listeJeton[$i][1]);
                            $date = $listeJeton[$i][0];
                            $heure = date('H:i', strtotime($date));
                            $jour = date('d', strtotime($date));
                            $mois = date('m', strtotime($date));
                            $annee = date('Y', strtotime($date));
                            echo'
                                <div class="boiteJetonHistorique">
                                    <div class="ligneJetonHistorique">
                                        <p>'.$membre[1].' <b>'.$membre[0].'</b></p>
                                        <p>'.$heure.'</p>
                                    </div>
                                    <div class="ligneJetonHistorique">
                                        <p><b>+1</b> jeton</p>
                                        <p>'.$jour.' / '.$mois.' / '.$annee.'</p>
                                    </div>
                                </div>
                                <div class="espaceBlanc30"></div>
                            ';
                        }
                    }else{
                        echo"
                            <p>Aucun jeton n'a encore été placé</p>
                        ";
                    }
                }else{
                    echo"
                        <p>Aucun jeton n'a encore été placé</p>
                    ";
                }
            ?>

        </section>
    </body>

    <footer>
    </footer>

</html>
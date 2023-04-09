<?php
    session_start();
    include '../PHP/fonction.php';
    if(!isset($_SESSION['id'])){
        header('location:index.php');
    }
    $enfant = rechercheEnfantId($_SESSION['idEnfantSuivi']);
    $objectif = rechercheObjectif($_SESSION['objectifEnCours']);
    $recompense = rechercheLiaison($_SESSION['objectifEnCours']);
    $recompenseInformation = recompenseParId($recompense[1]);
    if(listeJetonPourObjectif($_SESSION['objectifEnCours']) != FALSE){
        $jetonEnCours = count(listeJetonPourObjectif($_SESSION['objectifEnCours']));
    }else{
        $jetonEnCours = FALSE;
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
            <a class="boutonRondRetourArriere" href="objectif.php"></a>
            <?php
                echo'
                    <h1 class="titreObjectif grand">'.$objectif[0].'</h1>
                    <p class="etatDureeObjectif sousTitre">'."Cet objectif a été un succés".'</p>
                ';
            ?>
            <div class="espaceBlanc30"></div>
            <img class="validation annule" src="../SVG/boutonRondValider.svg">
            <div class="espaceBlanc30"></div>
            <?php 
                echo'
                <div class="afficageImageRecompense">
                <img class="" id="afficheImage" src="'.$recompenseInformation[1].'">
                </div>
                
                <div class="espaceBlanc30"></div>
                <h2 class="sousTitreMoyenne">'.$recompenseInformation[0].'</h2>
                ';
            ?>
            <?php
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
            ?>
            <div class="espaceBlanc30"></div>
            <?php
                echo'
                    <label class="labelChampDeSaisi">Durée initiale : <b>'.conversionDureeFini(conversionDureeHeure($objectif[3])).'</b></label> 
                    <div class="espaceBlanc30"></div>
                ';
            ?>
            <div class="espaceBlanc100"></div>
        </section>
    </body>

    <footer>
    </footer>

</html>

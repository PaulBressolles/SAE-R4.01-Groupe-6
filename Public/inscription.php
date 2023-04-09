<?php
    session_start();
    include '../PHP/fonction.php';
    $logMessage = '<p class="sousTitreH1"> Veuillez renseigner vos informations </p>';
    $erreurPrenom = FALSE;
    $erreurNom = FALSE;
    $erreurAdresse = FALSE;
    $erreurCp = FALSE;
    $erreurVille = FALSE;
    $erreurEmail = FALSE;
    $erreurMotDePasse = FALSE;
    $erreurMotDePasseConfirmation = FALSE;
    $prenom = "";
    $nom = "";
    $adresse = "";
    $cp = "";
    $ville = "";
    $email = "";
    $jour = "Jour";
    $mois = "Mois";
    $annee = "Année";

    if(isset($_POST['boutonInscription'])){
        $prenom = $_POST['prenomUtilisateur'];
        $nom = $_POST['nomUtilisateur'];
        $adresse = $_POST['adresseUtilisateur'];
        $cp = $_POST['cpUtilisateur'];
        $ville = $_POST['villeUtilisateur'];
        $email = $_POST['emailUtilisateur'];
        $jour = $_POST['jour'];
        $mois = $_POST['mois'];
        $annee = $_POST['annee'];
        if(!empty($_POST['prenomUtilisateur']) 
        && !empty($_POST['nomUtilisateur'])
        && !empty($_POST['jour'])
        && !empty($_POST['mois'])
        && !empty($_POST['annee'])
        && !empty($_POST['adresseUtilisateur'])
        && !empty($_POST['cpUtilisateur'])
        && !empty($_POST['villeUtilisateur'])
        && !empty($_POST['roleUtilisateur'])
        && !empty($_POST['emailUtilisateur'])
        && !empty($_POST['motDePasseUtilisateur'])
        && !empty($_POST['motDePasseConfirmationUtilisateur'])){
            $motDePasseChiffre = validationMotDePasse($_POST['motDePasseUtilisateur'], $_POST['motDePasseConfirmationUtilisateur']);
            if($motDePasseChiffre != FALSE){
                if(validationCodePostal($_POST['cpUtilisateur']) == TRUE){
                    $informationUtilisateur = array('0' => $_POST['nomUtilisateur'], 
                                            '1' => $_POST['prenomUtilisateur'],                                             
                                            '2' => $_POST['annee'].'-'.$_POST['mois'].'-'.$_POST['jour'], 
                                            '3' => $_POST['adresseUtilisateur'], 
                                            '4' => $_POST['cpUtilisateur'], 
                                            '5' => $_POST['villeUtilisateur'], 
                                            '6' => $_POST['roleUtilisateur'], 
                                            '7' => $_POST['emailUtilisateur'], 
                                            '8' => $motDePasseChiffre,
                                        );
                    if(verificationPremiereInscription($informationUtilisateur) == TRUE){
                        var_dump(inscriptionMembre($informationUtilisateur));
                        header('location:index.php');
                    }else{
                        $logMessage = '<p class="sousTitreH1 rouge"> Le compte a déjà été créée </p>';
                        $erreurEmail = TRUE;
                    }
                }else{
                    $logMessage = '<p class="sousTitreH1 rouge"> Le code postal est non conforme </p>';
                    $erreurCp = TRUE;
                }
            }else{
                $logMessage = '<p class="sousTitreH1 rouge"> Les mots de passe ne correspondent pas ou sont trop court ( 5 caractères minimum ) </p>';
                $erreurMotDePasseConfirmation = TRUE;
                $erreurMotDePasse = TRUE;
            }
        }else{
            $logMessage = '<p class="sousTitreH1 rouge"> Veillez à renseigner tous <b>les champs</b> </p>';
        }

        if(empty($_POST['prenomUtilisateur'])){
            $erreurPrenom = TRUE;
        }

        if(empty($_POST['nomUtilisateur'])){
            $erreurNom = TRUE;
        }

        if(empty($_POST['adresseUtilisateur'])){
            $erreurAdresse = TRUE;
        }

        if(empty($_POST['cpUtilisateur'])){
            $erreurCp = TRUE;
        }

        if(empty($_POST['villeUtilisateur'])){
            $erreurVille = TRUE;
        }

        if(empty($_POST['emailUtilisateur'])){
            $erreurEmail = TRUE;
        }

        if(empty($_POST['motDePasseUtilisateur'])){
            $erreurMotDePasse = TRUE;
        }

        if(empty($_POST['motDePasseConfirmationUtilisateur'])){
            $erreurMotDePasseConfirmation = TRUE;
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

    <body>  
        <section class="sectionInscription">
            <a class="boutonRondRetourArriere" href="index.php"></a>
            <h1 class="connexion">Inscription</h1>
            <?php echo $logMessage ?>
            <div class="espaceBlanc30"></div>
            <form action="" method="POST">
                <h2 class="titreSection">Identité</h2>
                <div class="espaceBlanc10"></div>
                <?php
                    if($erreurPrenom == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" name="prenomUtilisateur" placeholder="Prenom" value="'.$prenom.'">
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
                                    <input type="text" name="prenomUtilisateur" placeholder="Prenom" value="'.$prenom.'">
                                </div>
                            </div>
                        ';
                    }
                    
                    if($erreurNom == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" class="erreur" name="nomUtilisateur" placeholder="Nom" value="'.$nom.'">
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
                                    <input type="text" name="nomUtilisateur" placeholder="Nom"  value="'.$nom.'">
                                </div>
                            </div>
                        ';
                    }
                ?>   
                <label class="labelChampDeSaisi"> Date de naissance : </label> 
                <div class="champDeSaisi">
                    <div class="selecteurDate">
                        <div class="selecteur">
                            <div class="flecheSelecteur">
                                <img class="flecheSelecteurImage" src="../SVG/flecheSelecteur.svg">
                            </div>
                            <select name="jour">
                                <option value="<?php echo $jour ?>"><?php echo $jour ?></option>
                                <option value="01">1</option>
                                <option value="02">2</option>
                                <option value="03">3</option>
                                <option value="04">4</option>
                                <option value="05">5</option>
                                <option value="06">6</option>
                                <option value="07">7</option>
                                <option value="08">8</option>
                                <option value="09">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                            </select>
                        </div>
                        <div class="selecteur">
                            <div class="flecheSelecteur">
                                <img class="flecheSelecteurImage" src="../SVG/flecheSelecteur.svg">
                            </div>
                            <select name="mois">
                                <option value="<?php echo $mois ?>"><?php echo $mois ?></option>
                                <option value="01">Janv</option>
                                <option value="02">Févr</option>
                                <option value="03">Mars</option>
                                <option value="04">Avri</option>
                                <option value="05">Mai</option>
                                <option value="06">Juin</option>
                                <option value="07">Juil</option>
                                <option value="08">Aout</option>
                                <option value="09">Sept</option>
                                <option value="10">Octo</option>
                                <option value="11">Nove</option>
                                <option value="12">Déc</option>
                            </select>
                        </div>
                        <div class="selecteur">
                            <div class="flecheSelecteur">
                                <img class="flecheSelecteurImage" src="../SVG/flecheSelecteur.svg">
                            </div>
                            <select name="annee">
                                <option value="<?php echo $annee ?>"><?php echo $annee ?></option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>

                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>

                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>

                                <option value="1989">1989</option>
                                <option value="1988">1988</option>
                                <option value="1987">1987</option>
                                <option value="1986">1986</option>
                                <option value="1985">1985</option>
                                <option value="1984">1984</option>
                                <option value="1983">1983</option>
                                <option value="1982">1982</option>
                                <option value="1981">1981</option>
                                <option value="1980">1980</option>

                                <option value="1979">1979</option>
                                <option value="1978">1978</option>
                                <option value="1977">1977</option>
                                <option value="1976">1976</option>
                                <option value="1975">1975</option>
                                <option value="1974">1974</option>
                                <option value="1973">1973</option>
                                <option value="1972">1972</option>
                                <option value="1971">1971</option>
                                <option value="1970">1970</option>

                                <option value="1969">1969</option>
                                <option value="1968">1968</option>
                                <option value="1967">1967</option>
                                <option value="1966">1966</option>
                                <option value="1965">1965</option>
                                <option value="1964">1964</option>
                                <option value="1963">1963</option>
                                <option value="1962">1962</option>
                                <option value="1961">1961</option>
                                <option value="1960">1960</option>

                                <option value="1959">1959</option>
                                <option value="1958">1958</option>
                                <option value="1957">1957</option>
                                <option value="1956">1956</option>
                                <option value="1955">1955</option>
                                <option value="1954">1954</option>
                                <option value="1953">1953</option>
                                <option value="1952">1952</option>
                                <option value="1951">1951</option>
                                <option value="1950">1950</option>

                                <option value="1949">1949</option>
                                <option value="1948">1948</option>
                                <option value="1947">1947</option>
                                <option value="1946">1946</option>
                                <option value="1945">1945</option>
                                <option value="1944">1944</option>
                                <option value="1943">1943</option>
                                <option value="1942">1942</option>
                                <option value="1941">1941</option>
                                <option value="1940">1940</option>
                            </select>
                        </div>
                    </div>
                </div> 
                  
                 
                <div class="espaceBlanc10"> </div>
                <label class="labelChampDeSaisi"> Adresse : </label> 
                <div class="espaceBlanc10"> </div>
                <?php
                    if($erreurAdresse == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" name="adresseUtilisateur" placeholder="Adresse" value="'.$adresse.'">
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
                                    <input type="text" name="adresseUtilisateur" placeholder="Adresse" value="'.$adresse.'">
                                </div>
                            </div>
                        ';
                    }

                    if($erreurCp == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" name="cpUtilisateur" placeholder="Code postal" value="'.$cp.'">
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
                                    <input type="text" name="cpUtilisateur" placeholder="Code postal" value="'.$cp.'">
                                </div>
                            </div>
                        ';
                    }

                    if($erreurVille == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="text" name="villeUtilisateur" placeholder="Ville" value="'.$ville.'">
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
                                    <input type="text" name="villeUtilisateur" placeholder="Ville" value="'.$ville.'">
                                </div>
                            </div>
                        ';
                    }
                ?>
                <div class="espaceBlanc30"></div>
                <h2 class="titreSection">Rôle</h2>
                <div class="champDeTexte"> 
                    <p class="texteFormulaire">Veuillez sélectionner votre <b>rôle</b> au sein de l'association.</p>    
                </div>
                <div class="espaceBlanc10"></div>
                <div class="conteneurBoutonRadio">
                    <div class="boiteBoutonRadio">
                        <div class="boutonRadio">
                            <input type="radio" class="radioCache" name="roleUtilisateur" id="a" value="2">
                            <label for="a" class="ligneBoutonRadio">
                                <span class="intitule">Professionnel</span>
                                <div class="cercle"></div>
                            </label>
                        </div>

                        <div class="boutonRadio">
                            <input type="radio" class="radioCache" name="roleUtilisateur" id="b" value="1">
                            <label for="b" class="ligneBoutonRadio">
                                <span class="intitule">Famille</span>
                                <div class="cercle"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <h2 class="titreSection">Identifiant</h2>
                <div class="espaceBlanc10"></div>
                <?php
                    if($erreurEmail == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="email" name="emailUtilisateur" placeholder="Email" value="'.$email.'">
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
                                    <input type="email" name="emailUtilisateur" placeholder="Email" value="'.$email.'">
                                </div>
                            </div>
                        ';
                    }

                    if($erreurMotDePasse == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="password" name="motDePasseUtilisateur" placeholder="Mot de passe" value="">
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
                                    <input type="password" name="motDePasseUtilisateur" placeholder="Mot de passe" value="">
                                </div>
                            </div>
                        ';
                    }

                    if($erreurMotDePasseConfirmation == TRUE){
                        echo'
                            <div class="champDeSaisi">
                                <div class="inputChamp erreur">
                                    <input type="password" name="motDePasseConfirmationUtilisateur" placeholder="Mot de passe confirmation" value="">
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
                                    <input type="password" name="motDePasseConfirmationUtilisateur" placeholder="Mot de passe confirmation" value="">
                                </div>
                            </div>
                        ';
                    }
                ?>
                <div class="boutonValidation">
                    <input type="submit" name="boutonInscription" value="S'inscrire">
                </div>
                <div class="espaceBlanc30"></div>
            </form>
        </section>
    </body>

    <footer>
    </footer>

</html>

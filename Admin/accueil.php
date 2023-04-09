<?php
     session_start();
     if(!isset($_SESSION['email'])){
        header('location:index.php');
     }

    try{
      $bdd = new PDO('mysql:host=localhost;dbname=projett21;charset=utf8', 'test', 'password');
    }
    catch (Exception $erreur){
          die('Erreur : ' . $erreur->getMessage());
    }
    //Requête SQL
    $res = $bdd->query('SELECT * FROM membre WHERE compteValide=0');

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="monstyle.css">
  </head>
  <body>
  <a class="deconnexion" href="../Admin/deconnexion.php"><h5>Déconnexion</h5></a>
  <a class="deconnexion" href="../Admin/gestionEnfant.php"><h5>Gestion enfant</h5></a>

    <div class="boiteTableau">

        <table class="tableau-style">
            
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                    <th>Code postal</th>
                    <th>Ville</th>
                    <th>Email</th>
                    <th>Date de naissance</th>
                    <th>Modifier</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    echo '<tr>';
                    while ($row = $res->fetch()) {
                            $date = $row['dateNaissance'];
                            $timestamp = strtotime($date);
                            $date = date("d/m/Y", $timestamp);
                            echo '<td>' . $row['nom'] . ' </td>';
                            echo '<td>' . $row['prenom'] . '</td>';
                            echo '<td>' . $row['adresse'] . '</td>';
                            echo '<td>' . $row['codePostal'] . '</td>';
                            echo '<td>' . $row['ville'] . '</td>';
                            echo '<td>' . $row['courriel'] . '</td>';
                            echo '<td>' . $date . '</td>';
                            echo '<td>';
                            
                            echo '<form action="accepter.php" method="post">';
                            echo '<input type="hidden" name="id" value="' . $row['idMembre'] . '">';
                            echo '<input class="btnAccept" type="submit" value="Accepter" onclick="return confirm(\'Êtes-vous sûr de vouloir accepter cette personne ?\')">';
                            echo '</form>';

                            echo '<form action="supprimer.php" method="post">';
                            echo '<input type="hidden" name="id" value="' . $row['idMembre'] . '">';
                            echo '<input class="btnRefuser" type="submit" value="Refuser" onclick="return confirm(\'Êtes-vous sûr de vouloir refuser cette personne ?\')">';
                            echo '</form>';

                            echo '</td>';
                        echo '</tr>';
                    }
                ?>
                    

            </tbody>


        </table>
        
    </div>
   
  </body>
</html>
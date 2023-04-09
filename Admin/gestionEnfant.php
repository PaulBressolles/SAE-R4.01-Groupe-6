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
  <a class="deconnexion" href="../Admin/accueil.php"><h5>Gestion membre</h5></a>
  <form action="ajouterEnfant.php" method="POST">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom"><br><br>
    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom"><br><br>
    <label for="dateNaissance">Date de naissance :</label>
    <input type="date" id="dateNaissance" name="dateNaissance"><br><br>
    <input class="btnAccept" type="submit" value="Ajouter" onclick="return confirm('Êtes-vous sûr de vouloir ajouter cet enfant ?')">
  </form>

   
  </body>
</html>
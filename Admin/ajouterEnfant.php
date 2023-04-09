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
    if(!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["dateNaissance"])){
      $nom = htmlspecialchars($_POST["nom"]);
      $prenom = htmlspecialchars($_POST["prenom"]);
      $dateNaissance = htmlspecialchars($_POST["dateNaissance"]);
      $jeton = '../Image/Jeton/jetonJaune.png';
      $reponse = $bdd->prepare('INSERT INTO enfant(nom, prenom, dateNaissance, lienJeton) VALUES(?, ?, ?, ?)');
      $reponse->execute(array($nom, $prenom, $dateNaissance, $jeton));
      var_dump($reponse->rowCount());
      if($reponse->rowCount() > 0){ 
        echo 'Enfant ajouté avec succès';
      }else{
        echo 'Erreur';
      }
    }

?>
<html>
  <a class="deconnexion" href="../Admin/gestionEnfant.php"><h5>Retour</h5></a>
</html>
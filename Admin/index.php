 <?php
    session_start();

    try{
      $bdd = new PDO('mysql:host=localhost;dbname=projett21;charset=utf8', 'test', 'password');
    }
    catch (Exception $erreur){
          die('Erreur : ' . $erreur->getMessage());
    }

    function connexionAdmin($email, $motDePasse, $bdd){
        $email = htmlspecialchars($email);
        $motDePasse = htmlspecialchars($motDePasse);
        $recupAdmin = $bdd->prepare('SELECT * FROM admin WHERE email = ?');
        $recupAdmin->execute(array($email));
        if($recupAdmin->rowCount() > 0){

          foreach($recupAdmin as $row){
            if(password_verify($motDePasse,$row['motDePasse'])) {
              $_SESSION['email'] = $row['email'];
              $_SESSION['motDePasse'] = $row['motDePasse'];
              return TRUE;
            }
          }
          return TRUE;
        }else{
          return FALSE;
        }
    }

    if(isset($_POST['btnConnexion'])){
      if(connexionAdmin($_POST['email'], $_POST['motDePasse'], $bdd)){
        header("location:accueil.php");
      }
    }
?>

<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>page connexion</title>
</head>

<body>

    <div class="container">
        
        <form class="Connexion" action="" method="POST">

            <p class="pConnexion"><b class="pConnexion">Connexion</b></p>

            <input class="inputEmailMDP" name="email" type="email" placeholder="Email" required><br>
            <input class="inputEmailMDP" name="motDePasse" type="password" placeholder="Mot de passe" required><br>
            

            <input class="buttonConnexion" name="btnConnexion" type="submit" value="Connexion"><br>

        </form>

    </div>
    
</body>

</html>
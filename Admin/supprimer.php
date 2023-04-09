<?php

    $idMembre = $_POST['id'];
     //Connexion base de données
     $server = "localhost";
     $login = 'root';
     $mdp = '';
     $db = 'projett21';

    //Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    }
    ///Capture des erreurs éventuelles
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

        $req = $linkpdo->prepare('DELETE FROM membre WHERE idMembre = :id');
        $req->bindValue(":id", $idMembre);
        $req->execute();
        header('Location: accueil.php');
?>
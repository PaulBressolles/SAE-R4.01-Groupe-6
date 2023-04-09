<?php
session_start();
include '../PHP/fonction.php';
if(!isset($_SESSION['id'])){
    header('location:index.php');
}
$listeJeton = listeJetonMembreObjectif($_SESSION['objectifEnCours'], $_SESSION['id']);
array_multisort($listeJeton, SORT_DESC);
supprimeJeton($listeJeton[0],$_SESSION['id'], $_SESSION['objectifEnCours']);
header('location:ajoutObjectif.php');
?>
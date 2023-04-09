<?php
session_start();
include '../PHP/fonction.php';
if(!isset($_SESSION['id'])){
    header('location:index.php');
}
$listeMessage = rechercheDernierMessage($_SESSION['id'], $_SESSION['objectifEnCours']);
array_multisort($listeMessage, SORT_DESC);
var_dump($listeMessage);
var_dump($listeMessage[0]); 
supprimerMessage($listeMessage[0]);
header('location:message.php');
?>
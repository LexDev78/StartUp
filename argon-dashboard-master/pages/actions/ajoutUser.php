<?php
session_start();
    require "../../../connecter.php";
    $nom = $_SESSION['inscrit']['nom'];
    $prenom = $_SESSION['inscrit']['prenom'];
    $identifiant = $_SESSION['inscrit']['identifiant'];
    $password = $_SESSION['inscrit']['password'];
    $poste = $_SESSION['inscrit']['poste'];
    $req=$bdd->query('INSERT INTO utilisateurs VALUES(null,"'.$nom.'","'.$prenom.'","'.$identifiant.'","'.$password.'","'.$poste.'")');
    header('location: ../sign-in.php');
?>
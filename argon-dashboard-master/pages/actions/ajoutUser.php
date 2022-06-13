<?php
session_start();
    require "../../../connecter.php";
    $nom = $_SESSION['inscrit']['nom'];
    $prenom = $_SESSION['inscrit']['prenom'];
    $identifiant = $_SESSION['inscrit']['identifiant'];
    $password = $_SESSION['inscrit']['password'];
    $poste = $_SESSION['inscrit']['poste'];
        $veri=$bdd->query('SELECT * FROM utilisateurs where identifiantUser = "'.$identifiant.'" ');
        $veri=$veri->fetch();
     
        if(is_array($veri)){
            die("<h1>Votre identifiant existe déjà <a href='../sign-up.php'>réesayez avec un autre identifiant</a></h1>");
        } else {
            $req=$bdd->query('INSERT INTO utilisateurs VALUES(null,"'.$nom.'","'.$prenom.'","'.$identifiant.'","'.$password.'","'.$poste.'")');
        header('location: ../sign-in.php');
        }
   
?>
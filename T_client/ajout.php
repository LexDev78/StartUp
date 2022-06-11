
<?php 

require '../connecter.php';

//extraction des variables
    @$nomcli=htmlspecialchars($_POST['nomcli']);
    @$precli=htmlspecialchars($_POST['precli']);
    @$telcli=htmlspecialchars($_POST['telcli']);
    @$vilcli=htmlspecialchars($_POST['vilcli']);
    @$adcli=htmlspecialchars($_POST['adcli']);
    @$genrecli=htmlspecialchars($_POST['genrecli']);

if (isset($_POST['ok'])) {

    $rech=$bdd->prepare('SELECT idClient FROM clients WHERE nomClient=? AND prenomClient=? AND 
                                villeClient=? AND adresseClient=? AND genreClient=? AND telephoneClient=? ');
    $rech->execute(array($nomcli,$precli,$vilcli,$adcli,$genrecli,$telcli));
	$result=$rech->rowCount();

    if ($result == 0) {
        $sql='INSERT INTO clients(idClient, nomClient, prenomClient, villeClient, 
                                    adresseClient, genreClient, telephoneClient) VALUES (null, "'.$nomcli.'", "'.$precli.'", 
                                    "'.$vilcli.'", "'.$adcli.'", "'.$genrecli.'", "'.$telcli.'")';
        $sql=$bdd->query($sql);
            if ($sql) {
                $succes="Client enregistré avec succès !...";
                header('location:ajout.php');
            }else {
                $erreur="Enrgistrement non effectué !...";
            }
    }else {
        $erreur="Ce client exite déjà !...";
    }
   
}
// Recuperation pour les détails
@$det=$_GET['det'];
$details=$bdd->prepare("SELECT * FROM clients WHERE idClient=?");
$details->execute(array($det));
$cliInfodet=$details->fetch();

// Recuperation pour les modifications
@$mod=$_GET['mod'];
$details=$bdd->prepare("SELECT * FROM clients WHERE idClient=?");
$details->execute(array($mod));
$cliInfomod=$details->fetch();

//Modifications des données
if (isset($_POST['modif'])) {

        $quete= "UPDATE clients SET nomClient=?, prenomClient=?, villeClient=?, 
                                adresseClient=?, genreClient=?, telephoneClient=? 
                                WHERE idClient=? ";
        $res = $bdd->prepare($quete);
        $res->execute(array($nomcli, $precli, $vilcli, $adcli, $genrecli, $telcli, $mod));
        if ($res) {
            $succes="Modification effectuée avec succès !...";
            header('location:ajout.php');
        }else {
            $erreur="Modification non effectuée !...";
        }
    }

//Recuperation pour la suppression
@$sup=$_GET['sup'];
// Pour la suppression des camions
if (isset($sup)) {
    $req =$bdd->prepare("DELETE FROM clients WHERE idClient=?");
    $req->execute((array($sup)));
    if ($req) {
        $succes="Suppression effectuée avec succès !...";
        header('location:ajout.php');
    }else {
        $erreur="Suppression non effectuée !...";
    }
}





// Pour aficher la liste des camions
$sql=$bdd->prepare("SELECT * FROM clients ORDER BY nomClient ASC");
$sql->execute(array());
$row=$sql->fetchAll();

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../argon-dashboard-master/assets/img/favicon.png">
  <title>
    Page client
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="../argon-dashboard-master/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../argon-dashboard-master/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../argon-dashboard-master/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../argon-dashboard-master/assets/css/argon-dashboard.css?v=2.0.2" rel="stylesheet" />
</head>

<body class="">
    <!-- Menu de navigation des crud -->
    <?php require '../entete-crud.php'  ?>


  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-100">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
              <div class="card card-plain">
                <div class="card-header pb-0 text-start">

                    <?php 
                        if ($det) {
                    ?>
                        <h4 class="font-weight-bolder">Détails du client</h4>
                        <p class="mb-0">Ci-dessous l'ensemble des informations concertant le client</p> 
                    <?php
                        }  elseif ($mod) {
                    ?>
                        <h4 class="font-weight-bolder">Modification du client</h4>
                        <p class="mb-0">Veuillez mettre à jour les données</p> 
                    <?php
                        } else {
                    ?>
                        <h4 class="font-weight-bolder">Ajout des clients</h4>
                        <p class="mb-0">Veuillez renseigner tous les champs ci-dessous</p>
                    <?php
                        }
                    ?>



                </div>
                <div class="card-body">
                  <form method="post">
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">
                                <?php
                                    if (isset($erreur)) {
                                        echo' <b style=color:red> '.$erreur.' </b>';
                                    }
                                    if (isset($succes)) {
                                        echo' <b style=color:green> '.$succes.' </b>';
                                    }
                                ?>
                            </p>
                        </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="Nom de famille du client" name="nomcli"
                                value="<?php
                                            if ($det) {
                                                echo $cliInfodet['nomClient'];
                                            }elseif ($mod) {
                                                echo $cliInfomod['nomClient'];
                                            }
                                                
                                        ?>"    
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="Prenom(s) du client" name="precli" 
                                value="<?php
                                            if ($det) {
                                                echo $cliInfodet['prenomClient'];
                                            }elseif ($mod) {
                                                echo $cliInfomod['prenomClient'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="La ville du client" name="vilcli" 
                                value="<?php
                                            if ($det) {
                                                echo $cliInfodet['villeClient'];
                                            }elseif ($mod) {
                                                echo $cliInfomod['villeClient'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="L'adresse du client" name="adcli" 
                                value="<?php
                                            if ($det) {
                                                echo $cliInfodet['adresseClient'];
                                            }elseif ($mod) {
                                                echo $cliInfomod['adresseClient'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                        <select name="genrecli" id="" class="form-control form-control-lg">
                            <option value="">
                                        <?php
                                            if ($det) {
                                                echo $cliInfodet['genreClient'];
                                            }elseif ($mod) {
                                                echo $cliInfomod['genreClient'];
                                            }else {
                                                echo "//..Votre client est ?...//";   
                                            }
                                                
                                        ?>
                            </option>
                            <option value="Homme">
                                Homme    
                            </option>
                            <option value="Femme">
                                Femme
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="Le telephone du client" name="telcli" 
                                value="<?php
                                            if ($det) {
                                                echo $cliInfodet['telephoneClient'];
                                            }elseif ($mod) {
                                                echo $cliInfomod['telephoneClient'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    
                    <div class="text-center">
                            <?php 
                                if ($det) {
                            ?>
                                <button type="reset" name="details" class="btn btn-info btn-lg w-100 mt-4 mb-0" onClick="window.location.href='ajout.php' ">
                                    Fermer 
                                </button>
                            <?php
                                }  elseif ($mod) {
                            ?>
                                <button type="submit" name="modif" class="btn btn-primary btn-lg w-100 mt-4 mb-0" onClick="window.location.href='ajout.php' ">
                                            Modifer 
                                 </button>
                                 <button type="reset" name="" class="btn btn-danger btn-lg w-100 mt-4 mb-0" onClick="window.location.href='ajout.php' ">
                                            Annuler 
                                 </button>
                            <?php
                                } else {
                            ?>
                            <button type="submit" name="ok" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Enregistrer </button>
                            <?php
                                }
                            ?>
                            
                      
                    </div>

                    
                    
                  </form>
                </div>
              </div>
            </div>
            <div class="col-7 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
              <div class="position-relative bg-gradient-primary h-100 m-3 px-2 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg');
             background-size: cover;">
              <span class="mask bg-gradient-primary opacity-6"></span> 
                <h4 class="mt-5 text-white font-weight-bolder position-relative">Liste des camions loués</h4>
                        <div class="mt-5 text-white font-weight-bolder position-relative">

                            <table class="table table-dark" style="text-align: center;">

                                <thead style="border : 3px solid white ;">
                                    <tr>
                                        <td> Prenom </td>
                                        <td> Nom </td>
                                        <td> Telephone </td>
                                        <td colspan="3"> Action </td>
                                    </tr>
                                </thead>
                                    <?php foreach ($row as $res) {  ?>
                                        <tbody>
                                            <tr>
                                                <td> <?= $res['prenomClient']; ?> </td>
                                                <td> <?= $res['nomClient']; ?> </td>
                                                <td> <?= $res['telephoneClient']; ?> </td>
                                                <td> 
                                                    <button type="submit" name="" class="btn btn-info" onClick="window.location.href='ajout.php?det=<?= $res['idClient'] ?>' ">
                                                        Détails 
                                                    </button>
                                                </td>
                                                <td> 
                                                    <button type="submit" name="" class="btn btn-primary" onclick="window.location.href='ajout.php?mod=<?= $res['idClient'] ?>' ">
                                                        Modifier 
                                                    </button>
                                                </td>
                                                <td> 
                                                    <button type="submit" name="suppri" class="btn btn-danger" onclick="alert('En êtes-vous sûr ?..')">
                                                        <a href="ajout.php?sup=<?= $res['idClient'] ?>">
                                                            Supprimer
                                                        </a>
                                                    </button>
                                                </td>
                                            </tr>   
                                        </tbody>
                                    <?php } ?>
                            </table>
                        </div>      
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
  </main>
  <!--   Core JS Files   -->
  <script src="../argon-dashboard-master/assets/js/core/popper.min.js"></script>
  <script src="../argon-dashboard-master/assets/js/core/bootstrap.min.js"></script>
  <script src="../argon-dashboard-master/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../argon-dashboard-master/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../argon-dashboard-master/assets/js/argon-dashboard.min.js?v=2.0.2"></script>
</body>

</html>
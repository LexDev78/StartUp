<?php 

require '../connecter.php';

//extraction des variables
    @$refecam=htmlspecialchars($_POST['refecam']);
    @$nompropricam=htmlspecialchars($_POST['nompropricam']);
    @$telpropricam=htmlspecialchars($_POST['telpropricam']);
    @$fraisloccam=$_POST['fraisloccam'];
    @$camcapa=htmlspecialchars($_POST['camcapa']);
    @$camdateloc=htmlspecialchars($_POST['camdateloc']);

if (isset($_POST['ok'])) {

    $count=$bdd->prepare("SELECT referenceCamion FROM camions WHERE referenceCamion=?");
    $count->execute(array($refecam));
	$donnee=$count->rowCount();

    if ($donnee == 0) {
        $sql='INSERT INTO camions(idCamion, referenceCamion, proprietaireCamion, contactProprietaire, 
                                    fraisLocation, capaciteCamion, dateLocation) VALUES (null,"'.$refecam.'", "'.$nompropricam.'", 
                                    "'.$telpropricam.'", "'.$fraisloccam.'", "'.$camcapa.'", "'.$camdateloc.'")';
        $sql=$bdd->query($sql);
            if ($sql) {
                $succes="Camion enregistré avec succès !...";
                header('location:ajout.php');
            }else {
                $erreur="Enrgistrement non effectué !...";
            }
    }else {
        $erreur="Cette réference du camion exite déjà !...";
    }
   
}
// Recuperation pour les détails
@$det=$_GET['det'];
$details=$bdd->prepare("SELECT * FROM camions WHERE idCamion=?");
$details->execute(array($det));
$camInfodet=$details->fetch();

// Recuperation pour les modifications
@$mod=$_GET['mod'];
$details=$bdd->prepare("SELECT * FROM camions WHERE idCamion=?");
$details->execute(array($mod));
$camInfomod=$details->fetch();

//Modifications des données
if (isset($_POST['modif'])) {

        $quete= "UPDATE camions SET referenceCamion=?, proprietaireCamion=?, 
                                    contactProprietaire=?, fraisLocation=?, capaciteCamion=?, dateLocation=? 
                                WHERE idCamion=? ";
        $res = $bdd->prepare($quete);
        $res->execute(array($refecam,$nompropricam,$telpropricam,$fraisloccam,$camcapa,$camdateloc,$mod));
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
    $req =$bdd->prepare("DELETE FROM camions WHERE idCamion=?");
    $req->execute((array($sup)));
    if ($req) {
        $succes="Suppression effectuée avec succès !...";
        header('location:ajout.php');
    }else {
        $erreur="Suppression non effectuée !...";
    }
}





// Pour aficher la liste des camions
$sql=$bdd->prepare("SELECT * FROM camions ORDER BY dateLocation DESC");
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
    Argon Dashboard 2 by Creative Tim
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
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-relative mt-4 py-2 start-0 end-0 mx-4">
          <div class="container-fluid">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="../argon-dashboard-master/pages/dashboard.html">
              Argon Dashboard 2
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            <div class="collapse navbar-collapse" id="navigation">
              <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                  <a class="nav-link d-flex align-items-center me-2 active" aria-current="page" href="../argon-dashboard-master/pages/dashboard.html">
                    <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                    Dashboard
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../argon-dashboard-master/pages/profile.html">
                    <i class="fa fa-user opacity-6 text-dark me-1"></i>
                    Profile
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../argon-dashboard-master/pages/sign-up.html">
                    <i class="fas fa-user-circle opacity-6 text-dark me-1"></i>
                    Sign Up
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link me-2" href="../argon-dashboard-master/pages/sign-in.html">
                    <i class="fas fa-key opacity-6 text-dark me-1"></i>
                    Sign In
                  </a>
                </li>
              </ul>
              <ul class="navbar-nav d-lg-block d-none">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/product/argon-dashboard" class="btn btn-sm mb-0 me-1 btn-primary">Free Download</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
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
                        <h4 class="font-weight-bolder">Détails du camion</h4>
                        <p class="mb-0">Ci-dessous l'ensemble des informations concertant le camion</p> 
                    <?php
                        }  elseif ($mod) {
                    ?>
                        <h4 class="font-weight-bolder">Modification du camion</h4>
                        <p class="mb-0">Veuillez mettre à jour les données</p> 
                    <?php
                        } else {
                    ?>
                        <h4 class="font-weight-bolder">Ajout des camions</h4>
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
                                placeholder="La réference du camion" name="refecam"
                                value="<?php
                                            if ($det) {
                                                echo $camInfodet['referenceCamion'];
                                            }elseif ($mod) {
                                                echo $camInfomod['referenceCamion'];
                                            }
                                                
                                        ?>"    
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="Le nom du propriétaire" name="nompropricam" 
                                value="<?php
                                            if ($det) {
                                                echo $camInfodet['proprietaireCamion'];
                                            }elseif ($mod) {
                                                echo $camInfomod['proprietaireCamion'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="Le contact du propriétaire" name="telpropricam" 
                                value="<?php
                                            if ($det) {
                                                echo $camInfodet['contactProprietaire'];
                                            }elseif ($mod) {
                                                echo $camInfomod['contactProprietaire'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="number" class="form-control form-control-lg" 
                                placeholder="Les frais de location du camion en FCFA" name="fraisloccam" 
                                value="<?php
                                            if ($det) {
                                                echo $camInfodet['fraisLocation'];
                                            }elseif ($mod) {
                                                echo $camInfomod['fraisLocation'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="La capacité du camion" name="camcapa" 
                                value="<?php
                                            if ($det) {
                                                echo $camInfodet['capaciteCamion'];
                                            }elseif ($mod) {
                                                echo $camInfomod['capaciteCamion'];
                                            }
                                                
                                        ?>"
                                required>
                    </div>
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" 
                                placeholder="La date de location du camion" 
                                onfocus="(this.type='date')" name="camdateloc" 
                                value="<?php
                                            if ($det) {
                                                echo $camInfodet['dateLocation']; 
                                            }elseif ($mod) {
                                                echo $camInfomod['dateLocation'];
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
                                        <td> Reference </td>
                                        <td> Frais_Location </td>
                                        <td> Date_Location </td>
                                        <td colspan="3"> Action </td>
                                    </tr>
                                </thead>
                                    <?php foreach ($row as $res) {  ?>
                                        <tbody>
                                            <tr>
                                                <td> <?= $res['referenceCamion']; ?> </td>
                                                <td> <?= $res['fraisLocation']; ?> FCFA  </td>
                                                <td> <?= $res['dateLocation']; ?> </td>
                                                <td> 
                                                    <button type="submit" name="" class="btn btn-info" onClick="window.location.href='ajout.php?det=<?= $res['idCamion'] ?>' ">
                                                        Détails 
                                                    </button>
                                                </td>
                                                <td> 
                                                    <button type="submit" name="" class="btn btn-primary" onclick="window.location.href='ajout.php?mod=<?= $res['idCamion'] ?>' ">
                                                        Modifier 
                                                    </button>
                                                </td>
                                                <td> 
                                                    <button type="submit" name="suppri" class="btn btn-danger" onclick="alert('En êtes-vous sûr ?..')">
                                                        <a href="ajout.php?sup=<?= $res['idCamion'] ?>">
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
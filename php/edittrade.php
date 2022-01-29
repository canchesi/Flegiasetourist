<?php

    require_once('config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

    if(isset($_POST['submitted']))
        header('location: ../trades.php');

    $id = explode("-", $_GET['id']);

    $sql = "
    
        SELECT price_adult, price_underage
        FROM trades
        WHERE harb_dep ='" . $id[0] . "' AND harb_arr = '" . $id[1] . "'
        
        ";

    if($result = $connection->query($sql))
        $row = $result->fetch_array(MYSQLI_ASSOC);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" type="image/x-icon" href="/img/logo.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/img/180.png">

        <!-- Style -->
        <link href="https://coreui.io/demo/4.0/free/css/style.css" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.bundle.min.js"></script>

        <!-- jQuery -->
        <script src="../src/jquery/jquery.js"
                integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <title>Aggiorna informazioni nave</title>
    </head>
    <body>


    <!-- Begin Sidebar -->
    <div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
        <div class="sidebar-brand d-md-flex">
            <button class="header-toggler px-md-0 me-md-3" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                <span class="text-light fs-3">Menu</span>
            </button>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="cil-speedometer nav-icon"></i>
                    Dashboard
                </a>
            </li>
        <li class="nav-item">
            <a class="nav-link" href="../routes.php">
                <i class="cil-compass nav-icon"></i>
                Rotte
            </a>
        </li>
            <li class="nav-item">
                <a class="nav-link" href="../employees.php">
                    <i class="cil-contact nav-icon "></i>
                    Dipendenti
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="warehouse.php">
                    <i class="cil-tags nav-icon"></i>
                    Prenotazioni
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../ships.php">
                    <i class="cil-boat-alt nav-icon"></i>
                    Navi
                </a>
            </li>
                        <li class="nav-item">
                <a class="nav-link" href="../clients.php">
                    <i class="cil-user nav-icon"></i>
                    Clienti
                </a>
            </li>

        </ul>
        <button class="sidebar-toggler" type="button"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle(); "></button>
    </div>
    <!--End Sidebar-->


    <div class="wrapper d-flex flex-column min-vh-100 bg-light">


        <!-- Begin Header -->
        <header class="header header-sticky mb-4">
            <div class="container-fluid">
                <button class="header-toggler px-md-0 me-md-3" type="button"
                        onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
                    <i class="icon icon-lg cil-menu"></i>
                </button>

                <span class="fs-4">Flegias & Tourist</span>

                <a href="../logout.php" class="btn btn-light">Esci</a>
            </div>

        </header>
        <!-- End Header -->


        <!--Begin Content -->
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-5">
                            <div class="card-header">
                                <span class="fs-2">
                                    Aggiorna prezzi
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" method="POST">
                                    <div class="col-md-3">
                                        <label for="Part" class="form-label">Partenza</label>
                                        <input type="text" class="form-control" id="Part" name="harb_dep" value="<?php echo $id[0] ?>" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Arr" class="form-label">Arrivo</label>
                                        <input type="text" class="form-control" id="Arr" name="harb_arr" value="<?php echo $id[1] ?>" disabled>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price_adult" class="form-label">Prezzo maggiorenni</label>
                                        <input type="number" class="form-control" id="price_adult" name="price_adult" placeholder="Prezzo O18" value="<?php echo $row['price_adult'] ?>" required>
                                        <input type="text" name="submitted" value="1" hidden>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price_adult" class="form-label">Prezzo minorenni</label>
                                        <input type="number" class="form-control" id="price_adult" name="price_underage" placeholder="Prezzo U18" value="<?php echo $row['price_underage'] ?>" required>
                                        <input type="text" name="submitted" value="1" hidden>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Aggiorna</button>
                                        <a class="btn btn-outline-secondary" type="submit" href="../trades.php">Annulla</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </div>
        <!--End Content -->
        <!--End Content -->

        <!--Begin Footer -->
        <footer class="footer">
            <div class="">
                Flegias & Tourist
            </div>
            <div class="ms-auto">Danny De Novi & Claudio Anchesi © 2022</div>
        </footer>
        <!-- End Footer -->
    </div>
    </body>

<?php

    if(isset($_POST['submitted'])) {
        $prad = $_POST['price_adult'];
        $prun = $_POST['price_underage'];

        $sql = "
        
                UPDATE trades
                    SET
                        price_adult = '$prad',
                        price_underage = '$prun'
                    WHERE harb_dep = '" . $id[0] . "' AND harb_arr = '" . $id[1] . "'
                
            ";
        echo $sql;
        if (!($result = $connection->query($sql)))
            die('<script>alert("Errore nell\'invio dei dati.")</script>');

    }

?>

</html>
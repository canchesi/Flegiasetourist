<?php

    require_once('config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

    if(isset($_POST['name']))
        header('location: ../ships.php');

    $sql = "
    
        SELECT *
        FROM ships
        WHERE id = " . $_GET['id'] . " 
        
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
        <script src="https://code.jquery.com/jquery-3.6.0.js"
                integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <title>Crea Dipendente</title>
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
                <a class="nav-link" href="../dashboard.php">
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
                <a class="nav-link" href="warehouse.php">
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
                <?php echo print_r($row);?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-5">
                            <div class="card-header">
                                <span class="fs-2">
                                    Nuova nave
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" method="POST">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="<?php echo $row['name'] ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Max passeggeri</label>
                                        <input type="number" class="form-control" id="max_pass" name="max_pass" placeholder="Max passeggeri" value="<?php echo $row['max_pass'] ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Max veicoli</label>
                                        <input type="number" class="form-control" id="max_veh" name="max_veh" placeholder="Max veicoli" value="<?php echo $row['max_veh'] ?>" required>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Aggiorna</button>
                                        <a class="btn btn-outline-secondary" type="submit" href="../ships.php">Annulla</a>
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

    if(isset($_POST['name'])) {
        $id = $row['id'];
        $name = $connection->real_escape_string(ucfirst($_POST['name']));
        $num_pass = $_POST['max_pass'];
        $num_veic = $_POST['max_veh'];

        $sql = "
        
                UPDATE ships
                    SET name = '$name', max_pass = '$num_pass', max_veh = '$num_veic'
                    WHERE id = '$id'
                
            ";

        if (!($result = $connection->query($sql)))
            die('<script>alert("Errore nell\'invio dei dati.")</script>');

    }

?>

</html>
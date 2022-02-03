<?php
require_once('php/config.php');

session_start();

if (!isset($_SESSION['id']))
    header("location: login.php");
else if ($_SESSION['type'] === 'cliente')
    header('location: index.php');


$sql = "SELECT COUNT(id_code) AS employees FROM users WHERE type != 'cliente'";

if ($result = $connection->query($sql)) {
    $employeesCount = $result->fetch_assoc();
}

$sql = "SELECT COUNT(id_code) AS customers FROM users WHERE type = 'cliente'";

if ($result = $connection->query($sql)) {
    $customersCount = $result->fetch_assoc();
}

$sql = "SELECT COUNT(code) AS reservations FROM reservations";

if ($result = $connection->query($sql)) {
    $reservationsCount = $result->fetch_assoc();
}

$sql = "SELECT COUNT(dep_exp) AS routes FROM routes";

if ($result = $connection->query($sql)) {
    $routesCount = $result->fetch_assoc();
}


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
    <script src="src/jquery/jquery.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>

    <title>Dashboard</title>
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
            <a class="nav-link" href="dashboard.php">
                <i class="cil-speedometer nav-icon"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="routes.php">
                <i class="cil-compass nav-icon"></i>
                Rotte
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="employees.php">
                <i class="cil-contact nav-icon "></i>
                Dipendenti
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="ships.php">
                <i class="cil-boat-alt nav-icon"></i>
                Navi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="clients.php">
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

            <a href="logout.php" class="btn btn-light">Esci</a>
        </div>
        <div class="header-divider"></div>
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb my-0 ms-2">
                    <!--
                        <li class="breadcrumb-item">
                            <span>
                                Home
                            </span>
                        </li>
                    -->
                    <li class="breadcrumb-item"><span>Dashboard</span></li>
                </ol>
            </nav>
        </div>
    </header>
    <!-- End Header -->


    <!--Begin Content -->
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">

            <!-- BEGIN WIDGETS -->
            <div class="row mb-4">
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold"><?php echo $employeesCount['employees']; ?></div>
                            <div><h5>Dipendenti</h5></div>

                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold"><?php echo $customersCount['customers']; ?></div>
                            <div><h5>Clienti</h5></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold"><?php echo $reservationsCount['reservations']; ?></div>
                            <div><h5>Prenotazioni</h5></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="fs-4 fw-semibold"><?php echo $routesCount['routes']; ?></div>
                            <div><h5>Rotte</h5></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>

            <!-- END WIDGETS -->


            <div class="row">

                <!--Begin Routes List-->
                <div class="col-md-12 mb-4">
                    <div class="card mb-12">
                        <div class="card-header"><span
                                    class="fs-2">Rotte da oggi <?php $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                echo $formatter->format(time()); ?></span></div>

                        <div class="card-body">
                            <div class="table-responsive" id="warehouseTable">
                                <table class="table border">
                                    <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="text-center">Nave</th>
                                        <th class="text-center">Partenza</th>
                                        <th class="text-center">Arrivo</th>
                                        <th class="text-center">Data partenza prev.</th>
                                        <th class="text-center">Data arrivo prev. </th>
                                        <th class="text-center">Data partenza eff.</th>
                                        <th class="text-center">Data arrivo eff.</th>
                                        <th class="text-center">Capitano</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    $today = date("Y-m-d");

                                    $sql = "
                                            
                                                SELECT ships.name AS ship, ship_id, trade_dep, trade_arr, dep_exp, arr_exp, dep_eff, arr_eff, captain, users.name AS name, surname
                                                    FROM ships JOIN routes
                                                        ON ship_id = id
                                                    JOIN users
                                                        ON id_code = captain
                                                    WHERE dep_exp >= '$today' ORDER BY dep_exp ASC

                                            ";

                                    if ($result = $connection->query($sql)) {

                                        while ($row = $result->fetch_array()) {
                                            if (!$row["dep_eff"])
                                                $row["dep_eff"] = '/';
                                            else
                                                $row['dep_eff'] = date('d/m/Y H:m', strtotime(str_replace('.', '-', $row['dep_eff'])));
                                            if (!$row["arr_eff"])
                                                $row["arr_eff"] = '/';
                                            else
                                                $row['arr_eff'] = date('d/m/Y H:m', strtotime(str_replace('.', '-', $row['arr_eff'])));

                                            echo '
                                                    <tr class="align-middle" id="' . $row["ship_id"] . '-' . $row["dep_exp"] . '">
                                                        <td class="text-center">
                                                            <div>' . $row["ship"] . '</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div>' . $row['trade_dep'] . '</div>
                                                        </td>
                                                        <td class="text-center" >
                                                            <div>' . $row["trade_arr"] . '</div>
                                                        </td>
                                                        <td class="text-center" >
                                                           <div>' . date('d/m/Y H:m', strtotime(str_replace('.', '-', $row['dep_exp']))) . '</div>
                                                        </td>
                                                        <td class="text-center" >
                                                            <div>' . date('d/m/Y H:m', strtotime(str_replace('.', '-', $row['arr_exp']))) . '</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div>' . $row["dep_eff"] . '</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div>' . $row["arr_eff"] . '</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div>' . $row["surname"] . ' ' . $row["name"] . '</div>
                                                        </td>
                                                        <td>
                                                    </tr>
                                                ';
                                        }
                                    }

                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Routes List-->

                <!--Begin Captains List-->
                <div class="col-md-9">
                    <div class="card mb-5">
                        <div class="card-header"><span class="fs-2">Ultimi Capitani</span></div>

                        <div class="card-body">
                            <div class="table-responsive" id="warehouseTable">
                                <table class="table border">
                                    <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="text-center">ID</th>
                                        <th class="">Cognome</th>
                                        <th class="">Nome</th>
                                        <th class="">Email</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    $sql = "
                                        
                                        SELECT id_code, name, surname, email FROM users
                                            WHERE type = 'capitano' ORDER BY id_code DESC LIMIT 5
                                    
                                    ";

                                    if ($result = $connection->query($sql)) {

                                        while ($row = $result->fetch_array()) {
                                            echo '
                                                <tr class="align-middle" id="' . $row["id_code"] . '">
                                                    <td class="text-center">
                                                        <div>' . $row["id_code"] . '</div>
                                                    </td>
                                                    <td class="" style="padding: 20px">
                                                        <div>' . $row["surname"] . '</div>
                                                    </td>
                                                    <td class="" style="padding: 20px">
                                                        <div>' . $row["name"] . '</div>
                                                    </td>
                                                    <td class="" style="padding: 20px">
                                                       <div>' . $row["email"] . '</div>
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Captains List-->

                <!--Begin Ships List-->
                <div class="col-md-3">
                    <div class="card mb-5">
                        <div class="card-header"><span class="fs-2">Ultime Navi</span></div>

                        <div class="card-body">
                            <div class="table-responsive" id="warehouseTable">
                                <table class="table border">
                                    <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="text-center">ID</th>
                                        <th class="">Nome</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    $sql = "
                                        
                                        SELECT * FROM ships
                                           ORDER BY id DESC LIMIT 5
                                    
                                    ";

                                    if ($result = $connection->query($sql)) {

                                        while ($row = $result->fetch_array()) {
                                            echo '
                                                <tr class="align-middle" id="' . $row["id_code"] . '">
                                                    <td class="text-center">
                                                        <div>' . $row["id"] . '</div>
                                                    </td>
                                                    <td class="" style="padding: 20px">
                                                        <div>' . $row["name"] . '</div>
                                                    </td>
                                                </tr>
                                            ';
                                        }
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Ships List-->
            </div>
        </div>
    </div>
    <!--End Content -->

    <!--Begin Footer -->
    <footer class="footer">
        <div class="">Flegias & Tourist</a>
        </div>
        <div class="ms-auto">Danny De Novi & Claudio Anchesi © 2022</div>
    </footer>
    <!-- End Footer -->
</div>
</body>

</html>
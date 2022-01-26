<?php
require_once('php/config.php');

session_start();

if (!isset($_SESSION['id']))
    header("location: login.php");
else if ($_SESSION['type'] === 'cliente')
    header('location: index.php');

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
                <a class="nav-link" href="index.php">
                    <i class="cil-speedometer nav-icon"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
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
                <a class="nav-link" href="warehouse.php">
                    <i class="cil-tags nav-icon"></i>
                    Prenotazioni
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="warehouse.php">
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

                <a href="logout.php" class="btn btn-light">Esci</a>
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
                                    Nuovo dipendente
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nome*</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="surname" class="form-label">Cognome*</label>
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputAddress2" class="form-label">Sesso*</label>
                                        <select class="form-select" name="sex">
                                            <option disabled selected>
                                                Seleziona...
                                            </option>
                                            <option value="M">
                                                Maschio
                                            </option>
                                            <option value="F">
                                                Femmina
                                            </option>
                                            <option value="X">
                                                Altro
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="inputCity" class="form-label">Data di nascita</label>
                                        <input type="date" class="form-control" id="inputCity">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="telefono" class="form-label">Telefono</label>
                                        <input type="text" class="form-control" id="telefono" name="tel">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inputState" class="form-label">State</label>
                                        <select id="inputState" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck">
                                            <label class="form-check-label" for="gridCheck">
                                                Check me out
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
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
            <div class="">Flegias & Tourist</a>
            </div>
            <div class="ms-auto">Danny De Novi & Claudio Anchesi © 2022</div>
        </footer>
        <!-- End Footer -->
    </div>
    </body>

    <script>

    </script>

</html>
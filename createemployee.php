<?php

    require_once('php/config.php');
    require_once('php/residenceinfos.php');

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
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputAddress2" class="form-label">Sesso*</label>
                                        <select class="form-select" name="gender" required>
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
                                    <div class="col-md-3">
                                        <label for="birth" class="form-label">Data di nascita*</label>
                                        <input type="date" class="form-control" id="birth" name="birth_date" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="telefono" class="form-label">Telefono*</label>
                                        <input type="text" pattern="[0-9]*" class="form-control" id="telefono" name="tel" placeholder="Form. 123456789 " required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cf" class="form-label">Codice Fiscale*</label>
                                        <input type="text" class="form-control" id="cf" name="cf" maxlength="16" minlength="16" placeholder="Form. ABCDEF01G23H456J" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="Residenza" class="form-label">Residenza*</label>
                                        <select id="Provincia" class="form-select" name="prov_r" required>
                                            <option disabled selected>Provincia</option>
                                            <?php
                                            foreach($provinces as $prov => $val) {
                                                echo "
                                                        
                                                        <option value='$prov'>
                                                            $val
                                                        </option>
                                                    
                                                    ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="" class="form-label">
                                            <input class="form-check-input" type="checkbox" id="domicile">
                                            <label class="form-check-label" for="domicile">
                                                Residenza coincide con domicilio
                                            </label>
                                        </label>
                                        <select id="Comune" class="form-select" name="city_r" required>
                                            <option disabled selected>Comune</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label for="Domicilio" class="form-label">Domicilio</label>
                                        <select id="Domicilio" class="form-select" name="prov_d">
                                            <option disabled selected>Provincia</option>
                                            <?php
                                            foreach($provinces as $prov => $val) {
                                                echo "
                                                        
                                                        <option value='$prov'>
                                                            $val
                                                        </option>
                                                    
                                                    ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label for="Comune" class="form-label"><br></label>
                                        <select id="Comune" class="form-select" name="city_d">
                                            <option disabled selected>Comune</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <select id="Cap" class="form-select" name="zip_d">
                                            <option disabled selected>CAP</option>

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label show"><br></label>
                                        <input class="col-md-12 form-control" type="text" placeholder="Via/Viale/Piazza" name="addr_r" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label show"><br></label>
                                        <select id="Cap" class="form-select" name="zip_r" required>
                                            <option disabled selected>CAP</option>
                                            <option>a</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <input class="col-md-12 form-control" type="text" placeholder="Via/Viale/Piazza" name="addr_d">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="hair" class="form-label">Altezza*</label>
                                        <input class="form-control" type="number" placeholder="Cm" name="height" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="blood" class="form-label">Gruppo Sanguigno*</label>
                                        <select class="form-select" name="blood" required>
                                            <option disabled selected>
                                                Seleziona...
                                            </option>
                                            <option value="a+">
                                                A+
                                            </option>
                                            <option value="a-">
                                                A-
                                            </option>
                                            <option value="b+">
                                                B+
                                            </option>
                                            <option value="b-">
                                                B-
                                            </option>
                                            <option value="ab+">
                                                AB+
                                            </option>
                                            <option value="ab-">
                                                AB-
                                            </option>
                                            <option value="0+">
                                                0+
                                            </option>
                                            <option value="0-">
                                                0-
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="hair" class="form-label">Colore capelli*</label>
                                        <select class="form-select" name="hair" required>
                                            <option disabled selected>
                                                Seleziona...
                                            </option>
                                            <option value="castani">
                                                Castani
                                            </option>
                                            <option value="biondi">
                                                Biondi
                                            </option>
                                            <option value="rossi">
                                                Rossi
                                            </option>
                                            <option value="">
                                                Pelato
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="eyes" class="form-label">Colore occhi*</label>
                                        <select class="form-select" name="eyes" required>
                                            <option disabled selected>
                                                Seleziona...
                                            </option>
                                            <option value="marrone">
                                                Marroni
                                            </option>
                                            <option value="azzurro">
                                                Azzurri
                                            </option>
                                            <option value="verde">
                                                Verdi
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                        <a class="btn btn-outline-secondary" type="submit" href="employees.php">Annulla</a>
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

    <?php



    ?>

    <script>

        $(function(){
            var checkbox = $('#domicile'),
                hidden = $('.hidden'),
                show = $('.show');

            show.hide()
            checkbox.change(function(){
                if(checkbox.is(":checked")){
                    hidden.hide();
                    show.show();
                } else {
                    hidden.show();
                    show.hide();
                }
            });
        });

    </script>

</html>
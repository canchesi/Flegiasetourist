<?php

    require_once('php/config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'capitano')
        header('location: dashboard.php');
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

    if(isset($_POST['harb_dep']))
        header('location: trades.php');

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
        <script src="src/jquery/jquery.js"
                integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <title>Crea Tratta</title>
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
                                    Nuova tratta
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" method="POST">
                                    <div class="col-md-3">
                                        <label for="harb_dep" class="form-label">Porto di partenza*</label>
                                        <select class="form-select" id="harb_dep" name="harb_dep" required>
                                            <option disabled selected>Partenza</option>
                                            <?php
                                                $sql = "
                            
                                                    SELECT *
                                                    FROM harbors
                                                
                                                ";

                                                if ($result = $connection->query($sql)) {

                                                    $cities = array();
                                                    while ($row = $result->fetch_array(MYSQLI_ASSOC)){
                                                        echo "
                                                            <option value = '" . $row['city'] . "'> " . $row['city'] . " </option>
                                                        ";
                                                        $cities[] = $row['city'];
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="arr_div">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="PrezzoMag" class="form-label">Prezzo maggiorenni*</label>
                                        <input type="number" class="form-control" id="PrezzoMag" name="price_adult" placeholder="Prezzo O18" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="PrezzoMin" class="form-label">Prezzo minorenni*</label>
                                        <input type="number" class="form-control" id="PrezzoMin" name="price_underage" placeholder="Prezzo U18" required>
                                        <input type="text" value="1" name="submitted" hidden>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Aggiungi</button>
                                        <a class="btn btn-outline-secondary" type="submit" href="trades.php">Annulla</a>
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
            $dep = $connection->real_escape_string($_POST['harb_dep']);
            $arr = $connection->real_escape_string($_POST['harb_arr']);
            $prad = $_POST['price_adult'];
            $prun = $_POST['price_underage'];

            $sql = "
                
                        INSERT INTO trades
                            VALUES ('$dep', '$arr', '$prad', '$prun');
                        
                    ";

            if (!$result = $connection->query($sql))
                die('<script>alert("Errore nell\'invio dei dati.")</script>');

        }

    ?>

    <script>

        $(document).ready(function (){
            $("#arr_div").append('<label for="harb_arr" class="form-label">Porto di arrivo*</label> <select class="form-select" id="harb_arr" name="harb_arr" disabled><option disabled selected>Arrivo</option></select>');
        });

        $("#harb_dep").change(function (){
            $("#arr_div").empty();
            $("#arr_div").append('<label for="harb_arr" class="form-label">Porto di arrivo*</label> <select class="form-select" id="harb_arr" name="harb_arr" required> <option disabled selected>Arrivo</option></select>');

            var cities = <?php echo json_encode($cities);?>,
                arr = $("#harb_arr");

            $.ajax({
                url: "php/settrades.php?city="+$("#harb_dep option:selected").text().trim(),
                type: "GET",
                dataType: 'json',
                data: {cities: cities},
                success:function (response){
                    arr.empty();
                    arr.append("<option disabled selected>Arrivo</option>");
                    response.forEach(function (city){
                        arr.append("<option value = '"+city+"'>"+city+"</option>");
                    })
                }
            });
        });


    </script>



</html>
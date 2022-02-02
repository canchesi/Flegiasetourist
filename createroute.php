<?php

    require_once('php/config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

/*    if(isset($_POST['trade_dep']))
        header('location: routes.php');*/


    if(isset($_POST['submitted'])) {

        // Vars

        $shipID = $connection->real_escape_string($_POST['ship_id']);
        $depExp = $connection->real_escape_string($_POST['dep_exp']);
        $arrExp = $connection->real_escape_string($_POST['arr_exp']);
        $captain = $connection->real_escape_string($_POST['captain']);
        $tradeDep = $connection->real_escape_string($_POST['trade_dep']);
        $tradeArr = $connection->real_escape_string($_POST['trade_arr']);

        $error = false;

        if ($depExp >= $arrExp)
            $error = true;
        else {
            $sql = "
                    
                INSERT INTO routes (ship_id, dep_exp, arr_exp, captain, trade_dep, trade_arr)
                    VALUES ('$shipID', '$depExp', '$arrExp', '$captain', '$tradeDep', '$tradeArr');
                
            ";

            if (!($result = $connection->query($sql)))
                echo "Errore nell\'invio dei dati.". $sql;

        }
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
        <script src="src/jquery/jquery.js"
                integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <title>Crea Rotta</title>
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
                <button class="header-toggler px-md-0 me-md-3" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
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
                                    Nuova rotta
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" method="POST">
                                    <?php

                                    if($error)
                                        echo '
                                            <div class="alert alert-danger" role="alert">
                                                Seleziona una data di arrivo successiva alla data di partenza.
                                            </div>
                                        ';
                                    ?>
                                    <div class="col-md-4">
                                        <label for="trade_dep" class="form-label">Porto di partenza*</label>
                                        <select class="form-select" id="trade_dep" name="trade_dep" required>
                                            <option disabled selected>Partenza</option>
                                            <?php

                                                $cities = array();
                                                $sql = '
                                                
                                                    SELECT harb_dep, harb_arr
                                                        FROM trades
                                                        ORDER BY harb_dep
                                                
                                                ';

                                                if ($result = $connection->query($sql)) {
                                                    $last = '';
                                                    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                                        if ($row['harb_dep'] != $last) {
                                                            $last = $row['harb_dep'];
                                                            echo "
                                                                <option value = '" . $row['harb_dep'] . "'> " . $row['harb_dep'] . " </option>
                                                            ";
                                                        }
                                                        $cities[] = array($row['harb_dep'] => $row['harb_arr']);
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dep_exp" class="form-label">Data di partenza*</label>
                                        <div class="" id="dep_div"></div>
                                    </div>
                                    <div class="col-md-4" >
                                        <label for="captain" class="form-label">Capitani disponibili*</label>
                                        <div class="" id="cap_div">
                                        </div>
                                        <input type="text" value="1" name="submitted" hidden>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="trade_arr" class="form-label">Porto di destinazione*</label>
                                        <div class="" id="arr_div"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="arr_exp" class="form-label">Data di arrivo*</label>
                                        <div class="" id="arr_exp_div"></div>
                                    </div>
                                    <div class="col-md-4" >
                                        <label for="ship" class="form-label">Navi*</label>
                                        <div class="" id="ship_div">
                                        </div>
                                        <input type="text" value="1" name="submitted" hidden>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Aggiungi</button>
                                        <a class="btn btn-outline-secondary" type="submit" href="routes.php">Annulla</a>
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

    <script>

        $(document).ready(function (){
                $("#arr_div").append('<select class="form-select" id="trade_arr" name="trade_arr" disabled><option disabled selected>Arrivo</option></select>');
                $("#cap_div").append('<select class="form-select" id="captain" name="captain" disabled><option disabled selected>Capitano</option></select>');
                $("#ship_div").append('<select class="form-select" id="nave" name="nave" disabled><option disabled selected>Nave</option></select>');
                $("#dep_div").append('<input type="datetime-local" class="form-control" id="dep_exp" name="dep_exp" disabled>');
                $("#arr_exp_div").append('<input type="datetime-local" class="form-control" id="arr_exp" name="arr_exp" disabled>');
        });


        var datedep;
        $("#trade_dep").change(function (){
            $("#arr_div").empty();
            $("#arr_div").append('<select class="form-select" id="trade_arr" name="trade_arr" required> <option disabled selected>Arrivo</option></select>');
            var cities = '<?php echo json_encode($cities);?>',
                arr = $("#trade_arr");
            $.ajax({
                url: "php/setroutes.php?city="+$("#trade_dep option:selected").text().trim(),
                type: "GET",
                dataType: 'json',
                data: {cities: cities},
                success:function (response){
                    arr.empty();
                    arr.append("<option disabled selected>Arrivo</option>");
                    response.forEach(function (city) {
                        $("#trade_arr").append("<option value = '"+city+"'>"+city+"</option>");
                    })
                }
            });
        });
        
        $('#arr_div').change(function (){

            $("#dep_div").empty();
            $("#arr_exp_div").empty();
            $("#dep_div").append('<input type="datetime-local" class="form-control" id="dep_exp" name="dep_exp" required>');
            $("#arr_exp_div").append('<input type="datetime-local" class="form-control" id="arr_exp" name="arr_exp" required>');

        });

        $('#dep_div').change(function () {

            $("#cap_div").empty();
            $("#ship_div").empty();
            $("#ship_div").append('<select class="form-select" id="ship_id" name="ship_id" required><option disabled selected>Nave</option></select>');
            $("#cap_div").append('<select class="form-select" id="captain" name="captain" required><option disabled selected>Capitano</option></select>');

            var city = $('#trade_dep option:selected').text().trim();

            $.ajax({
                url: "php/setcapships.php",
                data: {city: city, date: $('#dep_exp').val()},
                type: "GET",
                dataType: "JSON",
                success: function (response){
                    $('#ship_id').empty();
                    $('#captain').empty();
                    $('#ship_id').append('<option disabled selected>Nave</option>');
                    $('#captain').append('<option disabled selected>Capitano</option>');
                    for (var id in response[0]) {
                        $('#captain').append('<option value="'+id+'">'+ response[0][id] +'</option>');
                    }
                    for (id in response[1]) {
                        $('#ship_id').append('<option value="'+id+'">'+ response[1][id] +'</option>');
                    }
                }
            });

        });



    </script>



</html>
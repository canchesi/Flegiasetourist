<?php

require_once('config.php');

/** @var MYSQLI $connection*/

session_start();

if (!isset($_SESSION['id']))
    header("location: login.php");
else if ($_SESSION['type'] === 'capitano')
    header('1location: dashboard.php');
else if ($_SESSION['type'] === 'cliente')
    header('location: index.php');

if (isset($_POST['harb_dep']))
    header('location: routes.php');


$id = $_GET['id'];  //ID rotta

// Query che prende le informazioni della rotta
$sql = "
    SELECT ships.name AS sname, users.name as cname, surname, harb_dep, harb_arr, dep_exp, arr_exp, dep_eff, ret, captain, ship_id
        FROM routes 
        JOIN trades
            ON trade_id = trades.id
        JOIN ships 
            ON ship_id = ships.id 
        JOIN users 
            ON captain = id_code 
    WHERE routes.id = '" . $id . "'
";

if ($result = $connection->query($sql)) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if($row['dep_eff'])
        header('location: ../routes.php');

    // Scambia partenza e arrivo al flag ret = 1
    if($row['ret']){
        $tmp = $row['harb_dep'];
        $row['harb_dep'] = $row['harb_arr'];
        $row['harb_arr'] = $tmp;
        unset($tmp);
    }
}
else
    echo "<script>alert('Errore nel caricamento dei dati.')</script>";


if (isset($_POST['submitted'])) {

    // Vars

    $shipID = $connection->real_escape_string($_POST['ship_id']);   //ID nave
    $captain = $connection->real_escape_string($_POST['captain']);  //ID capitano

    // Query che aggiorna le informazioni della nave
    $sql = "

        UPDATE routes
            SET ship_id = '" . $shipID . "', captain = '" . $captain . "' 
        WHERE id = '" . $id . "'
        
    ";

    if (!($result = $connection->query($sql)))
        echo "<script>alert('Errore nell\'invio dei dati.')</script>";


    header('location: ../routes.php');

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
    <link href="../src/favicon.png" rel="icon">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="../src/jquery/jquery.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <title>Modifica Rotta</title>
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
            <a class="nav-link" href="../dashboard.php">
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
                                    Modifica rotta
                                </span>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST">

                                <!--Begin Porto Di Partenza-->
                                <div class="col-md-4">
                                    <label for="harb_dep" class="form-label">Porto di partenza*</label>
                                    <select class="form-select" id="harb_dep" name="harb_dep" disabled>
                                        <?php
                                        echo "<option selected>" . $row['harb_dep'] . "</option>"
                                        ?>
                                    </select>
                                </div>
                                <!-- End Porto Di Partenza -->

                                <!-- Begin Data Di Partenza -->
                                <div class="col-md-4">
                                    <label for="dep_exp" class="form-label">Data di partenza*</label>
                                    <input type="text" class="form-control" id="dep_exp" name="dep_exp" disabled
                                           value="<?php echo date('d/m/Y H:i', strtotime($row['dep_exp'])); ?>">
                                </div>
                                <!-- End Data Di Partenza -->

                                <!-- Begin Capitani Disponibili -->
                                <div class="col-md-4">
                                    <label for="captain" class="form-label">Capitani disponibili*</label>
                                    <select class="form-select" id="captain" name="captain">
                                        <option selected
                                                id="<?php echo $row['captain']; ?>"> <?php echo $row['captain'];?> </option>
                                    </select>
                                    <input type="text" value="1" name="submitted" hidden>
                                </div>
                                <!-- End Capitani Disponibili -->

                                <!-- Begin Porto Di Destinazione -->
                                <div class="col-md-4">
                                    <label for="harb_arr" class="form-label">Porto di destinazione*</label>
                                    <select class="form-select" id="harb_arr" name="harb_arr" disabled>
                                        <?php
                                        echo "<option selected>" . $row['harb_arr'] . "</option>"
                                        ?>
                                    </select>
                                </div>
                                <!-- End Porto Di Destinazione -->

                                <!-- Begin Data Di Arrivo -->
                                <div class="col-md-4">
                                    <label for="arr_exp" class="form-label">Data di arrivo*</label>
                                    <input type="text" class="form-control" id="arr_exp" name="arr_exp" disabled
                                           value="<?php echo date('d/m/Y H:i', strtotime($row['arr_exp'])); ?>">
                                </div>
                                <!-- End Data Di Arrivo -->

                                <!-- Begin Navi -->
                                <div class="col-md-4">
                                    <label for="nave" class="form-label">Navi*</label>
                                    <select class="form-select" id="nave" name="ship_id"></select>
                                    <input type="text" value="1" name="submitted" hidden>
                                </div>
                                <!-- End Navi -->

                                <!-- Submit Button -->
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Modifica</button>
                                    <a class="btn btn-outline-secondary" type="submit" href="../routes.php">Annulla</a>
                                </div>
                                <!-- End Submit Button -->
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
    $(document).ready(function () {
        $.ajax({
            url: "setcapships.php",
            data: {date: $("#dep_exp").val(), cap: $("#captain").val()},
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                $('#nave').empty();
                $('#captain').empty();
                $('#nave').append('<option value="<?php echo $row['ship_id'];?>" selected><?php echo $row['sname'];?></option>');
                $('#captain').append("<option selected value='<?php echo $row['captain'];?>'><?php echo $row['surname'] . ' ' . $row['cname'];?></option>");

                for (var id in response[0])
                    $('#captain').append('<option value="' + id + '">' + response[0][id] + '</option>');

                for (id in response[1])
                    $('#nave').append('<option value="' + id + '">' + response[1][id] + '</option>');
            }
        });

    })

    $(document).change("#dep_exp, #arr_exp", function () {
        $.ajax({
            url: "setcapships.php",
            data: {date: $("#dep_exp").val(), cap: $("#captain").val()},
            type: "GET",
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                $('#nave').empty();
                $('#captain').empty();
                $('#nave').append('<option value="<?php echo $row['ship_id'];?>" selected><?php echo $row['sname'];?></option>');
                $('#captain').append("<option selected value='<?php echo $row['captain'];?>'><?php echo $row['surname'] . ' ' . $row['cname'];?></option>");

                for (var id in response[0])
                    $('#captain').append('<option value="' + id + '">' + response[0][id] + '</option>');

                for (id in response[1])
                    $('#nave').append('<option value="' + id + '">' + response[1][id] + '</option>');
            }
        });

    })
</script>


</html>
<?php
    require_once('php/config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');


    $sql = "SELECT COUNT(id_code) AS employees FROM users WHERE type != 'cliente'";

    if ($result = $connection->query($sql))
        $employeesCount = $result->fetch_assoc();

    $sql = "SELECT COUNT(id_code) AS customers FROM users WHERE type = 'cliente'";

    if ($result = $connection->query($sql))
        $customersCount = $result->fetch_assoc();

    $sql = "SELECT COUNT(code) AS reservations FROM reservations";

    if ($result = $connection->query($sql))
        $reservationsCount = $result->fetch_assoc();

    $sql = "SELECT COUNT(dep_exp) AS routes FROM routes";

    if ($result = $connection->query($sql))
        $routesCount = $result->fetch_assoc();

    $sqltrades = "SELECT harb_dep, harb_arr FROM trades";

    if (isset($_POST['AddShip']) && $_POST['AddShip'] == 1) {

        $name = $connection->real_escape_string(ucfirst($_POST['name']));
        $trade = explode('-', $_POST['trade'], 2);

        $sql = "
                
            INSERT INTO ships (name, harb1, harb2)
                VALUES ('$name', NULLIF('$trade[0]',''), NULLIF('$trade[1]',''));
            
        ";

        if (!($result = $connection->query($sql)))
            die('<script>alert("Errore nell\'invio dei dati.")</script>');
        else
            header('location: dashboard.php');
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
    <link href="/src/favicon.png" rel="icon">

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
        <?php
        if ($_SESSION['type'] !== 'capitano')
            echo '
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
              ';
        ?>

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

            <a href="index.php" style="text-decoration: none; color: #374253"><span class="fs-4">Flegias & Tourist</span></a>

            <div class="btn-group">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-coreui-toggle="dropdown" aria-expanded="false">

                    <?php
                    echo $_SESSION['name'] . ' ' . $_SESSION['surname'];
                    ?>

                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="<?php echo "php/editcaptain.php?id=".$_SESSION['id'];?>">Modifica Profilo</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li> <a href="logout.php" class="dropdown-item">Esci</a>
                    </li>
                </ul>
            </div>
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
                                    class="fs-2"><?php
                                if ($_SESSION['type'] === 'capitano')
                                    echo 'Le tue rotte di oggi ';
                                else
                                    echo 'Rotte di oggi ';

                                $formatter = new IntlDateFormatter('it_IT', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                echo $formatter->format(time()); ?></span>
                        </div>


                        <div class="card-body pt-0">

                            <?php

                            if ($_SESSION['type'] == 'capitano')
                                echo '
                                    <div class="m-2">
                                        <button class="btn btn-success my-2" id="startTripBtn">Avvia Viaggio</button>
                                    </div>
                                ';
                            else
                                echo '<div class="m-4"></div>';
                            ?>

                            <div class="table-responsive" id="warehouseTable">
                                <table class="table border" id="routes">
                                    <thead class="table-light fw-semibold">
                                    <tr class="align-middle">
                                        <th class="text-center">Nave</th>
                                        <th class="text-center">Partenza</th>
                                        <th class="text-center">Arrivo</th>
                                        <th class="text-center">Data partenza prev.</th>
                                        <th class="text-center">Data arrivo prev.</th>
                                        <th class="text-center">Data partenza eff.</th>
                                        <th class="text-center">Data arrivo eff.</th>
                                        <th class="text-center">Capitano</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">

                                    <?php

                                    $id = $_SESSION['id'];
                                    $today = date("Y-m-d");
                                    $tomorrow = (new DateTime($today))->modify('+1 day')->format('Y-m-d');
                                    $sql = "
                                                
                                        SELECT ships.name AS ship, ship_id, trade_dep, trade_arr, dep_exp, arr_exp, dep_eff, arr_eff, captain, users.name AS name, surname, ret, routes.deleted AS delroute
                                            FROM ships JOIN routes
                                                ON ship_id = id
                                            JOIN users
                                                ON id_code = captain
                                            WHERE dep_exp >= '$today' AND dep_exp < '$tomorrow'

                                    ";

                                    if ($_SESSION['type'] === 'capitano')
                                        $sql .= "AND captain = '$id'";

                                    $sql .= "ORDER BY dep_exp ASC";


                                    if ($result = $connection->query($sql)) {
                                        $row = $result->fetch_array();
                                        if (!$row)
                                            echo '
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center">Nessuna rotta per oggi</div>
                                                ';
                                        else {
                                            while ($row) {
                                                if ($row['ret']) {
                                                    $tmp = $row['trade_dep'];
                                                    $row['trade_dep'] = $row['trade_arr'];
                                                    $row['trade_arr'] = $tmp;
                                                    unset($tmp);
                                                }
                                                if (!$row["dep_eff"])
                                                    $row["dep_eff"] = '~';
                                                else
                                                    $row['dep_eff'] = date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['dep_eff'])));
                                                if (!$row["arr_eff"])
                                                    $row["arr_eff"] = '~';
                                                else
                                                    $row['arr_eff'] = date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['arr_eff'])));

                                                echo '
                                                    <tr class="align-middle'; if($row['delroute']) echo ' text-decoration-line-through'; echo'" id="' . $row["ship_id"] . '-' . $row["dep_exp"] . '">
                                                        <td class="text-center">
                                                            <div>' . $row["ship"] . '</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div>' . $row['trade_dep'] . '</div>
                                                        </td>
                                                        <td class="text-center" >
                                                            <div>' . $row["trade_arr"] . '</div>
                                                        </td>
                                                        <td class="text-center deff" >
                                                           <div>' . date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['dep_exp']))) . '</div>
                                                        </td>
                                                        <td class="text-center aeff" >
                                                            <div>' . date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['arr_exp']))) . '</div>
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
                                                $row = $result->fetch_array();
                                            }
                                            echo '</tbody></table>';
                                        }
                                    }

                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Routes List-->


                <!--Begin Captains List-->

                <?php

                if ($_SESSION['type'] != 'capitano') {
                    echo '
                    <div class="col-md-8">
                        <div class="card mb-5">
                            <div class="card-header">
                                <span class="fs-2">
                                    Capitani
                                </span>
                                <span class="fs-3" style="float: right">
                                    <a href="createemployee.php?type=capitano" type="button" class="btn btn-primary">
                                        Aggiungi
                                    </a>
                                </span>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive" style="max-height: 320px;overflow-y: auto;" id="captains">
                                    <table class="table border">
                                        <thead class="table-light fw-semibold">
                                            <tr class="align-middle">
                                                <th class="text-center">ID</th>
                                                <th class="text-center">Cognome</th>
                                                <th class="text-center">Nome</th>
                                                <th class="text-center">Email</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ';
                }
                ?>
                <?php
                if ($_SESSION['type'] != 'capitano') {

                    $sql = "
                                                
                        SELECT id_code, name, surname, email FROM users
                            WHERE type = 'capitano' AND NOT deleted ORDER BY id_code ASC
                    
                    ";

                    if ($result = $connection->query($sql)) {

                        while ($row = $result->fetch_array()) {
                            echo '
                                <tr class="align-middle" id="' . $row["id_code"] . '">
                                    <td class="text-center">
                                        <div>' . $row["id_code"] . '</div>
                                    </td>
                                    <td class="text-center">
                                        <div>' . $row["surname"] . '</div>
                                    </td>
                                    <td class="text-center">
                                        <div>' . $row["name"] . '</div>
                                    </td>
                                    <td class="text-center">
                                       <div>' . $row["email"] . '</div>
                                    </td>
                                    <td></td>
                                </tr>
                            ';
                    }
                    }
                }
                ?>

                <?php
                if ($_SESSION['type'] != 'capitano')
                    echo "
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                            ";
                ?>
                <!--End Captains List-->

                <!--Begin Ships List-->
                <?php

                if ($_SESSION['type'] != 'capitano') {

                    echo '
                    <div class="col-md-4">
                    <div class="card mb-5">
                        <div class="card-header">
                                <span class="fs-2">
                                    Navi
                                </span>
                            <span class="fs-3" style="float: right">
                                    <button type="button" class="btn btn-primary addshipButton">
                                        Aggiungi
                                    </button>
                                </span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="max-height: 320px;overflow-y: auto;" id="ships">
                                <table class="table border">
                                    <thead class="table-light fw-semibold ">
                                    <tr class="align-middle">
                                        <th class="text-center">
                                            ID
                                        </th>
                                        <th class="text-center">
                                            Nome
                                        </th>
                                        <th class="text-center">
                                            Tratta
                                        </th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                    ';
                } ?>

                <?php

                if ($_SESSION['type'] != 'capitano') {

                    $sql = "
                                                    
                        SELECT * FROM ships
                            WHERE NOT unused
                            ORDER BY id ASC
                    
                    ";

                    if ($result = $connection->query($sql)) {
                        $reserve = array();
                        while ($row = $result->fetch_array()) {
                            if ($row['harb1'] && $row['harb2'])
                                echo '
                                    <tr class="align-middle" id="' . $row["id"] . '">
                                        <td class="text-center">
                                            <div>' . $row["id"] . '</div>
                                        </td>
                                        <td class="text-center">
                                            <div>' . $row["name"] . '</div>
                                        </td>
                                        <td class="text-center">
                                            <div>' . $row["harb1"] . '-' . $row["harb2"] . '</div>
                                        </td><td></td></tr>';
                            else
                                $reserve[] = '
                                    <tr class="align-middle table-warning" id="' . $row["id"] . '">
                                        <td class="text-center">
                                            <div>' . $row["id"] . '</div>
                                        </td>
                                        <td class="text-center">
                                            <div>' . $row["name"] . '</div>
                                        </td>
                                        <td class="text-center">
                                            <div>Riserva</div>
                                        </td><td></td></tr>';
                        }
                        foreach ($reserve as $res)
                            echo $res;


                        echo '
                        
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                        ';

                    }
                }
                ?>

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

<!-- Modal -->

<div class="modal fade" id="AddShips" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" id="add_ship">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddShipsTitle">Aggiungi nave</h5>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nome*</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="trade" class="form-label">Tratte*</label>
                        <select class="form-select" name="trade" required>
                            <option value="-" selected>Riserva</option>
                            <?php
                            if ($result = $connection->query($sqltrades))
                                while ($row = $result->fetch_array(MYSQLI_ASSOC))
                                    echo '
                                        <option value="' . $row['harb_dep'] . '-' . $row['harb_arr'] . '">' . $row['harb_dep'] . '-' . $row['harb_arr'] . '</option>
                                    ';
                            ?>
                        </select>
                    </div>
                </div>
                <input type="text" name="AddShip" value="1" hidden>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary addshipButton">Chiudi</button>
                <button type="submit" class="btn btn-primary" form="add_ship">Aggiungi</button>
            </div>
        </div>
    </div>
</div>

<!-- END Modal -->


<!-- Begin Trip Modal -->

<div class="modal fade" id="startTrip" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddShipsTitle">Attenzione</h5>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">

                    Nessuna rotta per oggi!

                </div>
            </div>
            <input type="text" name="AddShip" value="1" hidden>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="startTripBtn">Chiudi</button>
                <!--                <button type="submit" class="btn btn-primary" form="add_ship">Aggiungi</button>-->
            </div>
        </div>
    </div>
</div>


<!-- END Trip Modal -->

<!-- Modal -->

<div class="modal fade" id="addNote" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="add_Note">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddShipsTitle">Nota di Viaggio</h5>
                </div>
                <div class="modal-body row">
                    <div class="col-md-12">
                        <label for="note" class="form-label">Nota</label>
                        <textarea class="form-control" id="note" rows="5" name="note" placeholder="Inserisci nota..."
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary submitNote">Aggiungi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- END Modal -->


</body>

<script>

    var myModal = new coreui.Modal($('#AddShips'), {
        keyboard: false
    })

    var myModal2 = new coreui.Modal($('#addNote'), {
        keyboard: false,
        backdrop: 'static'
    })

    $(document).on('click', '.addshipButton', function () {
        $('#AddShips').modal('toggle');
    })

    $(document).ready(function () {
        var end = 1;
        $('#routes tr').each(function (index, tr){
            if ($(this).find('td').eq(6).find('div').text() !== '~')
                return true;
            else if (!($(tr).hasClass('text-decoration-line-through'))) {
                end = 0;
                return false;
            }
        })

        if (($('#routes tr:last td:eq(5) div').text() !== '~' && $('#routes tr:last td:eq(6) div').text() !== '~') || end)
            $('#startTripBtn').toggleClass('btn-success btn-warning');

        $('#routes tbody tr').each(function (i, tr){
            if ($(tr).find('td:eq(5) div').text() !== '~' && $(tr).find('td:eq(6) div').text() === '~') {
                $('#startTripBtn').toggleClass('btn-success btn-danger');
                $('#startTripBtn').text('Fine Viaggio');

                return false;
            }
        })

    });

    $(document).on('click', '#startTripBtn, .submitNote', function () {
        var txt = $('#startTripBtn').text(),
            today = '<?php echo $today;?>',
            tomorrow = '<?php echo $tomorrow;?>',
            start = 0,
            note = "";

        if ($('#startTripBtn').hasClass('btn-danger')) {
            $('#addNote').modal('toggle');
            start = 1;
            note += $('#note').val();
        }

        if ($('#startTripBtn').hasClass('btn-warning'))
            $('#startTrip').modal('toggle');

        if ($(this).hasClass('btn-success') || $(this).hasClass('submitNote')) {
            $.ajax({
                url: 'php/starttrip.php',
                type: 'GET',
                data: {today: today, tomorrow: tomorrow, start: start, note: note},
                success: function (response) {
                    if (response) {
                        $('#startTripBtn').toggleClass('btn-success btn-danger');
                        $('#startTripBtn').text(txt === 'Avvia Viaggio' ? 'Fine Viaggio' : 'Avvia Viaggio');
                        window.location.replace('dashboard.php');
                    } else {
                        $('#startTrip').modal('toggle');
                    }
                }
            })
        }
    })


    $('.deleteButton').click(function () {
        var tr = $(this).closest('tr'),
            del_id = $(tr).attr('id');

        $.ajax({
            method: 'GET',
            url: "php/deleteship.php?id=" + del_id,
            cache: false,
            success: function () {
                tr.fadeOut(1000, function () {
                    $(this).remove();
                });
            }
        });
    });

    $(document).on("click", ".orderButton", function () {
        var column = $(this).attr("id"),
            order = $(this).data("order");

        $.ajax({
            url: "php/sortships.php",
            method: "POST",
            data: {column: column, order: order},
            success: function (data) {
                $('#ships').html(data);
            }
        });
    });

</script>

</html>
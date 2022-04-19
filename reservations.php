<?php
require_once('php/config.php');

session_start();

if (isset($_SESSION['id']))
    if (!$_SESSION['type'] === 'cliente')
        header('location: dashboard.php');
?>


<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/src/favicon.png" rel="icon">

    <!-- Style -->
    <link href="../src/favicon.png" rel="icon">
    <link href="src/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- JavaScript -->
    <script src="src/js/coreui.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="src/jquery/jquery.js"></script>
    <title>Flegias & Tourist</title>

    <style>
        img {
            width: 100%;
            height: auto;
        }

    </style>

</head>
<body>
<!-- Begin Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Flegias & Tourist</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            </ul>
            <form class="d-flex">


                <?php

                if (isset($_SESSION['type'])) {
                    /*   if ($_SESSION['type'] != 'cliente') {
                           echo '<a class="btn btn-outline-primary me-2" href="dashboard.php">Area Riservata</a>';
                       }
                       echo '<a class="btn btn-outline-danger me-2" href="logout.php">Logout</a>';*/

                    $sql = "SELECT name, surname FROM users WHERE id_code = " . $_SESSION['id'];

                    if ($result = $connection->query($sql)) {
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        echo '
                                    <div class="dropstart">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            ' . $row['name'] . ' ' . $row['surname'] . '
                                        </a>
                                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                ';

                        if ($_SESSION['type'] == 'cliente')
                            echo '
                                        <li><a class="dropdown-item" href="#">I miei ordini</a></li>
                                        <li><a class="dropdown-item" href="php/editclientinfo.php">Gestione profilo</a></li>
                                        <li class="dropdown-divider"></li>
                                    ';


                        echo '
                                   <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                      </ul>
                                    </div>
                                ';
                    }


                } else {
                    echo '
                                <a class="btn btn-outline-primary me-2" href="login.php">Accedi</a>
                                <a class="btn btn-outline-success" href="register.php">Registrati</a>
                            ';
                }

                ?>

            </form>
        </div>
    </div>
</nav>
<!-- End Navbar-->



<!-- Begin Content -->

<div class="container-lg mt-4">

    <h1>I miei ordini</h1>

    <table class="table table-bordered" id="routes">
        <thead class="table-light fw-semibold">
            <th class="">Data di prenotazione</th>
            <th class="">Tratta</th>
            <th class="">Data di partenza</th>
            <th>Numero Biglietti</th>
            <th class="">Totale</th>
            <th class="text-center">Azioni</th>
        </thead>
        <tbody>
            <?php
                $sql = "SELECT * FROM reservations 
                            JOIN routes ON routes.id = reservations.route_id 
                            JOIN `user-card_matches` AS ucm ON payment_id = ucm.id 
                            JOIN trades ON routes.trade_id = trades.id
                            LEFT JOIN vehicles ON type = vehicle 
                        WHERE ucm.user_id = '".$_SESSION['id']. "' AND routes.deleted = 0
                        ORDER BY date_res DESC
";

                if($result = $connection->query($sql)){
                    while($row = $result->fetch_array(MYSQLI_ASSOC)){
                        if($row['ret']) {
                            $tmp = $row["harb_dep"];
                            $row["harb_dep"] = $row['harb_arr'];
                            $row["harb_arr"] = $tmp;
                            unset($tmp);
                        }

                        echo '<tr id="'.$row['code'].'"';
                        if($row['undone'])
                            echo 'class="text-decoration-line-through"';
                        if (!$row['vehicle'])
                            $row['vehicle'] = 'Nessuno';
                        echo '>
                                  <td>'.date("d/m/Y H:i", strtotime($row["date_res"])).'</td>
                                  <td>'.$row["harb_dep"].'-'.$row["harb_arr"].'</td>
                                  <td>'.date("d/m/Y H:i", strtotime($row["dep_exp"]));

                        if($row['deleted'])
                            echo '<br><span class="badge bg-danger">Annullata</span>';

                        echo '</td><td>Adulti: '.$row["adults"].' | Ragazzi: '.$row['underages'].'<br>Veicolo: '.$row["vehicle"];

                            echo'
                                  </td>
                                  <td>€'.number_format($row['subtotal'], 2).'</td>
                                  
                               ';


                        if(date('Y-m-d H:i') <= ((new DateTime($row['dep_exp']))->modify('-1 day')->format('Y-m-d H:i')) && $row['undone'] === '0' && !$row['deleted'])
                            echo '<td class="text-center"><form><a href="#" class="btn btn-danger delete">Annulla</a></form></td>';
                        else
                            echo '<td class="text-center"><a class="btn btn-secondary" disabled>Annulla</a></td>';

                        echo '</tr>';
                    }
                }

            ?>
        </tbody>

    </table>

</div>




<!-- End Content -->

<!-- Begin Footer -->
<!--<div class="container fixed-bottom">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3"></ul>
        <p class="text-center text-muted">© 2022 Flegias & Tourist</p>
    </footer>
</div>-->
<!-- End Footer -->



</body>

<script type="text/javascript">

    $(document).on('click', '.delete', function () {

        var tr = $(this).closest('tr'),
            btns = $(this).closest('form'),
            idres = tr.attr('id');

        $.ajax({
            url: "php/deleteres.php?idres="+idres,
            type: "GET",
            success: function (response) {
                console.log(response);
                if (response === '0') {
                    tr.addClass("text-decoration-line-through");
                    btns.fadeOut(1000, function () {
                        btns.empty();
                        btns.html('<a href="" class="btn btn-secondary" disabled>Annulla</a>');
                        btns.fadeIn(1000);
                    });
                } else
                    alert("Errore.");
            }
        })


    });


</script>

</html>



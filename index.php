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

    <!-- Style -->
    <link href="src/favicon.png" rel="icon">
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
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
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
                                <li><a class="dropdown-item" href="reservations.php">I miei ordini</a></li>
                                <li><a class="dropdown-item" href="php/editclientinfo.php">Gestione profilo</a></li>
                                <li class="dropdown-divider"></li>
                            ';
                        else
                            echo '
                                <li><a class="dropdown-item" href="dashboard.php">Area Privata</a></li>
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

<!-- Begin Carousel -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="src/img/img1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption text-start d-md-block">
                <h1>Prenota il tuo viaggio</h1>
                <p>Scopri le offerte dedicate ai minori...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="src/img/img2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption text-center d-md-block">
                <h1>Scopri</h1>
                <p>Scopri i nostri itinerari...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="src/img/img3.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption text-end d-md-block">
                <h1>Iscriviti</h1>
                <p>Iscriviti per prenotare il tuo prossimo viaggio...</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- End Carousel -->

<div class="card">
    <div class="card-body">
        <form class="row text-center h-100" id="form">
            <div class="col-12 h1 text-center mb-4">Cerca soluzioni</div>
            <div class="col-1">

            </div>

            <div class="mb-3 col-md-3">
                <label for="harb_dep" class="form-label">Porto di partenza</label>
                <select class="form-select" id="harb_dep" name="harb_dep">
                    <option disabled selected>Partenza</option>
                    <?php
                    $sql = "
                                
                        SELECT *
                        FROM harbors
                    
                    ";

                    if ($result = $connection->query($sql)) {
                        $cities = array();
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            echo "
                                <option value = '" . $row['city'] . "'> " . $row['city'] . " </option>
                            ";
                            $cities[] = $row['city'];
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="harb_arr" class="form-label">Porto di arrivo</label>
                <input type="text" class="form-control" id="harb_arr" name="harb_arr" placeholder="Arrivo"
                       style="background-color: white" readonly>
            </div>


            <div class="mb-3 col-md-3">
                <label for="date" class="form-label">Data di partenza</label>
                <input type="datetime-local" class="form-control" id="date" min="<?php echo date("Y-m-d"); ?>">

            </div>

            <div class="col-md-auto">
                <label for="date" class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-primary form-control sub">Cerca</button>
            </div>
        </form>
    </div>
</div>

<div class="container-sm align-content-center">
    <div class="row table-responsive routetable">
    </div>
</div>

<div class="container px-4 py-5" id="hanging-icons">
    <h2 class="pb-2 border-bottom">Flegias & Tourist</h2>
    <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
        <div class="col d-flex align-items-start">

            <div>
                <h2>Destinazioni</h2>
                <p>Destinazioni da e verso i più belli porti del Sud Italia. Potrete godervi il mare della Sicilia e
                    della Calabria e il sole della Campania.</p>

            </div>
        </div>
        <div class="col d-flex align-items-start">
            <div>
                <h2>Sconti</h2>
                <p>Offriamo sconti per i ragazzi per tutti gli itinerari.</p>
            </div>
        </div>
        <div class="col d-flex align-items-start">
            <div>
                <h2>Le Nostre Navi</h2>
                <p>Le nostre navi offrono il confort di cui hai bisogno! Troverai a bordo un centro di ristorazione,
                    balconi vista mare souvenir e tanto altro...</p>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        </ul>
        <p class="text-center text-muted">© 2022 Flegias & Tourist</p>
    </footer>
</div>


<!-- BEGIN MODAL -->
<div class="modal" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Prenota</h5>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="row">
                        <input type="text" id="id" hidden>
                        <div class="col-md-6">
                            <label for="partenza" class="col-form-label">Partenza</label>
                            <div class="form-control" id="partenza"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="arrivo" class="col-form-label">Arrivo</label>
                            <div class="form-control" id="arrivo"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="dep_exp" class="col-form-label">Data partenza</label>
                            <div class="form-control" id="dep_exp"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="arr_exp" class="col-form-label">Data arrivo</label>
                            <div class="form-control" id="arr_exp"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="maggiorenni" class="col-form-label">Adulti</label>
                            <input type="number" class="form-control mb-3" value="1" id="maggiorenni" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label for="minorenni" class="col-form-label">Ragazzi</label>
                            <input type="number" class="form-control mb-3" value="0" id="minorenni" min="0">
                        </div>
                        <div class="col-12">
                            <label for="veicolo" class="col-form-label">Tipo di veicolo</label>
                            <select class="form-select" id="veicolo" required>
                                <option value="0">Nessuno</option>
                                <?php
                                $sql = "SELECT * FROM vehicles";

                                if ($result = $connection->query($sql))
                                    while ($row = $result->fetch_array(MYSQLI_ASSOC))
                                        echo '<option value="' . $row['charge'] . '">' . $row['type'] . ' +€' . $row['charge'] . '</option>';
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="saved_payment" class="col-form-label">Metodo di pagamento</label>
                            <select id="saved_payment" class="form-select mb-3">
                                <option disabled selected>
                                    Seleziona...
                                </option>
                                <option value="-1">
                                    Paga in cassa
                                </option>
                                <?php
                                $sql = "SELECT * FROM credit_cards WHERE user = " . $_SESSION['id'];

                                if ($result = $connection->query($sql))
                                    while ($row = $result->fetch_array(MYSQLI_ASSOC))
                                        echo '<option value="' . $row['id'] . '">xxxx-xxxx-xxxx-x' . substr($row['number'], -3) . '</option>';
                                ?>
                                <option value="0">
                                    Inserisci carta...
                                </option>
                            </select>
                        </div>
                        <div class="col-md-12 row" id="newCardForm" style="display: none;">
                            <div class="col-md-12">
                                <label class="col-form-label" for="cardNumber">Numero carta: </label>
                                <input type="number" class="form-control" id="cardNumber" placeholder="**** **** **** ****">
                                <span class="text-danger mb-3" id="cardNumberError" style="display: none;">Numero carta non valido.</span>
                            </div>
                            <div class="col-md-6">
                                <label for="expirationDate" class="col-form-label">Data di scadenza</label>
                                <input id="expirationDate" placeholder="mm/yy" class="form-control mb-3" type="month">
                                <span class="text-danger mb-3" id="expDateError" style="display: none;">Data di scadenza non valida.</span>
                            </div>
                            <div class="col-md-6">
                                <label for="CVV" class="col-form-label">CVV</label>
                                <input id="CVV" class="form-control" type="number" style="-webkit-appearance: none;" min="0" max="999">
                                <span class="text-danger mb-3" id="CVVNumberError" placeholder="123" style="display: none;">CVV non valido.</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <h3 class="mt-2">Totale:</h3>
                            <h5 id="price"></h5>
                            <h6 class="text-secondary" id="iva"></h6>
                        </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary reservationModalBtn close">Annulla</button>
            <button type="button" class="btn btn-primary book">Prenota</button>
        </div>
    </div>
</div>
<!-- END MODAL -->

</body>

<script type="text/javascript">

    var myModal = new coreui.Modal($('#reservationModal'), {
        keyboard: false
    });

    $(document).ready(function() {

    });

    $(document).on('click', '.reservationModalBtn', function () {
        if (!($(this).hasClass('close'))) {
            var tr = $(this).closest('tr'),
                ids = $(tr).attr('id'),
                harbs = $(tr).find('td:eq(0)').text().split(' - ', 2),
                price = $(tr).find('td:eq(3)').text().split('Ragazzo:\t', 2)[0].replace('Adulto:\t', ''),
                dep_exp = $(tr).find('td:eq(1)').text(),
                arr_exp = $(tr).find('td:eq(2)').text();

            $('#id').attr('value', ids);

            $('#dep_exp').text(dep_exp);
            $('#arr_exp').text(arr_exp);
            $('#partenza').text(harbs[0]);
            $('#arrivo').text(harbs[1]);
            $('#maggiorenni').val('1').change();
            $('#minorenni').val('0').change();
            $('#veicolo').val('0').change();
            $('#price').text(price);
        }

        $('#reservationModal').modal('toggle');

    });

    $("#harb_dep").on('change', function () {
        var arr = $("#harb_arr");
        $.ajax({
            url: "php/setroutes.php?city=" + $("#harb_dep option:selected").text().trim(),
            type: "GET",
            dataType: 'json',
            success: function (response) {
                arr.empty();
                response.forEach(function (city) {
                    $("#harb_arr").val(city);
                })
            }
        });
    });

    $(document).on('change', '#maggiorenni, #minorenni, #veicolo', function () {
        var prices = $('#routes tr td:eq(3)').text().split('Ragazzo:\t€', 2);
        prices[0] = prices[0].replace('Adulto:\t€', '');
        var total = (parseFloat($('#maggiorenni').val()).toFixed(2) * prices[0] + parseFloat($('#minorenni').val()).toFixed(2) * prices[1] + 1.00 * parseFloat($('#veicolo option:selected').val()).toFixed(2)).toFixed(2);
        $('#price').text('€' + total);
        $('#iva').text("di cui IVA: €" + (total * 0.18).toFixed(2));

    });

    $('.sub').on('click', function () {
        var trade_dep = $('#harb_dep').val(),
            trade_arr = $('#harb_arr').val(),
            date = $('#date').val();


        $.ajax({
            url: "php/searchroute.php",
            type: "GET",
            data: {
                    trade_dep: trade_dep,
                    trade_arr: trade_arr,
                    dep_exp: date
            },
            success: function (response) {
                $('.routetable').empty();
                $('.routetable').html(response);
            }
        })
    });

    var validation;

    $(document).on('change', '#saved_payment', function() {
        validation = $('#saved_payment').val();
        if(validation === '0')
            $('#newCardForm').removeAttr('style');
        else {
            $('#newCardForm').hide();
            if(validation){
                //TODO controllo carta
            }
        }
    })

    $(document).on('click', '.book', function () {
        if(validation === '0') {
            var id = $('#id').val(),
                dep_exp = $('#dep_exp').val(),
                adult = $('#maggiorenni').val(),
                minori = $('#minorenni').val(),
                veicolo = $('#veicolo option:selected').text();


            //Credit card validation
            var cardNumber = $('#cardNumber').val();
            var cardNumberRegex = /^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14})$/;
            var cardNumberResult = cardNumberRegex.test(cardNumber);
            if (!cardNumberResult)
                $("#cardNumberError").removeAttr("style");
            else
                $("#cardNumberError").hide();

            //CVV Validation
            var CVVNumber = $("#CVV").val();
            var CVVRegex = /^[0-9]{3}$/;
            var CVVNumberResult = CVVRegex.test(CVVNumber);
            if (!CVVNumberResult)
                $("#CVVNumberError").removeAttr('style');
            else
                $("#CVVNumberError").hide();

            //ExpDate Validation
            var today = new Date();
            var expDate = new Date($("#expirationDate").val());
            var firstDayOfNextMonth = new Date(expDate.getFullYear(), expDate.getMonth() + 1);
            var expDateResult = firstDayOfNextMonth >= today;

            if (!expDateResult)
                $("#expDateError").removeAttr('style');
            else
                $("#expDateError").hide();


            if(!(cardNumberResult && CVVNumberResult && expDateResult))
                validation = '0';
            else
                validation = true;
        }

        //Booking
        if(validation !== '0') {
            $.ajax({
                url: "php/book.php",
                type: "GET",
                data: {id: id, dep_exp: dep_exp, adult: adult, under: minori, vehicle: veicolo},
                success: function (response) {
                    if (response === '0') {
                        alert("Prenotazione effettuata.");
                        window.location.replace("reservations.php");
                    } else if (response === '-1')
                        alert("Errore nell\'invio dei dati");
                    else if (response === '-2')
                        window.location.replace("login.php");
                    else
                        alert("Prenotazione rifiutata.\nNumero di passeggeri superiore al limite massimo di 200: " + response);
                }
            })
        }


    });


    //New Card Form
    var selectedCard = $('#saved_payment').find(":selected").val();
    var cardFormDiv = $('#newCardForm')

    if (selectedCard === "-1") {
        cardFormDiv.append().html("")
    }

</script>

</html>



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
    <link href="src/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- JavaScript -->
    <script src="src/js/coreui.js"></script>
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->

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
                <?php
                if(isset($_SESSION['id']))
                    echo '
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">I miei ordini</a>
                        </li>  
                    ';
                ?>
            </ul>
            <form class="d-flex">
                <?php

                if (isset($_SESSION['type'])) {
                    if ($_SESSION['type'] != 'cliente') {
                        echo '<a class="btn btn-outline-primary me-2" href="dashboard.php">Area Riservata</a>';
                    }
                    echo '<a class="btn btn-outline-danger me-2" href="logout.php">Logout</a>';
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
                <p>Iscriviti per acquistare...</p>
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
                <label for="harb_arr" class="form-label">Porto di arrivo*</label>
                <input type="text" class="form-control" id="harb_arr" name="harb_arr" placeholder="Arrivo" style="background-color: white" readonly>
                </input>
            </div>


            <div class="mb-3 col-md-3">
                <label for="date" class="form-label">Data di partenza</label>
                <input type="date" class="form-control" id="date" min="<?php echo date("Y-m-d");?>">

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
                <p>Destinazioni da e verso i più belli porti del Sud Italia. Potrete godervi il mare della Scilia,
                    le spiaggie della Puglia e della Calabria, il sole della Campania.</p>

            </div>
        </div>
        <div class="col d-flex align-items-start">
            <div>
                <h2>Sconti</h2>
                <p>Offriamo sconti per i minorenni a partire dal 10% per tutti gli itinerari.</p>
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
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Accedi</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Registrati</a></li>
        </ul>
        <p class="text-center text-muted">© 2022 Flegias & Tourist</p>
    </footer>
</div>

</body>

<script type="text/javascript">

/*    $(document).ready(function () {
        $('#datepicker').datepicker();
    });*/

    $("#harb_dep").on('change', function (){
        var arr = $("#harb_arr");
        $.ajax({
            url: "php/setroutes.php?city="+$("#harb_dep option:selected").text().trim(),
            type: "GET",
            dataType: 'json',
            success:function (response){
                arr.empty();
                response.forEach(function (city) {
                    $("#harb_arr").val(city);
                })
            }
        });
    });

/*    $(document).ready(function() {
        $('form').on('submit', function(e){
            // validation code here
            if(!valid) {
                e.preventDefault();
            }
        });
    });*/

    $('.sub').on('click', function (){
        var trade_dep = $('#harb_dep').val(),
            trade_arr = $('#harb_arr').val(),
            date = $('#date').val();

        $.ajax({

            url: "php/searchroute.php",
            type: "GET",
            data: {trade_dep: trade_dep, trade_arr: trade_arr, dep_exp: date},
            success:function (response){
/*                var json = $.parseJSON(response)
                console.log(json.ship_id);*/
                console.log(response);
                $('.routetable').empty();
                $('.routetable').html(response);
            }

        })


    })


</script>

</html>



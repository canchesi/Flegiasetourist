<?php

    require_once('config.php');
    require_once('residenceinfos.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

    if(isset($_POST['name']))
        header('location: ../clients.php');
    
    $sql = "
    
        SELECT *
        FROM users JOIN infos 
        ON users.id_code = infos.user_id
        WHERE users.id_code = " . $_GET['id'] . " 
        
        ";

    if($result = $connection->query($sql))
            $row = $result->fetch_array(MYSQLI_ASSOC);

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
        <link href="../src/css/style.css" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

        <!-- JavaScript -->
        <script src="../src/js/coreui.js"></script>

        <!-- jQuery -->
        <script src="../src/jquery/jquery.js"></script>

        <title>Modifica Cliente</title>

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
                <a class="nav-link" href="../index.php">
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
                <a class="nav-link" href="../ships.php">
                    <i class="cil-boat-alt nav-icon"></i>
                    Navi
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
                                    Aggiorna dati cliente
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" method="POST">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nome*</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="<?php echo $row['name'] ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="surname" class="form-label">Cognome*</label>
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome" value="<?php echo $row['surname'] ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="inputAddress2" class="form-label">Sesso*</label>
                                        <select class="form-select" name="gender" required>
                                            <option disabled>
                                                Seleziona...
                                            </option>
                                            <option value="M" <?php if($row['gender'] == 'M') echo 'selected'?>>
                                                Maschio
                                            </option>
                                            <option value="F" <?php if($row['gender'] == 'F') echo 'selected'?>>
                                                Femmina
                                            </option>
                                            <option value="X" <?php if($row['gender'] == 'X') echo 'selected'?>>
                                                Altro
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="birth" class="form-label">Data di nascita*</label>
                                        <input type="date" class="form-control" id="birth" name="birth_date" required value="<?php echo $row['birth_date'];?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="telefono" class="form-label">Telefono*</label>
                                        <input type="text" pattern="[0-9]*" class="form-control" id="telefono" name="tel" placeholder="Form. 123456789 " value="<?php echo $row['tel'] ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="cf" class="form-label">Codice Fiscale*</label>
                                        <input type="text" class="form-control" id="cf" name="cf" maxlength="16" minlength="16" placeholder="Form. ABCDEF01G23H456J" value="<?php echo $row['cf'] ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ProvR" class="form-label">Residenza*</label>
                                        <select id="ProvR" class="form-select" name="prov_r" required>
                                            <option disabled>Provincia</option>
                                            <?php
                                            foreach($provinces as $prov => $val) {
                                                if($prov == $row['prov_r'] ){
                                                    echo "
                                                        
                                                        <option value='$prov' selected>
                                                            $val
                                                        </option>
                                                    
                                                    ";
                                                } else {

                                                    echo "
                                                        
                                                        <option value='$prov' >
                                                            $val
                                                        </option>
                                                    
                                                    ";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="ComuneR" class="form-label"><br></label>
                                        <select id="ComuneR" class="form-select" name="city_r" required>
                                            <option disabled>Comune</option>
                                            <?php
                                                echo "
                                                        
                                                        <option value='".$row["city_r"]."' selected>
                                                            ".$row["city_r"]."
                                                        </option>
                                                    
                                                    ";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="AddrD" class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="AddrR" type="text" placeholder="Via/Viale/Piazza" name="addr_r" value="<?php echo $row['addr_r'] ?>" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="zip_d" class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="zip_r" type="text" placeholder="CAP" name="zip_r" value="<?php echo $row['zip_r'] ?>" required>
                                    </div>


                                    <div class="col-12">
                                        <label for="" class="form-label">
                                            <input class="form-check-input" type="checkbox" id="domicile" name='domicile' <?php if(!$row['prov_d']) echo 'checked' ?>>
                                            <label class="form-check-label" for="domicile">
                                                Domicilio coincide con residenza
                                            </label>
                                        </label>
                                    </div>


                                    <div class="col-md-3 hidden">
                                        <label for="ProvD" class="form-label">Domicilio</label>
                                        <select id="ProvD" class="form-select" name="prov_d">
                                            <option disabled>Provincia</option>
                                            <?php
                                            foreach($provinces as $prov => $val) {

                                                if($prov == $row['prov_d'] ){
                                                    echo "
                                                        
                                                        <option value='$prov' selected>
                                                            $val
                                                        </option>
                                                    
                                                    ";
                                                } else {

                                                    echo "
                                                        
                                                        <option value='$prov' >
                                                            $val
                                                        </option>
                                                    
                                                    ";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label for="ComuneD" class="form-label"><br></label>
                                        <select id="ComuneD" class="form-select" name="city_d">
                                            <option disabled selected value="base">Comune</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="AddrD" type="text" placeholder="Via/Viale/Piazza" name="addr_d" value="<?php echo $row['addr_d'] ?>">
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="ZipD" type="text" placeholder="CAP" name="zip_d" value="<?php echo $row['zip_d'] ?>">
                                    </div>
                                    <input type="text" value="1" name="submitted" hidden>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Aggiorna</button>
                                        <a class="btn btn-outline-secondary" type="submit" href="../clients.php">Annulla</a>
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
        if (isset($_POST['submitted'])) {
            if (isset($_POST)) {
                $name = $connection->real_escape_string(ucfirst($_POST['name']));
                $surname = $connection->real_escape_string(ucfirst($_POST['surname']));
                $hashPasswd = password_hash('password', PASSWORD_DEFAULT);
                $type = $connection->real_escape_string($_POST['type']);
                $cf = $connection->real_escape_string(strtoupper($_POST['cf']));
                $tel = $_POST['tel'];
                $birth = $_POST['birth_date'];
                $gender = $connection->real_escape_string($_POST['gender']);
                $provr = $connection->real_escape_string($_POST['prov_r']);
                $cityr = $connection->real_escape_string($_POST['city_r']);
                $zipr = $connection->real_escape_string($_POST['zip_r']);
                $addrr = $connection->real_escape_string($_POST['addr_r']);
                $provd = $connection->real_escape_string($_POST['prov_d']);
                $cityd = $connection->real_escape_string($_POST['city_d']);
                $zipd = $connection->real_escape_string($_POST['zip_d']);
                $addrd = $connection->real_escape_string($_POST['addr_d']);

                $sql = "
            
                    UPDATE users 
                        SET
                            name = '$name',
                            surname = '$surname',
                            psw = '$hashPasswd'
                        WHERE id_code = " . $row['id_code'] . ";
                    
                    UPDATE infos
                        SET
                            cf = '$cf',
                            tel = '$tel',
                            birth_date = '$birth',
                            gender = '$gender',
                            prov_r = '$provr',
                            city_r = '$cityr',
                            zip_r = '$zipr',
                            addr_r = '$addrr',
                            prov_d = NULLIF('$provd', ''),
                            city_d = NULLIF('$cityd', ''),
                            zip_d = NULLIF('$zipd', ''),
                            addr_d = NULLIF('$addrd', '')
                        WHERE infos.user_id = " . $row['id_code'] . ";
    
                    ";

                }

                if (!($result = $connection->multi_query($sql)))
                    die('<script>alert("Errore nell\'invio dei dati.")</script>');

        }

    ?>

    <script>

        $( document ).ready(function() {
            var checkbox = $('#domicile');
            var hidden = $('.hidden');
            var show = $('.show');

            if (checkbox.is(":checked")) {
                hidden.hide();
                show.show();
            }
        });

        $(function(){
            var dtToday = new Date();

            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();

            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;
            $('#birth').attr('max', maxDate);
        });

        $(function(){
            var checkbox = $('#domicile'),
                hidden = $('.hidden'),
                show = $('.show');

            show.hide();
            checkbox.change(function () {
                if (checkbox.is(":checked")) {
                    $('#ProvD').val('');
                    $('#ComuneD').val('');
                    $('#ZipD').val('');
                    $('#AddrD').val('');
                    hidden.hide();
                    show.show();
                } else {
                    hidden.show();
                    show.hide();
                }
            });
        });

    </script>

    <script>
        $("#ProvR").change(function(){
            var deptid = $(this).val();

            /*
                    alert($("#ProvR option:selected").text().replace(/\s+/g, ''));
            */

            $.ajax({
                url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/'+$("#ProvR option:selected").text().trim(),
                type: 'get',
                dataType: 'json',
                success:function(response) {

                    var len = response.length;
                    $("#ComuneR").empty();

                    for( var i = 0; i<len; i++){
                        var id = response[i]['nome'];
                        var name = response[i]['nome'];

                        $("#ComuneR").append("<option value='"+id+"'>"+name+"</option>");

                    }
                }
            });
        });
    </script>

    <script>
        $("#ProvD").change(function(){
            var deptid = $(this).val();

            $.ajax({
                url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/'+$("#ProvD option:selected").text().replace(/\s+/g, ''),
                type: 'get',
                dataType: 'json',
                success:function(response) {

                    var len = response.length;
                    $("#ComuneD").empty();

                    for( var i = 0; i<len; i++){
                        var id = response[i]['nome'];
                        var name = response[i]['nome'];

                        $("#ComuneD").append("<option value='"+id+"'>"+name+"</option>");

                    }
                }
            });
        });
    </script>
    <script>
        $( document ).ready(function() {

            var selectedCR = '<?php echo $provinces[$row['prov_r']]?>';
            var selectedPR = '<?php echo $row['city_r']?>';
            var selectedCD = '<?php echo $provinces[$row['prov_d']]?>';
            var selectedPD = '<?php echo $row['city_d']?>';

            $.ajax({
                url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/'+ selectedCR,
                type: 'get',
                dataType: 'json',
                success:function(response) {

                    var len = response.length;
                    $("#ComuneR").empty();

                    for( var i = 0; i<len; i++){
                        var id = response[i]['nome'];
                        var name = response[i]['nome'];

                        if(selectedPR == name){
                            $("#ComuneR").append("<option value='" + id + "' selected>" + name + "</option>");

                        } else {
                            $("#ComuneR").append("<option value='" + id + "'>" + name + "</option>");
                        }
                    }
                }
            });

            if (selectedCD) {
                $.ajax({
                    url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/' + selectedCD,
                    type: 'get',
                    dataType: 'json',
                    success: function (response) {

                        var len = response.length;
                        $("#ComuneD").empty();

                        for (var i = 0; i < len; i++) {
                            var id = response[i]['nome'];
                            var name = response[i]['nome'];

                            if (selectedPD == name) {
                                $("#ComuneD").append("<option value='" + id + "' selected>" + name + "</option>");

                            } else {
                                $("#ComuneD").append("<option value='" + id + "'>" + name + "</option>");
                            }
                        }
                    }
                });
            }

        });

    </script>



</html>
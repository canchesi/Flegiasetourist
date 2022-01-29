<?php

    require_once('php/config.php');
    require_once('php/residenceinfos.php');

    session_start();
    if (isset($_SESSION['id'])) {
        if ($_SESSION['type'] === 'cliente')
            header('location: index.php');
        else
            header('location: dashboard.php');

    }

    if (isset($_POST['submitted']))
        header('location: login.php');

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
        <link href="src/css/style.css" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

        <!-- JavaScript -->
        <script src="src/js/coreui.js"></script>

        <!-- jQuery -->
        <script src="src/jquery/jquery.js"></script>


        <title>Register</title>
    </head>

    <!-- Begin Body -->
    <body>

    <!-- Begin Content -->
    <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4 mx-4">
                        <div class="card-body p-4">
                            <h1>Registrazione</h1>
                            <p class="text-medium-emphasis">Registrati su Flegias & Tourist </p>
                            <div id="error">
                                <?php
                                echo $error;
                                ?>
                            </div>
                            <form class="row g-3" method="POST">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <label for="birth" class="form-label">Data di nascita*</label>
                                    <input type="date" class="form-control" id="birth" name="birth_date"  max="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Telefono*</label>
                                    <input type="text" pattern="[0-9]*" class="form-control" id="telefono" name="tel" placeholder="Form. 123456789 " required>
                                </div>
                                <div class="col-md-6">
                                    <label for="cf" class="form-label">Codice Fiscale*</label>
                                    <input type="text" class="form-control" pattern="^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$" id="cf" name="cf" maxlength="16" minlength="16" placeholder="Form. ABCDEF01G23H456J" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="ProvR" class="form-label">Residenza*</label>
                                    <select id="ProvR" class="form-select" name="prov_r" required>
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
                                    <label for="ComuneR" class="form-label"><br></label>
                                    <select id="ComuneR" class="form-select" name="city_r" required>
                                        <option disabled selected value="base">Comune</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="AddrR" class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="AddrR" type="text" placeholder="Via/Viale/Piazza" name="addr_r" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="ZipR" class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="zip_r" type="text" placeholder="CAP" name="zip_r" required>
                                </div>

                                <div class="col-12">
                                    <label for="" class="form-label">
                                        <input class="form-check-input" type="checkbox" id="domicile" name='domicile'>
                                        <label class="form-check-label" for="domicile">
                                            Domicilio coincide con residenza
                                        </label>
                                    </label>
                                </div>


                                <div class="col-md-3 hidden">
                                    <label for="ProvD" class="form-label">Domicilio</label>
                                    <select id="ProvD" class="form-select" name="prov_d">
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

                                    <label for="ComuneD" class="form-label"><br></label>
                                    <select id="ComuneD" class="form-select" name="city_d">
                                        <option disabled selected value="base">Comune</option>
                                    </select>
                                </div>


                                <div class="col-md-3 hidden">
                                    <label class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="AddrD" type="text" placeholder="Via/Viale/Piazza" name="addr_d">
                                </div>
                                <div class="col-md-3 hidden">
                                    <label class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="zip_d" type="text" placeholder="CAP" name="zip_d">
                                    <input type="text" name="submitted" value="1" hidden>
                                </div>
                                <div class="col-12 d-flex justify-content-end mt-4">
                                    <div>
                                        <a class="btn btn-outline-secondary" type="submit" href="login.php">Annulla</a>
                                        <button class="btn btn-success" type="submit">Registrati</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->

    </body>
    <!-- End Body -->

    <?php

    if(isset($_POST['submitted'])) {

        $cf = $connection->real_escape_string($_POST['cf']);
        $tel = $_POST['tel'];
        $birth = $_POST['birth_date'];
        $gender = $connection->real_escape_string($_POST['gender']);
        $prov = $connection->real_escape_string($_POST['prov_r']);
        $city = $connection->real_escape_string($_POST['city_r']);
        $zip = $connection->real_escape_string($_POST['zip_r']);
        $addr = $connection->real_escape_string($_POST['addr_r']);

        $sql = "
    
                    INSERT INTO infos(user_id, cf, tel, birth_date, gender, prov_r, city_r, zip_r, addr_r)
                        VALUES((SELECT max(id_code) FROM users), '$cf', '$tel', '$birth', '$gender', '$prov', '$city', '$zip', '$addr');            

                ";

        if ($result = $connection->query($sql))
            if (!isset($_POST['domicile'])) {

                $prov = $connection->real_escape_string($_POST['prov_d']);
                $city = $connection->real_escape_string($_POST['city_d']);
                $zip = $connection->real_escape_string($_POST['zip_d']);
                $addr = $connection->real_escape_string($_POST['addr_d']);

                $sql = "
        
                        UPDATE infos
                            SET prov_d = '$prov', city_d = '$city', zip_d = '$zip', addr_d = '$addr';
                    
                    ";
                die($sql);
                if (!($result = $connection->query($sql)))
                    die('<script>alert("Errore nell\'invio dei dati.")</script>');

            }

    }

    ?>

    <script>

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

    <script type="text/javascript">
        //TODO Verificare unicità mail


    </script>
</html>












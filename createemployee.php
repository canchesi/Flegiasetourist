<?php

    require_once('php/config.php');
    require_once('php/residenceinfos.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'capitano')
        header('location: dashboard.php');
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

    if(isset($_POST['name']))
        header('location: employees.php');

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
        <script src="src/jquery/jquery.js"
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-5">
                            <div class="card-header">
                                <span class="fs-2">
                                    Nuovo dipendente
                                </span>
                            </div>
                            <div class="card-body">
                                <form class="row g-3" method="POST">
                                    <div class="col-md-5">
                                        <label for="name" class="form-label">Nome*</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Nome" required>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="surname" class="form-label">Cognome*</label>
                                        <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome" required>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="type" class="form-label">Grado*</label>
                                        <select id="type" class="form-select" name="type" required>
                                            <option disabled selected>
                                                Seleziona...
                                            </option>
                                            <option value="amministratore">
                                                Amministratore
                                            </option>
                                            <option value="capitano" <?php if(isset($_GET['type']) && $_GET['type'] == 'capitano') echo 'selected';?>>
                                                Capitano
                                            </option>
                                        </select>
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
                                        <input type="date" class="form-control" id="birth" name="birth_date"  max="" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="telefono" class="form-label">Telefono*</label>
                                        <input type="text" pattern="[0-9]*" class="form-control" id="telefono" name="tel" placeholder="Form. 123456789 " required>
                                    </div>
                                    <div class="col-md-3">
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
                                    <div class="col-md-3" id="ComuneRid">
                                        <label for="ComuneR" class="form-label"><br></label>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="AddrR" class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="AddrR" type="text" placeholder="Via/Viale/Piazza" name="addr_r" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="zip_R" class="form-label"><br></label>
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
                                    <div class="col-md-3 hidden" id="ComuneDid">
                                        <label for="ComuneD" class="form-label"><br></label>
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="AddrD" type="text" placeholder="Via/Viale/Piazza" name="addr_d">
                                    </div>
                                    <div class="col-md-3 hidden">
                                        <label class="form-label"><br></label>
                                        <input class="col-md-12 form-control" id="zip_d" type="text" placeholder="CAP" name="zip_d">
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
                                                <?php

                                                $hColorsQuery = "SELECT * FROM hair_colors";

                                                if($hairRes = $connection->query($hColorsQuery)){
                                                    while($colorList = $hairRes->fetch_array(MYSQLI_ASSOC)){
                                                        if ($colorList["value"] == 'no')
                                                            echo '<option value="'.$colorList["value"].'">Pelato</option>';
                                                        else
                                                            echo '<option value="'.$colorList["value"].'">'.ucfirst($colorList["value"]).'</option>';
                                                    }
                                                }


                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="eyes" class="form-label">Colore occhi*</label>
                                        <select id='eyes' class="form-select" name="eyes" required>
                                            <option disabled selected>
                                                Seleziona...
                                            </option>
                                            <?php

                                            $eColorsQuery = "SELECT * FROM eyes_colors";

                                            if($eyeRes = $connection->query($eColorsQuery)){
                                                while($colorList = $eyeRes->fetch_array(MYSQLI_ASSOC)){
                                                    echo '<option value="'.$colorList["value"].'">'.ucfirst($colorList["value"]).'</option>';
                                                }
                                            }


                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Aggiungi</button>
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

        if(isset($_POST['name'])) {
            $name = $connection->real_escape_string(ucfirst($_POST['name']));
            $surname = $connection->real_escape_string(ucfirst($_POST['surname']));
            $sql = "

                SELECT COUNT(id_code) 
                FROM users
                WHERE name = '$name' AND surname = '$surname'
    
            ";
            $sn_users = $connection->query($sql);
            $sn_users = $sn_users->fetch_array(MYSQLI_ASSOC);
            $email = $connection->real_escape_string(strtolower(str_replace( array("'"," ","@","+", "-", "&&", "||", "!", "(", ")", "{", "}", "[", "]", "^", "~", "*", "?", ":","\"","\\"), '',strtolower($_POST['name'])) . '.' . str_replace( array("'"," ","@","+", "-", "&&", "||", "!", "(", ")", "{", "}", "[", "]", "^", "~", "*", "?", ":","\"","\\"), '',strtolower($_POST['surname'])). $sn_users['COUNT(id_code)'] .'@flegias.it'));
            $unwantedCharacters = array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y');
            $email = strtr($email, $unwantedCharacters);
            $hashPasswd = password_hash('password', PASSWORD_DEFAULT);
            $type = $connection->real_escape_string($_POST['type']);
            $cf = $connection->real_escape_string($_POST['cf']);
            $tel = $_POST['tel'];
            $birth = $_POST['birth_date'];
            $gender = $connection->real_escape_string($_POST['gender']);
            $prov = $connection->real_escape_string($_POST['prov_r']);
            $city = $connection->real_escape_string($_POST['city_r']);
            $zip = $connection->real_escape_string($_POST['zip_r']);
            $addr = $connection->real_escape_string($_POST['addr_r']);
            $blood = $connection->real_escape_string($_POST['blood']);
            $hair = $connection->real_escape_string($_POST['hair']);
            $height = $connection->real_escape_string($_POST['height']);
            $eyes = $connection->real_escape_string($_POST['eyes']);

            //TODO - Regex di cf, tel, birth, zip

            $sql = "
        
                INSERT INTO users (email, psw, name, surname, type)
                    VALUES ('$email', '$hashPasswd', '$name', '$surname', '$type');
            
            ";

            if (!($result = $connection->query($sql)))
                die('<script>alert("Errore nell\'invio dei dati.")</script>');

            $sql = "
    
                    INSERT INTO infos(user_id, cf, tel, birth_date, gender, prov_r, city_r, zip_r, addr_r)
                        VALUES((SELECT max(id_code) FROM users), '$cf', '$tel', '$birth', '$gender', '$prov', '$city', '$zip', '$addr');            
            ";

            if ($result = $connection->query($sql)) {
                $sql = "
                    INSERT INTO generalities(user_id, blood, hair, eyes, height)
                        VALUES((SELECT max(id_code) FROM users), '$blood', '$hair', '$eyes', '$height');
               
                ";

                if ($result = $connection->query($sql))
                    if (!isset($_POST['domicile'])) {

                        $prov = $connection->real_escape_string($_POST['prov_d']);
                        $city = $connection->real_escape_string($_POST['city_d']);
                        $zip = $connection->real_escape_string($_POST['zip_d']);
                        $addr = $connection->real_escape_string($_POST['addr_d']);

                        $sql = "
        
                            UPDATE infos
                                SET prov_d = '$prov', city_d = '$city', zip_d = '$zip', addr_d = '$addr'
                                WHERE user_id = (
                                    SELECT MAX(id_code)
                                        FROM users
                                );
                    
                        ";

                        if (!($result = $connection->query($sql)))
                            die('<script>alert("Errore nell\'invio dei dati.")</script>');

                    }
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

    $(document).ready(function (){
        $("#ComuneRid").append('<select id="ComuneR" class="form-select" name="city_r" disabled><option disabled selected>Comune</option></select>');
        $("#ComuneDid").append('<select id="ComuneD" class="form-select" name="city_d" disabled><option disabled selected>Comune</option></select>');
    });

    $("#ProvR").change(function(){

        $("#ComuneRid").empty();
        $("#ComuneRid").append('<label for="ComuneR" class="form-label"><br></label><select id="ComuneR" class="form-select" name="city_r" required><option disabled selected>Comune</option></select>');

        var city = $("#ProvR option:selected").text().trim();

        if(city === "Aosta")
            city = "Valle d'Aosta";

        $.ajax({
            url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/'+ city,
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

            $("#ComuneDid").empty();
            $("#ComuneDid").append('<label for="ComuneD" class="form-label"><br></label><select id="ComuneD" class="form-select" name="city_d" required><option disabled selected>Comune</option></select>');

            var city = $("#ProvD option:selected").text().trim();

            if(city === "Aosta")
                city = "Valle d'Aosta";

            $.ajax({
                url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/'+city,
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




</html>
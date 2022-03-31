<?php

require_once('config.php');
require_once('residenceinfos.php');

session_start();

if (!isset($_SESSION['id']))
    header("location: login.php");
else if ($_SESSION['type'] === 'cliente')
    header('location: index.php');


$sql = "
    
        SELECT *
        FROM users JOIN infos 
        ON users.id_code = infos.user_id
        JOIN generalities
        ON users.id_code = generalities.user_id
        WHERE generalities.user_id = " . $_GET['id'] . " 
        
        ";

if ($_SESSION['id'] != $_GET['id']) {
    header('location ../dashboard.php');
}

if ($result = $connection->query($sql))
    $row = $result->fetch_array(MYSQLI_ASSOC);


if (isset($_POST['submitted'])) {
    if (isset($_POST)) {

        $tel = $_POST['tel'];

        if ($_POST['psw']) {

            $error = '';

            $password = $_POST['psw'];
            $passwordConfirmation = $_POST['pswConf'];
            $oldPassword = $_POST['oldPsw'];

            if ($password != $passwordConfirmation) {
                $error = "I campi Nuova Password e Conferma Password non coincidono.<br>";
            }

            if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/', $password)){
                $error .= "La password deve contenere almeno 8 caratteri e deve essere alfanumerica e con caratteri speciali.<br>";
            }

            if (!$error) {
                if ($result = $connection->query("SELECT * FROM users WHERE id_code =" . $_SESSION['id'])) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    if (password_verify($oldPassword, $row['psw'])) {
                        $hashPasswd = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "UPDATE users SET psw = '$hashPasswd' WHERE id_code =" . $_SESSION['id']. ";  
                        UPDATE infos
                        SET
                            tel = '$tel'
                        WHERE user_id = " . $_SESSION['id'] . ";
                        ";
                        if(!($result = $connection->multi_query($sql))){
                            die('<script>alert("Errore nell\'invio dei dati.")</script>');
                        }
                        echo '<script>window.location.replace("../dashboard.php")</script>';
                    } else {
                        $error .= "Vecchia Password errata.";
                    }
                }
            }
        } else {
            $sql = "
                UPDATE infos
                    SET
                        tel = '$tel'
                    WHERE user_id = " . $_SESSION['id'] . ";
                ";

                    if (!($result = $connection->query($sql)))
                        die('<script>alert("Errore nell\'invio dei dati.")</script>');

                    echo '<script>window.location.replace("../dashboard.php")</script>';
        }
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
    <link href="../src/css/style.css" rel="stylesheet">
    <link href="../src/favicon.png" rel="icon">


    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

    <!-- JavaScript -->
    <script src="../src/js/coreui.js"></script>

    <!-- jQuery -->
    <script src="../src/jquery/jquery.js"></script>

    <title>Modifica Dipendente</title>

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
                    <li> <a href="../logout.php" class="dropdown-item">Esci</a>
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
                                Aggiorna dati dipendente
                            </span>
                        </div>
                        <div class="card-body">
                            <form class="row g-3" method="POST">


                                <?php

                                if ($error)
                                    echo '
                                         <div class="col-md-12">
                                            <div class="alert alert-danger" role="alert">
                                               ' . $error . '
                                            </div>
                                        </div>
                                     ';
                                ?>

                                <div class="col-md-5">
                                    <label for="name" class="form-label">Nome*</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome"
                                           value="<?php echo $row['name'] ?>" disabled>
                                </div>
                                <div class="col-md-5">
                                    <label for="surname" class="form-label">Cognome*</label>
                                    <input type="text" class="form-control" id="surname" name="surname"
                                           placeholder="Cognome" value="<?php echo $row['surname'] ?>" disabled>
                                </div>
                                <div class="col-md-2">
                                    <label for="type" class="form-label">Grado*</label>
                                    <select id="type" class="form-select" name="type" disabled>
                                        <option disabled selected>
                                            Seleziona...
                                        </option>
                                        <option value="amministratore" <?php if ($row['type'] == 'amministratore') echo 'selected'; ?>>
                                            Amministratore
                                        </option>
                                        <option value="capitano" <?php if ($row['type'] == 'capitano') echo 'selected'; ?>>
                                            Capitano
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="inputAddress2" class="form-label">Sesso*</label>
                                    <select class="form-select" name="gender" disabled>
                                        <option disabled>
                                            Seleziona...
                                        </option>
                                        <option value="M" <?php if ($row['gender'] == 'M') echo 'selected' ?>>
                                            Maschio
                                        </option>
                                        <option value="F" <?php if ($row['gender'] == 'F') echo 'selected' ?>>
                                            Femmina
                                        </option>
                                        <option value="X" <?php if ($row['gender'] == 'X') echo 'selected' ?>>
                                            Altro
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="birth" class="form-label">Data di nascita*</label>
                                    <input type="date" class="form-control" id="birth" name="birth_date" disabled
                                           value="<?php echo $row['birth_date']; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="telefono" class="form-label">Telefono*</label>
                                    <input type="text" pattern="[0-9]*" class="form-control" id="telefono" name="tel"
                                           placeholder="Form. 123456789 " value="<?php echo $row['tel'] ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="cf" class="form-label">Codice Fiscale*</label>
                                    <input type="text" class="form-control" id="cf" name="cf" maxlength="16"
                                           minlength="16" placeholder="Form. ABCDEF01G23H456J"
                                           value="<?php echo $row['cf'] ?>" disabled>
                                </div>


                                <!-- BEGIN PASSWORD EDIT-->

                                <div class="col-md-4">
                                    <label for="oldPsw" class="form-label">Vecchia Password*</label>
                                    <input type="password" class="form-control" id="oldPsw" name="oldPsw"
                                           placeholder="Vecchia Password">
                                </div>
                                <div class="col-md-4">
                                    <label for="psw" class="form-label">Nuova Password*</label>
                                    <input type="password" class="form-control" id="psw" name="psw"
                                           placeholder="Nuova Password">
                                </div>
                                <div class="col-md-4">
                                    <label for="pswConf" class="form-label">Conferma Password*</label>
                                    <input type="password" class="form-control" id="pswConf" name="pswConf"
                                           placeholder="Conferma Password">
                                </div>

                                <!-- END PASSWORD EDIT-->


                                <div class="col-md-3">
                                    <label for="ProvR" class="form-label">Residenza*</label>
                                    <select id="ProvR" class="form-select" name="prov_r" disabled>
                                        <option disabled>Provincia</option>
                                        <?php
                                        foreach ($provinces as $prov => $val) {
                                            if ($prov == $row['prov_r']) {
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
                                    <select id="ComuneR" class="form-select" name="city_r" disabled>
                                        <option disabled>Comune</option>
                                        <?php
                                        echo "
                                                        
                                                        <option value='" . $row["city_r"] . "' selected>
                                                            " . $row["city_r"] . "
                                                        </option>
                                                    
                                                    ";
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="AddrD" class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="AddrR" type="text"
                                           placeholder="Via/Viale/Piazza" name="addr_r"
                                           value="<?php echo $row['addr_r'] ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="zip_d" class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="zip_r" type="text" placeholder="CAP"
                                           name="zip_r" value="<?php echo $row['zip_r'] ?>" disabled>
                                </div>


                                <div class="col-12">
                                    <label for="" class="form-label">
                                        <input class="form-check-input" type="checkbox" id="domicile"
                                               name='domicile' <?php if (!$row['prov_d']) echo 'checked' ?> disabled>
                                        <label class="form-check-label" for="domicile">
                                            Domicilio coincide con residenza
                                        </label>
                                    </label>
                                </div>


                                <div class="col-md-3 hidden">
                                    <label for="ProvD" class="form-label">Domicilio</label>
                                    <select id="ProvD" class="form-select" name="prov_d" disabled>
                                        <option disabled>Provincia</option>
                                        <?php
                                        foreach ($provinces as $prov => $val) {

                                            if ($prov == $row['prov_d']) {
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
                                    <select id="ComuneD" class="form-select" name="city_d" disabled>
                                        <option disabled selected value="base">Comune</option>
                                    </select>
                                </div>
                                <div class="col-md-3 hidden">
                                    <label class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="AddrD" type="text"
                                           placeholder="Via/Viale/Piazza" name="addr_d"
                                           value="<?php echo $row['addr_d'] ?>" disabled>
                                </div>
                                <div class="col-md-3 hidden">
                                    <label class="form-label"><br></label>
                                    <input class="col-md-12 form-control" id="ZipD" type="text" placeholder="CAP"
                                           name="zip_d" value="<?php echo $row['zip_d'] ?>" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="height" class="form-label">Altezza*</label>
                                    <input class="form-control" type="number" placeholder="Altezza"
                                           value="<?php echo $row['height'] ?>" name="height" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="blood" class="form-label">Gruppo Sanguigno*</label>
                                    <select class="form-select" name="blood" disabled>
                                        <option disabled>
                                            Seleziona...
                                        </option>
                                        <option value="a+" <?php if ($row['blood'] == 'a+') echo 'selected' ?>>
                                            A+
                                        </option>
                                        <option value="a-" <?php if ($row['blood'] == 'a-') echo 'selected' ?>>
                                            A-
                                        </option>
                                        <option value="b+" <?php if ($row['blood'] == 'b+') echo 'selected' ?>>
                                            B+
                                        </option>
                                        <option value="b-" <?php if ($row['blood'] == 'b-') echo 'selected' ?>>
                                            B-
                                        </option>
                                        <option value="ab+" <?php if ($row['blood'] == 'ab+') echo 'selected' ?>>
                                            AB+
                                        </option>
                                        <option value="ab-" <?php if ($row['blood'] == 'ab-') echo 'selected' ?>>
                                            AB-
                                        </option>
                                        <option value="0+" <?php if ($row['blood'] == '0+') echo 'selected' ?>>
                                            0+
                                        </option>
                                        <option value="0-" <?php if ($row['blood'] == '0-') echo 'selected' ?>>
                                            0-
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="hair" class="form-label">Colore capelli*</label>
                                    <select class="form-select" name="hair" disabled>
                                        <option disabled selected>
                                            Seleziona...
                                        </option>
                                        <?php

                                        $hColorsQuery = "SELECT * FROM hair_colors";

                                        if($hairRes = $connection->query($hColorsQuery)){
                                            while($colorList = $hairRes->fetch_array(MYSQLI_ASSOC)){
                                                $color = $colorList['value'] == 'no' ? 'Pelato' : $colorList['value'];
                                                if($row['hair'] == $colorList['value'])
                                                    echo '<option value="'.$colorList["value"].'" selected>'.ucfirst($color).'</option>';
                                                else
                                                    echo '<option value="'.$colorList["value"].'">'.ucfirst($color).'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="eyes" class="form-label">Colore occhi*</label>
                                    <select id='eyes' class="form-select" name="eyes" disabled>
                                        <option disabled>
                                            Seleziona...
                                        </option>
                                        <?php

                                        $eColorsQuery = "SELECT * FROM eyes_colors";

                                        if($eyeRes = $connection->query($eColorsQuery)){
                                            while($colorList = $eyeRes->fetch_array(MYSQLI_ASSOC)){
                                                if($row['eyes'] == $colorList["value"])
                                                    echo '<option value="'.$colorList["value"].'" selected>'.ucfirst($colorList["value"]).'</option>';
                                                else
                                                    echo '<option value="'.$colorList["value"].'">'.ucfirst($colorList["value"]).'</option>';
                                            }
                                        }


                                        ?>
                                    </select>
                                    <input type="text" value="1" name="submitted" hidden>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary">Aggiorna</button>
                                    <a class="btn btn-outline-secondary" type="submit"
                                       href="../employees.php">Annulla</a>
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

<script>

    $(document).ready(function () {
        var checkbox = $('#domicile');
        var hidden = $('.hidden');
        var show = $('.show');

        if (checkbox.is(":checked")) {
            hidden.hide();
            show.show();
        }
    });

    $(function () {
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();

        if (month < 10)
            month = '0' + month.toString();
        if (day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;
        $('#birth').attr('max', maxDate);
    });

    $(function () {
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


</html>
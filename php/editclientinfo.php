<?php
require_once('config.php');
require_once('residenceinfos.php');
/** @var MYSQLI $connection*/
/** @var PROVINCE $provinces*/
session_start();

if (isset($_SESSION['id']))
    if ($_SESSION['type'] !== 'cliente')
        header('location: dashboard.php');

if(isset($_POST['ajax'])){

    $cardNum = $_POST['ccnum'];
    $delete = -1;

    $sql = "
        SELECT saved
            FROM `user-card_matches`
        WHERE cc_num = '" . $cardNum . "'
    
    ";

    if($result = $connection->query($sql))
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            if($row['saved'] == 1) {
                $delete += 1;
                if($delete > 0)
                    break;
            }

    $sql = "
        UPDATE `user-card_matches`
            SET saved = 0
        WHERE user_id = '" . $_SESSION['id'] . "' AND cc_num = '" . $cardNum . "'
    
    ";

    if(!($connection->query($sql)))
        die('-1');

    if($delete == 0) {
        $sql = "
            DELETE FROM credit_cards
                WHERE number = '" . $cardNum . "'
        ";

        if(!$connection->query($sql))
            die('-1');

    }
    die('0');
}

?>


<!doctype html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Style -->
    <link href="../src/css/style.css" rel="stylesheet">
    <link href="../src/favicon.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <!-- JavaScript -->
    <script src="../src/js/coreui.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="../src/jquery/jquery.js"></script>
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
        <a class="navbar-brand" href="../index.php">Flegias & Tourist</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <div class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            </div>
            <form class="d-flex">


                <?php

                if (isset($_SESSION['type'])) {

                    $sql = "SELECT name, surname FROM users WHERE id_code = " . $_SESSION['id'];

                    if ($result = $connection->query($sql)) {
                        $row = $result->fetch_array(MYSQLI_ASSOC);

                        echo '
                            <div class="dropstart">
                              <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                ' . $row['name'] . ' ' . $row['surname'] . '
                              </a>
                            
                              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><a class="dropdown-item" href="../reservations.php">I miei ordini</a></li>
                                <li><a class="dropdown-item" href="editclientinfo.php">Gestione profilo</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                              </ul>
                            </div>
                        ';
                    }


                } else {
                    echo '
                        <a class="btn btn-outline-primary me-2" href="../login.php">Accedi</a>
                        <a class="btn btn-outline-success" href="../register.php">Registrati</a>
                        ';
                }

                ?>

            </form>
        </div>
    </div>
</nav>
<!-- End Navbar-->

<?php

$sql = "
        
        SELECT *
        FROM users JOIN infos 
        ON users.id_code = infos.user_id
        WHERE users.id_code = " . $_SESSION['id'] . " 
        
        ";

if ($result = $connection->query($sql))
    if($row = $result->fetch_array(MYSQLI_ASSOC)){
        $provr = $connection->real_escape_string($row['prov_r']);
        $provd = $connection->real_escape_string($row['prov_d']);
    }
if (isset($_POST['submitted'])) {
    if (isset($_POST)) {

        $error = "";

        $name = $connection->real_escape_string(ucfirst($_POST['name']));
        $surname = $connection->real_escape_string(ucfirst($_POST['surname']));
        $email = $connection->real_escape_string($_POST['email']);
        $provr = $connection->real_escape_string($_POST['prov_r']);
        $oldPassword = $connection->real_escape_string($_POST['oldPsw']);
        $newPassword = $connection->real_escape_string($_POST['passwd']);
        $confirmPassword = $connection->real_escape_string($_POST['passwdConf']);
        $type = $connection->real_escape_string($_POST['type']);
        $cf = $connection->real_escape_string(strtoupper($_POST['cf']));
        $tel = $_POST['tel'];
        $birth = $_POST['birth_date'];
        $gender = $connection->real_escape_string($_POST['gender']);
        $cityr = $connection->real_escape_string($_POST['city_r']);
        $zipr = $connection->real_escape_string($_POST['zip_r']);
        $addrr = $connection->real_escape_string($_POST['addr_r']);
        $provd = $connection->real_escape_string($_POST['prov_d']);
        $cityd = $connection->real_escape_string($_POST['city_d']);
        $zipd = $connection->real_escape_string($_POST['zip_d']);
        $addrd = $connection->real_escape_string($_POST['addr_d']);

        if ($oldPassword && $newPassword) {

            if (!password_verify($oldPassword, $row['psw']))
                $error .= "La vecchia password non è corretta. <br>";

            if ($newPassword != $confirmPassword) {
                $error .= "I campi Nuova Password e Conferma Password non coincidono.<br>";
            }

            if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,}$/', $newPassword)) {
                $error .= "La password deve contenere almeno 8 caratteri e deve essere alfanumerica e con caratteri speciali.<br>";
            }

            if (!$error) {

                $hashPasswd = password_hash($newPassword, PASSWORD_DEFAULT);

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

        } else {

            $sql = "
            
                    UPDATE users 
                        SET
                            name = '$name',
                            surname = '$surname'
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

        if (!$error) {
            if (!($result = $connection->multi_query($sql)))
                die('<script>alert("Errore nell\'invio dei dati.")</script>');

            header('location: ../index.php');
        }
    }
}

?>

<!-- Begin Content-->
<div class="container-lg mt-4">

    <h1>Modifica Account</h1>

    <form class="row g-3" method="POST">
        <?php
            if($error)
                echo '        
        <div class="alert alert-danger" role="alert">
           '.$error.'
        </div>
        ';
        ?>

        <div class="col-md-4">
            <label for="name" class="form-label">Nome*</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome"
                   value="<?php echo $row['name'] ?>" required>
        </div>
        <div class="col-md-4">
            <label for="surname" class="form-label">Cognome*</label>
            <input type="text" class="form-control" id="surname" name="surname" placeholder="Cognome"
                   value="<?php echo $row['surname'] ?>" required>
        </div>
        <div class="col-md-4">
            <label for="mail" class="form-label">Email*</label>
            <input type="mail" class="form-control" id="mail" name="mail" placeholder="Email"
                   value="<?php echo $row['email'] ?>" required>
        </div>
        <div class="col-md-4">
            <label for="oldPsw" class="form-label">Vecchia Password</label>
            <input type="password" class="form-control" id="oldPsw" name="oldPsw" placeholder="Vecchia Password">
        </div>
        <div class="col-md-4">
            <label for="passwd" class="form-label">Nuova Passowd</label>
            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Nuova Password">
        </div>
        <div class="col-md-4">
            <label for="passwdConf" class="form-label">Conferma Password</label>
            <input type="password" class="form-control" id="passwdConf" name="passwdConf"
                   placeholder="Conferma Password">
        </div>
        <div class="col-md-3">
            <label for="gender" class="form-label">Sesso*</label>
            <select class="form-select" name="gender" id="gender" required>
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
            <input type="date" class="form-control" id="birth" name="birth_date" required
                   value="<?php echo $row['birth_date']; ?>">
        </div>
        <div class="col-md-3">
            <label for="telefono" class="form-label">Telefono*</label>
            <input type="text" pattern="[0-9]*" class="form-control" id="telefono" name="tel"
                   placeholder="Form. 123456789 " value="<?php echo $row['tel'] ?>" required>
        </div>
        <div class="col-md-3">
            <label for="cf" class="form-label">Codice Fiscale*</label>
            <input type="text" class="form-control" id="cf" name="cf" maxlength="16" minlength="16"
                   placeholder="Form. ABCDEF01G23H456J" value="<?php echo $row['cf'] ?>" required>
        </div>
        <div class="col-md-3">
            <label for="ProvR" class="form-label">Residenza*</label>
            <select id="ProvR" class="form-select" name="prov_r" required>
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
            <select id="ComuneR" class="form-select" name="city_r" required>
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
            <input class="col-md-12 form-control" id="AddrR" type="text" placeholder="Via/Viale/Piazza" name="addr_r"
                   value="<?php echo $row['addr_r'] ?>" required>
        </div>
        <div class="col-md-3">
            <label for="zip_d" class="form-label"><br></label>
            <input class="col-md-12 form-control" id="zip_r" type="text" placeholder="CAP" name="zip_r"
                   value="<?php echo $row['zip_r'] ?>" required>
        </div>


        <div class="col-12">
            <label for="" class="form-label">
                <input class="form-check-input" type="checkbox" id="domicile"
                       name='domicile' <?php if (!$row['prov_d']) echo 'checked' ?>>
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
            <select id="ComuneD" class="form-select" name="city_d">
                <option disabled selected value="base">Comune</option>
            </select>
        </div>
        <div class="col-md-3 hidden">
            <label class="form-label"><br></label>
            <input class="col-md-12 form-control" id="AddrD" type="text" placeholder="Via/Viale/Piazza" name="addr_d"
                   value="<?php echo $row['addr_d'] ?>">
        </div>
        <div class="col-md-3 hidden">
            <label class="form-label"><br></label>
            <input class="col-md-12 form-control" id="ZipD" type="text" placeholder="CAP" name="zip_d"
                   value="<?php echo $row['zip_d'] ?>">
        </div>
        <input type="text" value="1" name="submitted" hidden>
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary">Aggiorna</button>
            <a class="btn btn-outline-secondary" type="submit" href="../clients.php">Annulla</a>
        </div>
    </form>
    <p>
        <table class="table table-bordered" id="routes">
            <thead class="table-light fw-semibold">
                <th class="">Numero carta</th>
                <th class="">Intestatario</th>
                <th class="">Data di scadenza</th>
                <th class="text-center">Azioni</th>
            </thead>
            <?php
                $sql = "
                    SELECT number, acc_holder, exp
                        FROM credit_cards JOIN `user-card_matches`
                            ON number = cc_num
                        WHERE user_id = '" . $_SESSION['id'] . "'
                ";

                if($result = $connection->query($sql))
                    if($result->num_rows){
                        echo '<tbody>';
                        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                            echo "
                                <tr id='" . $row['number'] . "'>
                                    <td>" . $row['number'] . "</td>
                                    <td>" . $row['acc_holder'] . "</td>
                                    <td>" . (new DateTime($row['exp']))->sub(new DateInterval('P1M'))->format('m/Y');
                            if($row['exp'] <= (new DateTime())->format('Y-m-d'))
                                echo "<br><div class='badge bg-danger'>Scaduta</div>";
                            echo"</td>
                                    <td class='text-center'><form><a href='#' class='btn btn-danger delete'>Elimina</a></form></td>
                                </tr>
                            ";
                        }
                        echo "</tbody>";
                    }
            ?>
        </table>
        <?php
            if ($result && $result->num_rows == 0)
                echo "<div class='text-center'>Non hai carte memorizzate</div>";
        ?>
    </p>
</div>


<!-- End Content-->

<!-- Begin Footer-->
<!--<div class="container fixed-bottom">
    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3"></ul>
        <p class="text-center text-muted">© 2022 Flegias & Tourist</p>
    </footer>
</div>-->
<!-- End Footer-->

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

<script>
    $("#ProvR").change(function () {
        var deptid = $(this).val();

        var city = $("#ProvR option:selected").text().trim();

        if (city === "Aosta")
            city = "Valle d'Aosta";
        /*
                alert($("#ProvR option:selected").text().replace(/\s+/g, ''));
        */

        $.ajax({
            url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/' + city,
            type: 'get',
            dataType: 'json',
            success: function (response) {

                var len = response.length;
                $("#ComuneR").empty();

                for (var i = 0; i < len; i++) {
                    var id = response[i]['nome'];
                    var name = response[i]['nome'];

                    $("#ComuneR").append("<option value='" + id + "'>" + name + "</option>");

                }
            }
        });
    });
</script>

<script>
    $("#ProvD").change(function () {
        var deptid = $(this).val();

        var city = $("#ProvD option:selected").text().trim();

        if (city === "Aosta")
            city = "Valle d'Aosta";
        $.ajax({
            url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/' + city,
            type: 'get',
            dataType: 'json',
            success: function (response) {

                var len = response.length;
                $("#ComuneD").empty();

                for (var i = 0; i < len; i++) {
                    var id = response[i]['nome'];
                    var name = response[i]['nome'];

                    $("#ComuneD").append("<option value='" + id + "'>" + name + "</option>");

                }
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        var selectedCR = '<?php echo $provinces[$provr]?>';
        var selectedPR = '<?php echo $provr?>';
        var selectedCD = '<?php echo $provinces[$provd]?>';
        var selectedPD = '<?php echo $provd?>';
        $.ajax({
            url: 'https://comuni-ita.herokuapp.com/api/comuni/provincia/' + selectedCR,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                $("#ComuneR").empty();

                for (var i = 0; i < len; i++) {
                    var id = response[i]['nome'];
                    var name = response[i]['nome'];

                    if (selectedCR == name) {
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

                        if (selectedCD == name) {
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

<script>

    $(document).on('click', '.delete', function () {

        var tr = $(this).closest('tr'),
            ccnum = tr.attr('id');

        $.ajax({
            type: "POST",
            data: {ajax: 1, ccnum: ccnum},
            success: function (response) {
                console.log(response);
                if (response === '0') {
                    tr.fadeOut(1000, function () {
                        tr.empty();
                    });
                } else
                    alert("Errore.");
            }
        })


    });


</script>

</html>



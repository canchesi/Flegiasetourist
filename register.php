<?php

require_once('php/config.php');

session_start();
if (isset($_SESSION['id'])) {
    if ($_SESSION['type'] === 'cliente')
        header('location: index.php');
    else
        header('location: dashboard.php');

}


if ($_POST) {

    $error = "";

    if (!$_POST['name'])
        $error .= "Nome richiesto<br>";
    if (!$_POST['surname'])
        $error .= "Cognome richiesto<br>";
    if (!$_POST['email'])
        $error .= "Email richiesta<br>";
    if ($_POST['email'] && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $error .= "Email in formato sbagliato<br>";
    if (!$_POST['password'])
        $error .= "Password richiesta<br>";
    if (!($_POST['password2'] === $_POST['password']))
        $error .= "Conferma password errata<br>";

    $sql = "SELECT * FROM users WHERE email = '".$_POST['email']."'";

    if ($result = $connection->query($sql)) {
        if ($result->num_rows){
            $error .= "Email già esistente";
        }

    }

    if ($error)
        $error = "
            <div class='alert alert-danger' role='alert'>
                <h4>
                    <strong>
                        Errore inserimento dati
                    </strong>
                </h4>                    
                $error
            </div>
        ";
    else {

        $email = $connection->real_escape_string($_POST['email']);
        $password = $connection->real_escape_string($_POST['password']);
        $name = $connection->real_escape_string($_POST['name']);
        $surname = $connection->real_escape_string($_POST['surname']);

        $hashPasswd = password_hash($password, PASSWORD_DEFAULT);


        $sql = "INSERT INTO users (email, psw, name, surname, type) VALUES ('$email', '$hashPasswd', '$name', '$surname', 'cliente')";

        if ($result = $connection->query($sql))
            header('location: index.html');
        else
            echo '<script>alert("Errore nell\'invio dei dati.")</script>';


    }

}

$connection->close();

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
                                <label class="form-label" for="name">Nome</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Nome"
                                       value="<?php echo $_POST['name'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="surname">Cognome</label>
                                <input class="form-control" id="surname" name="surname" type="text"
                                       placeholder="Cognome" value="<?php echo $_POST['surname'] ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" name="email" type="text" placeholder="Email"
                                       value="<?php echo $_POST['email'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="password">Password</label>
                                <input class="form-control" id="password" name="password" type="password"
                                       placeholder="Password">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="confirmPassword">Conferma Password</label>
                                <input class="form-control" id="confirmPassword" name="password2" type="password"
                                       placeholder="Conferma Password">
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


?>

<script type="text/javascript">
    //TODO Verificare unicità mail


</script>
</html>












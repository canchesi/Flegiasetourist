<?php

require_once('php/config.php');


session_start();
if(isset($_SESSION['id'])){
    if ($_SESSION['type'] === 'cliente')
        header('location: index.php');
    else
        header('location: dashboard.php');

}

$email = $connection->real_escape_string($_POST['email']);
$password = $connection->real_escape_string($_POST['password']);


if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    if ($result = $connection->query("SELECT * FROM users WHERE email = '$email'")) {

        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (password_verify($password, $row['psw'])) {

            $_SESSION['id'] = $row['id_code'];
            $_SESSION['type'] = $row['type'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['surname'] = $row['surname'];

            if($row['deleted'])
                header('location: logout.php');

            if($_SESSION['type'] === 'cliente')
                header('location: index.php');
            else
                header('location: dashboard.php');


        } else
            $_SESSION['error'] = "Errore";

    } else
        $_SESSION['error'] = "Errore";

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


    <title>Login</title>
</head>
<body>
    <form id="form" method="post">
        <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="card-group d-block d-md-flex row">
                            <div class="card col-md-7 p-4 mb-0">
                                <div class="card-body">
                                    <h1>Login</h1>
                                    <p class="text-medium-emphasis">
                                        Accedi al tuo account
                                    </p>
                                    <?php if (isset($_SESSION['error'])) {
                                        echo '
                                    <p class="text-danger">Email e/o password errati</p>';
                                        $_SESSION = array();
                                        session_destroy();
                                    } ?>
                                    <div class="input-group mb-3">
                                        <input class="form-control" name="email" id="email" type="text" placeholder="Email">
                                    </div>
                                    <div class="input-group mb-4">
                                        <input class="form-control" name="password" id="password" type="password" placeholder="Password">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="register.php" class="btn btn-secondary ms-6 col-12" id="button" type="submit">Registrati</a>
                                        </div>
                                        <div class="col-6">
                                            <input class="btn btn-primary ms-6 col-12" id="button" value="Accedi" type="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

<script type="text/javascript">
    $("#button").click(function () {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $("#form").attr('action'),
            data: $("#form").serialize(),
            success: function (response) {
                if (response === "success") {
                    window.reload;
                } else {
                    alert("invalid username/password.  Please try again");
                }
            }
        });
    });
</script>
</html>
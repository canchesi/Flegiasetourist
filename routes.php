<?php

require_once('php/config.php');

    session_start();

    if (!isset($_SESSION['id']))
        header("location: login.php");
    else if ($_SESSION['type'] === 'cliente')
        header('location: index.php');

    if(isset($_POST['ajax'])) {

        $ids = explode('-', $_POST['id'], 2);
        $sql = "
        
            SELECT content
                FROM notes
                WHERE ship_id = '" . $ids[0] . "' AND dep_exp = '" . $ids[1] . "' 
        
        ";

        if($result = $connection->query($sql))
            if($row = $result->fetch_array(MYSQLI_ASSOC))
                echo $row['content'];
        exit();
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
        <link href="https://coreui.io/demo/4.0/free/css/style.css" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/all.css">

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.1.0/dist/js/coreui.bundle.min.js"></script>

        <!-- jQuery -->
        <script src="src/jquery/jquery.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

        <title>Rotte</title>
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
            <?php
            if($_SESSION['type'] !== 'capitano')
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
        <button class="sidebar-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle(); "></button>
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
            <div class="header-divider"></div>
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0 ms-2">
                        <li class="breadcrumb-item"><span>Rotte</span></li>
                    </ol>
                </nav>
            </div>
        </header>
        <!-- End Header -->


        <!--Begin Content -->
        <div class="body flex-grow-1 px-3">
            <div class="container-lg">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-5">
                            <div class="card-header"><span class="fs-2">Rotte</span></div>
                            <div class="card-body">
                                <div class=" d-flex flex-row-reverse">
                                    <?php
                                        if($_SESSION['type'] !== 'capitano')
                                            echo '<a href="createroute.php" class="btn btn-primary m-2">Aggiungi</a>';
                                    ?>
                                    <div class="m-2"></div>
                                    <div class="lg-col-2">
                                        <input class="form-control m-2 me-1" id="searchInputDate" onkeyup="searchElementsDate()"
                                               type="date"
                                               placeholder="Cerca per porti">
                                    </div>
                                    <div class="m-2"></div>
                                    <div class="lg-col-2">
                                        <input class="form-control m-2 me-1" id="searchInputHarb" onkeyup="searchElementsHarb()"
                                               type="text"
                                               placeholder="Cerca per porti">
                                    </div>
                                    <div class="m-2"></div>
                                    <div class="lg-col-2">
                                        <input class="form-control m-2 me-1" id="searchInputShip" onkeyup="searchElementsShip()"
                                        type="text"
                                        placeholder="Cerca per nave">
                                    </div>
                                    <div class="m-2"></div>
                                </div>
                                <div class="table-responsive" id="warehouseTable">
                                    <table class="table border">
                                        <thead class="table-light fw-semibold">
                                        <tr class="align-middle">
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="name" data-order="asc">Nave</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="trade_dep" data-order="asc">Partenza</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="trade_arr" data-order="asc">Arrivo</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="dep_exp" data-order="asc">Data partenza prev.</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="arr_exp" data-order="asc">Data arrivo prev.</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="dep_eff" data-order="asc">Data partenza eff.</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="arr_eff" data-order="asc">Data arrivo eff.</a></th>
                                            <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="surname" data-order="asc">Capitano</a></th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                            $sql = "
                                            
                                                SELECT ships.name AS ship, ship_id, trade_dep, trade_arr, dep_exp, arr_exp, dep_eff, arr_eff, captain, users.name AS name, surname, ret
                                                    FROM ships JOIN routes
                                                        ON ship_id = id
                                                    JOIN users
                                                        ON id_code = captain

                                            ";
                                            if($_SESSION['type'] === 'capitano')
                                                $sql .= 'WHERE id_code = ' . $_SESSION['id'];
                                            if ($result = $connection->query($sql)) {
                                                while ($row = $result->fetch_array()) {
                                                    if($row['ret']){
                                                        $tmp = $row['trade_dep'];
                                                        $row['trade_dep'] = $row['trade_arr'];
                                                        $row['trade_arr'] = $tmp;
                                                        unset($tmp);
                                                    }

                                                    if(!$row["dep_eff"])
                                                        $row["dep_eff"] = '/';
                                                    else
                                                        $row['dep_eff'] = date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['dep_eff'])));
                                                    if(!$row["arr_eff"])
                                                        $row["arr_eff"] = '/';
                                                    else
                                                        $row['arr_eff'] = date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['arr_eff'])));

                                                    echo '
                                                        <tr class="align-middle" id="' . $row["ship_id"] . '-' . $row["dep_exp"] .'">
                                                            <td class="text-center">
                                                                <div>' . $row["ship"] . '</div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div>' . $row['trade_dep'] . '</div>
                                                            </td>
                                                            <td class="text-center" >
                                                                <div>' . $row["trade_arr"] . '</div>
                                                            </td>
                                                            <td class="text-center" >
                                                               <div>' . date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['dep_exp']))) . '</div>
                                                            </td>
                                                            <td class="text-center" >
                                                                <div>' .date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['arr_exp']))) . '</div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div>' . $row["dep_eff"] . '</div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div>' . $row["arr_eff"] . '</div>
                                                            </td>
                                                            <td class="text-center">
                                                                <div>' . $row["surname"] . '<br>' . $row["name"] . '</div>
                                                            </td>
                                                            <td>
                                                    ';
                                                    if($_SESSION['type'] !== 'capitano')
                                                        echo'
                                                            <div>
                                                                <a href="php/editroute.php?id=' . $row["ship_id"] . '-' . $row["dep_exp"] .'" class="btn btn-primary m-1">
                                                                    <i class="cil-pen"></i>
                                                                </a>
                                                                <a href="#" class="btn btn-danger deleteButton m-1">
                                                                    <i class="cil-trash"></i>
                                                                </a>
                                                            </div>';
                                                    echo'<div>';
                                                    if($_SESSION['type'] !== 'capitano')
                                                        echo'
                                                                <a href="#" class="btn btn-info m-1" >
                                                                    <i class="cil-people"></i>
                                                                </a>';
                                                    echo'
                                                                <button class="btn btn-warning m-1 notes">
                                                                    <i class="cil-notes"></i>
                                                                </button> 
                                                            </div>
                                                        
                                                    </td>
                                                </tr>
                                                    ';
                                                }

                                            }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
        </div>
        <!--End Content -->

        <!-- Begin Modal-->

        <div class="modal fade" id="noteModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nota di Viaggio</h5>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-12 noteblock">
                        </div>
                    </div>
                    <input type="text" value="-1" name="submittedNote" hidden>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closenotes">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Modal-->

        <!--Begin Footer -->
        <footer class="footer">
            <div class="">
                Flegias & Tourist
            </div>
            <div class="ms-auto">
                Danny De Novi & Claudio Anchesi © 2022
            </div>
        </footer>
        <!-- End Footer -->
    </div>
    </body>

    <script>

        var myModal = new coreui.Modal($('.notes'), {
            keyboard: false
        })

        $(document).on('click', '.closenotes', function () {
            $('#noteModal').modal('toggle');
        })

        $(document).on('click', '.notes', function () {
            var tr = $(this).closest('tr'),
                note_id = $(tr).attr('id');

            $.ajax({
                url: 'routes.php',
                type: "POST",
                data: {id: note_id, ajax: 1},
                success:function (data){
                    $('.noteblock').empty();
                    $('.noteblock').html(data);
                    $('#noteModal').modal('toggle');
                }
            })
        });


        function searchElementsHarb() {
            // Declare variables
            var input, filter, table, tr, td_dep, td_arr, i, txtValue_dep, txtValue_arr;
            input = document.getElementById("searchInputHarb");
            filter = input.value.toUpperCase();
            table = document.getElementById("warehouseTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td_dep = tr[i].getElementsByTagName("td")[1];
                td_arr = tr[i].getElementsByTagName("td")[2];
                if (td_dep || td_arr) {
                    txtValue_dep = td_dep.textContent || td_dep.innerText;
                    txtValue_arr = td_arr.textContent || td_arr.innerText;

                    if (txtValue_dep.toUpperCase().indexOf(filter) > -1 || txtValue_arr.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function searchElementsDate() {
            // Declare variables
            var input, filter, table, tr, td_dep, td_arr, i, txtValue_dep, txtValue_arr;
            input = document.getElementById("searchInputDate");
            filter = new Date(input.value.toUpperCase());
            table = document.getElementById("warehouseTable");
            tr = table.getElementsByTagName("tr");

            if(isNaN(filter.getTime())) {
                for (i = 0; i < tr.length; i++)
                    tr[i].style.display = "";
            } else {
                filter = filter.toLocaleDateString("it-IT", { // you can use undefined as first argument
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                });

                // Loop through all table rows, and hide those who don't match the search query
                for (i = 0; i < tr.length; i++) {
                    td_dep = tr[i].getElementsByTagName("td")[3];
                    td_arr = tr[i].getElementsByTagName("td")[4];

                    if (td_dep || td_arr) {
                        txtValue_dep = td_dep.textContent || td_dep.innerText;
                        txtValue_arr = td_arr.textContent || td_arr.innerText;

                        if (txtValue_dep.indexOf(filter) > -1 || txtValue_arr.indexOf(filter) > -1)
                            tr[i].style.display = "";
                        else
                            tr[i].style.display = "none";
                    }
                }
            }
        }

        function searchElementsShip() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInputShip");
            filter = input.value.toUpperCase();
            table = document.getElementById("warehouseTable");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];

                if (td) {
                    txtValue = td.textContent || td.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        $(document).on('click', '.deleteButton', function(){
            var tr = $(this).closest('tr'),
                del_id = $(tr).attr('id');

            $.ajax({
                method: 'GET',
                url: "php/deleteroute.php?id="+ del_id,
                cache: false,
                success:function(result){
                    tr.fadeOut(1000, function(){
                        $(this).remove();
                    });
                }
            });
        });

        $(document).on("click", ".orderButton", function () {
            var column = $(this).attr("id"),
                order = $(this).data("order");

            $.ajax({
                url: "php/sortroutes.php",
                method: "POST",
                data: {column: column, order: order},
                success: function (data) {
                    $('#warehouseTable').html(data);
                }
            });
        });

    </script>

</html>
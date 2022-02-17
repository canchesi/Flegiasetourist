<?php

    require_once('config.php');
    session_start();
    $out = "";
    $ord = $_POST["order"];

    $sql = "
    
        SELECT ships.name AS ship, ship_id, trade_dep, trade_arr, dep_exp, arr_exp, dep_eff, arr_eff, captain, users.name AS name, surname, ret
            FROM ships JOIN routes
                ON ship_id = id
            JOIN users
                ON id_code = captain ";

    if($_SESSION['type'] === 'capitano')
        $sql .= " WHERE id_code = '" . $_SESSION['id'] . "'";

        $sql .= "
            ORDER BY " . $_POST["column"] . " " . $_POST["order"] . " 
        ";

    if(!($result = $connection->query($sql)))
        die('<script>alert("Errore nella richiesta di ordinamento.")</script>');

    if ($ord == "desc")
        $ord = "asc";
    else
        $ord = "desc";

    $out .= '
        <table class="table border">
            <thead class="table-light fw-semibold">
                <tr class="align-middle">
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="name" data-order="' . $ord . '">Nave</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="trade_dep" data-order="' . $ord . '">Partenza</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="trade_arr" data-order="' . $ord . '">Arrivo</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="dep_exp" data-order="' . $ord . '">Data partenza prev.</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="arr_exp" data-order="' . $ord . '">Data arrivo prev.</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="dep_eff" data-order="' . $ord . '">Data partenza eff.</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="arr_eff" data-order="' . $ord . '">Data arrivo eff.</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="captain" data-order="' . $ord . '">Capitano</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>     
    ';

    while($row = $result->fetch_array(MYSQLI_ASSOC)) {
        if ($row['ret']) {
            $tmp = $row['trade_dep'];
            $row['trade_dep'] = $row['trade_arr'];
            $row['trade_arr'] = $tmp;
            unset($tmp);
        }
        if (!$row["dep_eff"])
            $row["dep_eff"] = '/';
        else
            $row['dep_eff'] = date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['dep_eff'])));
        if (!$row["arr_eff"])
            $row["arr_eff"] = '/';
        else
            $row['arr_eff'] = date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['arr_eff'])));
        $out .= '
        
            <tr class="align-middle" id="' . $row["ship_id"] . '-' . $row["dep_exp"] . '">
                <td class="text-center">
                    <div>' . $row["ship"] . '</div>
                </td>
                <td class="text-center">
                    <div>' . $row["trade_dep"] . '</div>
                </td>
                <td class="text-center">
                    <div>' . $row["trade_arr"] . '</div>
                </td>
                <td class="text-center">
                   <div>' . date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['dep_exp']))) . '</div>
                </td>
                <td class="text-center">
                    <div>' . date('d/m/Y H:i', strtotime(str_replace('.', '-', $row['arr_exp']))) . '</div>
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
                <td>';
        if (!$row['deleted']) {

            $out .= '<buttons>';

            if ($_SESSION['type'] !== 'capitano' && $row['dep_eff'] === '/')
                $out .= '
                    <div>
                        <a href="php/editroute.php?id=' . $row["ship_id"] . '-' . $row["dep_exp"] . '" class="btn btn-primary m-1">
                            <i class="cil-pen"></i>
                        </a>
                        <a href="#" class="btn btn-danger deleteButton m-1">
                            <i class="cil-trash"></i>
                        </a>
                    </div>';
            $out .= '<div>';
            if ($_SESSION['type'] !== 'capitano')
                $out .= '
                    <a href="#" class="btn btn-info reservationModalBtn m-1" >
                        <i class="cil-people"></i>
                    </a>';
            $out .= '
                        <button class="btn btn-warning m-1 notes">
                            <i class="cil-notes"></i>
                        </button> 
                    </div>
              </buttons>
            </td>
        </tr>
        ';
        } else {
            $out .= '
                <span class="badge bg-danger">Annullata</span>
                    </td>
                </tr>';
        }
    }
    echo $out;
?>
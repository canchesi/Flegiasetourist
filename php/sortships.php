<?php

    require_once('config.php');

    $out = "";
    $ord = $_POST["order"];

    $sql = "
    
        SELECT *
            FROM ships 
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
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="id" data-order="' . $ord . '">ID</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="name" data-order="' . $ord . '">Nome</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="harb1" data-order="' . $ord . '">Porto n. 1</a></th>
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="harb2" data-order="' . $ord . '">Porto n. 2</a></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-end"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    ';

    while($row = $result->fetch_array(MYSQLI_ASSOC)){
        $out .= '
        
            <tr class="align-middle" id="' . $row["id"] . '">
                <td class="text-center">
                    <div>' . $row["id"] . '</div>
                </td>
                <td class="text-center">
                    <div>' . $row["name"] . '</div>
                </td>
                <td class="text-center">
                    <div>'; $out .= $row["harb1"] ? $row["harb1"] : "/"; $out .= '</div>
                </td>
                <td class="text-center">
                   <div>'; $out .= $row["harb2"] ? $row["harb2"] : "/"; $out .= '</div>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                <form method="GET" class="">
                    <a href="php/editship.php?id=' . $row['id'] . '" class="btn btn-primary m-1"><i class="cil-pen"></i></a>
                    <a href="#" class="btn btn-danger m-1 deleteButton"><i class="cil-trash"></i></a>
                </form>
                </td>
            </tr>
        ';
    }

    $out .= '</tbody></table>';

    echo $out;
?>
<?php

    require_once('config.php');

    $out = "";
    $ord = $_POST["order"];

    $sql = "
    
        SELECT *
            FROM trades 
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
                    <th class="text-center"><a href="#" class="btn btn-ghost-dark orderButton" id="harb_dep" data-order="' . $ord . '">Partenza</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="harb_arr" data-order="' . $ord . '">Arrivo</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="price_adult" data-order="' . $ord . '">Prezzo maggiorenni</a></th>
                    <th class=""><a href="#" class="btn btn-ghost-dark orderButton" id="price_underage" data-order="' . $ord . '">Prezzo minorenni</a></th>
                    <th class="text-center"></th>
                    <th class="text-center"></th>
                    <th class="text-end"></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    ';

    while($row = $result->fetch_array(MYSQLI_ASSOC))
        $out .= '
        
            <tr class="align-middle" id="' . $row["harb_dep"] . '-' . $row['harb_arr'] .'">
                <td class="text-center">
                    <div>' . $row["harb_dep"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                    <div>' . $row["harb_arr"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                    <div>€' . $row["price_adult"] . '</div>
                </td>
                <td class="" style="padding: 20px">
                   <div>€' . $row["price_underage"] . '</div>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                <form method="GET" class="">
                    <a href="php/edittrade.php?id=' . $row["harb_dep"] . '-' . $row['harb_arr'] .'" class="btn btn-primary m-1"><i class="cil-pen"></i></a>
                    <a href="#" class="btn btn-danger m-1 deleteButton"><i class="cil-trash"></i></a>
                </form>
                </td>
            </tr>
        
        ';

    $out .= '</tbody></table>';

    echo $out;
?>
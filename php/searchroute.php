<?php


    require_once('config.php');

    $tradeDep = $_GET['trade_dep'];
    $tradeArr = $_GET['trade_arr'];
    $depExp = $_GET['dep_exp'];


    $sql = "

        SELECT dep_exp, arr_exp, ship_id, price_adult, price_underage
            FROM routes JOIN trades 
                ON trade_dep = harb_dep
                OR trade_dep = harb_arr
            WHERE 
                ((trade_dep = '$tradeDep' AND trade_arr = '$tradeArr' AND ret = 0) 
                OR
                (trade_dep = '$tradeArr' AND trade_arr = '$tradeDep' AND ret = 1))
                AND dep_exp >= '$depExp' AND dep_eff IS NULL
                
    ";

    $out = '
        <div class="mb-4"></div>
        <table class="table border" id="routes">
            <thead class="table-light fw-semibold">
                <th class="">Tratta</th>
                <th class="">Data partenza</th>
                <th class="">Data arrivo</th>
                <th class="">Prezzi</th>
            
    ';
    if ($result = $connection->query($sql)) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (!$row)
            $out .= '</thead></table><div class="text-center">Nessuna rotta programmata</div>';
        else {
            $out .= "<th></th></thead><tbody>";
            while ($row) {
                $out .= "
                
                    <tr id='". $row['ship_id'] ."-" . $row['dep_exp'] ."'>
                        <td>$tradeDep - $tradeArr</td>
                        <td>" . date("d/m/Y H:i", strtotime($row['dep_exp'])) . "</td>
                        <td>" . date("d/m/Y H:i", strtotime($row['arr_exp'])) . "</td>
                        <td>Adulto:\t€" . number_format((float)$row['price_adult'], 2) . "<br>Minore:\t€" . number_format((float)$row['price_underage'], 2) . "</td>
                        <td class='text-center'><button class='btn btn-warning mt-1 reservationModalBtn'>Prenota</button></td>
                    </tr>
                
                ";
                $row = $result->fetch_array(MYSQLI_ASSOC);
            }
            $out .= "</tbody></table>";
        }
    }

    echo $out;

<?php
    require_once('config.php');
    session_start();
    if (!isset($_SESSION['id'])) {
        echo '-2';
        exit();
    }elseif($_SESSION['type'] != 'cliente') {
        echo '-2';
        exit();
    }

    $ids = explode('-', $_GET['id'], 2);
    $num_ad = $_GET['adult'];
    $num_un = $_GET['under'];
    $veh = explode(' +', $_GET['vehicle'])[0];


    $sql = "
    
        SELECT num_pass AS pass
            FROM routes
            WHERE ship_id = '" . $ids[0] . "' AND dep_exp = '" . $ids[1] . "';
    
    ";

    if($result = $connection->query($sql))
        if($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $pass = $num_ad + $num_un;
            if (($pass + $row['pass']) <= 200) {

                $sql = "
                
                    INSERT INTO reservations(user_id, date_res, adults, underages, vehicle, ship_id, dep_exp)
                        VALUES('" . $_SESSION['id'] . "', '" . date('Y-m-d H:i:s') . "', '$num_ad', '$num_un', NULLIF('$veh','Nessuno'), '" . $ids[0] . "', '" . $ids[1] ."');
                        
                    UPDATE routes SET num_pass = num_pass +'$pass' WHERE ship_id = '" . $ids[0] . "' AND dep_exp = '" . $ids[1] . "';
                
                ";
                if ($result = $connection->multi_query($sql))
                    echo '0';
                else
                    echo '-1';

            } else
                echo($num_ad + $num_un + $row['pass']);
        }
?>
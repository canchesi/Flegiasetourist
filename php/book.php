<?php
    require_once('config.php');

    /** @var MYSQLI $connection*/


session_start();
    if (!isset($_SESSION['id'])) {
        echo '-2';
        exit();
    }elseif($_SESSION['type'] != 'cliente') {
        echo '-2';
        exit();
    }

    $id = $_GET['id'];
    $num_ad = $_GET['adult'];
    $num_un = $_GET['under'];
    $veh = explode(' +', $_GET['vehicle'])[0];




    $sql = "
    
        SELECT num_pass AS pass
            FROM routes
            WHERE id = '" . $id . "';
    
    ";

if($result = $connection->query($sql))
        if($row = $result->fetch_array(MYSQLI_ASSOC)) {
            $pass = $num_ad + $num_un;
            if (($pass + $row['pass']) <= 200) {



                $sql = "
                    SELECT id
                        FROM `user-card_matches`
                        WHERE user_id = '" . $_SESSION['id'] . "' AND cc_num = '" . $_GET['cc_num'] . "'
                
                ";

                die($sql);

                $sql = "
                
                    INSERT INTO reservations(user_id, date_res, adults, underages, vehicle, ship_id, dep_exp)
                        VALUES('" . $_SESSION['id'] . "', '" . date('Y-m-d H:i:s') . "', '$num_ad', '$num_un', NULLIF('$veh','Nessuno'), '" . $ids[0] . "', '" . $ids[1] ."');
                        
                    UPDATE routes SET num_pass = num_pass +'$pass' WHERE id = '" . $id . "';
                
                ";
                if ($result = $connection->multi_query($sql))
                    echo '0';
                else
                    echo '-1';

            } else
                echo($num_ad + $num_un + $row['pass']);
        }
?>
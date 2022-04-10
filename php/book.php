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

    //TODO - Aggiungere dati di carta e fare il regex
    switch($_GET['payment']) {
        case '-3':  // Cassa
            break;
        case '-1':  // Carta nuova

            $sql = "
                    SELECT cc_num
                        FROM `user-card_matches`
                    WHERE user_id = '" . $_SESSION['id'] . "' AND  cc_num = '" . $_GET['cc_info']['cc_num'] . "'
                ";

            if ($result = $connection->query($sql)) {
                if ($result->num_rows == 0) {
                    $sql = "
                            INSERT INTO `user-card_matches` (user_id, cc_num, saved)
                                VALUES('" . $_SESSION['id'] . "', '" . $_GET['cc_info']['cc_num'] . "', '" . $_GET['saved'] . "')
                        ";

                    if (!($result = $connection->query($sql)))
                        die('-1');

                }
            } else
                die('-1');

            if($_GET['saved'] === '1'){
                $sql = "
                    SELECT number
                        FROM credit_cards
                    WHERE number = '" . $_GET['cc_num'] . "'
                
                ";
                if ($result = $connection->query($sql))
                    if ($result->num_rows == 0) {

                        $sql = "
                            INSERT INTO credit_cards
                                VALUES('" . $_GET['cc_info']['cc_num'] . "', '" . $_GET['cc_info']['cc_acchold'] . "', '" . $_GET['cc_info']['cc_exp'] . "', '" . $_GET['cc_info']['cc_cvv'] . "');
                                
                        ";
                        if(!($result = $connection->query($sql)))
                            die('-1');
                    }
            }
            break;
        default:    // Carta già salvata
            // FARE

    }

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
                
                    INSERT INTO reservations(route_id, date_res, adults, underages, vehicle)
                        VALUES('" . $_GET['id'] . "', '" . date('Y-m-d H:i:s') . "', '$num_ad', '$num_un', NULLIF('$veh','Nessuno'));
                        
                    UPDATE routes SET num_pass = num_pass +'$pass' WHERE id = '" . $id . "';
                
                ";
                if ($result = $connection->multi_query($sql))
                    echo '0';
                else
                    echo '-1';

            } else
                echo($num_ad + $num_un + $row['pass']);
        }

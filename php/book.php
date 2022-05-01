<?php
require_once('config.php');

/** @var MYSQLI $connection */

/*
 * Pagina che effettua la prenotazione di un cliente
 * */

session_start();
if (!isset($_SESSION['id']) || $_SESSION['type'] != 'cliente')
    die('-2');


$id = $_GET['id'];          //ID rotta
$num_ad = $_GET['adult'];   //Numero adulti
$num_un = $_GET['under'];   //Numero ragazzi
$veh = explode(' +', $_GET['vehicle'])[0];  //Tipo di veicolo

$cc_user_id = 0;    //ID associazione utente-carta inizializzato a 0

// Query che prende il numero di passeggeri in una rotta
$sql = "
    
        SELECT num_pass AS pass
            FROM routes
            WHERE id = '" . $id . "';
    
    ";


if ($result = $connection->query($sql))
    if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        //Numero di passeggeri che si vuole prenotare
        $pass = $num_ad + $num_un;

        /*
         * Se il numero di passeggeri che si vuole prenotare
         * più quelli già prenotati è minore o uguale a 200...
         * */

        if (($pass + $row['pass']) <= 200) {

            // ...verifica il pagamento...
            switch ($_GET['payment']) {
                case '-3':  // Cassa
                    do {
                        // Query che trova l'id dell'associazione utente-carta, se presente
                        $sql = "
                            SELECT id
                                FROM `user-card_matches`
                            WHERE user_id = '" . $_SESSION['id'] . "' AND cc_num IS NULL
                        ";

                        if ($result = $connection->query($sql)) {
                            // Se non lo trova...
                            if ($result->num_rows == 0) {
                                // ...Lo inserisce...
                                $sql = "
                                    INSERT INTO `user-card_matches` (user_id, cc_num, saved)
                                        VALUES('" . $_SESSION['id'] . "', NULL, '" . $_GET['saved'] . "')
                                ";
                                if (!($result = $connection->query($sql)))
                                    die('-1');
                            } else if ($row = $result->fetch_array(MYSQLI_ASSOC))
                                // ...altrimenti lo inserisce nella variabile $cc_user_id
                                $cc_user_id = $row['id'];
                        }
                    } while ($cc_user_id === 0);
                    /*
                     * Il do-while serve per effettuare al più due volte il controllo dell'id,
                     * in maniera tale da prendere, eventualmente, l'id dell'associazione utente-carta
                     * appena inserito
                     * */
                    break;

                case '-1':  // Carta nuova
                    $saved = 1; //Flag che determina se appena salvata
                    $alreadySaved = 0; //Flag che determina se già presente
                    do {
                        // Query che verifica se è presente un'associazione con la carta non salvata
                        $sql = "
                            SELECT id, saved
                                FROM `user-card_matches`
                            WHERE user_id = '" . $_SESSION['id'] . "' AND cc_num = '" . $_GET['cc_info']['cc_num'] . "'
                        ";

                        if ($result = $connection->query($sql)) {
                            // Se mai usata...
                            if ($result->num_rows == 0) {

                                // ...verifica la presenza della carta salvata da un altro utente...
                                $sql = "
                                    SELECT cvv
                                        FROM credit_cards
                                        WHERE number = '" . $_GET['cc_info']['cc_num'] . "'
                                ";

                                if($result = $connection->query($sql))
                                    // Se non presente...
                                    if($result->num_rows == 0) {
                                        // ...inserisce solo il numero di carta tra le carte salvate
                                        $sql = "
                                            INSERT INTO credit_cards (number)
                                                VALUES('" . $_GET['cc_info']['cc_num'] . "')
                                        ";

                                        if (!($result = $connection->query($sql)))
                                            die('-1');
                                    }

                                // ...e crea l'associazione utente-carta...
                                $sql = "
                                    INSERT INTO `user-card_matches` (user_id, cc_num)
                                        VALUES('" . $_SESSION['id'] . "', '" . $_GET['cc_info']['cc_num'] . "')
                                ";

                                if (!($result = $connection->query($sql)))
                                    die('-1');
                            } else if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                                // ...altrimenti salva l'id dell'associazione e un flag se salvata
                                $cc_user_id = $row['id'];
                                $saved = $row['saved'];
                            }

                        } else
                            die('-1');
                    } while ($cc_user_id === 0);
                    /*
                     * Il do-while serve per effettuare al più due volte il controllo dell'id,
                     * in maniera tale da prendere, eventualmente, l'id dell'associazione utente-carta
                     * appena inserito
                     * */

                    // Se si vuole salvare la carta...
                    if ($_GET['saved'] === '1') {
                        // ...controlla se la carta è già stata salvata...
                        $sql = "
                            SELECT saved
                                FROM `user-card_matches`
                            WHERE cc_num = '" . $_GET['cc_info']['cc_num'] . "'
                        ";

                        if ($result = $connection->query($sql)) {
                            // ...da almeno un utente...
                            while (($row = $result->fetch_array(MYSQLI_ASSOC)) && !$alreadySaved)
                                if ($row['saved'] == 1)
                                    $alreadySaved = 1;
                        } else
                            die('-1');

                        // ...e...
                        if(!$alreadySaved){
                            // ...se non è mai stata salvata aggiunge i dati necessari e...
                            $sql = "
                                UPDATE credit_cards
                                    SET 
                                        acc_holder = '" . $_GET['cc_info']['cc_acchold'] . "',
                                        exp = '" .$_GET['cc_info']['cc_exp']. "',
                                        cvv = '" .$_GET['cc_info']['cc_cvv']. "'
                                    WHERE number = '" . $_GET['cc_info']['cc_num'] . "'

                            ";

                            if (!($result = $connection->query($sql)))
                                die('-1');


                        }
                        // ... aggiorna il flag
                        $sql = "UPDATE `user-card_matches` SET saved = 1 WHERE id = '" . $cc_user_id  . "'";

                        if (!($result = $connection->query($sql)))
                            die('-1');
                    }
                    break;
                default:    // Carta già salvata
                    // salva direttamente l'id dell'associazione utente-carta
                    $cc_user_id = $_GET['payment'];
            }

            // Se tutto è andato a buon fine...
            if ($cc_user_id) {
                // ...aggiunge la prenotazione
                $sql = "
                
                    INSERT INTO reservations(route_id, payment_id, date_res, adults, underages, vehicle, subtotal)
                        VALUES('" . $id . "', '" . $cc_user_id . "', '" . date('Y-m-d H:i:s') . "', '$num_ad', '$num_un', NULLIF('$veh','Nessuno'), '".$_GET['subtotal']."');
                        
                    UPDATE routes SET num_pass = num_pass +'$pass' WHERE id = '" . $id . "';
                
                ";

                if ($result = $connection->multi_query($sql))
                    echo '0';
                else
                    echo '-1';
            }
        } else
            // ...altrimenti restituisce il numero totale di passeggeri, che genera un errore
            echo($num_ad + $num_un + $row['pass']);
    }
else
    die('-1');
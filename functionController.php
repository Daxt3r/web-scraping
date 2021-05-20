<?php

    require_once('dbHandler.php');
    
    $db_Handler = new dbHandler();
    
    $action = $_POST['functionName'];

    switch($action) {
        case 'leaderboard' :
            
            $range; 
            $datumVon;
            $datumBis;
            
            if(!$_POST['number']) {
                $range = 5; //default Value wenn nichts angegeben
            } else {
                $range = $_POST['number'];
            }
           if(!isset($_POST['datepickerVon'])) {
                $datumVon = $db_Handler->getFirstDate(); //Wenn nichts angegeben, wird das erste Datum aus Tabelle genommen
            } else {
                $datumVon = $_POST['datepickerVon'];
            }
                
            if(!isset($_POST['datepickerBis'])) {
                $datumBis = $db_Handler->getLastDate(); //Wenn nichts angegeben, wird das letzte Datum aus Tabelle genommen
            } else {
                $datumBis = $_POST['datepickerBis'];
            }
            
            //Nachdem die gesendeten Daten eingelesen wurden, müssen sie geprüft werden
            
            if(!$db_Handler->dateExist($datumVon))
                throw new Exception("Unbekanntes Datum: " . $datumVon);
            if(!$db_Handler->dateExist($datumBis))
                throw new Exception("Unbekanntes Datum: " . $datumVon);
            
            echo $db_Handler->getNumberOfRepetitions($range, $datumVon, $datumBis);
            break;
        default: die('Access denied for this function!');
    }

?>
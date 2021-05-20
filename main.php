<?php

require_once('htmlHandler.php');
require_once('dbHandler.php');


echo "Start <br/>";

$html_Handler = new htmlHandler();
$db_Handler = new dbHandler();


//Daten werden von der Webseite geholt
$html_Handler->scrapSongs();
//$html_Handler->displayTitelliste();

//Daten werden in die Datenbank geschrieben

$db_Handler->connect();
$db_Handler->write($html_Handler);
$db_Handler->close();

echo "Ende <br/>";

?>

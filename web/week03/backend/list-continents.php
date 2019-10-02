<?php
/**
 * I would produce continents array here, but instead I prefer 
 * to just open the json file and return to caller.
 
 * I need same json file elsewhere.
 */
$continents = file_get_contents('continents.json');

header('Content-Type: application/json');
echo $continents;
?>
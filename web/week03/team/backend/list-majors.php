<?php
/**
 * I would produce majors array here, but instead I prefer 
 * to just open the json file and return to caller.
 
 * I need same json file elsewhere.
 */
$majors = file_get_contents('majors.json');

header('Content-Type: application/json');
echo $majors;
?>
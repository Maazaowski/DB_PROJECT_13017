<?php

DEFINE ('DB_USER', 'maaz');
DEFINE ('DB_PASSWORD', '.Rubberband12.');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'customers');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die ('Could not connect to MySQL ' . mysqli_connect_error());

?>

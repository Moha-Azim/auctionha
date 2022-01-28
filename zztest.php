<?php


$path_parts = pathinfo('/www/htdocs/inc/lib.inc.PHP');

print_r($path_parts);

echo strtolower($path_parts['extension']);

echo strtolower(pathinfo('/www/htdocs/inc/lib.inc.PHP')['extension']);
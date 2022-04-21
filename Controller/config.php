<?php
require __DIR__ . '../inc/functions.php';
date_default_timezone_set('Europe/Bucharest');// set created_at for DB

/*
if (!file_exists("config/db.php") ) {
    header("Location: install/index.php");
    exit;
}
*/
print_r($_GET);
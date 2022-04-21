<?php

spl_autoload_register('loadClasses');

function loadClasses($class)
{
    $path = "../../".$class.'.php';

    if (!file_exists($path)) {
        echo "Class not found ".$path;
    }else {
        include_once $path;
    }
    
}


?>
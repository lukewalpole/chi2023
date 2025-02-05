<?php

/**
 * autoLoader
 * 
 * Automatically loads classes as they are
 * needed without needing to manually include
 * files. 
 * 
 * @author Luke Walpole W20020794
 */

function autoloader($className) {
    $filename = $className . ".php";
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $filename);
    if (is_readable($filename)) {
        include_once $filename;
    } else {
        throw new Exception("File not found: " . $filename);
    }
}
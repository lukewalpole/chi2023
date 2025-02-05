<?php

/**
 * exceptionHandler
 * 
 * Handles uncaught exceptions and internal server 
 * errors by outputting JSON as a response. 
 * 
 * @author Luke Walpole W20020794
 */
 
function exceptionHandler($e) {
   http_response_code(500);
   $output['message'] = "Internal Server Error";
   $output['details']['exception'] = $e->getMessage();
   $output['details']['file'] = $e->getFile();
   $output['details']['line'] = $e->getLine();
   echo json_encode($output);
   exit();
}
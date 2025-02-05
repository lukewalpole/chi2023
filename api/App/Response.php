<?php

namespace App;
 
/**
 * Response
 * 
 * Handles HTTP headers and JSON output from the api.
 * 
 * @author Luke Walpole W20020794
 */

class Response
{
    public function __construct()
    {
        $this->outputHeaders();
 
        if (Request::method() == "OPTIONS") {
            exit();
        }
    }
    
    private function outputHeaders()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Authorization');
    }
 
    public function outputJSON($data)
    {
      if (empty($data)) {
        http_response_code(204);
      }
      echo json_encode($data);
    }
}
<?php

namespace App\EndpointControllers;

/**
 * Preview
 * 
 * An endpoint that displays content
 * from the preview table. It calls 
 * back the title of a paper as well
 * as a link to the video. 
 * 
 * @author Luke Walpole W20020794
 */

class Preview extends Endpoint
{
    protected $allowedParams = ["limit"];
    private $sql = "SELECT title, preview_video FROM content WHERE content.preview_video IS NOT NULL ORDER BY RANDOM()";
    private $sqlParams = [];
 
    public function __construct()
    {
        switch(\App\Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $this->buildSQL();
                $dbConn = new \App\Database(CHI2023_DATABASE);
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams); 
                break;
            default:
                throw new \App\ClientError(405);
        }
 
        parent::__construct($data);
    }

    private function buildSQL()
    {
        // Set a flag
        $where = false;
 
        if (isset(\App\Request::params()['limit'])) 
        {
            if (!is_numeric(\App\REQUEST::params()['limit'])) {
                throw new \App\ClientError(422);
            }
            if (count(\App\Request::params()) > 1) {
                throw new \App\ClientError(422);
            } 
            $this->sql .= " LIMIT :limit";
            $this->sqlParams[":limit"] = \App\Request::params()['limit'];
        }
    }
}
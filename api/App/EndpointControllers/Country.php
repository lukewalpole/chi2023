<?php

namespace App\EndpointControllers;

/**
 * Country
 * 
 * An endpoint that displays the countries,
 * cities and institutions from the affiliation
 * table. Each country is only displayed once and 
 * the cities and institutions are grouped. 
 * 
 * @author generated
 * ChatGPT was used to help write the SQL statement.
 * The rest of the work is taken from the workshops
 * or done by myself. 
 */

class Country extends Endpoint
{
    private $sql = "SELECT country, GROUP_CONCAT(DISTINCT city) AS city, GROUP_CONCAT(DISTINCT institution) AS institution FROM affiliation GROUP BY country ORDER BY country ASC";
    private $sqlParams = [];
 
    public function __construct()
    {
        switch(\App\Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $dbConn = new \App\Database(CHI2023_DATABASE);
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams); 
                break;
            default:
                throw new \App\ClientError(405);
        }
 
        parent::__construct($data);
    }
}
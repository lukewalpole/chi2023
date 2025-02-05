<?php

namespace App;
 
/**
 * Database
 * 
 * Database class for connecting and 
 * executing SQL queries on the database. 
 * 
 * @author Luke Walpole W20020794
 */

class Database 
{
    private $dbConnection;
  
    public function __construct($dbName) 
    {
        $this->setDbConnection($dbName);  
    }
 
    private function setDbConnection($dbName) 
    {
        $this->dbConnection = new \PDO('sqlite:'.$dbName);
        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    public function executeSQL($sql, $params=[])
    { 
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
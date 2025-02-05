<?php

namespace App\EndpointControllers;

/**
 * AuthorAndAffiliation
 * 
 * An endpoint that displays the country,
 * city and institution each author is 
 * affiliated with and also the content they
 * have produced. 
 * The two parameters are for:
 * 1. searching for specific information that has
 * a certain content id.
 * 2. searching for specific content from a certain
 * country.
 * 
 * @author Luke Walpole
 */

class AuthorAndAffiliation extends Endpoint
{
    protected $allowedParams = ["content", "country"];
    private $sql = "SELECT author.id AS author_id, author.name AS author_name, content.id AS content_id, content.title as content_title, affiliation.country, affiliation.city, affiliation.institution 
                    FROM author 
                    JOIN affiliation ON author.id = affiliation.author 
                    JOIN content ON content.id = affiliation.content";
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
        $where = false;
 
        if (isset(\App\Request::params()['content'])) 
        {
            if (!is_numeric(\App\REQUEST::params()['content'])) {
                throw new \App\ClientError(422);
            }
            if (count(\App\Request::params()) > 1) {
                throw new \App\ClientError(422);
            } 
            $this->sql .= " WHERE :content IS NULL OR content_id = :content";
            $this->sqlParams[":content"] = \App\Request::params()['content'];
        }
 
        if (isset(\App\REQUEST::params()['country']))
        {
            $this->sql .= ($where) ? " AND" : " WHERE";
            $where = true;
            $this->sql .= " affiliation.country LIKE :country";
            $this->sqlParams[':country'] = \App\REQUEST::params()['country'];
        }
    }
}
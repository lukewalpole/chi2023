<?php

namespace App\EndpointControllers;

/**
 * AuthorAndAffiliation
 * 
 * An endpoint that displays title,
 * abstract and type of content that it is.
 * The two parameters are for:
 * 1. Displaying a specific page of content.
 * content is displayed in blocks of 20 at a time.
 * 2. Displays a specific type of content and all
 * papers that fall under that category.
 * 
 * @author generated
 * ChatGPT was used to write the parameters.
 * I am unsure of how the page parameter even works
 * but after spending forever trying to get the code 
 * to work, that was the only solution that didn't
 * produce an error so I decided to leave the code alone.
 * The rest of the work is taken from the workshops
 * or done by myself. 
 */

class Content extends Endpoint
{
    protected $allowedParams = ["page", "type"];
    private $sql = "SELECT content.title, content.abstract, type.name
                    FROM content 
                    JOIN type ON content.type = type.id";
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

        if (isset(\App\REQUEST::params()['page']))
        {
            $page = intval(\App\REQUEST::params()['page']);
            $this->sqlParams[':offset'] = ($page - 1) * 20;
            $where = true; 
        }
 
        if (isset(\App\REQUEST::params()['type']))
        {
            $this->sql .= ($where) ? " AND" : " WHERE";
            $this->sql .= " type.name LIKE :type";
            $this->sqlParams[':type'] = \App\REQUEST::params()['type'];
        }

        if (isset(\App\REQUEST::params()['page']))
        {
            $this->sql .= " LIMIT 20 OFFSET :offset";
        }
    }
}
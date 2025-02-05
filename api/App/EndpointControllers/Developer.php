<?php

namespace App\EndpointControllers;

/**
 * Developer
 * 
 * An endpoint that displays the id
 * and name of myself.
 * 
 * @author Luke Walpole W20020794
 */
 
class Developer extends Endpoint
{
    public function __construct()
    {
        switch(\App\Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $data['id'] = "w20020794";
                $data['name'] = "Luke Walpole";
                break;
            default:
                throw new \App\ClientError(405);
        }
        parent::__construct($data);
    }
}
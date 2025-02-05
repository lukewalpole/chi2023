<?php

namespace App;

/**
 * Router
 * 
 * Routes incoming requests and directs
 * the request to the correct endpoint.
 * 
 * @author Luke Walpole W20020794
 */

abstract class Router

{
    public static function routeRequest()
    {
        try
        {
            switch (Request::endpointName()) {
                case '/':
                case '/content':
                case '/content/':
                    $endpoint = new \App\EndpointControllers\Content();
                    break;
                case '/developer':
                case '/developer/':
                    $endpoint = new \App\EndpointControllers\Developer();
                    break;
                case '/country':
                case '/country/':
                    $endpoint = new \App\EndpointControllers\Country();
                    break;
                case '/preview':
                case '/preview/':
                    $endpoint = new \App\EndpointControllers\Preview();
                    break;
                case '/authorandaffiliation':
                case '/authorandaffiliation/':
                    $endpoint = new \App\EndpointControllers\AuthorAndAffiliation();
                    break;
                case '/token':
                case '/token/':
                    $endpoint = new \App\EndpointControllers\Token();
                    break;
                case '/note':
                case '/note/':
                    $endpoint = new \App\EndpointControllers\Note();
                    break;
                default:
                    throw new ClientError(404);
            }
        } catch (ClientError $e) {
            $data = ['message' => $e->getMessage()];
            $endpoint = new \App\EndpointControllers\Endpoint($data);
        }

        return $endpoint;
    }
}
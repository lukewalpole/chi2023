<?php

namespace App\EndpointControllers;

/**
 * Issue Token to Authenticated Users
 *
 * This class will check a username and password against those held in the 
 * database. Where authentication is successful it will return a JWT.
 * 
 * @author Luke Walpole W20020794
 */
 
class Token extends Endpoint
{
    /**
     * Constructor
     * @todo 1. connect to database
     * @todo 2. check the request method is GET or POST
     * @todo 3. check there is a username and password parameter
     * @todo 4. execute an SQL query
     * @todo 5. check if username matches one in database
     * @todo 6. validate the password
     * @todo 7. issue token
     */ 

    private $sql = "SELECT id, password FROM account WHERE email = :email";
    private $sqlParams = [];

    public function __construct() {
        // @todo 2. check the request method is GET or POST
        switch(\App\Request::method()) 
        {
            case 'GET':
            case 'POST':
                
                $this->checkAllowedParams();
                // @todo 1. connect to database
                $dbConn = new \App\Database(USERS_DATABASE);

                //@todo 3. check there is a username and password
                if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
                    throw new \App\ClientError(401);
                }
                if (empty(trim($_SERVER['PHP_AUTH_USER'])) || empty(trim($_SERVER['PHP_AUTH_PW']))) {
                    throw new \App\ClientError(401);
                }

                // @todo 4. execute an SQL query
                $this->sqlParams[":email"] = $_SERVER['PHP_AUTH_USER'];
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams);

                // @todo 5. check if username matches one in database
                if (count($data) != 1) {
                    throw new \App\ClientError(401);
                }
            
                // @todo 6. validate the password
                if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
                    throw new \App\ClientError(401);
                }

                // @todo 7. issue token
                $token = $this->generateJWT($data[0]['id']);        
                $data = ['token' => $token];

                parent::__construct($data);
                break;
            default:
                throw new \App\ClientError(405);
                break;
        }
    }

    private function generateJWT($id) { 
        // 1. Uses the secret key defined earlier
        $secretKey = SECRET;
        
        // 2. Specify what to add to the token payload. 
        $payload = [
            'sub' => $id,
            'exp' => strtotime('+30 minutes', time()),
            'iat' => time(),
            'iss' => $_SERVER['HTTP_HOST']
        ];
            
        // 3. Use the JWT class to encode the token  
        $jwt = \Firebase\JWT\JWT::encode($payload, $secretKey, 'HS256');
        
        return $jwt;
      }
}
<?php
 
namespace App\EndpointControllers;
 
/**
 * Note
 * 
 * For a get request, it returns all notes for a user 
 * unless a content_id is specified, in which case it returns 
 * the note for that piece of content. For a post request, 
 * it updates the note for a piece of content. For a delete 
 * request, it deletes the note for a piece of content. There 
 * is some basic validation of the note and content_id and notes must 
 * be less than 255 characters.
 * 
 * @author Luke Walpole W20020794
 */

class Note extends Endpoint 
{
    public function __construct()
    {
        $id = $this->validateToken();
        
        $this->checkUserExists($id);
 
        switch(\App\Request::method()) 
        {
            case 'GET':
                $data = $this->getNote($id);
                break;
            case 'POST':
                $data = $this->postNote($id);
                break;
            case 'DELETE':
                $data = $this->deleteNote($id);
                break;
            default:
                throw new \App\ClientError(405);
                break;
        }
        parent::__construct($data);
    }

    private function validateToken()
    {
        $secretkey = SECRET;
                
        $jwt = \App\REQUEST::getBearerToken();
 
        try {
            $decodedJWT = \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key($secretkey, 'HS256'));
        } catch (\Exception $e) {
            throw new \App\ClientError(401);
        }
 
        if (!isset($decodedJWT->exp) || !isset($decodedJWT->sub)) { 
            throw new \App\ClientError(401);
        }

        if ($decodedJWT->exp < time()) {
            throw new \App\ClientError(401);
        }

        if ($_SERVER['HTTP_HOST'] != $decodedJWT->iss)
        {
            throw new \App\ClientError(401);
        }
 
        return $decodedJWT->sub;
    }

    /**
     * Check the note exists and do some basic validation
     */

    private function note() 
    {
        if (!isset(\App\REQUEST::params()['note']))
        {
            throw new \App\ClientError(422);
        }
 
        if (mb_strlen(\App\REQUEST::params()['note']) > 255)
        {
            throw new \App\ClientError(422);
        }
 
       $note = \App\REQUEST::params()['note'];
       return htmlspecialchars($note);
    }

    /**
     * Get all notes for a user unless a content_id is specified, in which case
     * it returns the note for that piece of content.
     */

    private function getNote($id)
    {
        // If a content_id is specified, return the note for that piece of content
        // otherwise return all notes for the user.

        if (isset(\App\REQUEST::params()['content_id']))
        {
            $content_id = \App\REQUEST::params()['content_id'];
 
            if (!is_numeric($content_id))
            {
                throw new \App\ClientError(422);
            }
 
            $sql = "SELECT * FROM notes WHERE account_id = :id AND content_id = :content_id";
            $sqlParams = [':id' => $id, 'content_id' => $content_id];
        } else {
            $sql = "SELECT * FROM notes WHERE account_id = :id";
            $sqlParams = [':id' => $id];
        }
 
        $dbConn = new \App\Database(USERS_DATABASE);
        
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
 
    /**
     * This handles both posting a new note and updating an existing note
     * for a piece of content. There can only be one note per piece of content per user.
     */

    private function postNote($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
        $note = $this->note();
 
        $dbConn = new \App\Database(USERS_DATABASE);
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $sql = "SELECT * FROM notes WHERE account_id = :id AND content_id = :content_id";
        $data = $dbConn->executeSQL($sql, $sqlParams);
 
        // If there is no note for this content, create one. 
        // Otherwise update the existing note.

        if (count($data) === 0) {
            $sql = "INSERT INTO notes (account_id, content_id, note) VALUES (:id, :content_id, :note)";
        } else {
            $sql = "UPDATE notes SET note = :note WHERE account_id = :id AND content_id = :content_id";
        }
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id, 'note' => $note];
        $data = $dbConn->executeSQL($sql, $sqlParams);
     
        return [];
    }
 
    /**
     * Delete a note for a piece of content. This method is not strictly necessary as
     * the postNote method can be used to 'delete' a note by setting the note
     * to an empty string.
     */
    
    private function deleteNote($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
        $dbConn = new \App\Database(USERS_DATABASE);
        $sql = "DELETE FROM notes WHERE account_id = :id AND content_id = :content_id";
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
 
    private function checkUserExists($id)
    {
        $dbConn = new \App\Database(USERS_DATABASE);
        $sql = "SELECT id FROM account WHERE id = :id";
        $sqlParams = [':id' => $id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        if (count($data) != 1) {
            throw new \App\ClientError(401);
        }
    }
}
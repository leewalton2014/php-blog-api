<?php
class User {
    //Db Stuff
    private $conn;
    private $table = "users";

    //Post Properties
    public $u_id;
    public $u_forename;
    public $u_surname;
    public $u_email;
    public $u_passwordHash;

    //Constructor with Db
    public function __construct($db) 
    {
        $this->conn = $db;
    }

    //get users
    public function read() 
    {
        //Query
        $query = "SELECT 
                u_id,
                u_forename,
                u_surname,
                u_email,
                u_passwordHash
            FROM $this->table";
        
        //Prepared statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; 
        
    }

}
?>
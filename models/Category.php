<?php
class Category {
    //Db Stuff
    private $conn;
    private $table = "categories";

    //Post Properties
    public $id;
    public $name;
    public $created_at;

    //Constructor with Db
    public function __construct($db) 
    {
        $this->conn = $db;
    }

    //Get categories
    public function read() 
    {
        //Query
        $query = "SELECT 
                id,
                name,
                created_at
            FROM $this->table
            ORDER BY created_at DESC";
        
        //Prepared statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; 
    }

}
?>
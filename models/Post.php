<?php
class Post {
    //Db Stuff
    private $conn;
    private $table = "posts";

    //Post Properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //Constructor with Db
    public function __construct($db) 
    {
        $this->conn = $db;
    }

    //get posts
    public function read() 
    {
        //Query
        $query = "SELECT 
                categories.name,
                posts.id as post_id,
                categories.id,
                category_id,
                title,
                body,
                author,
                posts.created_at
            FROM $this->table 
            LEFT JOIN categories ON category_id = categories.id
            ORDER BY created_at DESC";
        
        //Prepared statement
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; 
        
    }

    //get single post
    public function read_single()
    {
        //Query
        $query = "SELECT 
                categories.name,
                categories.id,
                category_id,
                title,
                body,
                author,
                posts.created_at
            FROM $this->table 
            LEFT JOIN categories ON category_id = categories.id
            WHERE posts.id = ?
            LIMIT 0,1";
        
        //Prepared statement
        $stmt = $this->conn->prepare($query);
        //bind id
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //Set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['name'];

        return $stmt;     
    }

    //Create post
    public function create()
    {
        //Create Query
        $query = "INSERT INTO $this->table
        SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id";

        //Prepared statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        //Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //Update post
    public function update()
    {
        //Create Query
        $query = "UPDATE $this->table
        SET
        title = :title,
        body = :body,
        author = :author,
        category_id = :category_id
        WHERE id = :id";

        //Prepared statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        //Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    //delete post
    public function delete()
    {
        //Query
        $query = "DELETE FROM $this->table WHERE id = :id";
        
        //Prepared statement
        $stmt = $this->conn->prepare($query);

        //Clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        //Bind id
        $stmt->bindParam("id", $this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}
?>
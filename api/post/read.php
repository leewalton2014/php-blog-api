<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instanciate db and connect
$database = new Database();
$db = $database->connect();

//Instanciate blog post object
$post = new Post($db);

//Blog post query
$result = $post->read();
//Get row count
$num = $result->rowCount();
//Check if any posts exist
if($num > 0) {
    //Post array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $post_item = array(
            'id' => $post_id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $name,
        );

        //Push to 'data'
        array_push($posts_arr['data'], $post_item);
    }

    //Turn to json and output
    echo json_encode($posts_arr);
}else{
    //no posts
    echo json_encode(
        array('message' => 'No posts found')
    );
}

?>
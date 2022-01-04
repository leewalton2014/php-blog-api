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

//Get ID of post
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get blog post
$post->read_single();

//Create array
$post_arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name
);

//Make JSON
print_r(json_encode($post_arr));

// //Check if any posts exist
// if(!empty($post)) {
//     //Turn to json and output
//     echo json_encode($post_arr);
// }else{
//     //no posts
//     echo json_encode(
//         array('message' => 'No posts found')
//     );
// }

?>
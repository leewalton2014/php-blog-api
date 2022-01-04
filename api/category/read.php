<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

//Instanciate db and connect
$database = new Database();
$db = $database->connect();

//Instanciate category object
$category = new Category($db);

//Category query
$result = $category->read();
//Get row count
$num = $result->rowCount();
//Check if any categories exist
if($num > 0) {
    //Category array
    $cat_arr = array();
    $cat_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $cat_item = array(
            'id' => $id,
            'name' => $name,
            'created_at' => $created_at,
        );

        //Push to 'data'
        array_push($cat_arr['data'], $cat_item);
    }

    //Turn to json and output
    echo json_encode($cat_arr);
}else{
    //No categories
    echo json_encode(
        array('message' => 'No categories found')
    );
}

?>
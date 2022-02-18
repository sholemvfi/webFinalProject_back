<?php

use config\Database;

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
    include_once '../../config/Database.php';
    include_once '../../models/Movie.php';

    $database = new Database();
    $db = $database->connectingPdo();
    $movie = new Movie($db);

    $data = json_decode((file_get_contents("php://input")));

    $movie->name = $data->name;
    $movie->year = intval($data->year);
    $movie->description = $data->description;
    $movie->img = $data->img;

    if (isset($movie->name) && isset($movie->description) && isset($movie->year) && isset($movie->img) && $movie->create()) {
        echo json_encode(array('message' => 'new movie created yayy'));
    } else {
        echo json_encode(array('message' => 'not created sth is wrong..'));
    }

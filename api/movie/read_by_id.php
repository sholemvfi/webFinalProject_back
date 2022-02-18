<?php

use config\Database;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../config/Database.php';
    include_once '../../models/Movie.php';

    $database = new Database();
    $db = $database->connectingPdo();
    $movie = new Movie($db);

    $movie->id = isset($_GET['id']) ? $_GET['id'] : die();
    $answer = $movie->readById();

    $movie_arr = array(
        'id' => $movie->id,
        'name' => $movie->name,
        'year' => $movie->year,
        'description' => $movie->description,
        'img' => $movie->img,
    );
    print_r(json_encode($movie_arr));
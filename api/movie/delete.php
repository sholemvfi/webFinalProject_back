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
    $result = $movie->delete();

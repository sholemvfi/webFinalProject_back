<?php
use config\Database;
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    include_once '../../config/Database.php';
    include_once '../../models/Movie.php';

    $database = new Database();
    $db = $database->connectingPdo();
    $movie = new Movie($db);
    $answer = $movie->read();
    $rowCount = $answer->rowCount();

    if ($rowCount > 0) {
        $array = array();
        $array['data'] = array();
        while ($row = $answer->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $movie_item = array(
                'id' => $id,
                'name' => $name,
                'year' => $year,
                'description' => $description,
                'img' => $img,
            );
            array_push($array['data'], $movie_item);
        }

        echo json_encode($array);
    } else {
        echo json_encode(
            array('message' => 'nothing found!')
        );
    }
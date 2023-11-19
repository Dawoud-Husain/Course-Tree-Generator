<?php

require_once "../db.php";
$pdo = getDatabaseConnection();

if ($pdo === null) {
    http_response_code(500);
    echo "Internal Server Error";
    exit;
}

// Check what request is being made or else return error 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = 'SELECT DISTINCT SUBSTRING_INDEX(courseCode,\'*\', 1) as Subject FROM Course';

    try {
        header("Content-Type: application/json");
        $statement = $pdo->query($query);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
        http_response_code(200);
    } catch (PDOException $e) {
        echo $e->getMessage();
        http_response_code(500);
    }
} else {
    http_response_code(405); // Method Not Allowed
}

<?php
require_once "../db.php";

$pdo = getDatabaseConnection(TRUE);
if ($pdo === null) {
    http_response_code(500);
    echo "Internal Server Error";
    exit;
}
// Check what request is being made or else return error 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Execute the query
    //$courseCode = $_GET['courseCode'] ?? null;

        // To prevent SQL injection, escape and quote the input value
        //$escapedCourseCode = $pdo->quote("%$courseCode%");

        $query = 'SELECT DISTINCT SUBSTRING_INDEX(courseCode,\'*\', 1) as Subject FROM Course';

        try {
            header("Content-Type: application/json");
            $statement = $pdo->query($query);
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            $json = json_encode($results);
            echo $json;
            http_response_code(200);
        } catch (PDOException $e) {
            echo $e->getMessage();
            http_response_code(500);
        }
    } else {
        echo "Invalid or missing 'courseCode' parameter.";
        http_response_code(400);
    }


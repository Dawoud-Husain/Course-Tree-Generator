<?php
$host = 'localhost';
$user = 'cis3760';
$password = '1234';
$dsn = "mysql:host=localhost;dbname=courses";
// Attempt to connect to the database
try {
	$pdo = new PDO($dsn, $user, $password);

} catch (PDOException $e) {
	echo $e->getMessage();
    http_response_code(500);
}
// Check what request is being made or else return error 
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Execute the query
    $courseCode = $_GET['courseCode'] ?? null;

    if ($courseCode) {

        // To prevent SQL injection, escape and quote the input value
        $escapedCourseCode = $pdo->quote("%$courseCode%");

        $query = "SELECT * FROM Course WHERE courseCode LIKE $escapedCourseCode";

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
}


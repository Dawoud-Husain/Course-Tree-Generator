<?php
$host = 'localhost';
$user = 'cis3760';
$password = 'pass1234';
$dsn = "mysql:host=localhost;dbname=courses";
// Attempt to connect to the database
try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);
}
// Check what request is being made or else return error 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Execute the query
    $body = file_get_contents("php://input");
    $data = json_decode(file_get_contents("php://input"), true);
    $courseCodes = $data['coursesTaken'] ?? [];
    $query2 = "";
    $query1 = "SELECT c.* FROM Course AS c LEFT JOIN Prerequisite AS p ON c.courseCode = p.courseCode WHERE p.courseCode IS NULL ORDER BY `courseCode` ASC";
    if (!empty($courseCodes)) {
        $query2 = "SELECT courseCode FROM Prerequisite  ";
        $whereStatement = ' WHERE';

        if (count($courseCodes) >= 2) {
            $whereStatement = $whereStatement . " description LIKE \"%" . $courseCodes[0] . "%\"";
            for ($x = 1; $x < count($courseCodes); $x++) {
                $whereStatement = $whereStatement . " OR " . "description LIKE \"%" . $courseCodes[$x] . "%\"";
            }
        } else {
            $whereStatement = $whereStatement . " description LIKE \"%" . $courseCodes[0] . "%\"";
        }
        if (strcmp($whereStatement, " WHERE") != 0) {
            $query2 = $query2 . $whereStatement;
        }
    }
    if(strcmp($query2,"")!=0){
        $query = "SELECT c.* FROM Course AS c LEFT JOIN 
        Prerequisite AS p ON c.courseCode = p.courseCode WHERE p.courseCode 
        IS NULL UNION SELECT c.* FROM Course AS c NATURAL JOIN (".$query2.") AS preq ORDER BY courseCode ASC;";
    }else{
        $query = $query1;
    }
    try {
        header("Content-Type: application/json");
        $statement =  $pdo->query($query);      
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $json = json_encode($results);
        echo $json; 
        http_response_code(200);
    } catch (PDOException $e) {
        echo $e->getMessage();
        http_response_code(500);
    }
} else {
    http_response_code(405); // Method Not Allowed
}

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
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $checkMulti = False;
    $whereStatement = 'WHERE';
    $tableStatement = "";
    $query = "";

    // Check through each to see what query parameters we have and build the query 
    if (isset($_GET['preq'])) {
       $tableStatement = $tableStatement . '(SELECT * FROM Prerequisite WHERE description LIKE \'%' .$_GET['preq'].'%\') as Prerequisite ';
     }
    if (isset($_GET['id'])) {
       $whereStatement = $whereStatement . ' courseCode LIKE \'%' .$_GET['id'].'%\'';
       $checkMulti = True;
    }
    if (isset($_GET['name'])) {
        if($checkMulti== TRUE){
            $whereStatement = $whereStatement . ' AND';
        }
        $whereStatement = $whereStatement . ' courseName LIKE \'%' .$_GET['name'].'%\'';
        $checkMulti = True;
    }
    if (isset($_GET['description'])) {
        if($checkMulti== TRUE){
            $whereStatement = $whereStatement . ' AND';
        }
        $whereStatement = $whereStatement . ' courseDesc LIKE \'%' .$_GET['description'].'%\'';
        $checkMulti = True; 
    }

    if (isset($_GET['credit'])) {
        if($checkMulti== TRUE){
            $whereStatement = $whereStatement . ' AND';
        }
        $whereStatement = $whereStatement . ' credits = ' .$_GET['credit'];
        $checkMulti = True; 
    }
    if (isset($_GET['location'])) {
        if($checkMulti== TRUE){
            $whereStatement = $whereStatement . ' AND';
        }
        $whereStatement = $whereStatement . ' location LIKE \'%' .$_GET['location'].'%\'';
        $checkMulti = True; 
    }
    if (isset($_GET['restriction'])) {
        if($checkMulti== TRUE){
            $whereStatement = $whereStatement . ' AND';
        }
        $whereStatement = $whereStatement . ' restriction LIKE \'%' .$_GET['restriction'].'%\'';
        $checkMulti = True; 
    }
    if(strcmp($tableStatement,"") === 0){
        $query =  "SELECT * FROM Course ";
    }else{
        $query =  "SELECT * FROM Course Natural Join ". $tableStatement." ";
    }
    if(strcmp($whereStatement,"WHERE")!=0){
        $query = $query.$whereStatement;
    }
    // Execute the query
    try{
    header("Content-Type: application/json");
    $statement =  $pdo->query($query);      
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    $json = json_encode($results);
    echo $json; 
    http_response_code(200);
    }catch (PDOException $e) {
	echo $e->getMessage();
    http_response_code(500);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = $_GET["courseCode"]; 
        $name = $_GET["courseName"];
        $desc = $_GET["courseDesc"];
        $credit = $_GET["credits"];
        $location = $_GET["location"];
        $restrict = $_GET["restrictions"];
    
        try {
            $query = "INSERT INTO Course 
                    (courseCode, courseName, courseDesc, credits, location, restrictions)
                    VALUES
                    ('$code', '$name', '$desc', '$credit', '$restrict', '$location');";
            
            // connect to db
            //$pdo = new PDO($dsn, $username, $password);

            // query
            $query = "INSERT INTO Course (courseCode, courseName, courseDesc, credits, location, restrictions)
            VALUES (?, ?, ?, ?, ?, ?)";
            
            // create prepared statement
            $statement = $pdo->prepare($query);

            // bind values
            $statement->bindParam(1, $code, PDO::PARAM_STR);
            $statement->bindParam(2, $name, PDO::PARAM_STR);
            $statement->bindParam(3, $desc, PDO::PARAM_STR);
            $statement->bindParam(4, $credit, PDO::PARAM_STR);
            $statement->bindParam(5, $location, PDO::PARAM_STR);
            $statement->bindParam(6, $restriction, PDO::PARAM_STR);
            // $statement->bindParam(6, $prereq1, PDO:PARAM_STR);
            // $statement->bindParam(7, $prereq2, PDO:PARAM_STR);
            // $statement->bindParam(8, $prereq3, PDO:PARAM_STR);
            // $statement->bindParam(9, $prereq4, PDO:PARAM_STR);
            // $statement->bindParam(10, $prereq5, PDO:PARAM_STR);
            // $statement->bindParam(11, $prereq6, PDO:PARAM_STR);
            // $statement->bindParam(12, $prereq7, PDO:PARAM_STR);

            // execute statement
            $statement->execute();

            // check if row was added
            if ($statement->rowCount() > 0) {
                header("Content-Type: text/plain");
                echo "Success";
                http_response_code(200);

            } else {
                header("Content-Type: text/plain");
                echo "Internal Server Error";
                http_response_code(500);
            }

        } catch(Exception $e) {
            echo 'Exception occured: ' . $e->getMessage();
            http_response_code(500);
        } 
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $courses = json_decode(file_get_contents('php://input'), true);

    
    $updatedCount = 0;
    
    try {
        foreach($courses as $data){
            $code = $data["courseCode"];
            $name = $data["courseName"];
            $desc = $data["courseDesc"];
            $credit = $data["credits"];
            $location = $data["location"];
            
            // Assuming courseCode is the primary key or unique identifier
            $courseCode = $data["courseCode"];
            
            // Prepare the SQL statement with placeholders
            $query = "UPDATE Course 
                    SET courseCode = :code, courseName = :name, courseDesc = :desc, credits = :credit, location = :location 
                    WHERE courseCode = :courseCode";

            // connect to db - comment this
            // $pdo = new PDO($dsn, $user, $password);
            
            $statement = $pdo->prepare($query);
        
            // Binding the parameters
            $statement->bindParam(':code', $code);
            $statement->bindParam(':name', $name);
            $statement->bindParam(':desc', $desc);
            $statement->bindParam(':credit', $credit);
            $statement->bindParam(':location', $location);
            $statement->bindParam(':courseCode', $courseCode);

            // execute statement
            $statement->execute();

            if($statement->rowCount() > 0){
                $updatedCount++;
            }
        }
        header("Content-Type: text/plain");
        echo $updatedCount . " courses updated.";
        http_response_code(200);

    } catch(Exception $e) {
        echo 'Exception occured: ' . $e->getMessage();
        http_response_code(500);
    } 

} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
    $body = file_get_contents("php://input");
    if(!empty($body)){
        $data = json_decode($body, true);
        $courseCodes = $data['courseCodes'] ?? [];

        if (empty($courseCodes)) {
            echo "No course codes provided.";
            http_response_code(400);
            exit;
        }

        $courses= join(',', array_fill(0, count($courseCodes), '?'));
        $stmt = $pdo->prepare("DELETE FROM Course WHERE courseCode IN ($courses)");

        $stmt->execute($courseCodes);

        $deletedCount = $stmt->rowCount();
        if ($deletedCount > 0) {
            echo "$deletedCount courses deleted successfully.";
        } else {
            echo "No courses found with the provided course codes.";
        }
        http_response_code(200);
    }
    else {
        $courseCode = $_GET['courseCode'] ?? null;

        $stmt = $pdo->prepare("DELETE FROM Course WHERE courseCode = :courseCode");
        $stmt->bindParam(':courseCode', $courseCode, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Course with courseCode $courseCode deleted successfully.";
        } else {
            echo "No course found with course code $courseCode.";
        }
        http_response_code(200);
    }
}
else {
    http_response_code(405); // Method Not Allowed
}
?>

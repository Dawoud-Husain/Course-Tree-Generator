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
        // read raw input stream of POST request
        $requestBody = file_get_contents("php://input"); 

        // decode json string into PHP datatypes 
        $courseData = json_decode($requestBody); // echo json_encode($data[0]);

        // insert courses into db
        foreach($courseData as $course) {        
            // echo $course->courseCode;
            try {
                $query = "INSERT INTO Course (courseCode, courseName, courseDesc, credits, location, restrictions, prereq1,
                                                prereq2, prereq3, prereq4, prereq5, prereq6, prereq7)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                // create prepared statement
                $statement = $pdo->prepare($query);

                // bind values
                $statement->bindParam(1, $course->courseCode, PDO::PARAM_STR);
                $statement->bindParam(2, $course->courseName, PDO::PARAM_STR);
                $statement->bindParam(3, $course->courseDesc, PDO::PARAM_STR);
                $statement->bindParam(4, $course->credits, PDO::PARAM_STR);
                $statement->bindParam(5, $course->locations, PDO::PARAM_STR);
                $statement->bindParam(6, $course->restrictions, PDO::PARAM_STR);
                $statement->bindParam(7, $course->prereq1, PDO::PARAM_STR);
                $statement->bindParam(8, $course->prereq2, PDO::PARAM_STR);
                $statement->bindParam(9, $course->prereq3, PDO::PARAM_STR);
                $statement->bindParam(10, $course->prereq4, PDO::PARAM_STR);
                $statement->bindParam(11, $course->prereq5, PDO::PARAM_STR);
                $statement->bindParam(12, $course->prereq6, PDO::PARAM_STR);
                $statement->bindParam(13, $course->prereq7, PDO::PARAM_STR);

                // execute statement
                $statement->execute();

                // check if row was added
                if ($statement->rowCount() > 0) {
                    header("Content-Type: text/plain");
                    echo "Success added: " . $course->courseCode;
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
        }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $courses = json_decode(file_get_contents('php://input'), true);

    
    $updatedCount = 0;
    $isUpdated = false;
    
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
                $isUpdated = true;
            }
            if(isset($data["prerequisites"])){
                $deletePrerequisiteQuery = "DELETE FROM Prerequisite WHERE courseCode = :courseCode";
                $deleteStatement = $pdo->prepare($deletePrerequisiteQuery);
                $deleteStatement->bindParam(':courseCode', $code);
                $deleteStatement->execute();

                if ($deleteStatement->rowCount() > 0) {
                    $isUpdated = true;
                }

                $insertPrerequisiteQuery = "INSERT INTO Prerequisite (courseCode, description) VALUES (:courseCode, :description)";
                $insertStatement = $pdo->prepare($insertPrerequisiteQuery);

                foreach ($data["prerequisites"] as $prerequisite) {
                    $insertStatement->bindParam(':courseCode', $code);
                    $insertStatement->bindParam(':description', $prerequisite);
                    $insertStatement->execute();
                    if ($insertStatement->rowCount() > 0) {
                        $isUpdated = true;
                    }
                }
            }
            // If either course details or its prerequisites were updated, increase the counter
            if ($isUpdated) {
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
    $courseCodes = json_decode(file_get_contents('php://input'), true);
    
    if (empty($courseCodes)) {
        echo "No course codes provided.";
        http_response_code(400);
        exit;
    } 

    $courses= join(',', array_fill(0, count($courseCodes), '?'));
    $stmt = $pdo->prepare("DELETE FROM Course WHERE courseCode IN ($courses)");

    $stmt->execute($courseCodes);
    

    $deletedCount = $stmt->rowCount();

    $deleteStatement = $pdo->prepare("DELETE FROM Prerequisite WHERE courseCode IN ($courses)");
    $deleteStatement->execute($courseCodes);
    
    if ($deletedCount > 0) {
        echo "$deletedCount courses deleted successfully.";
    } else {
        echo "No courses found with the provided course code(s).";
    }
    http_response_code(200);
}
else {
    http_response_code(405); // Method Not Allowed
}
?>

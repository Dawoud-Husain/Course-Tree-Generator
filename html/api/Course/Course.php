<?php

require_once "../db.php";
$pdo = getDatabaseConnection();

if ($pdo === null) {
    http_response_code(500);
    echo "Internal Server Error";
    exit;
}

// Check what request is being made or else return error 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestBody = file_get_contents("php://input"); // Read raw input stream of POST request
    $requestBody = json_decode($requestBody); // Decode json string into PHP datatypes 
    // echo json_encode($requestBody); // Encode json string to echo 

    $checkMulti = False;
    $whereStatement = 'WHERE';
    $tableStatement = "";
    $query = "";

    // Check through each to see what query parameters we have and build the query 
    if (isset($requestBody -> preq)) {
        $preq = $requestBody -> preq;
        $tableStatement = $tableStatement . '(SELECT * FROM Prerequisite WHERE description LIKE \'%' . $preq .'%\') as Prerequisite ';
    }

    if (isset($requestBody -> id)) {
        $id = $requestBody -> id;
        $whereStatement = $whereStatement . ' courseCode LIKE \'%' . $id .'%\'';
        $checkMulti = True;
    }

    if (isset($requestBody -> name)) {
        if ($checkMulti == True) $whereStatement = $whereStatement . ' AND';
        $name = $requestBody -> name;
        
        $whereStatement = $whereStatement . ' courseName LIKE \'%' . $name . '%\'';
        $checkMulti = True;
    }

    if (isset($requestBody -> description)) { // description
        if ($checkMulti == True) $whereStatement = $whereStatement . ' AND';
        $description = $requestBody -> description;
        
        $whereStatement = $whereStatement . ' courseDesc LIKE \'%' . $description .'%\'';
        $checkMulti = True; 
    }

    if (isset($requestBody -> credit)) { // credit
        if ($checkMulti == True) $whereStatement = $whereStatement . ' AND';
        $credit = $requestBody -> credit;

        $whereStatement = $whereStatement . ' credits = ' . $credit;
        $checkMulti = True;
    }

    if (isset($requestBody -> location)) { // location
        if ($checkMulti == True) $whereStatement = $whereStatement . ' AND';
        $location = $requestBody -> location;

        $whereStatement = $whereStatement . ' location LIKE \'%' . $location . '%\'';
        $checkMulti = True; 
    }

    if (isset($requestBody -> restriction)) {
        if ($checkMulti == True) $whereStatement = $whereStatement . ' AND';
        $restriction = $requestBody -> restriction;

        $whereStatement = $whereStatement . ' restriction LIKE \'%' . $restriction . '%\'';
        $checkMulti = True;
    }
    
    if (strcmp($tableStatement,"") === 0) {
        $query = "SELECT * FROM Course ";
    } else {
        $query = "SELECT * FROM Course Natural Join ". $tableStatement." ";
    }

    if (strcmp($whereStatement,"WHERE") != 0) {
        $query = $query . $whereStatement;
    }

    try {
        // Execute the query
        header("Content-Type: application/json");
        $statement =  $pdo->query($query);      
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $key => $jsonString) {
            $data = $jsonString;
            $prereqStatement = $pdo->query('SELECT description FROM Prerequisite WHERE courseCode LIKE \'%' .$data['courseCode'].'%\'');
            $prereqResults = $prereqStatement->fetchAll(PDO::FETCH_ASSOC);
            $prereqString = null;
            foreach ($prereqResults as $key2 => $prereqKey) {
                if ($prereqKey['description'] != "") {
                    $prereqString[$key2] = $prereqKey['description'];
                }  
            }
            $data['prerequisites'] = $prereqString;
            $results[$key] = $data;
        }
        
        echo json_encode($results);
        http_response_code(200);
    } catch (PDOException $e) {
        echo $e->getMessage();
        http_response_code(500);
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

<?php 
    require_once "../db.php";

    if($_SERVER['REQUEST_METHOD'] == "POST") {
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
            $pdo = getDatabaseConnection();
            if ($pdo === null) {
                http_response_code(500);
                echo "Internal Server Error";
                exit;
            }

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
    } else {
        http_response_code(405);
    }
?>


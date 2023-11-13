<?php
$host = 'localhost';
$user = 'cis3760';
$password = 'pass1234';
$dsn = "mysql:host=localhost;dbname=courses";

try {
    $pdo = new PDO($dsn, $user, $password); // Attempt to connect to the database
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        $courseCodes = $data['coursesTaken'] ?? [];
        $placeholders = implode(',', array_fill(0, count($courseCodes), '?')); // Create a list of placeholders for prepared statement

        if (!empty($courseCodes)) {
            $query = "SELECT * FROM Prerequisite natural join Course WHERE Description LIKE ?";
            for ($i = 1; $i < count($courseCodes); $i++) {
                $query .= " OR Description LIKE ?";
            }
            $stmt = $pdo->prepare($query);
            // Bind the course codes to the placeholders
            foreach ($courseCodes as $index => $code) {
                // PDOStatement::bindParam expects parameter 1 to be 1-indexed
                $stmt->bindValue($index + 1, "%$code%");
            }

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tree = [];

            foreach($rows as $row) {
                $courseCode = $row['courseCode'];
                $description = $row['description'];

                if (!isset($tree[$courseCode])) $tree[$courseCode] = [];
                array_push($tree[$courseCode], $description);
            }

            $possibleCourses = [];

            foreach($tree as $course => $prerequisites){
                $isMatch = TRUE;
                foreach ($prerequisites as $prerequisite){
                    $prerequisite = preg_replace('/\s+/', ' ', trim($prerequisite));

                    if (preg_match('/(\d+) of/', $prerequisite, $matches)) {
                        // get the "n" from n of
                        $numberRequired = $matches[1];
                        // echo json_encode($matches);
                        $count = 0;
                        // get the prerequisites and put into an array
                        $options = explode(',', substr($prerequisite, strlen($matches[0])));
                        $options = array_map('trim', $options); // Trim each option
                        $intersect = array_intersect($options, $courseCodes);
                        if(count($intersect) < $numberRequired){
                            $isMatch = FALSE;
                            break;
                        }
                    } else {
                        //if a single course then check if it is in course codes
                        if(!in_array($prerequisite,$courseCodes)){
                            $isMatch = FALSE;
                            break;
                        }
                    }
                }
                if($isMatch){
                    array_push($possibleCourses,$course);
                }
                $isMatch = TRUE;
            }

            $courses= join(',', array_fill(0, count($possibleCourses), '?'));
            $stmt = $pdo->prepare("SELECT * FROM Course WHERE courseCode IN ($courses)");
            $stmt->execute($possibleCourses);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //maybe call to get the rest of the information?
            echo json_encode($rows);

        } else {
        
            $query = "SELECT * from Course left join Prerequisite on Course.courseCode = Prerequisite.courseCode WHERE Prerequisite.description = '';";
            $stmt = $pdo->prepare($query);

            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // echo $query;
            echo json_encode($rows);
            http_response_code(200);
        }


    }   
} catch (PDOException $e) {
    echo $e->getMessage();
    http_response_code(500);
}
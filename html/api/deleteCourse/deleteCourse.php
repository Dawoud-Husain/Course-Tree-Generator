<?php
$host = 'localhost';
$user = 'cis3760';
$password = 'pass1234';
$dsn = "mysql:host=localhost;dbname=courses";
try {
    $pdo = new PDO($dsn, $user,$password);
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE'){
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
    else{
        http_response_code(405);
    }
} catch (PDOException $e) {
	echo $e->getMessage();
    http_response_code(500);
}
?>
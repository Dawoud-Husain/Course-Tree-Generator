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
} else {
    http_response_code(405); // Method Not Allowed
}
?>

<?php
function getDatabaseConnection($isProdEnv) {
    $host = 'localhost';
    $user = $isProdEnv ? 'cis3760' : 'root';
    $password = $isProdEnv ? 'pass1234' : '';
    $dsn = "mysql:host=localhost;dbname=courses";
    
    try {
        $pdo = new PDO($dsn, $user, $password);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Database connection error: " . $e->getMessage());
        echo $e->getMessage();
        return null;
    }
}
?>
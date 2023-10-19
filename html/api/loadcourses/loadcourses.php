<?php
$host = 'localhost';
$user = 'cis3760';
$password = 'pass1234';
$dsn = "mysql:host=localhost;";
try {
	$pdo = new PDO($dsn, $user,$password);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS courses");
    $pdo->exec("USE courses");
    $pdo->exec("DROP TABLE IF EXISTS Prerequisite;");
    $pdo->exec("DROP TABLE IF EXISTS Course;");
    $pdo->exec("CREATE TABLE IF NOT EXISTS Course (
        courseCode VARCHAR(20),
        courseName TEXT,
        courseDesc TEXT,
        credits DOUBLE,
        location TEXT,
        restrictions TEXT,
        prereq1 TEXT,
        prereq2 TEXT,
        prereq3 TEXT,
        prereq4 TEXT,
        prereq5 TEXT,
        prereq6 TEXT,
        prereq7 TEXT,
        PRIMARY KEY (courseCode)
        );");
    $pdo->exec("LOAD DATA INFILE '/var/www/html/api/loadcourses/courses.csv'
    INTO TABLE Course
    FIELDS TERMINATED BY ',' 
    ENCLOSED BY '\"'
    LINES TERMINATED BY '\n'
    (@coursecode, @coursename, @coursedesc, @credits, @location, @restrictions, @prereq1, @prereq2, @prereq3, @prereq4, @prereq5, @prereq6, @prereq7)
    SET
    coursecode = NULLIF(@coursecode, ''),
    coursename = NULLIF(@coursename, ''),
    coursedesc = NULLIF(@coursedesc, ''),
    credits = NULLIF(@credits, ''),
    location = NULLIF(@location, ''),
    restrictions = NULLIF(@restrictions, ''),
    prereq1 = NULLIF(@prereq1, ''),
    prereq2 = NULLIF(@prereq2, ''),
    prereq3 = NULLIF(@prereq3, ''),
    prereq4 = NULLIF(@prereq4, ''),
    prereq5 = NULLIF(@prereq5, ''),
    prereq6 = NULLIF(@prereq6, ''),
    prereq7 = NULLIF(@prereq7, '');");
    $pdo->exec("CREATE TABLE IF NOT EXISTS Prerequisite (
        courseCode VARCHAR(20),
        description TEXT,
        FOREIGN KEY (courseCode) REFERENCES Course(courseCode)
        ON DELETE CASCADE
    );");
    $stmt = $pdo->query("SELECT * FROM Course");
    $result = $stmt->fetchAll(PDO::FETCH_NUM);
    foreach($result as $row) {
        for ($i = 6; $i < 13; $i ++) {
            if($row[$i] != NULL && $row[$i] != "\r") {
                $prereqadd = $pdo->prepare("INSERT INTO Prerequisite (courseCode, description) VALUES (:courseCode, :descrip);");
                $prereqadd->bindParam(':courseCode', $row[0], PDO::PARAM_STR);
                $prereqadd->bindParam(':descrip', $row[$i], PDO::PARAM_STR);
                $prereqadd->execute();
            } 
        }
    }
    $pdo->exec("ALTER TABLE Course
    DROP COLUMN prereq1,
    DROP COLUMN prereq2,
    DROP COLUMN prereq3,
    DROP COLUMN prereq4,
    DROP COLUMN prereq5,
    DROP COLUMN prereq6,
    DROP COLUMN prereq7
     ;");
header("Location: https://cis3760f23-04.socs.uoguelph.ca/ApiExamples");
} catch (PDOException $e) {
	echo $e->getMessage();
}
?>
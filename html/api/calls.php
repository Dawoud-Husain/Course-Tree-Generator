
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // $queryParams = "";
        if (isset($_GET['courseCodes'])) {
            $queryParams = $_GET['courseCodes'];
            $url = 'https://cis3760f23-14.socs.uoguelph.ca/api/get_more_prereqs?courseCodes='.$queryParams;
            $options = array(
              'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
              ),
            );
            $context  = stream_context_create($options);
            try {
                $result = file_get_contents($url, false, $context);
                echo $result;
            } catch (Exception $e) {
                echo "Exception: " . $e->getMessage();
            }
        } else {
            $url = "https://cis3760f23-14.socs.uoguelph.ca/api/get_courses";
            $options = array(
              'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
              ),
            );
            $context  = stream_context_create($options);
            try {
                $result = file_get_contents($url, false, $context);
                // echo $result;
                $obj = json_decode($result,true);
                // // Print out all the course names
                    $filteredCourses = array_filter($obj['data'], 
                    function ($course) {     return $course['prerequisites'] === null; });
                    $obj['data'] = $filteredCourses;
                    $obj['data'] = array_values($obj['data']);
                    echo json_encode($obj);
                
            } catch (Exception $e) {
                echo "Exception: " . $e->getMessage();
            }
        }
    }
?>



<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // $queryParams = "";
        if (isset($_GET['courseCode'])) {
            $queryParams = $_GET['courseCode'];
            $url = 'https://cis3760f23-14.socs.uoguelph.ca/api/get_course?courseCode='.$queryParams;
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
        } 
    }
?>


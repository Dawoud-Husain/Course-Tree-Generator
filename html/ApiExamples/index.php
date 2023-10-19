<html>
    <head>
        <title>Web Api Examples</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    </head>
    <body>
    <a class="link" href="https://cis3760f23-04.socs.uoguelph.ca/"><h1 class = "groupNum">104</h1></a>
    <div class="homepageBody">
        <p class="homepageBodyTitle">Web Api</p>
        <p class="homepageBodyText">
            This page will provide you with all the information you need to use our web api, along with some examples!
        </p>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">Load Courses from CSV</p>
                <div class = "downloadButton">
                    <form action="https://cis3760f23-04.socs.uoguelph.ca/api/loadcourses/loadcourses.php" method="POST">
                        <input type="submit" name='load' value="LOAD" class="dlButton">
                    </form>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">GET Example</p>
                <div class = "downloadButton">
                    <form action="" method="get">
                        <input type="submit" name='getCourse' value="GET" class="dlButton">
                        <input type="text" id="inputGET" name="getparam">
                    </form>
                    <?php
                    if (isset($_GET['getCourse'])) {
                        //code to send get request

                        //echo returned values out
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">PUT Example</p>
                <div class = "downloadButton">
                    <form action="" method="put">
                        <input type="submit" name='putCourse' value="PUT" class="dlButton">
                        <input type="text" id="inputPUT" name="putparam">
                    </form>
                    <?php
                    if (isset($_PUT['putCourse'])) {
                        //code to send put request

                        //echo a status message for success or failure
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">POST Example</p>
                <div class = "downloadButton">
                    <form action="https://cis3760f23-04.socs.uoguelph.ca/api/loadcourses/loadcourses.php" method="post">
                        <input type="submit" name='postCourse' value="POST" class="dlButton">
                        <input type="text" id="inputPOST" name ="postparam">
                    </form>
                    <?php
                    if (isset($_POST["postCourse"])) {
                        //code to send post request to api

                        //echo a status message for success or failure
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="VBAdownload">
            <div class="text_button">
                <p class="VBAdownload_text">DELETE Example</p>
                <div class = "downloadButton">
                    <form action="" method="delete">
                        <input type="submit" name='deleteCourse' value="DELETE" class="dlButton">
                        <input type="text" id="inputDELETE" name="deleteparam">
                    </form>
                    <?php
                    if (isset($_DELETE['deleteCourse'])) {
                        // code to send delete request to api

                        //echo a status message for success or failure
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
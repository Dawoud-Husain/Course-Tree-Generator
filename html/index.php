<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Group_104</title>
        <link rel="stylesheet" href="style.css">
        <!-- <link rel="stylesheet" type="text/css" href="styles2.css"> -->
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg ms-auto" style="background-color: #1D75DE;">
            <div class="container-fluid"  style="background-color: #1D75DE;">
                <a class="navbar-brand">104</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                    <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#setup">Setup</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#using">Using the Software</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#aboutTeam">Team</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="https://cis3760f23-04.socs.uoguelph.ca/ApiDoc/">Api Documentation</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="https://cis3760f23-04.socs.uoguelph.ca/ApiFrontend/">Api Frontend</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>

        <section class="homepageBody">
            <p class="homepageBodyTitle">F_23_CIS3760: Group_104</p>
            <p class="homepageBodyText">
                Welcome to Group 104's PHP-powered homepage, where innovation and collaboration thrive 🚀.
                Hasen was here
            </p>
            <div class="VBAdownload">
                <div class="text_button">
                    <p class="VBAdownload_text">Introducing VBA Induced Student Course Management Tool</p>
                    <div class = "downloadButton">
                        <form action="download.php" method="post">
                            <input type="submit" name='download' value="Download Excel" class="dlButton">
                        </form>
                        <a href="https://cis3760f23-04.socs.uoguelph.ca/ApiExamples/">
                            <button class = "dlButton">Web Api</button>
                        </a>
                    </div>
                </div>
                <img class="macbook" src="macbook.png" alt="macbook.png">
            </div>
        </section>
       

        <section class="feature1" id="features">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1> Free To Use </h1>
                    <h6 class = "featuredescriptionText">   COURSE MANAGER ® remains a free product for educational staff and students to use  </h6>
                </div>
                <img class="feature-image" src="../components/media/free.png"> 
            </div>
            
        </section>


        <section class="feature1" style="background-color: #175EB2">
            <div class="feature1-body">
                <div class="feature1-desc">
                    <h1>No External Software Needed </h1>
                    <h6 class = "featuredescriptionText">    Our application runs all within Microsoft Excel, no need to install any third party applications  </h6>
                </div>
                <img class="feature-image" src="../components/media/Microsoft_Office_13-16_Logo.png"> 
            </div>
        </section>

        <section class="feature1" style="background-color: #14529B">
            <div class="feature1-body">
                <div class="feature1-desc" style="margin-bottom: 150px;">
                    <h1> Minimalistic Design </h1>
                    <h6 class = "featuredescriptionText">  No hassle in navigating through endless menus to find the correct options needed. Simply press a button to enter your courses, and then another to find the ones you can take  </h6>
                </div>
                <img class="feature-image" src="../components/media/minimalistic.png">
            </div>
        </section>

        <section class="feature1">
            <div class="feature1-body">
                <div class="feature1-desc" style="margin-bottom: 150px;">
                    <h1> Robust End Product </h1>
                    <h6 class = "featuredescriptionText">  Our developers have extensively tested this product from preventing the software from crashing to make the user experience better  </h6>
                </div>
                <img class="feature-image" src="../components/media/robust.png">
            </div>
        </section>


        <section class="feature1" style="background-color: #175EB2">
            <div class="feature1-body">
                <div class="feature1-desc" style="margin-bottom: 150px;">
                    <h1> Secure </h1>
                    <h6 class = "featuredescriptionText"> COURSE MANAGER ® Only runs and stores data locally within the users device. Not communicating over any networks ensures that private user information cannot be stolen   </h6>
                </div>
                <img class="feature-image" src="../components/media/secure.png">
            </div>
        </section>


        <section class="feature1" style="background-color: #14529B">
            <div class="feature1-body">
                <div class="feature1-desc" style="margin-bottom: 150px;">
                    <h1> Offline Functionally  </h1>
                    <h6 class = "featuredescriptionText">  Storing all data and handling all process within the user device also means that no internet connection is required to run the program  </h6>
                </div>
                <img class="feature-image" src="../components/media/offline.png" width="200px" height="500px">
            </div>
        </section>


        <section class="feature1" id="lastFeature">
            <div class="lastFeatureDiv">
                <div class="feature1-body">
                    <div class="feature1-desc" style="margin-bottom: 150px;">
                        <h1> Open Source </h1>
                        <h6 class = "featuredescriptionText">   Users not happy with a certain aspect of the software or would like to add additional functionality can directly edit the program to make it meet their needs </h6>
                    </div>
                    <img class="feature-image" src="../components/media/open-source.png">
                    
                </div>
                
                <h1>Getting Started</h1>
                <!-- <button type="button" class="btn btn-dark btn-lg"><a href="https://cis3760f23-04.socs.uoguelph.ca/setup/">GET STARTED</a></button> -->
            </div>
        </section>

        <section class="getStarted" id="setup">
            <div class="step1-container">
                <div class="step1">
                    <h1>Step 1: Download The Software</h1>
                    <img class="stepsImage" src="../components/media/download.gif">
                </div>
            </div>

            <div class="step1-container" style="padding: 25px;">
                <div class="step1">
                    <h1>Step 2: Enable Permissions</h1>
                    <img  class = "stepsImage"  src="../components/media/enable-permissions.gif">
                </div>
            </div>

            <div class="step1-container">
                <div class="step1">
                    <h1> Step 3: Open the excel workbook</h1>
                    <img class="stepsImage" src="../components/media/open.gif">
                </div>
            </div>
        </section>

        <section class="using">
            <h1> Using The Software </h1>
            <div class="using-container">
                <div class="using-steps">
                    <h1>Step 1: Enter Your Courses</h1>
                    <img  class = "stepsImage" src="../components/media/add_course.gif">
                </div>

                <div class="using-steps">
                    <h1>Step 2: Generate & View The eligible courses</h1>
                    <img  class = "stepsImage"  src="../components/media/load_courses.gif">
                </div>

                <div class="using-steps">
                    <h1>Step 3: Delete Unwanted Courses</h1>
                    <img  class = "stepsImage"  src="../components/media/delete_courses.gif">
                </div>
            </div>
        </section>

        <section class="contributors">
            <h1>Our Team</h1>
            <div class="contributor-content">
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/hasen/">
                        <div class="team-member">
                            <img src="hasen/hasen.jpg" alt="Picture of Hasen Romani" height="100px" width="100px">
                            <h2>Hasen Romani</h2>
                        </div>
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/dawoud/">
                        <div class="team-member">
                            <img src="dawoud/dawoud-logo.png" alt="Picture of Dawoud Husain" height="100px" width="100px">
                            <h2>Dawoud Husain</h2>
                        </div>
                    </a>
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/karanvir/">
                        <div class="team-member">
                            <img src="karanvir/karanvir.jpeg" alt="Picture of Karanvir Basson " height="100px" width="100px">
                            <h2>Karanvir Basson</h2>
                        </div>
                    </a>
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/john/">
                        <div class="team-member">
                            <img src="john/john.jpg" alt="Picture of John Constantinides " height="100px" width="100px">
                            <h2>John Constantinides</h2>
                        </div>
                    </a>
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/riley/">
                        <div class="team-member">
                            <img src="riley/riley1.png" alt="Picture of Riley Deconkey" height="100px" width="100px">
                            <h2>Riley Deconkey</h2>
                        </div>
                    </a>
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/thomas/">
                        <div class="team-member">
                            <img src="thomas/thomas.jpg" alt="Picture of Thomas Phan" height="100px" width="100px">
                            <h2>Thomas Phan</h2>
                        </div>
                    </a>
                    <a href="https://cis3760f23-04.socs.uoguelph.ca/eason/">
                        <div class="team-member">
                            <img src="eason/person1.jpeg" alt="Picture of Eason Liang" height="100px" width="100px">
                            <h2>Eason Liang</h2>
                        </div>
                    </a>
            </div>
        </section>  

        <section class="footer">
            <a href="https://cis3760f23-04.socs.uoguelph.ca/terms/">Terms Of Services</a>
        </section>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>

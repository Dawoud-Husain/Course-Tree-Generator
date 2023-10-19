<html>
    <head>
        <title>Group_104</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" type="text/css" href="styles2.css">
        <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    </head>
    <body>
        <div class="header">
            <div class="navbar">
                <ul>
                    <p class="groupNum">104</p>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#setup">Setup</a></li>
                    <li><a href="#using">Using the Software</a></li>
                    <li><a href="#AboutTheTeam">Team</a></li>
                </ul>
            </div> 
        </div>
        <div class="homepageBody">
            <p class="homepageBodyTitle">F_23_CIS3760: Group_104</p>
            <p class="homepageBodyText">
                Welcome to Group 104's PHP-powered homepage, where innovation and collaboration thrive 🚀.
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
        </div>
       
        <div class="feature" style= "background-color: #1D75DE;display:flex; flex-direction: column;">
            <h1 class = "featureh1Text" id="features"> Free To Use </h1>
            <div style="display: flex;">
                <h6 class = "featuredescriptionText">   COURSE MANAGER ® remains a free product for educational staff and students to use  </h6>
                <img class="feature-image" src="../components/media/free.png"> 
            </div>
         
        </div>
       

        <div  style= "background-color: #14529b; display:flex; flex-direction: column;">
            <h1 class = "featureh1Text">  No External Software Needed</h1>
            <div class="feature" style="display:flex;">
                <h6 class = "featuredescriptionText">   Our application runs all within Microsoft Excel, no need to install any third party applications</h6>
                <img class="feature-image" src="../components/media/Microsoft_Office_13-16_Logo.png"> 
                </div>
            </div>  
        </div>

        <div  style= "background-color: #1D75DE;  display:flex; flex-direction: column;">
            <h1 class = "featureh1Text">Minimalistic Design </h1>
            <div class="feature" style="display:flex;">
                <h6 class = "featuredescriptionText">  No hassle in navigating through endless menus to find the correct options needed. Simply press a button to enter your courses, and then another to find the ones you can take.   </h6>
                <img class="feature-image" src="../components/media/minimalistic.png">
            </div>
        </div>

        <div  style= "background-color: #14529b;  display:flex; flex-direction: column;">
            <h1 class = "featureh1Text">Robust End Product </h1>
            <div class="feature" style="display:flex;">
                <h6 class = "featuredescriptionText">     Our developers have extensively tested this product from preventing the software from crashing to make the user experience better
                </h6>
                <img class="feature-image" src="../components/media/robust.png">
            </div>
        </div>

        <div  style= "background-color: #1D75DE; display:flex; flex-direction: column; ">        
            <h1 class = "featureh1Text">Secure</h1>
            <div class="feature" style="display:flex;">              
                <h6 class = "featuredescriptionText">  COURSE MANAGER ® Only runs and stores data locally within the users device. Not communicating over any networks ensures that private user information cannot be stolen.   </h6>
                <img class="feature-image" src="../components/media/secure.png">
            </div>
        </div>

        <div  style= "background-color: #14529b; display:flex; flex-direction: column;">
            <h1 class = "featureh1Text">Offline Functionally </h1>
            <div class="feature" style="display:flex;">
                <h6 class = "featuredescriptionText">  Storing all data and handling all process within the user device also means that no internet connection is required to run the program 
                </h6>
                <img class="feature-image" src="../components/media/offline.png">
            </div>
        </div>

        <div style= "background-color: #1D75DE; display:flex; flex-direction: column;">
            <h1 class = "featureh1Text">Open Source </h1>
            <div class="feature" style=" display:flex;" >
                <h6 class = "featuredescriptionText">     Users not happy with a certain aspect of the software or would like to add additional functionality can directly edit the program to make it meet their needs  </h6>
                <img class="feature-image" src="../components/media/open-source.png">
            </div>
        </div>

        <div  style= "background-color: #14529b; height: 100%;">
            <div class="steps" style="padding: 50px;" id="setup">
                <h1 style=""> First Time Setup </h1>
                <p class = "stepsText" style="color: white;">
                    <img  class = "stepsImage" src="../components/media/download.gif">
                    Step 1: Download The Software
                </p>
                <p class = "stepsText" style="color: white;">
                    <img  class = "stepsImage"  src="../components/media/enable-permissions.gif">
                    Step 2: Enable Permissions
                </p>
                <p class = "stepsText" style="color: white;">
                    <img  class = "stepsImage"  src="../components/media/open.gif">
                    Step 3: Open the excel workbook
                </p>
            </div>
        </div>

        <div  style= "background-color: #1D75DE;">
            <div class="steps" id="using">
                <h1> Using The Software </h1>
                <p class = "stepsText" style="color: white;">
                    <img  class = "stepsImage" src="../components/media/add_course.gif">
                    Step 1: Enter Your Courses
                </p>
                <p class = "stepsText" style="color: white;">
                    <img  class = "stepsImage"  src="../components/media/load_courses.gif">
                    Step 2: Generate & View The eligible courses
                </p>
            </div>
        
            <div class="steps">
                <h1> Deleting Courses </h1>
                <p class = "stepsText" style="color: white;">
                    <img  class = "stepsImage" src="../components/media/delete_courses.gif">
                    Step 1: Delete Unwanted Courses
                </p>
            </div>
        </div>


        <div class = "tos">
            <h1>Terms Of Services</h1>
            <p> COURSE MANAGER ® Is not an official affiliate with any educational institution, as a consequence, this tool shall not be used as an finalized reference in determining which courses a student can take. </p>
            <p> COURSE MANAGER ® Is not liable for any loss of data, damage to property, or any other negative outcomes, use at your own risk. </p>
            <p> COURSE MANAGER ® Remains as a free software for educational purposes, however any third party vendors attempting to distribute this software for profit will not face legal consequences due to the COURSE MANAGER ® legal team being non-existent. 
            </p>
            <p> COURSE MANAGER ®  Is verified to only work on Microsoft Windows 10 and 11. All end users are also expected to have Office 365 installed with a valid license. </p>
            <p> COURSE MANAGER ®  Does not guarantee that the software remains functional on MacOs or any Linux based operating systems, users are advised to refrain from running the program on such operating systems. 
            </p>
        </div>

        <div id = "AboutTheTeam" class = "AboutUs">
            <h1 class = "aboutUsText">Contributors: </h1>
            <div class="center-content">
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
        </div>
    </body>
</html>

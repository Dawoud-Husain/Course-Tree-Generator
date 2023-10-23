<!DOCTYPE html>
<html>
  <head>
    <title>Course API Documentation</title>
    
    <style>
      body {
        font-family: Arial, sans-serif;
        max-width: 800px; 
        margin: 0 auto;
      }
      
      h1 {
        text-align: center;
        background: #333;
        color: white;
        padding: 20px;
        margin-bottom: 30px;
      }
      
      h2, h3 {
        background: #ccc;
        padding: 10px;
        margin: 30px 0 10px; 
      }
      
      p {
        line-height: 1.5;
        margin-bottom: 20px;
      }
      
      code {
        background: #f4f4f4;
        padding: 5px 10px;
        border-radius: 5px;
      }
    </style>
  </head>

  <body>
    
    <h1>Course API</h1>

    <h3>Query Parameters</h3>
      
      <p>
        - "name" - Filter by course name<br>
        - "id" - Filter by course ID<br> 
        - "description" - Filter by course description<br>
        - "credit" - Filter by number of credits<br>
        - "location" - Filter by course location<br>
        - "restriction" - Filter by course restrictions<br>
        - "preq" - Join prerequisite table and filter by prerequisite description
    </p>

    <h3>Error Codes</h3>
      
      <p>
    - 400 Bad Request<br>
      - 404 Not Found<br>
      - 405 Method Not Allowed<br>
      - 500 Internal Server Error</p>   

    <h2>Endpoints</h2>
    
    <h3>GET (Retreive Courses)</h3>

    <p><code>GET https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?id={courseCode}</code></p>

    
    <h4>Example Request - Get All Courses</h4>

    <p><code>GET https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php</code></p>
    
    <h4>Response</h4>

    <p>(Returns all courses in the database)</p>
    <hr>
      <h4>Example Request -  Get Single Course</h4>
        
      <code>GET https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?preq=CIS*1300</code>
        
      <h4>Example Response</h4>

      <code>[
      {
      "courseCode": "CIS2170",
      "courseName": "User Interface Design"
      },
      {   
      "courseCode": "CIS2250",
      "courseName": "Software Design II"
      }
      ]</code>
      
      
      <h3>POST (Create Course) </h3>
        
      <p><code>POST https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?courseCode={courseCode}&courseName={courseName}&courseDesc={courseDesc}&credits={credits}&location={location}&restrictions={restrictions}</code></p>
      
      <h4>Example Request</h4>
      
      <code>POST https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?courseCode=CIS*3760&courseName=Web APIs&courseDesc=Building web APIs&credits=0.5&location=CKNC%20533&restrictions=None</code>
      
      <h4>Example Response</h4>
      
      <p>200 OK</p>
      
      <h3>PUT (Update Course)</h3>
      
      <p><code>PUT https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?id={courseCode}&courseName={courseName}&courseDesc={courseDesc}&credits={credits}&location={location}&restrictions={restrictions}</code></p>  
      
      <h4>Example Request</h4>
      
      <code>PUT https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?courseCode=CIS*3760&courseName=Web APIs&courseDesc=Building web APIs&credits=0.5&location=CKNC%20533&restrictions=None</code>
      
      <h4>Example Response</h4>
      
      <p>200 OK</p>
      
      <h3>DELETE (Delete Course)</h3>
        
      <p><code>DELETE https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?id={courseCode}</code></p>
      
      <h4>Example Request</h4>

      <code>DELETE https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?id=CIS*2500</code>
      
      <h4>Example Response</h4>
      
      <p>200 OK</p>

  </body>
</html>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>API Documentation</title>

    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
      /* Global styles */
      body {
        font-family: Arial, sans-serif;
        margin: 10;
        padding: 0;
      }

      header {
        background-color: #333;
        color: #fff;
        padding: 20px;
      }

      h1 {
        font-size: 30px;
        margin-bottom: 20px;
      }

      main {
        padding: 20px;
      }

      section {
        margin-bottom: 30px;
      }

      h2 {
        font-size: 25px;
        margin: 0 0 15px 0;
      }

      p {
        margin: 0 0 10px 0;
      }

      /* API documentation specific styles */
      code,
      pre {
        font-family: Consolas, monospace;
      }

      pre {
        background-color: #f5f5f5;
        padding: 10px;
        overflow-x: auto;
      }

      .endpoint {
        margin-bottom: 15px;
        padding: 10px;
        background-color: #f5f5f5;
        border-radius: 5px;
      }

      .endpoint h3 {
        font-size: 18px;
        margin: 0 0 10px 0;
      }

      .endpoint p {
        margin: 0;
      }

      .endpoint.collapsible {
        cursor: pointer;
      }

      .endpoint.collapsed .content {
        display: none;
      }

      .endpoint.collapsible::after {
        content: "▼";
        margin-left: 5px;
      }

      .endpoint.collapsed::after {
        content: "►";
      }

      /* Table of Contents */
      ul {
        list-style-type: none;
        padding-left: 10px;
      }

      ul li {
        margin-bottom: 10px;
      }

      ul li a {
        color: #333;
        text-decoration: none;
      }

      ul li a:hover {
        text-decoration: underline;
      }

      /* Appendix */
      .appendix {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ccc;
      }

      .appendix h3 {
        margin-bottom: 10px;
      }

      .appendix table {
        border-collapse: collapse;
        width: 100%;
      }

      .appendix th {
        background-color: #f5f5f5;
        padding: 8px;
        text-align: left;
        font-weight: normal;
        border: 1px solid #ccc;
      }

      .appendix td {
        padding: 8px;
        border: 1px solid #ccc;
      }
    </style>
  </head>

  <body>
    <header>
      <h1>API Documentation</h1>
    </header>
    <main>
      <section>
        <h1>Table of Contents</h1>
        <hr />
        <br />

        <p>This documentation covers the following subject areas:</p>
        <ul>
          <li><a href="#overview">Overview</a></li>
          <li><a href="#crud">CRUD Operations</a></li>
          <li><a href="#extended_operations">Additional Functions</a></li>
          <li><a href="#appendix">Appendix</a></li>
        </ul>
      </section>

      <section id="overview">
        <h1>Overview</h1>
        <hr />
        <br />

        <h2>Purpose</h2>

        <p>
          The Course CRUD API provides a programmatic interface for applications
          to interact with course data stored in a MySQL database. It allows
          clients to perform the basic Create, Read, Update, and Delete (CRUD)
          operations on course records.
        </p>

        <br />

        <p>Some example uses of the API include:</p>

        <ul>
          <li>
            A course registration system using the API to display available
            courses, add new courses, and update existing course details.
          </li>
          <li>
            A course catalog application querying the API to display searchable
            lists of courses grouped by subject area, prerequisites, credit
            value, etc.
          </li>
          <li>
            An administrative dashboard accessing the API to manage course
            offerings, modify schedules, and archive past courses.
          </li>
        </ul>
        <br />
        <p>
          By providing a RESTful API, these kinds of systems can integrate with
          the backend course data in a standardized and scalable way.
        </p>
        <br />
        <h3>Authentication</h3>

        <p>
          The API does not require any authentication or authorization, all
          endpoints are publicly accessible.
        </p>
        <br />

        <h2>Endpoints</h2>

        <p>The API has the following endpoints:</p>
        <ul>
          <li>
            <code>GET</code> - Retrieves courses based on query parameters
          </li>
          <li><code>POST</code> - Creates a new course</li>
          <li><code>PUT</code> - Updates an existing course</li>
          <li><code>DELETE</code> - Deletes one or more courses</li>
        </ul>

        <h3>Data Model</h3>

        <p>
          The core entities supported by the API are <b>Courses</b> and their
          related <b>Prerequisites</b>.
        </p>
        <br />
        <p>A <b>Course</b> has the following attributes:</p>

        <ul>
          <li>
            <code>courseCode</code> (string): Unique identifier like "CIS*2170"
          </li>
          <li>
            <code>courseName</code> (string): Display name like "User Interface
            Design"
          </li>
          <li>
            <code>courseDesc</code> (string): Description like " This course is
            a practical introduction ..."
          </li>
          <li><code>credits</code> (float): Credit value like 0.75</li>
          <li><code>location</code> (string): Campus like "Guelph"</li>
          <li>
            <code>restrictions</code> (string): Any enrollment restrictions like
            "null"
          </li>
        </ul>
        <br />
        <p>
          Optional <b>Prerequisite</b> courses for a course can also be queried.
          A <b>Prerequisite</b> has:
        </p>

        <ul>
          <li><code>id</code> (int): ID</li>
          <li>
            <code>description</code> (string): Course code like "CIS*1300"
          </li>
        </ul>

        <br />

        <p>
          Additional details on the database schema can be found in the
          Appendix.
        </p>
      </section>

      <section id="crud">
        <h1>CRUD Operations</h1>
        <hr />
        <br />
        <br />
        <h2>Get (Retrieve Courses)</h2>

        <p>
          The <code>GET /courses</code> endpoint retrieves courses from the
          database. It supports filtering courses through query parameters.
        </p>

        <br />
        <p>
          Custom queries can filter on any attribute like <code>name</code>,
          <code>code</code>, <code>credits</code> range, multiple
          <code>prerequisites</code>, etc. Wildcards like
          <code>name=Pro%</code> are also supported.
        </p>
        <br />

        <p><b>Query Parameters:</b></p>
        <ul>
          <li><code>name</code> - Filters courses by name</li>
          <li><code>credits</code> - Filters courses by number of credits</li>
          <li><code>id</code> - Filters courses by course code</li>
          <li><code>description</code> - Filters courses by description</li>
          <li><code>location</code> - Filters courses by location offered</li>
          <li>
            <code>preq</code> - Joins with Prerequisite table to filter courses
            by prerequisite description
          </li>
          <li><code>restriction</code> - Filters courses by restrictions</li>
        </ul>

        <br />

        <p><b>Status Codes:</b></p>

        <ul>
          <li><code>200 OK</code> - Request succeeded</li>
          <li><code>400 Bad Request</code> - Invalid query parameters</li>
          <li><code>500 Internal Server Error</code> - Database error</li>
        </ul>

        <br />

        <p><b>Examples:</b></p>

        <div class="endpoint collapsible">
          <p>Get All Courses</p>
          <br />

          <div class="content">
            <code>
              GET https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            </code>
            <br />
            <hr />
            <br />
            <br />
            <p>The response is a JSON array of course objects.</p>
            <pre><code>[
  {"courseCode":"ACCT*1240",
    "courseName":"Applied  Financial  Accounting",
    "courseDesc":"  This  course  requires  students  to  apply  the  fundamental  principles  emanating  from  accounting's  conceptual  framework  and  undertake  the  practice  of  financial  accounting.  Students  will  become  adept  at  performing  the  functions  related  to  each  step  in  the  accounting  cycle|  up  to  and  including  the  preparation  of  the  financial  statements  and  client  reports.  Students  will  also  develop  the  skills  necessary  for  assessing  an  organization's  system  of  internal  controls  and  financial  conditions.",
    "credits":0.5,
    "location":"Guelph",
    "restrictions":"  ACCT*2240.  This  is  a  Priority  Access  Course.  Enrolment  may  be  restricted  to  particular  programs  or  specializations.  See  department  for  more  information."
  }
    ...
]
</code></pre>
          </div>
        </div>

        <div class="endpoint collapsible">
          <p>Get A Single Course</p>
          <br />

          <div class="content">
            <code>
              GET
              https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?id=CIS*1300
            </code>
            <br />
            <br />
            <hr />
            <br />
            <br />

            <p>The response is a single course object.</p>
            <pre><code>[
  {
    "courseCode": "CIS*1300",
    "courseName": "Programming",
    "courseDesc": "  This  course  examines  the  applied  and  conceptual  aspects  of  programming.  Topics  may  include  data  and  control  structures|  program  design|  problem  solving  and  algorithm  design|  operating  systems  concepts|  and  fundamental  programming  skills.  This  course  is  intended  for  students  who  plan  to  take  later  CIS  courses.  If  your  degree  does  not  require  further  CIS  courses  consider  CIS*1500  Introduction  to  Programming.",
    "credits": 0.5,
    "location": "Guelph",
    "restrictions": "  CIS*1500.  This  is  a  Priority  Access  Course.  Enrolment  may  be  restricted  to  particular  programs  or  specializations.  See  department  for  more  information."
  }
]

</code></pre>
          </div>
        </div>

        <div class="endpoint collapsible">
          <p>Get Multiple Courses</p>
          <br />

          <div class="content">
            <code
              >GET
              https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?name=Intro&id=CIS*%&credits=0.5</code
            >
            <br />
            <br />
            <p>(Gets all intro programming courses with 0.5 credits)</p>
            <br />

            <br />
            <hr />

            <p>The response is a JSON array of course objects.</p>

            <pre><code>[
  {
    "courseCode": "CIS*1200",
    "courseName": "Introduction  to  Computing",
    "courseDesc": "  This  course  covers  an  introduction  to  computer  hardware  and  software|  data  organization|  problem-solving  and  programming.  The  course  includes  exposure  to  application  packages  for  personal  and  business  use  and  is  intended  forstudents  who  wish  a  balance  between  programming  and  the  use  of  software  packages.",
    "credits": 0.5,
    "location": "Guelph",
    "restrictions": "  CIS*1000.  Not  available  to  students  registered  in  a  BCOMP  degree  or  a  CIS  minor."
  },
  {
    "courseCode": "CIS*1500",
    "courseName": "Introduction  to  Programming",
    "courseDesc": "  This  course  introduces  problem-solving|  programming  and  data  organization  techniques  required  for  applications  using  a  general  purpose  programming  language.  Topics  include  control  structures|  data  representation  and  manipulation|  program  logic|  development  and  testing.  This  course  is  intended  for  students  who  do  not  intend  to  enroll  in  further  CIS  courses.  If  your  degree  requires  further  CIS  courses|  CIS*1300|  is  required.",
    "credits": 0.5,
    "location": "Guelph",
    "restrictions": "  CIS*1300.  Not  available  to  students  registered  in  a  BCOMP  degree|  a  CIS  minor|  BENG.CENG  or  BENG.ESC."
  },
  {
    "courseCode": "CIS*3700",
    "courseName": "Introduction  to  Intelligent  Systems",
    "courseDesc": "  This  course  covers  the  core  topics  of  Artificial  Intelligence|  namely:  agents  and  environment|  search|  knowledge  representation|  reasoning|  and  learning.  The  last  three  topics  are  covered  using  logic  as  the  common  formalism  for  coherence.  The  course  introduces  a  broad  range  of  basic  concepts|  terminology|  and  applications|  in  addition  to  providing  some  specific|  widely  applicable  methodologies.",
    "credits": 0.5,
    "location": "Guelph",
    "restrictions": null
  },
  {
    "courseCode": "CIS*4520",
    "courseName": "Introduction  to  Cryptography",
    "courseDesc": "  This  course  is  an  introduction  to  the  foundations  of  modern  cryptography|  with  an  eye  toward  practical  applications.  Topics  covered  include  classical  systems|  information  theory|  mathematical  background  material|  symmetric  and  asymmetric  crypto-systems  and  their  cryptanalysis|  hash  functions  and  message  authentication  (MAC)|  provable  security|  key-exchange  and  management|  authentication  and  digital  signatures.  Importance  of  learning  Cryptography  in  Digital  Forensics  will  also  be  discussed",
    "credits": 0.5,
    "location": "Guelph",
    "restrictions": "  CIS*4110"
  }
]
</code></pre>
          </div>
        </div>

        <br />
        <br />

        <h2>POST (Create Course)</h2>
        <p>
          To add a new course, send a <code>POST</code> request to
          <code>/courses</code> with the course data in the request body.
        </p>

        <p>
          <br />
        </p>

        <p><b>Body Parameters:</b></p>

        <ul>
          <li><code>courseCode</code> - Unique course code (required)</li>
          <li><code>courseName</code> - Course name (required)</li>
          <li><code>courseDesc</code> - Course description (required)</li>
          <li><code>credits</code> - Number of credits (required)</li>
          <li><code>location</code> - Location offered (required)</li>
          <li><code>restrictions</code> - Any restrictions (required)</li>
          <li><code>preq[1-7]</code> - Any prerequisites (required)</li>
        </ul>

        <br />

        <p><b>Status Codes:</b></p>

        <ul>
          <li><code>200 OK</code> - Course added successfully</li>
          <li><code>400 Bad Request</code> - Invalid course data</li>
          <li><code>500 Internal Server Error</code> - Database error</li>
        </ul>

        <br />

        <p><b>Examples:</b></p>

        <div class="endpoint collapsible">
          <p>Add a Single Course</p>
          <br />

          <div class="content">
            <code>
              POST https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            </code>
            <pre><code>[
  {
      "courseCode": "CIS 2750",
      "courseName": "Intro",
      "courseDesc": "Learn coding",
      "credits": 0.5,
      "locations": "Guelph Humber",
      "restrictions": "None",
      "prereq1": "",
      "prereq2": "CIS 1300",
      "prereq3": "",
      "prereq4": "",
      "prereq5": "",
      "prereq6": "",
      "prereq7": ""
  }
]
</code></pre>
            <hr />
            <br />

            <p>Response</p>
            <pre><code>"Success"</code></pre>
          </div>
        </div>

        <div class="endpoint collapsible">
          <p>Add Multiple Courses</p>
          <br />

          <div class="content">
            <code>
              POST https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            </code>

            <pre><code>[
  {
      "courseCode": "CIS 2500",
      "courseName": "Intro",
      "courseDesc": "Learn coding",
      "credits": 0.5,
      "locations": "Guelph",
      "restrictions": "None",
      "prereq1": "",
      "prereq2": "CIS 1300",
      "prereq3": "",
      "prereq4": "",
      "prereq5": "",
      "prereq6": "",
      "prereq7": ""
  },
  {
      "courseCode": "CIS 2750",
      "courseName": "Intro",
      "courseDesc": "Learn coding",
      "credits": 0.5,
      "locations": "Guelph",
      "restrictions": "None",
      "prereq1": "",
      "prereq2": "CIS 1300",
      "prereq3": "",
      "prereq4": "",
      "prereq5": "",
      "prereq6": "",
      "prereq7": ""
  }
] </code></pre>
            <hr />
            <p>Response</p>
            <pre><code>"Success"</code></pre>
          </div>
        </div>

        <br />
        <br />

        <h2>PUT (Update Course)</h2>

        <p>
          To modify an existing course, send a <code>PUT</code> request to
          <code>/courses</code> with the updated course data and unique
          identifier (<code>courseCode</code>).
        </p>

        <br />

        <p><b>Query Parameters:</b></p>

        <ul>
          <li>
            <code>courseCode</code> - Unique course code to identify course
            (required)
          </li>
          <li><code>courseName</code> - New course name (required)</li>
          <li><code>courseDesc</code> - New description (required)</li>
          <li><code>credits</code> - New number of credits (required)</li>
          <li><code>location</code> - New location (required)</li>
          <li>
            <code>prerequisites</code> - Json array of prerequisites (required)
          </li>
        </ul>

        <br />

        <p><b>Status Codes:</b></p>

        <ul>
          <li><code>200 OK</code> - Course updated successfully</li>
          <li><code>400 Bad Request</code> - Invalid course code</li>
          <li><code>404 Not Found</code> - Course to update not found</li>
          <li><code>500 Internal Server Error</code> - Database error</li>
        </ul>

        <br />

        <p><b>Examples:</b></p>

        <div class="endpoint collapsible">
          <p>Edit a Single Course</p>
          <br />

          <div class="content">
            <code>
              PUT https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            </code>

            <pre><code>{
  "courseCode": "CIS*4400",
  "courseName": "Human Computer Interaction",
  "courseDesc": "Building interfaces",
  "credits": 0.5,
  "location": "Guelph",
  "prerequisites": ["CIS*1300","CIS*2520"]
}          </code></pre>
            <hr />
            <br />

            <p>Response</p>
            <pre><code>"Success"</code></pre>
          </div>
        </div>

        <div class="endpoint collapsible">
          <p>Edit Multiple Courses</p>
          <br />

          <div class="content">
            <code>
              PUT https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            </code>

            <pre><code>[
  {
  "courseCode": "CIS*1000",
  "courseName": "Intro To Computers",
  "courseDesc": "Learn how to complete basic tasks on your computer",
  "credits": 0.5,
  "location": "Guelph Humber"
  "prerequisites": []
  },
  {
  "courseCode": "CIS*4410",
  "courseName": "Advanced Algorithms",
  "courseDesc": "Advanced analysis of algorithms",  
  "credits": 0.5,
  "location": "Guelph"
  "prerequisites": ["CIS*2500"]
  }
] </code></pre>
            <hr />
            <p>Response</p>
            <pre><code>"Success"</code></pre>
          </div>
        </div>

        <br />
        <br />

        <h2>DELETE (Remove Course)</h2>

        <p>
          The <code>DELETE /courses</code> endpoint supports deleting courses by
          their unique identifier.
        </p>

        <p>Bulk deletion is also supported by passing an array of codes.</p>

        <br />

        <p><b>Status Codes:</b></p>

        <ul>
          <li><code>200 OK</code> - Courses deleted successfully</li>
          <li><code>400 Bad Request</code> - No course codes provided</li>
          <li><code>404 Not Found</code> - Course to delete not found</li>
          <li><code>500 Internal Server Error</code> - Database error</li>
        </ul>
        <br />

        <p><b>Examples:</b></p>

        <div class="endpoint collapsible">
          <p>Delete A Single Course</p>
          <br />

          <div class="content">
            <pre><code>DELETE 
https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            
{
  "courseCodes": ["CIS*1300"] 
}

(Deletes CIS*1300)</code></pre>

            <br />
            <hr />
            <p>Response</p>
            <pre><code>"Success"</code></pre>
          </div>
        </div>

        <div class="endpoint collapsible">
          <p>Delete Multiple Courses</p>
          <br />
          <div class="content">
            <pre><code>DELETE 
https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?
            
{
  "courseCodes": ["CIS*3000", "CIS*3100", ...] 
}

(Deletes All 3000 level CIS Courses)</code></pre>

            <hr />
            <br />
            <p>Response</p>
            <pre><code>"Success"</code></pre>
          </div>
        </div>
      </section>

      <section id="extended_operations">
        <h1>Additional Functions</h1>
        <hr />
        <br />

        <h2>Get Feature Courses</h2>

        <br />
        <p><b>Examples:</b></p>

        <div class="endpoint collapsible">
          <p>Has No Courses Taken</p>
          <br />

          <div class="content">
            <code>
              POST
              https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php
            </code>
            <pre><code>{
  "coursesTaken":[]
}
</code></pre>

            <br />
            <hr />
            <br />
            <br />
            <p>
              The response is a JSON array of course objects with no
              prerequisites.
            </p>
            <pre><code>[
  {
      "courseCode": "ACCT*1220",
      "courseName": "Introductory  Financial  Accounting",
      "courseDesc": "  This  course  will  introduce  students  to  the  fundamental  concepts  and  practices  of  Financial  Accounting.  Students  are  expected  to  become  adept  at  performing  the  functions  related  to  the  accounting  cycle|  including  the  preparation  of  financial  statements.",
      "credits": 0.5,
      "location": "Guelph",
      "restrictions": "  ACCT*2220.  This  is  a  Priority  Access  Course.  Enrolment  may  be  restricted  to  particular  programs  or  specializations.  See  department  for  more  information."
  },
  {
      "courseCode": "AGR*1110",
      "courseName": "Introduction  to  the  Agri-Food  Systems",
      "courseDesc": "  This  introductory  course  provides  an  overview  of  Canadian  and  global  agri-food  systems.  Students  will  be  introduced  to  many  different  facets  of  agriculture|  including  primary  production  (conventional  and  organic)  of  commodity|  mid-value  and  high-value  crops|  and  livestock.  Students  will  explore  the  agri-food  system  by  tracing  consumer  end-products  back  to  primary  production.  Modern|  industrial  agri-food  systems  as  well  as  subsistence  farming  will  be  discussed.  The  course  incorporates  an  experiential  learning  component  in  which  students  will  explore  a  new  agrifood  opportunity  for  Ontario  by  designing  and  assessing  the  value  chain.",
      "credits": 1,
      "location": "Guelph",
      "restrictions": "  AGR*1100.  AGR*1250.  Restricted  to  students  in  BAH.FARE|  BSC(AGR)|  Minor  in  Agriculture"
  },
          ...
]
          </code></pre>
          </div>
        </div>

        <div class="endpoint collapsible">
          <p>Has Taken One Course</p>
          <br />

          <div class="content">
            <code>
              POST
              https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php
            </code>

            <pre><code>
{
  "coursesTaken":["CIS*1300"]
}
</code></pre>

            <br />
            <hr />
            <br />
            <br />
            <p>
              The response is a JSON array of course objects that the student
              can take with CIS*1300.
            </p>
            <pre><code>[
  {
      "courseCode": "ACCT*1220",
      "courseName": "Introductory  Financial  Accounting",
      "courseDesc": "  This  course  will  introduce  students  to  the  fundamental  concepts  and  practices  of  Financial  Accounting.  Students  are  expected  to  become  adept  at  performing  the  functions  related  to  the  accounting  cycle|  including  the  preparation  of  financial  statements.",
      "credits": 0.5,
      "location": "Guelph",
      "restrictions": "  ACCT*2220.  This  is  a  Priority  Access  Course.  Enrolment  may  be  restricted  to  particular  programs  or  specializations.  See  department  for  more  information."
  },

      ...

  {
      "courseCode": "CIS*2500",
      "courseName": "Intermediate  Programming",
      "courseDesc": "  In  this  course  students  learn  to  interpret  a  program  specification  and  implement  it  as  reliable  code|  as  they  gain  experience  with  pointers|  complex  data  types|  important  algorithms|  intermediate  tools  and  techniques  in  problem  solving|  programming|  and  program  testing.",
      "credits": 0.5,
      "location": "Guelph",
      "restrictions": null
      },
      
      ...
]
</code></pre>
          </div>
        </div>

        <br />
        <br />

        <h2>Get Subjects</h2>

        <br />
        <p><b>Examples:</b></p>

        <div class="endpoint collapsible">
          <p>Get All Subjects</p>
          <br />

          <div class="content">
            <code>
              GET
              http://cis3760f23-04.socs.uoguelph.ca/api/getSubjects/getSubjects.php
            </code>

            <br />
            <hr />
            <br />
            <br />
            <p>The response is a JSON array of all subjects</p>
            <pre><code>[
  {
      "Subject": "ACCT"
  },
  {
      "Subject": "AGR"
  },
  {
      "Subject": "ANSC"
  },
  {
      "Subject": "ANTH"
  },
  {
      "Subject": "ARAB"
  },
  {
      "Subject": "ARTH"
  },
  {
      "Subject": "ASCI"
  },
  {
      "Subject": "BIOC"
  },

  ...
]

</code></pre>
          </div>
        </div>
      </section>

      <section id="appendix" class="appendix">
        <h1>Appendix</h1>
        <hr />
        <br />

        <h3>Database</h3>
        <p>The courses database has the following schema:</p>

        <h4>Courses table:</h4>
        <table>
          <tr>
            <th>Field</th>
            <th>Type</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
          </tr>
          <tr>
            <td>courseCode</td>
            <td>varchar(10)</td>
          </tr>
          <tr>
            <td>courseName</td>
            <td>varchar(50)</td>
          </tr>
          <tr>
            <td>courseDesc</td>
            <td>text</td>
          </tr>
          <tr>
            <td>credits</td>
            <td>float</td>
          </tr>
          <tr>
            <td>location</td>
            <td>varchar(20)</td>
          </tr>
          <tr>
            <td>restrictions</td>
            <td>varchar(50)</td>
          </tr>
        </table>

        <h4>Prerequisites table:</h4>
        <table>
          <tr>
            <th>Field</th>
            <th>Type</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
          </tr>
          <tr>
            <td>description</td>
            <td>varchar(10)</td>
          </tr>
        </table>

        <br />

        <p>Courses can have 0-n prerequisites mapped in a join table.</p>
      </section>

      <section class="appendix">
        <h3>Endpoint Specifications</h3>
        <table>
          <tr>
            <th>Method</th>
            <th>Parameters</th>
            <th>Response Codes</th>
          </tr>
          <tr>
            <td>GET</td>
            <td>name, code, credits, prerequisites etc</td>
            <td>200, 400, 500</td>
          </tr>
          <tr>
            <td>POST</td>
            <td>New course object</td>
            <td>200, 400, 500</td>
          </tr>
          <tr>
            <td>PUT</td>
            <td>Course code, updates</td>
            <td>200, 400, 404, 500</td>
          </tr>
          <tr>
            <td>DELETE</td>
            <td>Course code</td>
            <td>204, 400, 404, 500</td>
          </tr>
        </table>

        <br />
        <br />
      </section>

      <section class="appendix">
        <h3>Additional Functions</h3>
        <table>
          <tr>
            <th>Functions</th>
            <th>Parameters</th>
            <th>Response Codes</th>
          </tr>
          <tr>
            <td>Get Feature Courses</td>
            <td>course code</td>
            <td>200, 400, 500</td>
          </tr>
          <tr>
            <td>Get Subjects</td>
            <td>none</td>
            <td>200, 400, 500</td>
          </tr>
        </table>
      </section>
    </main>
    <!-- <script src="script.js"></script> -->

    <script>
      // JavaScript for collapsible endpoints

      const endpoints = document.querySelectorAll(".endpoint.collapsible");

      // Make endpoints collapsable by default
      endpoints.forEach((endpoint) => endpoint.classList.add("collapsed"));

      endpoints.forEach((endpoint) => {
        endpoint.addEventListener("click", () => {
          endpoint.classList.toggle("collapsed");

          const content = endpoint.querySelector(".content");
          content.style.display =
            content.style.display === "none" ? "block" : "none";
        });
      });
    </script>
  </body>
</html>

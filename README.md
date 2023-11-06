# Sprint 6 

## Description 
This Sprint implements a front end utilzing an API provided with the following documentation link

https://cis3760f23-14.socs.uoguelph.ca/documentation/


## Running and installing the project

This requires PHP installed the best recommendation is getting started using XAMMP 

https://www.apachefriends.org

From there go into XAMMP with the htdocs and clone the Repo start the server from there you should be able to get started.

## Production Server 

The production link can be found here

https://cis3760f23-04.socs.uoguelph.ca

## Sprint 6 Update 

This Sprint included the following updates 

- Utilzing a API which can be found from the following link https://cis3760f23-14.socs.uoguelph.ca/documentation/

- Created a front end with the following features
    - Users ability to enter courses they've taken
    - Generate Possible courses students can take in the future this include courses where students haven't taken any courses before
    - Filter Option based by Subject and Year
- Created a wrapper Function call in Php to call the API
- Utilzied JS to call the wrapper function in order to get a response from the api

To access the updates 

https://cis3760f23-04.socs.uoguelph.ca/ApiFrontend


### API's Used 

https://cis3760f23-14.socs.uoguelph.ca/api/get_more_prereqs

- Provides the ability to get future courses a student can take and also provides the ability to take query 
parameters

Example Query with Parameters: 
https://cis3760f23-14.socs.uoguelph.ca/api/get_more_prereqs?courseCodes=CIS*1300

https://cis3760f23-14.socs.uoguelph.ca/api/get_courses

- Provides the list of all courses and takes in no query parameters and only grabs the list of all courses

https://cis3760f23-14.socs.uoguelph.ca/api/get_course

- Provides the ability to get one singular courses using query parameters

Example with Query Parameters: 
https://cis3760f23-14.socs.uoguelph.ca/api/get_course?courseCode=CIS*1300


![Get Possible Courses](/Documentation/Sprint6/ApiFrontEnd.png)

## Test cases and User Story
 
The following Tests were added for the updated Front End

- Generate Courses when Student has taken no course
- Generate Courses When a Student has taken CIS*1300
- Generate Courses When a Student has taken CIS*1300 + CIS*1910
- Generate Courses When a Student has taken CIS*1300, CIS*1910, PSYC 1000
- Generate Courses When a student Takes CIS*1300 and Filter Only 2nd year courses

For more information on Test cases and User Story Refer to the 

[User Story and Test Case](Documentation/Sprint6/User_stories_Test_cases.pdf)

# Course API

This is a REST API built with PHP and MySQL to access and modify course data. 

## Endpoints
Our Api has been designed to perform all basic requests, including GET,POST,PUT, and DELETE. You can edit the data in the table using
GET,PUT, and POST requests, and get information about courses using GET. We have updated the API in sprint 5 to use JSON strings,
as well as allow a list of courses to be entered as a json string, and have a list of possible courses returned back.
We also get getSubjects, which returns a list of all possible subject areas. 

You can read more about our endpoints on our documentation page: https://cis3760f23-04.socs.uoguelph.ca/ApiExamples/

## Database Schema

The database has the following schema:
**Course Table**

- courseCode (Primary Key, String, Unique)
- courseName (String)
- courseDesc (String)
- credits (Double)
- location (String)
- restrictions (String)

**Prerequisite Table** 

- courseCode (Foreign Key, String, Unique) 
- description (Partial Key, String)

The Prerequisite table has a foreign key constraint on courseCode referencing the Course table, and is implemented such that if a 
course is deleted, all Prerequisite entries relating to it will be automatically deleted with it.

## Implementation Details

- The API is implemented in PHP using the PDO extension to connect to the MySQL database.
- Input validation is performed to reject invalid data.
- HTTP response codes are used to indicate request status.
- JSON is used for sending and receiving data.
- Some mysql and PHP are used for parsing and checking course prerequisites, to allow a string of possible courses to be returned. 

## Testing

- The API can be tested using an application like Postman. Some examples requests are included in the Postman collection file.

## Main Sprint 5 updates:

In sprint 5 we worked to change our API to properly take in JSON body strings, as opposed to query parameters, to properly allow for multiple course input.

Get remains unchanged, as query parameters make sense for that one.
PUT was updated to take an array of courses to change 
DELETE was updated to take an array of course codes to delete
POST was updated to take an array of courses to add
We also created getPossibleCourses as an API call. This will take a json body of coursecodes, and return a list of possible courses. 
We also created getSubjects, which returns a list of all subject areas.



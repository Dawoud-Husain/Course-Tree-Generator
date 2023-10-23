
# Course API

This is a REST API built with PHP and MySQL to access and modify course data. 

## Endpoints

Read about our endpoints on our documentation page: https://cis3760f23-04.socs.uoguelph.ca/ApiDoc/

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

The Prerequisite table has a foreign key constraint on courseCode referencing the Course table.

## Implementation Details

- The API is implemented in PHP using the PDO extension to connect to the MySQL database.
- Input validation is performed to reject invalid data.
- HTTP response codes are used to indicate request status.
- JSON is used for sending and receiving data.

## Testing

- The API can be tested using an application like Postman. Some examples requests are included in the Postman collection file.
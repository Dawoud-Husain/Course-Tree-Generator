
# Course API

This is a REST API built with PHP and MySQL to access and modify course data. 

## Endpoints

### Get Courses

```
GET /api/course/course.php
```

Returns all courses in the database.

**Query Parameters**

- `name` - Filter by course name
- `id` - Filter by course ID 
- `description` - Filter by course description
- `credit` - Filter by number of credits
- `location` - Filter by course location 
- `restriction` - Filter by course restrictions
- `preq` - Join prerequisite table and filter by prerequisite description

**Example Request**

```
GET /api/course/course.php?preq=CIS*1300
```

**Example Response**

```json
[
  {
    "courseCode": "CIS*2170", 
    "courseName": "User Interface Design",
    ...
  },
  {
    "courseCode": "CIS*2250",
    "courseName": "Software Design II", 
    ...
  }
]
```

### Get Single Course

```
GET /api/course/course.php?id={courseCode}
```

Returns a single course by course code.

**Example Request**

```
GET /api/course/course.php?id=CIS*2500 
```

**Example Response**

```json
{
  "courseCode": "CIS*2500",
  "courseName": "Intermediate Programming", 
  ...
}
```

### Create Course

```
POST /api/course/course.php
```

Creates a new course. Expects JSON data containing course info.

**Example Request**

```
POST /api/course/course.php

{
  "courseCode": "CIS*3500",
  "courseName": "Advanced Programming Concepts",
  "credits": 0.5,
  "description": "Introduction to advanced programming techniques..." 
}
``` 

**Example Response** 

201 Created

### Update Course

```
PUT /api/course/course.php
```

Updates an existing course. Expects JSON data containing course info.

**Example Request**

```
PUT /api/course/course.php 

{
  "courseCode": "CIS*2500",
  "credits": 0.75
}
```

This will update the credits for CIS*2500 to 0.75.

**Example Response**

200 OK

### Delete Course

```
DELETE /api/course/course.php?id={courseCode} 
```

Deletes a course by course code.

**Example Request** 

```
DELETE /api/course/course.php?id=CIS*3500
```

**Example Response**

204 No Content

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



**Error Handling** 

- 400 Bad Request - Invalid request parameters
- 404 Not Found - Resource not found
- 405 Method Not Allowed - Incorrect HTTP method used
- 500 Internal Server Error - Server error

**Implementation Details**

- The API is implemented in PHP using the ???? extension to connect to the MySQL database.
- Input validation is performed to reject invalid data.
- HTTP response codes are used to indicate request status.
- JSON is used for sending and receiving data.

Testing

- The API can be tested using an application like Postman. Some examples requests are included in the Postman collection file.

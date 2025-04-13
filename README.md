# Course Tree Generator & Course Finder

## Introduction

This project provides a web application designed to assist students in planning their academic journey. It allows users to track completed courses, calculate their academic standing (credits and average), and discover courses they are eligible to take based on prerequisites. Additionally, it features a tool to visualize course prerequisite dependencies within specific subjects.

The application utilizes a PHP backend API to manage course data and eligibility logic, coupled with interactive JavaScript frontend components for user interaction and visualization.

## Features

*   **Course Selection & Tracking:**
    *   Select completed courses from a comprehensive list.
    *   Input final grades for completed courses.
    *   Calculates and displays total earned credits and cumulative average.
*   **Course Eligibility Calculation:**
    *   Determines which courses a user is eligible to enroll in based on:
        *   Completed course prerequisites.
        *   Total credits earned.
        *   Cumulative average (if applicable for specific course restrictions).
*   **Eligible Course Display & Filtering:**
    *   Presents a clear, filterable table of eligible courses.
    *   Filter eligible courses by Subject (e.g., CIS, MATH), Course Level (e.g., 1000, 2000), and Credit Weight (e.g., 0.5, 1.0).
*   **Course Search:**
    *   Search the initial course list by course code or course name to quickly find and select completed courses.
*   **Prerequisite Visualization ("Course Mapper"):**
    *   Select a subject area (e.g., CIS).
    *   View an interactive, hierarchical tree graph displaying course prerequisites *within that subject*.
    *   Click on courses within the tree to highlight dependencies.
*   **Report Generation:**
    *   Download a summary report containing the list of completed courses (with grades) and the generated list of eligible courses.
*   **Backend API:**
    *   Provides endpoints for fetching course data, subjects, calculating eligibility, and potentially managing course information. (See API Documentation for details).

## Technology Stack

*   **Backend:** PHP
*   **Frontend:** HTML, CSS, JavaScript
*   **Database:** SQL Database (MySQL/MariaDB implied)
*   **Libraries/Frameworks:**
    *   Bootstrap (CSS Framework)
    *   jQuery (JavaScript Library)
    *   vis.js (Network Graph Visualization Library)
*   **Containerization:** Docker (based on Dockerfile presence)

## Setup and Installation

*(Instructions below are inferred based on project structure and common practices. Adjust as necessary for the specific environment.)*

1.  **Clone Repository:**
    ```bash
    git clone <repository-url>
    cd Course-Tree-Generator
    ```
2.  **Database Setup:**
    *   Ensure a MySQL/MariaDB server is running.
    *   Create a database for the application.
    *   Configure the database connection details in `html/api/db.php`.
    *   Populate the database: The script `html/api/loadcourses/loadcourses.php` (accessible via the root `index.php` in a browser) appears designed to create tables and load initial course data from `html/api/loadcourses/courses.csv`. Run this script once.
3.  **Web Server:**
    *   Configure a web server (like Apache or Nginx) with PHP support.
    *   Set the document root to the project's `html` directory or configure virtual hosts appropriately.
4.  **Dependencies:**
    *   Run `composer install` in the project root directory to install PHP dependencies (like phpstan, based on `composer.json`).
5.  **(Optional) Docker:**
    *   Build and run the application using the provided `Dockerfile`:
        ```bash
        docker build -t course-tree-generator .
        docker run -p 8080:80 course-tree-generator # Adjust port mapping as needed
        ```
    *   *(Note: Docker setup might require additional configuration for database linking).*

## Usage

1.  **Course Finder:**
    *   Access the application via your web server, navigating to `/pages/ApiFrontend/` (e.g., `http://localhost/pages/ApiFrontend/`).
    *   Use the search bar or browse the table to find courses you have completed.
    *   Check the box next to a completed course.
    *   Enter your final grade (50-100) when prompted.
    *   Repeat for all completed courses. Your selections, total credits, and average will update automatically.
    *   Click the "Generate" button.
    *   The lower table will populate with courses you are eligible to take.
    *   Use the "Filters" button to narrow down the eligible courses by subject, level, or credits.
    *   Click "Download Report" to get a summary.
2.  **Course Mapper (Prerequisite Tree):**
    *   Access the application via your web server, navigating to `/pages/ApiTree/` (e.g., `http://localhost/pages/ApiTree/`).
    *   Click the "Select Subject" dropdown.
    *   Choose a subject from the list.
    *   An interactive prerequisite tree for that subject will be generated.
    *   Click on nodes (courses) to highlight their prerequisite relationships.

## API Documentation

Detailed API endpoint information can be found by accessing `/pages/ApiDoc/` (e.g., `http://localhost/pages/ApiDoc/`).

## Contributing

Contributors to this project include:

- Dawoud Husain  
- Eason Liang  
- Hasen Romani  
- John Constantinides  
- Karanvir Basson  
- Riley Deconkey  
- Thomas Phan  

## License

This project is licensed under the [MIT License](LICENSE).
enterButton = document.getElementById("enterButton"); // Get enter button
generateCourses = document.getElementById("generateCourses"); // Get generateCourses button

enterButton?.addEventListener("click", () => { // Define onClick event listener for enter button
    courseInput = document.getElementById("courseInput"); // Get course input box
    courseCode = courseInput?.value?.toUpperCase(); // Extract course input box value
    if (validateCourseCode(courseCode) == false) return; // Validate course input box value
    
    courseEntries = document.getElementById("courseEntries"); // Get list of course entries
    if (isNewCourseCode(courseCode) == false || getCourse(courseCode) == undefined) return; // Exit if input is duplicate or not a real course code

    let li = document.createElement("li"); // Create new list element
    let text = document.createTextNode(courseCode); // Create text node for list element

    li.className = "courseEntry"; // Set className to "courseEntry"
    li.appendChild(text); // Append text node to list element
    courseEntries.appendChild(li); // Append list element to course entries
});

function validateCourseCode(courseCode) { // Given a couse code, return true if it is a valid course code, else return false
    let courseCodeRegex = /^[A-Z][A-Z][A-Z][A-Z]?\*\d\d\d\d$/; // Regex used to validate course code
    if (!courseCodeRegex.test(courseCode)) return false; // Return false if regex doesn't match
}

function getCourse(courseCode) { // Given courseCode, make network call to get course object
    let url = `https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php?id=${courseCode}`; // Store url of GET request
    const xhttp = new XMLHttpRequest(); // Make a network request

    xhttp.open("GET", url, false); // Define GET request to url
    xhttp.send(); // Send GET request to url

    let response = JSON.parse(xhttp.responseText); // Fetch response as JS object
    return response[0]; // Return true if matching courses found
}

function isNewCourseCode(courseCode) { // Returns true if the inputted course code hasn't already been added
    return !(getInputCourses().find((course) => (course == courseCode))); // Return true if find() function returns undefined, else false
}

generateCourses?.addEventListener("click", () => { // Define onClick event listener for generateCourses button
    clearEligibleCoursesTable(); // Clear current table rows, will be repopulated
    let url = 'https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php'; // Get url of network request

    const xhttp = new XMLHttpRequest(); // Make a network request
    const body = { // Define POST request body
        coursesTaken: getInputCourses() // Add current user input courses in POST request body
    };

    xhttp.onload = function() { // Runs once the response recieved
        let response = this.responseText; // Get response as JSON text
        let eligibleCourses = JSON.parse(response); // Convert to JS array of objects
        displayEligibleCourses(eligibleCourses); // repopulate table with new courses
    }

    xhttp.open("POST", url, true); // Define POST request
    xhttp.send(JSON.stringify(body)); // Send POST request with body
});

function getInputCourses() { // Returns an array of course codes
    courseEntries = document.getElementById("courseEntries"); // Get list of course entries
    li_elements = Array.from(courseEntries.getElementsByTagName("li")); // Get all current list items
    courses = []; // Stores array of course codes to return

    li_elements.map((li_element) => courses.push(li_element.innerText)); // Populate courses array
    return courses; // Return array of course codes
}

function displayEligibleCourses(eligibleCourses) { // Given an array of course objects, display these as rows on the eligibleCoursesTable
    let eligibleCoursesTableBody = document.getElementById("eligibleCoursesTableBody"); // Get <tbody> object for eligibleCoursesTable

    eligibleCourses?.map((eligibleCourse) => { // For all course objects in array
        let row = eligibleCoursesTableBody.insertRow(-1); // Add new row in table

        // Add new cells in row
        let courseCodeCell = row.insertCell(0); // Contains course code
        let descriptionCell = row.insertCell(1); // Contains course description
        let nameCell = row.insertCell(2); // Contains course name
        let creditsCell = row.insertCell(3); // Contains course credits
        let locationCell = row.insertCell(4); // Contains course location
        let restrictionsCell = row.insertCell(5); // Contains course restrictions

        courseCodeCell.innerHTML = eligibleCourse.courseCode; // Populate course code cell
        descriptionCell.innerHTML = eligibleCourse.courseDesc; // Populate course description cell
        nameCell.innerHTML = eligibleCourse.courseName; // Populate course name cell
        creditsCell.innerHTML = eligibleCourse.credits; // Populate course credits cell
        locationCell.innerHTML = eligibleCourse.location; // Populate course location cell
        restrictionsCell.innerHTML = eligibleCourse.restrictions; // Populate course restrictions cell
    });
}

function clearEligibleCoursesTable() { // Clear table rows for repopulation
    let eligibleCoursesTableBody = document.getElementById("eligibleCoursesTableBody"); // Get <tbody> object for eligibleCoursesTable
    eligibleCoursesTableBody.innerHTML = ""; // Clear <tbody> object for eligibleCoursesTable
}

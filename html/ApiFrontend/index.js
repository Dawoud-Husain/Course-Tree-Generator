enterButton = document.getElementById("enterButton"); // Get enter button

enterButton?.addEventListener("click", () => { // Define onClick event listener for enter button
    courseInput = document.getElementById("courseInput"); // Get course input box
    courseCode = courseInput?.value?.toUpperCase(); // Extract course input box value
    if (validateCourseCode(courseCode) == false) return; // Validate course input box value
    
    courseEntries = document.getElementById("courseEntries"); // Get list of course entries
    if (isNewCourseCode(courseCode, courseEntries) == false) return; // Check if course input box value is a new course

    let li = document.createElement("li"); // Create new list element
    let text = document.createTextNode(courseCode); // Create text node for list element

    li.className = "courseEntry"; // Set className to "courseEntry"
    li.appendChild(text); // Append text node to list element
    courseEntries.appendChild(li); // Append list element to course entries
});

function validateCourseCode(courseCode) { // Given a couse code, return true if it is a valid course code, else return false
    let courseCodeRegex = /^[A-Z][A-Z][A-Z][A-Z]?\*\d\d\d\d$/; // Regex used to validate course code
    return courseCodeRegex.test(courseCode); // Return true if regex matches else false
}

function isNewCourseCode(courseCode, courseEntries) { // Returns 1 if the inputted course code hasn't alreay been added
    courses = courseEntries.getElementsByTagName("li"); // Get all current list items

    for (let i = 0; i < courses.length; i++) { // For all current list items
        if (courses[i].innerText == courseCode) return false; // Return false if match found
    }

    return true; // If no match found, return true
}
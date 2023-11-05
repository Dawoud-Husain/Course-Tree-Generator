const enterButton = document.getElementById("enterButton"); // Get enter button
const generateCourses = document.getElementById("generateCourses"); // Get generateCourses button
const clearCourses = document.getElementById("clearCourses"); // Get course entries table

enterButton?.addEventListener("click", () => { // Define onClick event listener for enter button
    const courseInput = document.getElementById("courseInput"); // Get course input box
    const courseEntries = document.getElementById("courseEntries"); // Get course entries table
    
    const courseCode = courseInput?.value?.toUpperCase(); // Extract course input box value
    const errorMsg = document.getElementById("errorMsg"); // Get errorMsg

    if (validateCourseCode(courseCode) == false) errorMsg.innerText = "Invalid course code format!"; // If course input is invalid, set error text
    else if (getCourse(courseCode) == undefined) errorMsg.innerText = "Course not found!"; // If course doesn't exist, set error text
    else if (isNewCourseCode(courseCode) == false) errorMsg.innerText = "Course code already added!"; // If course code already added, set error text
    else errorMsg.innerText = ""; // Clear the error message

    if (errorMsg.innerText) return; // If error occured, exit
    const li = document.createElement("li"); // Create new list element
    const text = document.createTextNode(courseCode); // Create text node for list element

    li.className = "courseEntry"; // Set className to "courseEntry"
    li.appendChild(text); // Append text node to list element
    courseEntries.appendChild(li); // Append list element to course entries

    clearCourses.style.display = 'inline-flex'; // display clearCourses button
    courseInput.value = ""; // Clear input box value
});

clearCourses?.addEventListener("click", (e) => { // Define onClick event listener for enter button
    const courseEntries = document.getElementById("courseEntries"); // Get course entries table
    const li_elements = Array.from(courseEntries.getElementsByTagName("li")); // Get all current list items

    li_elements.forEach((li_element) => li_element.remove()); // Populate elements
    clearCourses.style.display = 'none'; // remove clearCourses button
});

function validateCourseCode(courseCode) { // Given a couse code, return true if it is a valid course code, else return false
    const courseCodeRegex = /^[A-Z][A-Z][A-Z][A-Z]?\*\d\d\d\d$/; // Regex used to validate course code
    if (!courseCodeRegex.test(courseCode)) return false; // Return false if regex doesn't match
}

function getCourse(courseCode) { // Given courseCode, make network call to get course object
    const url = `https://cis3760f23-04.socs.uoguelph.ca/ApiFrontend/getCourse.php?courseCode=${courseCode}`; // Store url of GET request
    const xhttp = new XMLHttpRequest(); // Make a network request

    xhttp.open("GET", url, false); // Define GET request to url
    
    try { // Try to send request to get course object
        xhttp.send(); // Send GET request to url
        const response = JSON.parse(xhttp.responseText); // Fetch response as JS object
        return response?.data?.courseCode; // Return result   
    } catch (e) { // If request fails
        return undefined; // Return undefined
    }
}

function isNewCourseCode(courseCode) { // Returns true if the inputted course code hasn't already been added
    return !(getInputCourses().find((course) => (course == courseCode))); // Return true if find() function returns undefined, else false
}

generateCourses?.addEventListener("click", () => { // Define onClick event listener for generateCourses button
    clearEligibleCoursesTable(); // Clear current table rows, will be repopulated
    
    const inputCourses = getInputCourses(); // Get list of inputted courses
    const queryParam = inputCourses.join(',') // Get query parameter string with comma glue char

    const url = `https://cis3760f23-04.socs.uoguelph.ca/ApiFrontend/calls.php${queryParam ? `?courseCodes=${queryParam}` : ''}`; // Get url of network request
    const xhttp = new XMLHttpRequest(); // Make a network request

    const body = { // Define POST request body
        coursesTaken: inputCourses // Add current user input courses in POST request body
    };

    xhttp.onload = function() { // Runs once the response recieved
        const response = this.responseText; // Get response as JSON text
        const eligibleCourses = JSON.parse(response); // Convert to JS array of objects
        displayEligibleCourses(eligibleCourses); // repopulate table with new courses
    }

    xhttp.open("GET", url, true); // Define POST request
    xhttp.send(); // Send POST request with body
});

function getInputCourses() { // Returns an array of course codes
    const courseEntries = document.getElementById("courseEntries"); // Get list of course entries
    const li_elements = Array.from(courseEntries.getElementsByTagName("li")); // Get all current list items
    const courses = []; // Stores array of course codes to return

    li_elements.forEach((li_element) => courses.push(li_element.innerText)); // Populate courses array
    return courses; // Return array of course codes
}

function displayEligibleCourses(eligibleCourses) { // Given an array of course objects, display these as rows on the eligibleCoursesTable
    const eligibleCoursesTableBody = document.getElementById("eligibleCoursesTableBody"); // Get <tbody> object for eligibleCoursesTable

    eligibleCourses.data?.forEach((eligibleCourse, index) => { // For all course objects in array
        const row = eligibleCoursesTableBody.insertRow(-1); // Add new row in table
        row.id = `row${index}`; // Assign id to row for delete functionality

        // Add new cells in row 
        const deleteCell = row.insertCell(0); // Contains delete row icon
        const courseCodeCell = row.insertCell(1); // Contains course code
        const nameCell = row.insertCell(2); // Contains course name
        const descriptionCell = row.insertCell(3); // Contains course description
        const creditsCell = row.insertCell(4); // Contains course credits
        const locationCell = row.insertCell(5); // Contains course location
        const restrictionsCell = row.insertCell(6); // Contains course restrictions

        deleteCell.appendChild(getDeleteRowImg(index)); // Populate delete row cell
        courseCodeCell.innerHTML = eligibleCourse.courseCode; // Populate course code cell
        descriptionCell.innerHTML = eligibleCourse.courseDescription; // Populate course description cell
        nameCell.innerHTML = eligibleCourse.courseTitle; // Populate course name cell
        creditsCell.innerHTML = eligibleCourse.credits; // Populate course credits cell
        locationCell.innerHTML = eligibleCourse.location; // Populate course location cell
        restrictionsCell.innerHTML = eligibleCourse.restrictions; // Populate course restrictions cell
    });
}

function getDeleteRowImg(index) { // Returns an img element containing delete row icon, with delete functionality
    const img = document.createElement("img"); // Create img element
    img.className = 'deleteRowIcon'; // Add class name for css
    img.id = `deleteRow${index}`; // Add id for onClick functionality

    img.setAttribute('src', '../components/media/delete.png'); // Get image picture
    img.setAttribute('alt', 'DELETE'); // Get image picture

    img.onclick = (e) => { // When delete icon is pressed
        const index = e.target.id.replace('deleteRow', ''); // Get index of row
        document.getElementById(`row${index}`).remove(); // Remove row element from table
    };

    return img; // Return image for display in table
}

function clearEligibleCoursesTable() { // Clear table rows for repopulation
    const eligibleCoursesTableBody = document.getElementById("eligibleCoursesTableBody"); // Get <tbody> object for eligibleCoursesTable
    eligibleCoursesTableBody.innerHTML = ""; // Clear <tbody> object for eligibleCoursesTable
}

const enterButton = document.getElementById("enterButton"); // Get enter button
const generateCourses = document.getElementById("generateCourses"); // Get generateCourses button
const clearCourses = document.getElementById("clearCourses"); // Get course entries table
const api_url = window.location.href.replace(/\/pages\/.*/, '/api/'); // Get url of api directory

filterButton.addEventListener("click", () => {
    filterCourses();
});

function updateFilters() {
    const eligibleCoursesTable = document.getElementById("eligibleCoursesTable");
    const courseCodeFilter = document.getElementById("courseCode");
    const courseCodePrefixes = document.getElementsByClassName("courseCodePrefixes")[0];
    const courseCodeLevels = document.getElementsByClassName("courseCodeLevels")[0];

    // Clear existing filters
    courseCodePrefixes.innerHTML = "";
    courseCodeLevels.innerHTML = "";

    const courseCodes = new Set(); // Use a Set to store unique course codes
    const courseLevels = new Set();

    Array.from(eligibleCoursesTableBody.rows).forEach((row) => {
        const courseCode = row.cells[1].textContent;
        codePrefix = courseCode.split("*")[0];

        // Add course prefix html 
        if (!courseCodes.has(codePrefix)) {
            // Create a new filter checkbox and corresponding label
            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.className = "checkbox";
            checkbox.name = "course-code-prefix";
            checkbox.id = codePrefix;
        

            const label = document.createElement("label");
            label.htmlFor = courseCode;
            label.className = "checkboxLabel";
            label.textContent = codePrefix;

            const br = document.createElement("br");

            // Add the checkbox and label to the courseCodePrefixes section
            courseCodePrefixes.appendChild(checkbox);
            courseCodePrefixes.appendChild(label);
            courseCodePrefixes.appendChild(br);

            // Add the course code to the Set
            courseCodes.add(label.textContent);
        }
    });

    // Add Course levels html
    Array.from(eligibleCoursesTableBody.rows).forEach((row) => {
        const courseCode = row.cells[1].textContent;
        level = courseCode.charAt(courseCode.indexOf("*") + 1);

        if(level == '1' || level == '2' || level == '3' || level == '4' || level == '5') {
            if(!courseLevels.has(level)){
                // Create a new filter checkbox and corresponding label
                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.className = "checkbox";
                checkbox.id = level;
                checkbox.name = "course-code-level";
            
                const label = document.createElement("label");
                label.htmlFor = courseCode;
                label.className = "checkboxLabel";
                label.textContent = level;
            
                const br = document.createElement("br");
            
                // Add the checkbox and label to the courseCodePrefixes section
                courseCodeLevels.appendChild(checkbox);
                courseCodeLevels.appendChild(label);
                courseCodeLevels.appendChild(br);
            
                // Add the course code to the Set
                courseLevels.add(label.textContent);
            }
        }
    });
}

function filterCourses() {
	let selectedCourseCodeFilters = [];
    let selelectedCourseLevelFilters = [];
    
	// Get all checked checkboxes
	const prefixCheckboxes = document.getElementsByName("course-code-prefix");
    const courseCodeLevelsCheckboxes = document.getElementsByName("course-code-level");
    
	// Loop through checkboxes and add id to filters array if checked
	for(let i = 0; i < prefixCheckboxes.length; i++) {
    	if(prefixCheckboxes[i].checked) {
        	selectedCourseCodeFilters.push(prefixCheckboxes[i].id);
    	}
	}

     for(let i = 0; i < courseCodeLevelsCheckboxes.length; i++) {
         if(courseCodeLevelsCheckboxes[i].checked) {
            selelectedCourseLevelFilters.push(courseCodeLevelsCheckboxes[i].id);
            //  alert(courseCodeLevelsCheckboxes[i].id);
        }
    }
    
	// Get table body
	let tableBody = document.getElementById("eligibleCoursesTableBody");
    
	// Loop through rows

    if(selectedCourseCodeFilters.length != 0){
        for(let i = tableBody.rows.length - 1; i >= 0; i--) {
   	 
            // Get course code from first cell
            let courseCode = tableBody.rows[i].cells[1].innerText;
            
            // Check if course code doesn't start with any of the filters
            let matchFound = false;
            for(let j = 0; j < selectedCourseCodeFilters.length; j++) {
                if(courseCode.startsWith(selectedCourseCodeFilters[j])) {
                    matchFound = true;
                    break;
                }
            }
            
            // If no match, delete the row
            if(!matchFound) {
                tableBody.deleteRow(i);
            }
        }   
    }


    // Loop through rows and delete course level filters that do not match

    if(selelectedCourseLevelFilters.length != 0){
        for(let i = tableBody.rows.length - 1; i >= 0; i--) {
            
            // Get course code from first cell
            let courseCode = tableBody.rows[i].cells[1].innerText;
            let level = courseCode.charAt(courseCode.indexOf("*") + 1);
            
            // Check if course code doesn't start with any of the filters
            let matchFound = false;
            for(let j = 0; j < selelectedCourseLevelFilters.length; j++) {
                // alert(level, selelectedCourseLevelFilters[j]);
                if(level === (selelectedCourseLevelFilters[j])) {
                    matchFound = true;
                    break; 
                }
            }
            
            // If no match, delete the row
            if(!matchFound) {
                tableBody.deleteRow(i);
            }
        }   
    }

    updateFilters();
}

enterButton?.addEventListener("click", () => { // Define onClick event listener for enter button
    const courseInput = document.getElementById("courseInput"); // Get course input box
    const courseEntries = document.getElementById("courseEntries"); // Get course entries table
    const courseEntriesBody = document.getElementById("courseEntriesBody"); // Get course entries table body

    const courseCode = courseInput?.value?.toUpperCase(); // Extract course input box value
    const errorMsg = document.getElementById("errorMsg"); // Get errorMsg

    if (validateCourseCode(courseCode) == false) errorMsg.innerText = "Invalid course code format!"; // If course input is invalid, set error text
    else if (getCourse(courseCode) == undefined) errorMsg.innerText = "Course not found!"; // If course doesn't exist, set error text
    else if (isNewCourseCode(courseCode) == false) errorMsg.innerText = "Course code already added!"; // If course code already added, set error text
    else errorMsg.innerText = ""; // Clear the error message

    if (errorMsg.innerText) return; // If error occured, exit
    const tr = document.createElement("tr"); // Create new table row element
    const td1 = document.createElement("td"); // Create new table data cell element
    const td2 = document.createElement("td"); // Create new table data cell element
    const text = document.createTextNode(courseCode); // Create text node for table data cell element
    const deleteBtn = document.createElement("button"); // Create delete button for course

    tr.className = "courseEntry"; // Set className to "courseEntry"
    tr.id = courseCode; // Set unique course code for each row as ID
    tr.appendChild(td1); // Append table data to table row
    td1.appendChild(text); // Append text to table data cell

    deleteBtn.className = "btn btn-danger btn-sm"; // Add bootstrap button styles
    deleteBtn.innerHTML = "x"; 
    deleteBtn.style.marginLeft = "20px";

    deleteBtn.onclick = (e) => {
        document.getElementById(`${courseCode}`).remove(); // Remove row element from table
    }

    tr.appendChild(td2); // Append second table data cell to row
    td2.appendChild(deleteBtn);  // Append delete button into second table data cell 

    courseEntriesBody.appendChild(tr); // Append list element to course entries
    courseEntries.className = "table table-hover align-middle text-center"; // Redefine bootstrap class 

    clearCourses.style.display = 'inline-flex'; // display clearCourses button
    courseInput.value = ""; // Clear input box value
});

clearCourses?.addEventListener("click", (e) => { // Define onClick event listener for enter button
    const courseEntries = document.getElementById("courseEntriesBody"); // Get course entries table

    const td_elements = courseEntries.querySelectorAll('td'); // Get all current table data cells
    td_elements.forEach((td_element) => td_element.remove()); // Populate elements

    const tr_elements = courseEntries.querySelectorAll('tr'); // Get all current table data cells
    tr_elements.forEach((tr_element) => tr_element.remove()); // Populate elements

    clearCourses.style.display = 'none'; // remove clearCourses button
});

function deleteCourse(element) {
    $(element).closest('tr').remove();
}

function validateCourseCode(courseCode) { // Given a couse code, return true if it is a valid course code, else return false
    const courseCodeRegex = /^[A-Z][A-Z][A-Z][A-Z]?\*\d\d\d\d$/; // Regex used to validate course code
    if (!courseCodeRegex.test(courseCode)) return false; // Return false if regex doesn't match
}

function getCourse(courseCode) { // Given courseCode, make network call to get course object
    const url = `${api_url}Course/Course.php?id=${courseCode}`; // Store url of GET request
    const xhttp = new XMLHttpRequest(); // Make a network request

    xhttp.open("GET", url, false); // Define GET request to url
    
    try { // Try to send request to get course object
        xhttp.send(); // Send GET request to url
        const response = JSON.parse(xhttp.responseText); // Fetch response as JS object
        return response.length ? response : undefined; // Return result   
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

    const url = `${api_url}Course/getPossibleCourses.php`; // Get url of network request
    const xhttp = new XMLHttpRequest(); // Make a network request

    const body = { // Define POST request body
        coursesTaken: inputCourses // Add current user input courses in POST request body
    };

    xhttp.onload = function() { // Runs once the response recieved
        const response = this.responseText; // Get response as JSON text
        // console.log(response);

        const eligibleCourses = JSON.parse(response); // Convert to JS array of objects
        displayEligibleCourses(eligibleCourses); // repopulate table with new courses
    }

    xhttp.open("POST", url, true); // Define POST request
    xhttp.send(JSON.stringify(body)); // Send POST request with body
});

function getInputCourses() { // Returns an array of course codes
    const courseEntryRows = document.getElementsByClassName('courseEntry'); // Get all table rows
    // const courseEntryRows = document.getElementById("courseEntries"); // Get all table rows

    if(!courseEntryRows || courseEntryRows.length === 0) {
        return [];
    }

    const courses = []; // Stores array of course codes to return

    for (let i = 0; i < courseEntryRows.length; i++) {
        const courseEntryRow = courseEntryRows[i];
        courses.push(courseEntryRow.firstChild.innerText);
    }

    // alert(courses);

    return courses; // Return array of course codes
}



function displayEligibleCourses(eligibleCourses) { // Given an array of course objects, display these as rows on the eligibleCoursesTable
    // console.log(eligibleCourses);
    const eligibleCoursesTableBody = document.getElementById("eligibleCoursesTableBody"); // Get <tbody> object for eligibleCoursesTable

    eligibleCourses?.forEach((eligibleCourse, index) => { // For all course objects in array
        const row = eligibleCoursesTableBody.insertRow(-1); // Add new row in table
        row.id = `row${index}`; // Assign id to row for delete functionality

        // Add new cells in row
        const courseCodeCell = row.insertCell(0); // Contains course code
        const nameCell = row.insertCell(1); // Contains course name
        const descriptionCell = row.insertCell(2); // Contains course description
        const creditsCell = row.insertCell(3); // Contains course credits
        const locationCell = row.insertCell(4); // Contains course location
        const restrictionsCell = row.insertCell(5); // Contains course restrictions
        const deleteCell = row.insertCell(6); // Contains delete row icon
        
        deleteCell.appendChild(getDeleteRowImg(index)); // Populate delete row cell
        courseCodeCell.innerHTML = eligibleCourse.courseCode; // Populate course code cell
        descriptionCell.innerHTML = eligibleCourse.courseDesc; // Populate course description cell
        nameCell.innerHTML = eligibleCourse.courseName; // Populate course name cell
        creditsCell.innerHTML = eligibleCourse.credits; // Populate course credits cell
        locationCell.innerHTML = eligibleCourse.location; // Populate course location cell
        restrictionsCell.innerHTML = eligibleCourse.restrictions; // Populate course restrictions cell
    });

    updateFilters();
}

function getDeleteRowImg(index) { // Returns an img element containing delete row icon, with delete functionality

   const deleteBtn = document.createElement("button"); // Create delete button for course
    
   deleteBtn.className = "btn btn-danger btn-sm"; // Add bootstrap button styles
   deleteBtn.innerHTML = "x"; 
   deleteBtn.style.marginLeft = "20px";
   deleteBtn.onclick = (e) => {
        document.getElementById(`row${index}`).remove(); // Remove row element from table
   }   

   return(deleteBtn);
}


function clearEligibleCoursesTable() { // Clear table rows for repopulation
    const eligibleCoursesTableBody = document.getElementById("eligibleCoursesTableBody"); // Get <tbody> object for eligibleCoursesTable
    eligibleCoursesTableBody.innerHTML = ""; // Clear <tbody> object for eligibleCoursesTable
}

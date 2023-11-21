import { getCourses, getPossibleCourses } from "./modules/calls.js";
import { filterCourses, getSubjects, getLevels } from "./modules/filter.js";

let userCourses = []; // Stores chosen courses by the user
let possibleCourses = []; // Stores possible courses the user can take

const generateCourses = document.getElementById("generateCourses"); // Get generateCourses button
const filters = document.getElementById("filters"); // Get filters
const applyFilters = document.getElementById("applyFilters"); // Get apply filters button
const coursesTable = document.querySelector(".courseTable");
const loader = document.getElementById("loading"); // select loading div

window.onload = () => {
    displayLoadingIcon();

    getCourses() // Get list of courses in database
        .then(result => {
            const courses = result;
            // hideLoadingIcon();
            const headers = getHeaders("courseList"); // Get headers in courseList table
            populateCourseTable("courseListBody", courses, headers); // Populate table with list of courses
            hideLoadingIcon();
            displayCoursesTable();
        })
}


function displayCoursesTable() {
    coursesTable.style.display = "inline";
}

function displayLoadingIcon() {
    loader.style.display = "inline";
    loader.style.marginLeft = "150px";
}

function hideLoadingIcon() {
    loader.style.display = "none";
}

function getHeaders(id) {
    const table = document.getElementById(id); // Get table
    const headerCells = table.querySelectorAll("th"); // Get table header cells
    const headers = []; // Stores array of header labels

    headerCells.forEach((header) => { // For each header cell
        headers.push(header.innerText); // Push header cell text to headers array
    });

    return headers; // Return headers array
}

function populateCourseTable(id, courses, headers) {
    const courseTableBody = document.getElementById(id); // Get table body of course list
    if (courseTableBody == null) return; // NULL object check

    courses.forEach((course, index) => { // For each course
        const tr = courseTableBody.insertRow(); // Create row
        tr.id = `${id}_row${index}`; // Set row id

        headers.forEach((header) => {
            const cell = tr.insertCell(); // Create cell in new row

            if (header == "select") {
                const checkbox = document.createElement('input'); // Create input  
                checkbox.type = "checkbox"; // Set as checkbox

                checkbox.onchange = (e) => {
                    if (e.target.checked) userCourses.push(course);
                    else userCourses = userCourses.filter((userCourse) => (userCourse.courseCode != course.courseCode));

                    displayUserCourses();
                }

                cell.appendChild(checkbox); // Add checkbox to select
            } else if (header == "delete") {
                const deleteBtn = document.createElement("button"); // Create delete button for course
        
                deleteBtn.className = "btn btn-danger btn-sm"; // Add bootstrap button styles
                deleteBtn.innerHTML = "x"; // Add x icon in delete button
                deleteBtn.rowID = tr.id; // Add id to object
    
                deleteBtn.onclick = (e) => {
                    document.getElementById(e.target.rowID).remove(); // Remove row element from table
                }   
             
                cell.appendChild(deleteBtn);
            } else if (header === 'location' || header === 'restrictions' || header === 'courseDesc' || header === 'credits' || header === 'courseName') {
                cell.classList.add('d-none', 'd-md-table-cell');
                cell.innerHTML = course[header];
            } else {
                cell.innerHTML = course[header]; // Populate course code cell
            }
        });
        if (window.innerWidth <= 767 && headers.includes('location')) {
        tr.addEventListener('click', function() {
            displayHiddenInfo(tr, course);
        });
    }
    });
};
function displayHiddenInfo(row, course) {
    var newRow = document.createElement('tr');
    var colspan = row.getElementsByTagName('td').length; // Set colspan to span the entire row
  
    // Create a cell to contain the additional information
    var cell = document.createElement('td');
    cell.classList.add('additional-info'); // Add a class for styling purposes
    cell.setAttribute('colspan', colspan);
    cell.innerHTML = `Name: ${course.courseName}<br>Description: ${course.courseDesc}<br>Credits: ${course.credits}<br>Location: ${course.location}<br>Restrictions: ${course.restrictions}`;
  
    // Append the cell to the new row
    newRow.appendChild(cell);
  
    // Insert the new row below the clicked row
    row.insertAdjacentElement('afterend', newRow);
    newRow.addEventListener('click', function() {
        removeHiddenInfo(newRow);
      });
  }
  function removeHiddenInfo(row) {
    row.parentNode.removeChild(row);
  }

function displayUserCourses() {
    const completedCourses = document.getElementById("completedCourses");
    completedCourses.innerHTML = "";

    userCourses.forEach((userCourse, index) => {
        completedCourses.innerHTML += `${index + 1}) ${userCourse.courseCode} - ${userCourse.courseName}<br>`;
    })
}

generateCourses?.addEventListener("click", () => { // Define onClick event listener for generateCourses button
    const userCourseCodes = userCourses.map((userCourse) => userCourse.courseCode); // Get array of course codes
    possibleCourses = getPossibleCourses(userCourseCodes); // Get list of courses the user can take

    const headers = getHeaders("eligibleCourseList"); // Get headers in eligibleCourseList table
    const id = "eligibleCourseListBody"; // get id of table body in eligibleCourseList

    clearTable(id); // Clear current table rows, will be repopulated
    populateCourseTable(id, possibleCourses, headers); // populate rows in eligibleCourseList
    populateFilters(possibleCourses); // populate filter dropdowns with new courses
});

function clearTable(id) { // Clear table rows for repopulation
    const tableBody = document.getElementById(id); // Get <tbody> object for table
    tableBody.innerHTML = ""; // Clear <tbody> object for table
}

function populateFilters(courses) {
    const subjects = getSubjects(courses);
    const levels = getLevels(courses);

    const subjectsDiv = document.getElementById("subjects");
    const courseLevels = document.getElementById("courseLevels");

    subjectsDiv.innerHTML = ""; // Clear current subjectsDiv
    courseLevels.innerHTML = ""; // Clear current courseLevels

    subjects.forEach((subject) => {
        const checkbox = document.createElement('input'); // Create checkbox
        const label = document.createElement('label'); // Create label for checkbox

        checkbox.type = 'checkbox'; // Set input as checkbox
        checkbox.className = 'form-check-input'; // Bootstrap
        checkbox.id = subject; // Set id as subject for label
        checkbox.name = "subjectCheckbox"; // Set name

        label.className = 'form-check-label'; // Bootstrap
        label.htmlFor = subject; // Connect to checkbox
        label.textContent = subject; // Add label text content

        // Create div with form-check classes
        const div = document.createElement('div');
        div.className = 'form-check form-switch';
        div.style = 'color:white; background: black;';

        // Add checkbox + label to DOM
        div.appendChild(checkbox);
        div.appendChild(label);
        subjectsDiv.appendChild(div);
    });

    levels.forEach((level) => {
        const checkbox = document.createElement('input');
        const label = document.createElement('label');

        checkbox.type = 'checkbox'; // Set input as checkbox
        checkbox.className = 'form-check-input'; // Bootstrap
        checkbox.id = level; // Set id as level for label
        checkbox.name = "levelCheckbox" // Set name

        label.className = 'form-check-label'; // Bootstrap
        label.htmlFor = level; // Connect to checkbox
        label.textContent = level; // Add label text content

        // Create div with form-check classes
        const div = document.createElement('div');
        div.className = 'form-check form-switch';
        div.style = 'color: white; background: black;';

        // Add checkbox + label to DOM
        div.appendChild(checkbox);
        div.appendChild(label);
        courseLevels.appendChild(div);
    });
}

filters.addEventListener("click", () => {
    const categories = document.getElementById("categories");
    categories.style.display = categories.style.display ? "" : "block";
});

applyFilters.addEventListener("click", () => {
    const subjectCheckboxes = document.getElementsByName("subjectCheckbox");
    const levelCheckboxes = document.getElementsByName("levelCheckbox");

    const filterSubjects = [];
    const filterLevels = [];
    
    subjectCheckboxes.forEach((subjectCheckbox) => {
        if (subjectCheckbox.checked) filterSubjects.push(subjectCheckbox.id);
    });

    levelCheckboxes.forEach((levelCheckbox) => {
        if (levelCheckbox.checked) filterLevels.push(levelCheckbox.id);
    });

    const filterInfo = {
        subjects: filterSubjects,
        levels: filterLevels,
    };

    const filteredCourses = filterCourses(possibleCourses, filterInfo); // Get filtered Courses
    const headers = getHeaders("eligibleCourseList"); // Get headers in eligibleCourseList table
    const id = "eligibleCourseListBody"; // get id of table body in eligibleCourseList

    clearTable(id); // Clear current table rows, will be repopulated
    populateCourseTable(id, filteredCourses, headers); // populate rows in eligibleCourseList
});

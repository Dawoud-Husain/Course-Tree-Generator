import { getCourses, getPossibleCourses } from "./modules/calls.js";
import { filterCourses, getSubjects, getLevels, getCredits } from "./modules/filter.js";

let userCourses = []; // Stores chosen courses by the user
let possibleCourses = []; // Stores possible courses the user can take
let credits = 0; // Stores total credits
let avg = 0; //stores gpa

const generateCourses = document.getElementById("generateCourses"); // Get generateCourses button
const filters = document.getElementById("filters"); // Get filters
const applyFilters = document.getElementById("applyFilters"); // Get apply filters button
const input = document.querySelector('input');
const homeBtn = document.getElementById("redirectHome");
const enteredCoursesTable = document.getElementById("enteredCoursesTable");
const possibleCoursesTable = document.getElementById("possibleCoursesTable");
const loader = document.getElementById("loading"); // select loading div

input.addEventListener('focus', () => {
    input.placeholder = '';
    possibleCoursesSearchSubmit.style.opacity = 1;
    possibleCoursesSearchSubmit.style.color = "white";
    possibleCoursesSearchSubmit.style.background = "black";
    possibleCoursesSearchSubmit.disabled = false;
    
  });
  
window.onload = () => {
    possibleCoursesSearchSubmit.style.opacity = 0.5;
    possibleCoursesSearchSubmit.disabled = true;
    displayLoadingIcon();
    getCourses()// Get list of courses in database
        .then(result => {
            const courses = result;
            // hideLoadingIcon();
            const headers = getHeaders("courseList"); // Get headers in courseList table
            populateCourseTable("courseListBody", courses, headers); // Populate table with list of courses
            hideLoadingIcon();
            displayEnteredCoursesTable();
        })
}
function displayEnteredCoursesTable() {
    enteredCoursesTable.style.display = "inline";
}
function displayPossibleCoursesTable() {
    possibleCoursesTable.style.display = "inline";
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
                    if (e.target.checked)  {
                        $('#gradeModal').modal('show');
                        document.getElementById('saveGradeBtn').onclick = () => {
                        const gradeInput = document.getElementById('gradeInput').value;
                        if (!isNaN(gradeInput) && parseFloat(gradeInput) >= 50 && parseFloat(gradeInput) <= 100) {
                            userCourses.push(course);
                            userCourses[userCourses.length - 1].grade = parseFloat(gradeInput);
                            credits += parseFloat(course.credits);
                            $('#gradeModal').modal('hide');
                            calcAvg();
                            displayUserCourses();
                        } else {
                            alert('Please enter a valid numeric grade that is greater than 50 and less than 100');
                        }
                        }
                        document.getElementById('closeGrade').onclick = () => {
                            $('#gradeModal').modal('hide');
                            e.target.checked = false;
                        }
                    }
                    else {
                        userCourses = userCourses.filter((userCourse) => (userCourse.courseCode != course.courseCode));
                        credits -= parseFloat(course.credits);
                    }
                    calcAvg();
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
    populateFilters(courses);
};
function calcAvg() {
    var total = 0;
    userCourses.forEach((userCourse, index) => {
        total += parseFloat(userCourse.grade);
    })
    if (userCourses.length != 0) {
        avg = total / userCourses.length;
    } else {
        avg = 0;
    }
    
}
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
    const creditText = document.getElementById("completedCoursesCredits");
    creditText.innerHTML = `Your completed courses: (Total Credits: ${credits}, Average: ${avg.toFixed(2)})`
    completedCourses.innerHTML = "";

    userCourses.forEach((userCourse, index) => {
        completedCourses.innerHTML += `${index + 1}) ${userCourse.courseCode} - ${userCourse.courseName} - Grade: ${userCourse.grade}<br>`;
    })
}

homeBtn?.addEventListener("click", () => {
    const urlHome = window.location.href.replace(/\/pages\/.*/, ''); // Get url of api directory

    homeBtn.href = urlHome;
});

generateCourses?.addEventListener("click", () => { // Define onClick event listener for generateCourses button
    const userCourseCodes = userCourses.map((userCourse) => userCourse.courseCode); // Get array of course codes
    getPossibleCourses(userCourseCodes,avg,credits)  // Get list of courses the user can take
        .then(result => {
            possibleCourses = result;
            const headers = getHeaders("eligibleCourseList"); // Get headers in eligibleCourseList table
            const id = "eligibleCourseListBody"; // get id of table body in eligibleCourseList
        
            clearTable(id); // Clear current table rows, will be repopulated
            populateCourseTable(id, possibleCourses, headers); // populate rows in eligibleCourseList
            populateFilters(possibleCourses); // populate filter dropdowns with new courses
            displayPossibleCoursesTable();
        })
});

function clearTable(id) { // Clear table rows for repopulation
    const tableBody = document.getElementById(id); // Get <tbody> object for table
    tableBody.innerHTML = ""; // Clear <tbody> object for table
}

function populateFilters(courses) {
    const subjects = getSubjects(courses);
    const levels = getLevels(courses);
    const credits = getCredits(courses);

    const subjectsDiv = document.getElementById("subjects");
    const courseLevels = document.getElementById("courseLevels");
    const courseCredits = document.getElementById("courseCredits");

    subjectsDiv.innerHTML = ""; // Clear current subjectsDiv
    courseLevels.innerHTML = ""; // Clear current courseLevels
    courseCredits.innerHTML = ""; 

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


    credits.forEach((credit) => {
        const checkbox = document.createElement('input');
        const label = document.createElement('label');
        checkbox.type = 'checkbox'; // Set input as checkbox
        checkbox.className = 'form-check-input'; // Bootstrap
        checkbox.id = credit; // Set id as level for label
        checkbox.name = "creditCheckbox" // Set name
        label.className = 'form-check-label'; // Bootstrap
        label.htmlFor = credit; // Connect to checkbox
        label.textContent = credit; // Add label text content
        // Create div with form-check classes
        const div = document.createElement('div');
        div.className = 'form-check form-switch';
        div.style = 'color: white; background: black;';
        // Add checkbox + label to DOM
        div.appendChild(checkbox);
        div.appendChild(label);
        courseCredits.appendChild(div);
    });
}

filters.addEventListener("click", () => {
    const categories = document.getElementById("categories");
    categories.style.display = categories.style.display ? "" : "block";
});

applyFilters.addEventListener("click", () => {
    const subjectCheckboxes = document.getElementsByName("subjectCheckbox");
    const levelCheckboxes = document.getElementsByName("levelCheckbox");
    const creditCheckboxes = document.getElementsByName("creditCheckbox");

    const filterSubjects = [];
    const filterLevels = [];
    const filterCredits = [];
    
    subjectCheckboxes.forEach((subjectCheckbox) => {
        if (subjectCheckbox.checked) filterSubjects.push(subjectCheckbox.id);
    });

    levelCheckboxes.forEach((levelCheckbox) => {
        if (levelCheckbox.checked) filterLevels.push(levelCheckbox.id);
    });

    creditCheckboxes.forEach((creditCheckbox) => {
        if (creditCheckbox.checked) filterCredits.push(creditCheckbox.id);
    });

    const filterInfo = {
        subjects: filterSubjects,
        levels: filterLevels,
        credits: filterCredits
    };

    const filteredCourses = filterCourses(possibleCourses, filterInfo); // Get filtered Courses
    const headers = getHeaders("eligibleCourseList"); // Get headers in eligibleCourseList table
    const id = "eligibleCourseListBody"; // get id of table body in eligibleCourseList

    clearTable(id); // Clear current table rows, will be repopulated
    populateCourseTable(id, filteredCourses, headers); // populate rows in eligibleCourseList
});

possibleCoursesSearchSubmit.addEventListener('click', () => {

    const result = []; // Stores filtered courses
    const headers = getHeaders("courseList"); // Get headers in courseList table
    const searchValue = (document.getElementById('possibleCoursesSearchInput').value).toLowerCase();
    let filteredCourses;

    getCourses().then(courselist => {// Get list of courses in database
        
        const courses = courselist;

        courses.forEach((course) => { // For each course, match filter
            let courseName = course.courseName.toLowerCase();
            let courseCode = course.courseCode.toLowerCase();
                
            if(searchValue.includes('*')) {
                if(courseCode === searchValue){
                    result.push(course)  
                }
            }
            
            else {
                if(courseName.includes(searchValue)){
                    result.push(course)
                }
            }
        })  

          // Clear existing content
        while(courseListBody.rows.length > 0) {
            courseListBody.deleteRow(0);
        }

        populateCourseTable("courseListBody", result, headers); // Populate table with list of courses

    });
});


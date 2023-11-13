
filterButton.addEventListener("click", () => {
    filterCourses();
});

showHideFiltersButton.addEventListener("click", () => {
    hideShowCatagories();
});

function hideShowCatagories() {
    var catagories = document.getElementsByClassName("categories");
    
    Array.from(catagories).forEach((x) => {
        if (x.style.display === "none") {
          x.style.display = "block";
        } else {
          x.style.display = "none";
        }
      })
} 

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
        const courseCode = row.cells[0].textContent;
        codePrefix = courseCode.split("*")[0];

        // Add course prefix html 
        if (!courseCodes.has(codePrefix)) {
            
            // Create checkbox
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'form-check-input';
            checkbox.id = codePrefix;
            checkbox.name = "course-code-prefix";

            // Create label
            const label = document.createElement('label');
            label.className = 'form-check-label'; 
            label.htmlFor = codePrefix;
            label.textContent = codePrefix;

            // Create div with form-check classes
            const div = document.createElement('div');
            div.className = 'form-check form-switch';
            div.style = 'color:white; background:#212529;';

            // Append elements
            div.appendChild(checkbox);
            div.appendChild(label);

            // Add to dom
            courseCodePrefixes.appendChild(div);
            courseCodes.add(codePrefix);
        }
    });

    // Add Course levels html
    Array.from(eligibleCoursesTableBody.rows).forEach((row) => {
        const courseCode = row.cells[0].textContent;
        level = courseCode.charAt(courseCode.indexOf("*") + 1);

        if(level == '1' || level == '2' || level == '3' || level == '4' || level == '5') {
            if(!courseLevels.has(level)){

            // Create checkbox
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'form-check-input';
            checkbox.id = level;
            checkbox.name = "course-code-level"

            // Create label
            const label = document.createElement('label');
            label.className = 'form-check-label'; 
            label.htmlFor = courseCode;
            label.textContent = level;

            // Create div with form-check classes
            const div = document.createElement('div');
            div.className = 'form-check form-switch';
            div.style = 'color:white; background:#212529;';

            // Append elements
            div.appendChild(checkbox);
            div.appendChild(label);
            
                // Add the course code to the Set
                courseCodeLevels.appendChild(div);
                courseLevels.add(level);
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
            // alert(prefixCheckboxes[i].id);
    	}
	}

     for(let i = 0; i < courseCodeLevelsCheckboxes.length; i++) {
         if(courseCodeLevelsCheckboxes[i].checked) {
            selelectedCourseLevelFilters.push(courseCodeLevelsCheckboxes[i].id);
            // alert(courseCodeLevelsCheckboxes[i].id);
        }
    }
    
	// Get table body
	let tableBody = document.getElementById("eligibleCoursesTableBody");
    
	// Loop through rows

    if(selectedCourseCodeFilters.length != 0){
        for(let i = tableBody.rows.length - 1; i >= 0; i--) {
   	 
            // Get course code from first cell
            let courseCode = tableBody.rows[i].cells[0].innerText;
            
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
            let courseCode = tableBody.rows[i].cells[0].innerText;
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
const api_url = window.location.href.replace(/\/pages\/.*/, '/api/'); // Get url of api directory

export function getCourses() {
    const url = `${api_url}Course/Course.php`; // Store url of GET request
    const xhttp = new XMLHttpRequest(); // Make a network request
    
    xhttp.open("GET", url, false); // Define GET request to url
    xhttp.send(); // Send GET request to url

    const response = JSON.parse(xhttp.responseText); // Fetch response as JS object
    return response.length ? response : undefined; // Return result   
}

export function getPossibleCourses(userCourseCodes) {
    const url = `${api_url}Course/getPossibleCourses.php`; // Get url of network request
    const xhttp = new XMLHttpRequest(); // Make a network request
    
    const body = { // Define POST request body
        coursesTaken: userCourseCodes // Add current user input courses in POST request body
    };

    xhttp.open("POST", url, false); // Define POST request
    xhttp.send(JSON.stringify(body)); // Send POST request with body

    return JSON.parse(xhttp.responseText); // Return response as JS object
}

export function filterCourses(courses, filterInfo) { // Filters an array of courses based on filter info
    const result = []; // Stores filtered courses

    const matchSubject = Boolean(filterInfo.subjects.length); // Stores true if we must match subject
    const matchLevel = Boolean(filterInfo.levels.length); // Stores true if we must match level
    if (!matchSubject && !matchLevel) return courses; // Early return if no filtering

    courses.forEach((course) => { // For each course, match filter
        const subject = course.courseCode.replace(/\*\d+/g, ''); // Get subject string
        const level = course.courseCode.replace(/[^0-9]/g, '')[0] + '000'; // Get level string
        let match = false; // Stores true if filter match found

        // FIND FILTER MATCH
        if (matchSubject && matchLevel) match = filterInfo.subjects.includes(subject) && filterInfo.levels.includes(level);
        else if (matchSubject) match = filterInfo.subjects.includes(subject);
        else if (matchLevel) match = filterInfo.levels.includes(level);
        else match = true;

        if (match) result.push(course); // Add course if filter match found
    });

    return result;
}

export function getSubjects(courses) {
    const subjects = new Set(); // Stores a set of subjects

    courses.forEach((course) => { // Loop through all courses
        const subject = course.courseCode.replace(/\*\d+/g, ''); // Get subject string
        subjects.add(subject); // Add subject to subjects set
    });

    return Array.from(subjects).sort(); // Return set of subjects
}

export function getLevels(courses) {
    const levels = new Set(); // Stores a set of levels

    courses.forEach((course) => { // Loop through all courses
        const level = course.courseCode.replace(/[^0-9]/g, '')[0] + '000'; // Get level string
        levels.add(level); // Add level to levels set
    });

    return Array.from(levels).sort(); // Return set of levels
}
# Course Tree Generator

For this sprint, our team created a webpage that allows users to visualize the pre-requisite relationships between courses through an interactive tree diagram.

## Setting up the Tree 

When a subject is selected, the webpage fetches all the courses associated with that subject from the API. It then builds up the tree structure by adding each course as a node to the network graph. If a course has any pre-requisite courses listed, it creates edges between that course and its pre-requisites. The pre-requisites that come in as "1 of" strings listing multiple options are handled by splitting these out and creating edges joining to that course. By tracing these relationships, it is able to assemble the full tree structure programmatically based on the course data. This allows the tree to be updated automatically if the even if the course data changes in the future.

## Using vis.js

We opted to use the vis network graph library to render the tree diagram as it provides an easy to use set of components for visualizing dynamic relationships in a node-link format. Futhermore, it handles all the messy details of laying out the graph and includes useful interactions like node selection. The previous frameworks we evaluated (such as d3.js) were either too low level, requiring us to manually lay out all the nodes, or lacked the hierarchical layouts needed for a tree structure. The smooth rendering, zooming and performance of vis makes it ideal for visualizing complex relational data (i.e. Course Prerequisites) in an intuitive way for users to explore.  

## Refactoring

Key changes includes:
- Extracting the API calls and filtering logic into separate modules
- Tables were standardized into a reusable component to remove duplication and simplify data handling.
- Header names are now dynamically fetched instead of hardcoded.
- User data and filters are stored in variables rather than DOM for improved reusability.

Overall these changes make the code more modular, reusable and maintainable by removing duplication and improving separation of concerns - helping it scale better as needs change.

## Testing 

A series of user stories were developed to validate the structure and interconnections of the trees for different subject areas. This helped detect any issues in how the prerequisite data was being interpreted or if the visual representation matched the underlying data model.
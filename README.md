# Sprint 7

## Refactoring

In sprint 7, we've refactored our front-end API to use our own backend instead of team 404s. When we moved to using our own API, we updated some of it to improve time complexity. We've also updated our `getPossibleCourses` to properly handle ORs, 1OFs, ANDs, etc.

We've also updated our filter code to fix a few bugs discovered in testing, including allowing courses to be filtered multiple times.

Additionally, we've refactored the code used to access the backend database and stored it in its own PHP function rather than global variables.

## Clean URLs

Working with the NGINX settings, we were able to use our existing file structure, along with some rewrite rules, to ensure our URLs looked clean and did not contain file extensions. In order to do this, we used `try_files` to try files first as their initial URL but second as a directory.

This is shown by the `$uri/`. This, along with the index variables set, means that with our file structure, where we use folders containing individual `index.php`s or `index.html`s, we can have the URLs clean.

Second, the API calls are made with `Course.php` and `getPossibleCourses.php`. Initially, our API calls were:
- [https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php](https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php)
- [https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php](https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php)

These are quite ugly, and using rewrite rules, we were able to change the calls. We can instead use:
- [https://cis3760f23-04.socs.uoguelph.ca/api/getPossibleCourses](https://cis3760f23-04.socs.uoguelph.ca/api/getPossibleCourses)
- [https://cis3760f23-04.socs.uoguelph.ca/api/Course](https://cis3760f23-04.socs.uoguelph.ca/api/Course)

With these rules, there are no longer any file extensions used in URLs, and we've shortened the API calls for simplicity and ease of use. These rewrite rules simply replace parts of the URL with full versions and then recall them, so they are caught by the original rule that catches all `.php`s, which passes them over to FastCGI to handle the PHP coding.

**Sources:**
- [Baeldung - Forward HTTP POST Request using Rewrite in Nginx](https://www.baeldung.com/linux/forward-http-post-request-using-rewrite#:~:text=In%20Nginx%2C%20URL%20rewriting%20uses,HTTP%20method%20of%20the%20request.)
- [NGINX Blog - Creating NGINX Rewrite Rules](https://www.nginx.com/blog/creating-nginx-rewrite-rules/)
- [NGINX Wiki - Config Pitfalls](https://www.nginx.com/resources/wiki/start/topics/tutorials/config_pitfalls/)

## Automated Testing

We used the playwright library to create Python code for automated testing. We added tests for both our front-end and our API calls.

## CI/CD

In order to simplify pushing to production, we've used GitLab's own CI/CD pipeline functionality. This allows us to develop our production environment in a more secure way and automatically push from our current sprint branch.

## Responsivity

To make our webpage properly responsive, we used Bootstrap to dynamically resize elements and parts of the webpage and to have a proper mobile view. Bootstrap allows us to simply assign elements to its pre-made responsiveness items, and it does the work for us!

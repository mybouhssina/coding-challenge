Hosted at: https://secure-lake-79426.herokuapp.com  
Technologies: Laravel 9/ Vue 3
## Endpoints:
### / : Search page  
### /ninjify: API:  
**expects** a querystring parameter 'x' consisting of one or more of the following words separated by ',':
sass, rails, html, php, cms, http, email, security, queue.   
**returns:** a name based on the passed words  
**errors:**:  
400: if the parameter x is missing or empty.  
422: if some of the passed words in x don't exist

#Process

- Database creation
- Folders Structure
- admin.php basic page
- stylesheets
- creating includes (header, footer, functions)
- connect to database
- add close database into footer include
- make db connection variables into constants
- adding pages to navigation
- refactor query statements into functions
- make subjects and pages into links and passing URL's
- highlighting current page
- encapsulate navigation into a function
- finding subject in db
- creating a new subject
- processing form values and adding subjects
- passing data in the session
- validating form values
- creating and editing subject create form
- using single page subject update submission
- deleting a subject (Can't delete subject with pages)
- creating a new page (associated to a subject => foreign key)
- page creation form
- using single page page update submission
- deleting a page
- add context (public or admin) and public navigation
- default landing page for subject (first page of subject)
- protecting page visibility
- Admin CRUD
- encrypting password (blowfish algorithm => included in PHP 5.5 and after => slow)
crypt($password, $salt); => only supports 6 algorithms
- create login system
- checking for user authorization
- logout added
- adding content creation text editor
- final styling
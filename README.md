# VOIQ - CRM Uploader Spreadsheet
# By: Oscar Olarte

## Libraries Used

[CakePHP](http://www.cakephp.org) - It was used to make easy the creation of user management console
given the MVC software architectural pattern. Also, allows a way to create very quickly views for search,
login, which saved me some time to focus in the main aspects of the software. Also, saved my a lot of time,
because it's not neccesary to execute explicit SQL statements, with well defined model, everything worked
perfect.

[PHPExcel](https://phpexcel.codeplex.com/) - It was used because the .xls and .xlsx are quite complex, and 
this library using object-oriented design gave a faster way to iterate rows and columns which also made
validations of format more easier. Given the differences between .xls and .xlsx, this library allows an easy 
interchangeable reader for those formats.

[ParseCSV-For-PHP](https://github.com/parsecsv/parsecsv-for-php) - It was used because gives a fast
way to generate arrays from input files like .csv and .txt, in this way, I defined a generic method of validation
which used a specific file format procedure to extract the information without many problems. Also, it was
object-oriented which made the process way easier to use in the current application.


## Layout Code 

The main scripts of my development core are:

* /app/Controller/: controllers for users, customers and files
* /app/Controller/FileStrategy/*: pattern to handle different types of file formats, defining handlers
to manage data and validation all the input information.
* /app/Model/: models of the database for users, customers, and files.
* /app/View/Customers: view for the search methods for customers
* /app/View/Files: view for the upload process of spreadsheets
* /app/View/Users: views for the user management module
* /app/View/Utils: utils functions for constants and loading bar progress with Memcached
* app/webroot/js/handle_upload.js: script to generate and update progress bar during upload



# roommate-ledger
This is a web-version of a roommate-ledger spreadsheet found on Google Docs. It uses PHP, MySQL, and HTML+JQuery to keep track of shared expenses between housemates.

To get started:

1) Setup your Apache, PHP, MySQL instances (use an XAMPP/LAMPP stack for easy setup).

2) Import the database into MySQL using the SQL file "roommate-ledger.sql" under the "db" folder.

3) Create a MySQL user with the appropriate permissions for the database and table.

4) Copy all files and folders under the "src" folder to the htdocs, www, or other web-accessible folder.

5) Edit the following items in the "constants.php" file copied over in step 4:

	NUMBER_OF_PEOPLE: The number of people to be listed on the ledger.

	PERSON_x:         The name of the person.

	DB_SERVER:        The server name or IP Address of the MySQL database.

	DB_USER:          The username for the MySQL database user.

	DB_PASS:          The password for the MySQL database user.

	DB_NAME:          The name for the MySQL database to use.

	TITLE:            The title pre-fix to show on the webpages. eg. Setting this to "Housemate" will display
	                  "Housemate Ledger" on the pages for the page heading.

6) Start the Apache instance if need be, and test the webpage.

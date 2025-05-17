=== How to setup the database ===

Method 1: Using phpMyAdmin
1. Go to your phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named "cms_db" if it doesn't exist already
3. Select the "cms_db" database
4. Click on the "Import" tab
5. Choose the file "cms_db_import.sql" (not cms_db.sql)
6. Click "Import" button

Method 2: Using MySQL Command Line
1. Open a command prompt or terminal
2. Navigate to your MySQL bin directory (e.g., C:\xampp\mysql\bin)
3. Run the following command:
   mysql -u root -h localhost cms_db < path\to\cms_db_import.sql

Note: If you're using XAMPP on Windows, you might need to create the database first:
1. mysql -u root -h localhost -e "CREATE DATABASE IF NOT EXISTS cms_db"
2. mysql -u root -h localhost cms_db -e "source path\to\cms_db_import.sql"

=== Updating an Existing Database ===

Method 1: Using the Automated Script (Recommended)
1. Make sure your database connection settings are correct in dbConfiguration.php
2. Run the upgrade script from your browser or command line:
   - Browser: http://localhost/CMSTestProj/db/upgrade_database.php
   - Command Line: php db/upgrade_database.php
3. The script will automatically apply any missing migrations

Method 2: Manual Migration
1. Check the db/migrations folder for available migration scripts
2. Connect to your database using phpMyAdmin or command line
3. Run each migration script in order (they are named with timestamps)
4. For command line: mysql -u root -h localhost cms_db < path\to\migration_script.sql

=== Troubleshooting ===
If you encounter foreign key constraint errors:
- Make sure you're using the cms_db_import.sql file, not the old cms_db.sql file
- The cms_db_import.sql file has the tables in the correct order to avoid foreign key issues

If you encounter issues with database migrations:
- Check that your database user has sufficient privileges
- Make sure the migrations directory exists and is readable
- Check the PHP error logs for detailed error messages

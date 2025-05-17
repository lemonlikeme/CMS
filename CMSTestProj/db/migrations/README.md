# Database Migrations

This folder contains SQL scripts to update the database schema when changes are needed.

## How to Run Migrations

To apply migrations, follow these steps:

1. Make sure you have a backup of your database
2. Log in to MySQL/MariaDB:
   ```
   mysql -u username -p
   ```
3. Select your CMS database:
   ```
   USE cms_db;
   ```
4. Run the migration script:
   ```
   SOURCE /path/to/migration/script.sql;
   ```

## Available Migrations

### add_template_id.sql

This migration adds the `template_id` field to the `site_preferences` table and ensures each template has a unique identifier. This change enables multiple templates per user instead of overwriting the same template.

**Changes:**
- Adds `template_id` column to `site_preferences` table
- Creates a unique index on the combination of `user_id` and `template_id`
- Updates existing records to have unique template IDs

**When to run:** After updating to a version that supports multiple templates per user.

## Troubleshooting

If you encounter errors while running migrations:

1. Check that the database user has sufficient privileges
2. Verify that you're connected to the correct database
3. Ensure you're using the full path to the migration script

For any issues, please review the error message carefully and consult the logs in your web server's error log. 
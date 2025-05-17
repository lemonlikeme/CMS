-- Migration to add template_id field to site_preferences table

-- Check if the table exists first
SET @table_exists = 0;
SELECT COUNT(*) INTO @table_exists FROM information_schema.tables 
WHERE table_schema = DATABASE() AND table_name = 'site_preferences';

-- Only proceed if the table exists
SET @continue = IF(@table_exists > 0, 'SELECT 1', 'SELECT 0 INTO @dummy');
PREPARE stmt FROM @continue;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check if template_id column already exists
SET @column_exists = 0;
SELECT COUNT(*) INTO @column_exists FROM information_schema.columns 
WHERE table_schema = DATABASE() AND table_name = 'site_preferences' AND column_name = 'template_id';

-- Only add column if it doesn't exist and table exists
SET @alter_command = IF(@table_exists > 0 AND @column_exists = 0, 
    'ALTER TABLE site_preferences ADD COLUMN template_id VARCHAR(100) NOT NULL DEFAULT \'homepage\' AFTER user_id', 
    'SELECT 1');
PREPARE stmt FROM @alter_command;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add unique index if it doesn't exist
SET @index_exists = 0;
SELECT COUNT(*) INTO @index_exists FROM information_schema.statistics
WHERE table_schema = DATABASE() AND table_name = 'site_preferences' AND index_name = 'user_template_idx';

SET @add_index_command = IF(@table_exists > 0 AND @index_exists = 0,
    'ALTER TABLE site_preferences ADD UNIQUE KEY user_template_idx (user_id, template_id)',
    'SELECT 1');
PREPARE stmt FROM @add_index_command;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Update existing records to have a unique template identifier
UPDATE site_preferences 
SET template_id = CONCAT('template_', id, '_', UNIX_TIMESTAMP())
WHERE template_id = 'homepage'; 
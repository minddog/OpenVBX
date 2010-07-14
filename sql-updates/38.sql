ALTER TABLE `annotations` ADD COLUMN `action_id` VARCHAR(34) NULL DEFAULT NULL;
UPDATE `settings` SET `value` = 38 WHERE `name` = 'schema-version';
-- Create authorization_rules table manually

CREATE TABLE IF NOT EXISTS `authorization_rules` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) UNSIGNED NOT NULL COMMENT 'User who has this authorization rule',
    `rule_type` ENUM('all', 'division', 'department', 'section') NOT NULL DEFAULT 'division' COMMENT 'Type of authorization: all (admin), division, department, or section',
    `target_type` ENUM('islanders', 'visitors', 'both') NOT NULL DEFAULT 'both' COMMENT 'What type of users this rule applies to',
    `division_ids` TEXT NULL COMMENT 'JSON array of division IDs user can access (for division/department rules)',
    `department_ids` TEXT NULL COMMENT 'JSON array of department IDs user can access (for department rules)',
    `section_ids` TEXT NULL COMMENT 'JSON array of section IDs user can access (for section rules)',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1 = active, 0 = inactive',
    `description` TEXT NULL COMMENT 'Optional description of this authorization rule',
    `created_by` INT(11) UNSIGNED NULL,
    `updated_by` INT(11) UNSIGNED NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    `deleted_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_rule_type` (`rule_type`),
    KEY `idx_target_type` (`target_type`),
    KEY `idx_is_active` (`is_active`),
    KEY `idx_deleted_at` (`deleted_at`),
    CONSTRAINT `fk_authorization_rules_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_authorization_rules_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk_authorization_rules_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data
INSERT INTO `authorization_rules` (`user_id`, `rule_type`, `target_type`, `division_ids`, `department_ids`, `section_ids`, `is_active`, `description`, `created_at`, `created_by`) VALUES
(1, 'all', 'both', NULL, NULL, NULL, 1, 'Administrator - can see all users', NOW(), 1),
(2, 'division', 'both', '[1]', NULL, NULL, 1, 'Division 1 Manager - can see all users in division 1', NOW(), 1),
(3, 'department', 'both', NULL, '[1,3,4]', NULL, 1, 'Multi-department Manager - can see users in departments 1, 3, and 4', NOW(), 1);
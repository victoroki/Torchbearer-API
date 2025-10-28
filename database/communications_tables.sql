-- Create communications table
CREATE TABLE IF NOT EXISTS `communications` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `subject` varchar(255) NOT NULL,
    `content` text NOT NULL,
    `type` enum('email', 'whatsapp') NOT NULL,
    `status` enum('draft', 'queued', 'sending', 'sent', 'failed', 'partially_sent') NOT NULL DEFAULT 'draft',
    `created_by` bigint(20) UNSIGNED NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `communications_created_by_foreign` (`created_by`),
    CONSTRAINT `communications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create communication_recipients table
CREATE TABLE IF NOT EXISTS `communication_recipients` (
    `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `communication_id` bigint(20) UNSIGNED NOT NULL,
    `recipient_type` varchar(255) DEFAULT NULL,
    `recipient_id` bigint(20) UNSIGNED DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `phone` varchar(255) DEFAULT NULL,
    `name` varchar(255) DEFAULT NULL,
    `status` enum('pending', 'sent', 'failed') NOT NULL DEFAULT 'pending',
    `status_message` text DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `communication_recipients_communication_id_foreign` (`communication_id`),
    KEY `communication_recipients_recipient_type_recipient_id_index` (`recipient_type`, `recipient_id`),
    CONSTRAINT `communication_recipients_communication_id_foreign` FOREIGN KEY (`communication_id`) REFERENCES `communications` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
USE `health_record_system`;

-- Drop existing tables in correct order to avoid foreign key conflicts
DROP TABLE IF EXISTS `prescriptions`;
DROP TABLE IF EXISTS `medical_records`;
DROP TABLE IF EXISTS `appointments`;
DROP TABLE IF EXISTS `patients`;
DROP TABLE IF EXISTS `users`;

-- Use your existing database
USE `health_record_system`;

-- 1) Users table (patients, staff, admins)
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT           NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100)    NOT NULL,
  `email` VARCHAR(100)   NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('patient','staff','admin') NOT NULL DEFAULT 'patient',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 2) Patients’ personal info (one-to-one with users)
CREATE TABLE IF NOT EXISTS `patients` (
  `id` INT           NOT NULL AUTO_INCREMENT,
  `user_id` INT      NOT NULL UNIQUE,
  `date_of_birth` DATE        NULL,
  `gender` ENUM('Male','Female','Other') NULL,
  `address` VARCHAR(255)      NULL,
  `phone` VARCHAR(20)         NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 3) Appointments (set by patients; confirmed/updated by staff)
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` INT           NOT NULL AUTO_INCREMENT,
  `patient_id` INT   NOT NULL,
  `staff_id` INT     NULL,
  `appointment_datetime` DATETIME NOT NULL,
  `status` ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`patient_id`) REFERENCES `patients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`staff_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 4) Medical records (created/updated by staff; read by staff & admin)
CREATE TABLE IF NOT EXISTS `medical_records` (
  `id` INT           NOT NULL AUTO_INCREMENT,
  `patient_id` INT   NOT NULL,
  `staff_id` INT     NOT NULL,
  `record_date` DATE       NOT NULL,
  `description` TEXT       NULL,
  `diagnosis` TEXT         NULL,
  `treatment` TEXT         NULL,
  `created_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`patient_id`) REFERENCES `patients`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`staff_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- 5) Prescriptions (added by staff before completing an appointment)
CREATE TABLE IF NOT EXISTS `prescriptions` (
  `id` INT           NOT NULL AUTO_INCREMENT,
  `appointment_id` INT   NOT NULL,
  `staff_id` INT         NOT NULL,
  `patient_id` INT       NOT NULL,
  `prescribed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notes` TEXT           NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`appointment_id`) REFERENCES `appointments`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`staff_id`)       REFERENCES `users`(`id`)        ON DELETE RESTRICT,
  FOREIGN KEY (`patient_id`)     REFERENCES `patients`(`id`)     ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

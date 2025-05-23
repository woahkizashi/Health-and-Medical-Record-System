USE `health_record_system`;

-- Drop old tables in order to avoid foreign key conflicts
DROP TABLE IF EXISTS `appointments`;
DROP TABLE IF EXISTS `medical_records`;
DROP TABLE IF EXISTS `patients`;
DROP TABLE IF EXISTS `users`;

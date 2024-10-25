-- create table student
CREATE TABLE `tbl_student` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`student_id` VARCHAR(50) NULL DEFAULT NULL,
	`khmer_name` VARCHAR(50) NULL DEFAULT NULL,
	`english_name` VARCHAR(50) NULL DEFAULT NULL,
	`gender` VARCHAR(6) NULL DEFAULT NULL,
	`dob` DATE NULL DEFAULT NULL,
	`nationality` VARCHAR(50) NULL DEFAULT NULL,
	`pob` VARCHAR(50) NULL DEFAULT NULL,
	`address` VARCHAR(50) NULL DEFAULT NULL,
	`father_name` VARCHAR(50) NULL DEFAULT NULL,
	`mother_name` VARCHAR(50) NULL DEFAULT NULL,
	`phone_number1` VARCHAR(50) NULL DEFAULT NULL COMMENT 'mother\'s phone',
	`phone_number2` VARCHAR(50) NULL DEFAULT NULL COMMENT 'father\'s phone',
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) COLLATE='utf8mb4_unicode_ci';

-- create table user
CREATE TABLE `tbl_user` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`fullname` VARCHAR(50) NULL DEFAULT NULL,
	`username` VARCHAR(50) NULL DEFAULT NULL,
	`password` VARCHAR(50) NULL DEFAULT NULL,
	`email` VARCHAR(50) NULL DEFAULT NULL,
	`user_type` VARCHAR(30) NULL DEFAULT NULL,
	`image` LONGBLOB NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) COLLATE='utf8mb4_unicode_ci';

-- create table register
CREATE TABLE `tbl_register` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`student_id` VARCHAR(50) NULL DEFAULT NULL,
	`register_date` DATETIME NULL,
	`user_id` INT NULL DEFAULT NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create table payment
CREATE TABLE `tbl_payment` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`invoice_id` VARCHAR(50) NOT NULL DEFAULT '0',
	`student_id` INT NOT NULL DEFAULT 0,
	`recieve` DECIMAL(20,6) NOT NULL DEFAULT 0,
	`discount` DECIMAL(20,6) NOT NULL DEFAULT 0,
	`pay_date` DATETIME NOT NULL DEFAULT 0,
	`expired_date` DATETIME NOT NULL DEFAULT 0,
	`user_id` INT NOT NULL DEFAULT 0,
	`currency_id` INT NOT NULL DEFAULT 1 COMMENT '$ only = base currency',
	`note` VARCHAR(50) NOT NULL DEFAULT '0',
	`class_id` INT NOT NULL DEFAULT 0,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create table class study
/* SQL Error (1075): Incorrect table definition; there can be only one auto column and it must be defined as a key */
CREATE TABLE `tbl_class_study` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`class_id` INT NULL DEFAULT '0',
	`room_id` INT NULL DEFAULT NULL,
	`teacher_id` INT NULL DEFAULT NULL,
	`time_id` INT NULL DEFAULT NULL,
	`create_date` DATETIME NULL DEFAULT NULL,
	`end_date` DATETIME NULL DEFAULT NULL,
	`student_capacity` VARCHAR(50) NULL DEFAULT NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create class study student
CREATE TABLE `tbl_class_study_student` (
	`student_id` INT NOT NULL,
	`class_study_id` INT NOT NULL,
	PRIMARY KEY (`student_id`, `class_study_id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create class study
CREATE TABLE `tbl_class` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`class_name` VARCHAR(50) NULL DEFAULT NULL,
	`description` VARCHAR(50) NULL DEFAULT NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create table room
CREATE TABLE `tbl_room` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`room_label` VARCHAR(50) NULL DEFAULT NULL,
	`description` VARCHAR(50) NULL DEFAULT NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create table time
CREATE TABLE `tbl_time` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`time_lable` VARCHAR(50) NULL DEFAULT NULL,
	`description` VARCHAR(50) NULL DEFAULT NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
)
COLLATE='utf8mb4_unicode_ci';

-- create table teacher
CREATE TABLE `tbl_teacher` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`teacher_id` VARCHAR(50) NULL DEFAULT NULL,
	`khmer_name` VARCHAR(50) NULL DEFAULT NULL,
	`english_name` VARCHAR(50) NULL DEFAULT NULL,
	`gender` VARCHAR(6) NULL DEFAULT NULL,
	`dob` DATE NULL DEFAULT NULL,
	`nationality` VARCHAR(50) NULL DEFAULT NULL,
	`pob` VARCHAR(50) NULL DEFAULT NULL,
	`address` VARCHAR(50) NULL DEFAULT NULL,
	`phone_number1` VARCHAR(50) NULL DEFAULT NULL,
	`phone_number2` VARCHAR(50) NULL DEFAULT NULL,
	`is_deleted` TINYINT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) COLLATE='utf8mb4_unicode_ci';
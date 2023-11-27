CREATE TABLE `users` (
	`staff_id` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`name` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`position` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`no` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`service` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`category` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`email` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`updated_at` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`created_at` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`staff_id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `training` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`code` VARCHAR(50) NOT NULL DEFAULT 'None' COLLATE 'utf8mb4_0900_ai_ci',
	`type` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`category` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`speaker` VARCHAR(255) NOT NULL DEFAULT 'None' COLLATE 'utf8mb4_0900_ai_ci',
	`location` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`price` VARCHAR(50) NOT NULL DEFAULT 'FREE' COLLATE 'utf8mb4_0900_ai_ci',
	`duration` VARCHAR(50) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
	`status` VARCHAR(255) NOT NULL DEFAULT 'On Hold' COLLATE 'utf8mb4_0900_ai_ci',
	`detail` VARCHAR(255) NOT NULL DEFAULT 'NONE' COLLATE 'utf8mb4_0900_ai_ci',
	`remark` VARCHAR(255) NOT NULL DEFAULT 'NONE' COLLATE 'utf8mb4_0900_ai_ci',
	`quantity` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`enroled` INT(10) NOT NULL DEFAULT '0',
	`date` VARCHAR(50) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
	`time_start` TIME NULL DEFAULT NULL,
	`time_end` TIME NULL DEFAULT NULL,
	`sponsor` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`organizer` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`food` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`approve_ceo` VARCHAR(50) NOT NULL DEFAULT 'Pending' COLLATE 'utf8mb4_0900_ai_ci',
	`approve_cno` VARCHAR(50) NOT NULL DEFAULT '' COLLATE 'utf8mb4_0900_ai_ci',
	`approve_hos` VARCHAR(50) NOT NULL DEFAULT 'Pending' COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`code`) USING BTREE,
	INDEX `id` (`id`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
AUTO_INCREMENT=7
;

CREATE TABLE `staff_apply` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`training_code` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`staff_id` VARCHAR(50) NOT NULL DEFAULT 'None' COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `staff-id` (`staff_id`) USING BTREE,
	INDEX `training_code` (`training_code`) USING BTREE,
	CONSTRAINT `Scode` FOREIGN KEY (`training_code`) REFERENCES `training` (`code`) ON UPDATE CASCADE ON DELETE NO ACTION,
	CONSTRAINT `Sstaff.id` FOREIGN KEY (`staff_id`) REFERENCES `users` (`staff_id`) ON UPDATE CASCADE ON DELETE NO ACTION
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;

CREATE TABLE `notification` (
	`id` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`staff_id` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`noti-details` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`time` TIME NOT NULL,
	INDEX `id` (`id`) USING BTREE,
	INDEX `N_staff_id` (`staff_id`) USING BTREE,
	CONSTRAINT `Nstaff_id` FOREIGN KEY (`staff_id`) REFERENCES `users` (`staff_id`) ON UPDATE CASCADE ON DELETE NO ACTION
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

CREATE TABLE `migrations` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`migration` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`batch` INT(10) NOT NULL,
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;

CREATE TABLE `auth` (
	`ID` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`password` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	`new_password` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_0900_ai_ci',
	PRIMARY KEY (`password`) USING BTREE
)
COLLATE='utf8mb4_0900_ai_ci'
ENGINE=InnoDB
;

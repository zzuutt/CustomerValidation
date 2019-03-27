
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- customer_validation
-- ---------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `customer_validation`
(
    `id` INTEGER NOT NULL,
    `status` TINYINT DEFAULT 0,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_customer_validation_customer_id`
        FOREIGN KEY (`id`)
        REFERENCES `customer` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- customer_validation_status
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `customer_validation_status`;
CREATE TABLE IF NOT EXISTS `customer_validation_status`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(45) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `code_UNIQUE` (`code`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- customer_validation_status_i18n
-- ---------------------------------------------------------------------
DROP TABLE IF EXISTS `customer_validation_status_i18n`;
CREATE TABLE IF NOT EXISTS `customer_validation_status_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `title` VARCHAR(255),
    `description` LONGTEXT,
    `chapo` TEXT,
    `postscriptum` TEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `customer_validation_status_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `customer_validation_status` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

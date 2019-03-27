SET FOREIGN_KEY_CHECKS = 0;

UPDATE `customer_validation_status_i18n` SET `locale` = 'en_US' WHERE `customer_validation_status_i18n`.`id` = 1 AND `customer_validation_status_i18n`.`locale` = 'en_EN';
UPDATE `customer_validation_status_i18n` SET `locale` = 'en_US' WHERE `customer_validation_status_i18n`.`id` = 2 AND `customer_validation_status_i18n`.`locale` = 'en_EN';
UPDATE `customer_validation_status_i18n` SET `locale` = 'en_US' WHERE `customer_validation_status_i18n`.`id` = 3 AND `customer_validation_status_i18n`.`locale` = 'en_EN';

SET FOREIGN_KEY_CHECKS = 1;

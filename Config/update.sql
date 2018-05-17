SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE `customer_validation`, `customer_validation_status`, `customer_validation_status_i18n`;
# This restores the fkey checks, after having unset them earlier

SET FOREIGN_KEY_CHECKS = 1;
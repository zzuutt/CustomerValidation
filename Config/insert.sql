SET FOREIGN_KEY_CHECKS = 0;

SELECT @max_id := IFNULL(MAX(`id`),0) FROM `customer_validation_status`;

INSERT INTO `customer_validation_status` (`id`, `code`, `created_at`, `updated_at`) VALUES
  (@max_id + 1, 'waiting', NULL, NULL),
  (@max_id + 2, 'valid', NULL, NULL),
  (@max_id + 3, 'refuse', NULL, NULL)
;

INSERT INTO `customer_validation_status_i18n` (`id`, `locale`, `title`, `description`, `chapo`, `postscriptum`) VALUES
  (@max_id + 1, 'en_EN','Waiting', '', '', ''),
  (@max_id + 2, 'en_EN','Valid', '', '', ''),
  (@max_id + 3, 'en_EN','Refuse', '', '', ''),
  (@max_id + 1, 'fr_FR','En attente', '', '', ''),
  (@max_id + 2, 'fr_FR','Validé', '', '', ''),
  (@max_id + 3, 'fr_FR','Refusé', '', '', '')
;

-- ---------------------------------------------------------------------
-- Mail templates
-- ---------------------------------------------------------------------

-- First, delete existing entries
SET @var := 0;
SELECT @var := `id` FROM `message` WHERE name="mail_customer_validation";
DELETE FROM `message` WHERE `id`=@var;
-- Try if ON DELETE constraint isn't set
DELETE FROM `message_i18n` WHERE `id`=@var;

-- Then add new entries
SELECT @max := MAX(`id`) FROM `message`;
SET @max := @max+1;
-- insert message
INSERT INTO `message` (`id`, `name`, `secured`) VALUES
  (@max,
   'mail_customer_validation',
   '0'
  );

-- and template fr_FR
INSERT INTO `message_i18n` (`id`, `locale`, `title`, `subject`, `text_message`, `html_message`) VALUES
  (@max, 'en_US', 'Customer validation message', 'A {config key="store_name"} account has been validated', '{loop type="customer" name="customer.order" current="false" id="$customer_id" backend_context="1"}\r\nDear {$FIRSTNAME} {$LASTNAME},\r\n{/loop}\r\nYour account at {config key="store_name"} has been validated by one of our managers.\r\nFeel free to contact us for any forther information\r\nBest Regards.', '{loop type="customer" name="customer.order" current="false" id="$customer_id" backend_context="1"}\r\nDear {$FIRSTNAME} {$LASTNAME},<br /><br />{/loop}\r\nYour account at {config key="store_name"} has been validated by one of our managers.<br />Feel free to contact us for any forther information<br /><br />nBest Regards.'),
  (@max, 'fr_FR', 'Message validation Client', 'Votre compte {config key="store_name"} a été validé', '{loop type="customer" name="customer.order" current="false" id="$customer_id" backend_context="1"}\r\nBonjour {$FIRSTNAME} {$LASTNAME},\r\n{/loop}\r\nVotre compte {config key="store_name"} a été validé par l\'administrateur.\r\nN\'hésitez pas à nous contacter pour toute information complémentaire.\r\nCordialement.', '{loop type="customer" name="customer.order" current="false" id="$customer_id" backend_context="1"}\r\nBonjour {$FIRSTNAME} {$LASTNAME},<br /><br />{/loop}\r\nVotre compte {config key="store_name"} a été validé par l\'administrateur.<br />N\'hésitez pas à nous contacter pour toute information complémentaire.<br /><br />Cordialement.');

SET FOREIGN_KEY_CHECKS = 1;
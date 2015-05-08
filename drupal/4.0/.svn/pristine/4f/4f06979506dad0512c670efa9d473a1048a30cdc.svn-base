/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.1.61 : Database - covidiendb
*********************************************************************
*/

/*Table structure for table `alert_state` */

DROP TABLE IF EXISTS `covidiendb`.`alert_state`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_state` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `notification_status_name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
COMMENT = 'Pending\nSent\nDuplicate \nSuppressed \nAcknowledged\nResolved\nCl /* comment truncated */ /*osed*/';

INSERT INTO `covidiendb`.`alert_state`(name) values('Pending');
INSERT INTO `covidiendb`.`alert_state`(name) values('Sent');
INSERT INTO `covidiendb`.`alert_state`(name) values('Duplicate');
INSERT INTO `covidiendb`.`alert_state`(name) values('Suppresses');
INSERT INTO `covidiendb`.`alert_state`(name) values('Acknowledged');
INSERT INTO `covidiendb`.`alert_state`(name) values('Resolved');
INSERT INTO `covidiendb`.`alert_state`(name) values('Closed');
/*Data for the table `alert_state` */

/*Table structure for table `alert_state_transition` */

DROP TABLE IF EXISTS `covidiendb`.`alert_state_transition`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_state_transition` (
  `from_alert_state_id` INT(10) NOT NULL,
  `to_alert_state_id` INT(10) NOT NULL,
  INDEX `alert_state_transition_alert_state_fk1_idx` (`from_alert_state_id` ASC),
  INDEX `alert_state_transition_alert_state_fk2_idx` (`to_alert_state_id` ASC),
  CONSTRAINT `alert_state_transition_alert_state_fk1`
    FOREIGN KEY (`from_alert_state_id`)
    REFERENCES `covidiendb`.`alert_state` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `alert_state_transition_alert_state_fk2`
    FOREIGN KEY (`to_alert_state_id`)
    REFERENCES `covidiendb`.`alert_state` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `alert_state_transition` */


/*Table structure for table `covidiendb`.`alert_category` */

DROP TABLE IF EXISTS `covidiendb`.`alert_category`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_category` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '- Notification\n- Business (alert)\n- Technical ';

INSERT INTO `covidiendb`.`alert_category` (`name`) VALUES ('Information');
INSERT INTO `covidiendb`.`alert_category` (`name`) VALUES ('Business');
INSERT INTO `covidiendb`.`alert_category` (`name`) VALUES ('Technic');


/*Data for the table `covidiendb`.`alert_category` */

/*Table structure for table `alert_event` */

DROP TABLE IF EXISTS `covidiendb`.`alert_event`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_event` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(500) NULL,
  `category_id` INT(10) NOT NULL,
  `alert_event_external_ref` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_alert_event_category_idx` (`category_id` ASC),
  UNIQUE INDEX `alert_event_external_ref_UNIQUE` (`alert_event_external_ref` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  CONSTRAINT `fk_alert_event_category`
    FOREIGN KEY (`category_id`)
    REFERENCES `covidiendb`.`alert_category` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Device Configuration Change', 'A device\'s configuration has changed (discrepancy report)', (select id from `covidiendb`.`alert_category` where name='Business'));
INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Invalid Device Configuration', 'Invalid Configuration Alert - An invalid device configuration was detected', (select id from `covidiendb`.`alert_category` where name='Business'));
INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Software Upgrade Failed', 'Upgrade Failed Alert - A software upgrade package has failed or installation was incomplete', (select id from `covidiendb`.`alert_category` where name='Business'));
INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Device Country Not Match', 'The country sent by the Client is diffenrent from the Device record in server', (select id from `covidiendb`.`alert_category` where name='Business'));
INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Serial Number Change', 'Serial Number changed (realigned).', (select id from `covidiendb`.`alert_category` where name='Business'));
INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Feature Enablement', 'Feature enablement', (select id from `covidiendb`.`alert_category` where name='Business'));
INSERT INTO `covidiendb`.`alert_event` (name,description,category_id) values('Non-Covidien User Upgrade', 'When a non-Covidien user attempts to upgrade SW on a device which is assigned to an account number which is not the user\'s account number (RMS only)', (select id from `covidiendb`.`alert_category` where name='Business'));

/*Data for the table `alert_event` */

/*Table structure for table `device_type_alert_event_relation` */

DROP TABLE IF EXISTS `covidiendb`.`device_type_alert_event_relation`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`device_type_alert_event_relation` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `alert_event_id` INT(10) NOT NULL,
  `enable_flag` ENUM('Y','N') NOT NULL,
  `device_type_nid` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `alert_event_relation_alert_event_fk1_idx` (`alert_event_id` ASC),
  INDEX `alert_event_relation_device_type_fk1_idx` (`device_type_nid` ASC),
  CONSTRAINT `alert_event_relation_alert_event_fk1`
    FOREIGN KEY (`alert_event_id`)
    REFERENCES `covidiendb`.`alert_event` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `device_type_alert_event_relation` */

/*Table structure for table `alert_transport_type` */

DROP TABLE IF EXISTS `covidiendb`.`alert_transport_type`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_transport_type` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `description` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `notification_transport_type_name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;

INSERT INTO `covidiendb`.`alert_transport_type` (name,description) values('Email', 'Send notification by email');

/*Data for the table `alert_transport_type` */

/*Table structure for table `alert` */

DROP TABLE IF EXISTS `covidiendb`.`alert`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `device_type_nid` INT(10) NOT NULL,
  `create_datetime` DATETIME NOT NULL,
  `alert_state_id` INT(10) NOT NULL,
  `alert_event_id` INT(10) NOT NULL,
  `device_nid` INT(10) NOT NULL,
  `reason` VARCHAR(200) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_alert_alert_state_idx` (`alert_state_id` ASC),
  INDEX `fk_alert_alert_event_idx` (`alert_event_id` ASC),
  INDEX `fk_alert_device_idx` (`device_nid` ASC),
  CONSTRAINT `fk_alert_alert_state`
    FOREIGN KEY (`alert_state_id`)
    REFERENCES `covidiendb`.`alert_state` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_alert_alert_event_type`
    FOREIGN KEY (`alert_event_id`)
    REFERENCES `covidiendb`.`alert_event` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;
/*Data for the table `alert` */

/*Table structure for table `alert_comment` */

DROP TABLE IF EXISTS `covidiendb`.`alert_comment`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_comment` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `comment` VARCHAR(512) NULL,
  `create_time` INT(11) NOT NULL,
  `last_change_time` DATETIME NOT NULL,
  `person_nid` INT NOT NULL,
  `alert_id` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `alert_comment_person_fk1_idx` (`person_nid` ASC),
  INDEX `alert_comment_alert_fk1_idx` (`alert_id` ASC),
  CONSTRAINT `alert_comment_alert_fk1`
    FOREIGN KEY (`alert_id`)
    REFERENCES `covidiendb`.`alert` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `alert_comment` */

/*Table structure for table `alert_state_history` */

DROP TABLE IF EXISTS `covidiendb`.`alert_state_history`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_state_history` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `create_datetime` DATETIME NOT NULL,
  `alert_id` INT(10) NOT NULL,
  `alert_state_id` INT(10) NOT NULL,
  `person_nid` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `alert_state_history_alert_fk1_idx` (`alert_id` ASC),
  INDEX `alert_state_history_alert_state_fk1_idx` (`alert_state_id` ASC),
  INDEX `alert_state_history_person_fk1_idx` (`person_nid` ASC),
  CONSTRAINT `alert_state_history_alert_fk1`
    FOREIGN KEY (`alert_id`)
    REFERENCES `covidiendb`.`alert` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `alert_state_history_alert_state_fk1`
    FOREIGN KEY (`alert_state_id`)
    REFERENCES `covidiendb`.`alert_state` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `alert_state_history` */

/*Table structure for table `person_alert_event_subscription` */

DROP TABLE IF EXISTS `covidiendb`.`person_alert_event_subscription`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`person_alert_event_subscription` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `device_type_nid` INT(10) NOT NULL,
  `person_nid` INT(10) NOT NULL,
  `active_flag` ENUM('Y','N') NOT NULL,
  `device_scope` ENUM('A','M') NOT NULL COMMENT 'If this value is \'Y\' then person gets all possible alerts based on their application role assignment.\nIf this value is \'M\' then person gets all alerts based on the device belongs to himself.',
  `device_type_alert_event_relation_id` INT(10) NOT NULL,
  INDEX `person_alert_subscription_device_typ_fk1_idx` (`device_type_nid` ASC),
  PRIMARY KEY (`id`),
  INDEX `person_alert_subscription_person_fk1_idx` (`person_nid` ASC),
  INDEX `person_alert_device_type_alert_event_relation_fk1_idx` (`device_type_alert_event_relation_id` ASC),
  CONSTRAINT `person_alert_device_type_alert_event_relation_fk1`
    FOREIGN KEY (`device_type_alert_event_relation_id`)
    REFERENCES `covidiendb`.`device_type_alert_event_relation` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `person_alert_event_subscription` */

/*Table structure for table `person_alert_country` */

DROP TABLE IF EXISTS `covidiendb`.`person_alert_country`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`person_alert_country` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `country_nid` INT(10) NOT NULL,
  `person_nid` INT(10) NOT NULL,
  `device_type_nid` INT(10) NOT NULL,
  `alert_category_id` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `person_alert_country_country_fk1_idx` (`country_nid` ASC),
  INDEX `person_alert_country_person_fk1_idx` (`person_nid` ASC),
  INDEX `person_alert_country_device_type_fk1_idx` (`device_type_nid` ASC),
  INDEX `person_alert_country_alert_category_fk1_idx` (`alert_category_id` ASC),
  CONSTRAINT `person_alert_country_alert_category_fk1`
    FOREIGN KEY (`alert_category_id`)
    REFERENCES `covidiendb`.`alert_category` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `person_alert_country` */

/*Table structure for table `person_alert_transport` */

DROP TABLE IF EXISTS `covidiendb`.`person_alert_transport`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`person_alert_transport` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `device_type_nid` INT(10) NOT NULL,
  `alert_category_id` INT(10) NOT NULL,
  `alert_transport_type_id` INT(10) NOT NULL,
  `person_nid` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `person_alert_delivery_device_type_fk1_idx` (`device_type_nid` ASC),
  INDEX `person_alert_transport_alert_transport_fk1_idx` (`alert_transport_type_id` ASC),
  INDEX `person_alert_transport_alert_category_fk1_idx` (`alert_category_id` ASC),
  INDEX `person_alert_transport_person_fk1_idx` (`person_nid` ASC),
  CONSTRAINT `person_alert_transport_alert_transport_fk1`
    FOREIGN KEY (`alert_transport_type_id`)
    REFERENCES `covidiendb`.`alert_transport_type` (`id`)
    ON DELETE CASCADE
    ON UPDATE RESTRICT,
  CONSTRAINT `person_alert_transport_alert_category_fk1`
    FOREIGN KEY (`alert_category_id`)
    REFERENCES `covidiendb`.`alert_category` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `person_alert_transport` */

/*Table structure for table `alert_message_template` */

DROP TABLE IF EXISTS `covidiendb`.`alert_message_template`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`alert_message_template` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `template_path` VARCHAR(200) NOT NULL,
  `description` VARCHAR(500) NULL,
  `alert_event_id` INT(10) NOT NULL,
  `alert_transport_type_id` INT(10) NOT NULL,
  `message_subject_text` VARCHAR(100) NULL,
  PRIMARY KEY (`id`),
  INDEX `alert_message_template_alert_event_fk1_idx` (`alert_event_id` ASC),
  INDEX `alert_message_template_alert_transport_type_fk1_idx` (`alert_transport_type_id` ASC),
  CONSTRAINT `alert_message_template_alert_event_fk1`
    FOREIGN KEY (`alert_event_id`)
    REFERENCES `covidiendb`.`alert_event` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `alert_message_template_alert_transport_type_fk1`
    FOREIGN KEY (`alert_transport_type_id`)
    REFERENCES `covidiendb`.`alert_transport_type` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `alert_message_template` */

/*Table structure for table `device_type_alert_template_relation` */

DROP TABLE IF EXISTS `covidiendb`.`device_type_alert_template_relation`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`device_type_alert_template_relation` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `alert_message_template_id` INT(10) NOT NULL,
  `device_type_nid` INT(10) NOT NULL,
  INDEX `device_type_alert_message_template_fk1_idx` (`alert_message_template_id` ASC),
  PRIMARY KEY (`id`),
  INDEX `device_type_alert_template_device_type_fk1_idx` (`device_type_nid` ASC),
  UNIQUE INDEX `alert_message_template_id_UNIQUE` (`alert_message_template_id` ASC),
  CONSTRAINT `device_type_alert_message_template_fk1`
    FOREIGN KEY (`alert_message_template_id`)
    REFERENCES `covidiendb`.`alert_message_template` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `device_type_alert_template_relation` */

/*Table structure for table `application_role_alert` */

DROP TABLE IF EXISTS `covidiendb`.`application_role_alert`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`application_role_alert` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `application_role_pk` INT(10) NOT NULL,
  `active_flag` ENUM('Y','N') NOT NULL,
  `device_type_alert_template_association_id` INT(10) NOT NULL,
  INDEX `application_role_idx` (`application_role_pk` ASC),
  PRIMARY KEY (`id`),
  INDEX `application_role_alert_device_type_alert_template_fk1_idx` (`device_type_alert_template_association_id` ASC),
  CONSTRAINT `application_role_alert_device_type_alert_template_fk1`
    FOREIGN KEY (`device_type_alert_template_association_id`)
    REFERENCES `covidiendb`.`device_type_alert_template_relation` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `application_role_alert` */

/*Table structure for table `technical_notification` */

DROP TABLE IF EXISTS `covidiendb`.`technical_notification`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`technical_notification` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `notification_name` VARCHAR(100) NOT NULL,
  `from_date` DATETIME NULL,
  `to_date` DATETIME NULL,
  `active_status` ENUM('Y','N') NOT NULL,
  `notification_state` INT(10) NOT NULL,
  `message_text` VARCHAR(128) NULL,
  `summary` VARCHAR(1500) NULL,
  `create_time` DATETIME NOT NULL,
  `alert_event_id` INT(10) NOT NULL,
  `display_flag` ENUM('Y','N') NOT NULL DEFAULT 'N',
  `time_zone` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  INDEX `tech_notification_from_idx` (`from_date` ASC, `notification_state` ASC),
  INDEX `tech_notification_to_idx` (`to_date` ASC, `notification_state` ASC),
  INDEX `tech_notification_from_to_idx` (`from_date` ASC, `to_date` ASC, `notification_state` ASC),
  INDEX `tech_notification_alert_event_fk1_idx` (`alert_event_id` ASC),
  INDEX `technical_notification_alert_state_fk1_idx` (`notification_state` ASC),
  CONSTRAINT `technical_notification_alert_event_fk1`
    FOREIGN KEY (`alert_event_id`)
    REFERENCES `covidiendb`.`alert_event` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `technical_notification_alert_state_fk1`
    FOREIGN KEY (`notification_state`)
    REFERENCES `covidiendb`.`alert_state` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


/*Data for the table `technical_notification` */

/*Table structure for table `technical_notification_schedule` */

DROP TABLE IF EXISTS `covidiendb`.`technical_notification_schedule`;

CREATE TABLE IF NOT EXISTS `covidiendb`.`technical_notification_schedule` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `technical_notification_id` INT(10) NOT NULL,
  `active_status` ENUM('Y','N') NULL,
  `on_completion_flag` ENUM('Y','N') NULL,
  `internal_only_flag` ENUM('Y','N') NULL,
  `schedule_date` DATETIME NOT NULL,
  `alert_message_template_id` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `notification_schedule_technical_notification_fk1_idx` (`technical_notification_id` ASC),
  INDEX `notification_schedule_alert_message_template_fk1_idx` (`alert_message_template_id` ASC),
  CONSTRAINT `notification_schedule_technical_notification_fk1`
    FOREIGN KEY (`technical_notification_id`)
    REFERENCES `covidiendb`.`technical_notification` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `notification_schedule_alert_message_template_fk1`
    FOREIGN KEY (`alert_message_template_id`)
    REFERENCES `covidiendb`.`alert_message_template` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

/*Data for the table `technical_notification_schedule` */

USE `covidiendb`;

/*Table structure for table `firmware` */

--DROP TABLE IF EXISTS `firmware`;

CREATE TABLE `firmware` (
  `vid` int(11) NOT NULL,
  `nid` int(11) NOT NULL,
  `part` varchar(50) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `device_type_id` int(10) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `file_id` int(10) DEFAULT NULL,
  `file_integrity_check_value` varchar(50) DEFAULT NULL,
  `type_id` int(10) DEFAULT '0',
  `status` int(10) DEFAULT '0',
  PRIMARY KEY (`vid`,`nid`),
  KEY `fm_nid_idx` (`nid`),
  KEY `fm_vid_idx` (`vid`),
  KEY `fm_pt_version_idx` (`part`,`version`),
  KEY `fm_device_type_nid_idx` (`device_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `firmware` */

--insert  into `firmware`(`vid`,`nid`,`part`,`version`,`device_type_id`,`description`,`file`,`file_id`,`file_integrity_check_value`,`create_time`,`update_time`,`type_id`,`status`) values (0,5017,'1','1',43,'1','body_logo.png',87,NULL,'2014-03-21 10:10:20','2014-03-24 10:15:02',0,1),(5023,5023,'1','1',43,'1','Training_Report.pdf',88,NULL,'2014-03-26 11:19:13','2014-03-26 11:19:13',0,1);

/*Table structure for table `firmware_status` */

--DROP TABLE IF EXISTS `firmware_status`;

CREATE TABLE `firmware_status` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `firmware_status` */

--insert  into `firmware_status`(`id`,`name`) values (1,'Limited RELEASE'),(2,'IN Production'),(3,'Archived');

/*Table structure for table `firmware_type` */

--DROP TABLE IF EXISTS `firmware_type`;

CREATE TABLE `firmware_type` (
  `id` int(10) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `firmware_type` */

--insert  into `firmware_type`(`id`,`name`) values (0,'FirmwareType1'),(1,'Firmware2');

/*Table structure for table `named_configuration_status` */

--DROP TABLE IF EXISTS `named_configuration_status`;

CREATE TABLE `named_configuration_status` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `named_configuration` */

--insert  into `named_configuration_status`(`id`,`name`) values (0,'Limited Release'),(1,'In Production'),(2,'Obsolete');

/*Table structure for table `named_configuration` */

--DROP TABLE IF EXISTS `named_configuration`;

CREATE TABLE `named_configuration` (
  `nid` int(11) NOT NULL,
  `type_id` tinyint(4) DEFAULT '0',
  `device_type_id` int(11) DEFAULT NULL,
  `version` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `is_deleted` tinyint(4) DEFAULT '0',
  `obsolete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`nid`),
  KEY `named_cfg_type_nid_idx` (`type_id`,`nid`),
  KEY `named_cfg_device_type_nid_idx` (`device_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*Data for the table `named_configuration` */

--insert  into `named_configuration`(`nid`,`type_id`,`device_type_id`,`version`,`create_time`,`update_time`,`description`,`is_deleted`,`is_obsolete`) values (5012,5,43,'1','2014-03-20 15:17:22','2014-03-20 15:17:22','1',0,1),(5013,6,43,'1','2014-03-20 15:39:18','2014-03-20 15:39:18','1',0,1),(5014,6,43,'2.0','2014-03-20 15:41:15','2014-03-20 15:45:49','2.0',0,1),(5015,8,43,'1','2014-03-21 09:05:07','2014-03-21 09:58:20','1',0,1),(5022,7,43,'1','2014-03-26 11:17:57','2014-03-26 11:17:57','1',0,1);

/*Table structure for table `named_configuration_relation` */

--DROP TABLE IF EXISTS `named_configuration_relation`;

CREATE TABLE `named_configuration_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `left_nid` int(11) NOT NULL DEFAULT '0' COMMENT 'config id or item id',
  `left_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'link to named_configuration_type id',
  `right_nid` int(11) NOT NULL DEFAULT '0' COMMENT 'config id or item id',
  `right_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'link to named_configuration_type id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `required` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:not required, 1:left required, 2:right required',
  PRIMARY KEY (`id`),
  KEY `named_cfg_rlt_left_type_idx` (`left_type`,`left_nid`),
  KEY `named_cfg_rlt_left_nid_idx` (`left_nid`),
  KEY `named_cfg_rlt_right_nid_idx` (`right_nid`),
  KEY `named_cfg_rlt_right_type_idx` (`right_nid`,`right_type`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;

/*Data for the table `named_configuration_relation` */

--insert  into `named_configuration_relation`(`id`,`left_nid`,`left_type`,`right_nid`,`right_type`,`create_time`,`update_time`,`required`) values (1,5012,5,3049,1,'2014-03-20 15:17:22','2014-03-20 15:17:22',0),(2,5013,6,3050,2,'2014-03-20 15:39:18','2014-03-20 15:39:18',0),(6,5014,6,3050,2,'2014-03-20 15:45:49','2014-03-20 15:45:49',0),(7,5014,6,3111,2,'2014-03-20 15:45:49','2014-03-20 15:45:49',0),(12,5015,8,5012,5,'2014-03-21 09:58:20','2014-03-21 09:58:20',0),(13,5015,8,5013,6,'2014-03-21 09:58:20','2014-03-21 09:58:20',0),(14,5016,3,0,5,'2014-03-21 10:06:55','2014-03-21 10:06:55',0),(16,5018,3,0,5,'2014-03-24 09:25:42','2014-03-24 09:25:42',0),(17,5019,3,5012,5,'2014-03-24 09:29:24','2014-03-24 09:29:24',0),(18,5020,3,5012,5,'2014-03-24 09:30:22','2014-03-24 09:30:22',0),(19,5021,3,5012,5,'2014-03-24 09:34:05','2014-03-24 09:34:05',0),(32,5017,3,5012,5,'2014-03-24 10:15:02','2014-03-24 10:15:02',0),(33,5022,7,0,3,'2014-03-26 11:17:57','2014-03-26 11:17:57',0),(34,5023,3,5012,5,'2014-03-26 11:19:13','2014-03-26 11:19:13',0);

/*Table structure for table `named_configuration_type` */

--DROP TABLE IF EXISTS `named_configuration_type`;

CREATE TABLE `named_configuration_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'reference type id',
  `name` varchar(255) DEFAULT NULL COMMENT 'reference type name',
  `title` varchar(255) DEFAULT NULL COMMENT 'reference type display title',
  `display` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'display on select configuration on web, order by display no',
  `wight` int(11) DEFAULT '0' COMMENT 'display order',
  `link_type_id` varchar(255) NOT NULL COMMENT 'types can be found through current id',
  PRIMARY KEY (`id`),
  KEY `named_cfg_type_name_idx` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `named_configuration_type` */

--insert  into `named_configuration_type`(`id`,`name`,`title`,`display`,`wight`,`link_type_id`) values (1,'hardware_item','Hardware Item',0,0,'0'),(2,'software_item','Software Item',0,0,'5'),(3,'firmware_item','Firmware Item',0,0,'5'),(4,'document_item','Docoment Item',0,0,'5,6,7'),(5,'hardware_configuration','Named Hardware Configuration',1,3,'1'),(6,'software_configuration','Named Software Configuration',1,4,'2'),(7,'firmware_configuration','Named Firmware Configuration',1,5,'3'),(8,'system_configuration','Named System Configuration',1,2,'5,6,7'),(9,'device_configuration','Device Configuration',0,1,'8');

DROP TABLE IF EXISTS `Configuration_update_VW`;

DROP TABLE IF EXISTS `Country_VW`;

DROP TABLE IF EXISTS `Customer_VW`;

DROP TABLE IF EXISTS `Device_VW`;

DROP TABLE IF EXISTS `Hardware_VW`;

DROP TABLE IF EXISTS `Software_VW`;

DROP TABLE IF EXISTS `config_hw_sw_view`;

DROP TABLE IF EXISTS `device_component_discrepancy_view`;

DROP TABLE IF EXISTS `device_emerald_software_version_view`;

DROP TABLE IF EXISTS `device_scd700_software_version_view`;

DROP TABLE IF EXISTS `device_service_history_VW`;

DROP TABLE IF EXISTS `device_service_history_view`;

DROP TABLE IF EXISTS `device_software_upgrade_view`;

DROP TABLE IF EXISTS `device_software_version_view`;

DROP TABLE IF EXISTS `discrepancy_list_VW`;

DROP TABLE IF EXISTS `hw_discrepancy_list_VW`;

DROP TABLE IF EXISTS `select_service_history_VW1`;

DROP TABLE IF EXISTS `sw_discrepancy_list_VW`;

DROP TABLE IF EXISTS `training_record_view`;

DROP TABLE IF EXISTS `view_device_sw_configuration`;

DROP TABLE IF EXISTS `view_device_type`;

DROP TABLE IF EXISTS `view_firmware`;

DROP TABLE IF EXISTS `view_hardware`;

DROP TABLE IF EXISTS `view_named_configuration`;

DROP TABLE IF EXISTS `view_named_configuration_relation`;

DROP TABLE IF EXISTS `view_named_firmware_configuration`;

DROP TABLE IF EXISTS `view_named_hardware_configuration`;

DROP TABLE IF EXISTS `view_named_software_configuration`;

DROP TABLE IF EXISTS `view_named_system_configuration`;

DROP TABLE IF EXISTS `view_software`;

DROP VIEW IF EXISTS `Configuration_update_VW`;

DROP VIEW IF EXISTS `Country_VW`;

DROP VIEW IF EXISTS `Customer_VW`;

DROP VIEW IF EXISTS `Device_VW`;

DROP VIEW IF EXISTS `Hardware_VW`;

DROP VIEW IF EXISTS `Software_VW`;

DROP VIEW IF EXISTS `config_hw_sw_view`;

DROP VIEW IF EXISTS `device_component_discrepancy_view`;

DROP VIEW IF EXISTS `device_emerald_software_version_view`;

DROP VIEW IF EXISTS `device_scd700_software_version_view`;

DROP VIEW IF EXISTS `device_service_history_VW`;

DROP VIEW IF EXISTS `device_service_history_view`;

DROP VIEW IF EXISTS `device_software_upgrade_view`;

DROP VIEW IF EXISTS `device_software_version_view`;

DROP VIEW IF EXISTS `discrepancy_list_VW`;

DROP VIEW IF EXISTS `hw_discrepancy_list_VW`;

DROP VIEW IF EXISTS `select_service_history_VW1`;

DROP VIEW IF EXISTS `sw_discrepancy_list_VW`;

DROP VIEW IF EXISTS `training_record_view`;

DROP VIEW IF EXISTS `view_device_sw_configuration`;

DROP VIEW IF EXISTS `view_device_type`;

DROP VIEW IF EXISTS `view_firmware`;

DROP VIEW IF EXISTS `view_hardware`;

DROP VIEW IF EXISTS `view_named_configuration`;

DROP VIEW IF EXISTS `view_named_configuration_relation`;

DROP VIEW IF EXISTS `view_named_firmware_configuration`;

DROP VIEW IF EXISTS `view_named_hardware_configuration`;

DROP VIEW IF EXISTS `view_named_software_configuration`;

DROP VIEW IF EXISTS `view_named_system_configuration`;

DROP VIEW IF EXISTS `view_software`;

/*View structure for view Configuration_update_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `Configuration_update_VW` AS select max(`content_type_device_service_history`.`field_service_datetime_value`) AS `lastest_date`,`content_field_device_pk`.`field_device_pk_nid` AS `component_device` from ((`content_type_device_service_history` join `content_field_device_pk` on(((`content_type_device_service_history`.`vid` = `content_field_device_pk`.`vid`) and (`content_type_device_service_history`.`nid` = `content_field_device_pk`.`nid`)))) join `node` on((`content_type_device_service_history`.`field_device_service_type_nid` = `node`.`nid`))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`node`.`title` = 'Configuration Update')) group by `content_field_device_pk`.`field_device_pk_nid`;

/*View structure for view Country_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `Country_VW` AS select `content_field_device_pk`.`field_device_pk_nid` AS `device_nid`,`node2`.`nid` AS `country_nid`,`node2`.`title` AS `country_name` from (((`content_field_device_pk` join `content_type_device_installation` on((`content_type_device_installation`.`vid` = `content_field_device_pk`.`vid`))) left join `content_type_country` on((`content_type_device_installation`.`field_device_country_nid` = `content_type_country`.`nid`))) left join `node` `node2` on((`node2`.`vid` = `content_type_country`.`vid`)));

/*View structure for view Customer_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `Customer_VW` AS select `content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`node3`.`title` AS `customername`,`node3`.`nid` AS `customer_nid` from ((`content_type_party` join `content_type_bu_customer` on((`content_type_bu_customer`.`field_customer_party_pk_nid` = `content_type_party`.`nid`))) join `node` `node3` on((`node3`.`nid` = `content_type_bu_customer`.`field_customer_party_pk_nid`)));

/*View structure for view Device_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `Device_VW` AS select `node`.`title` AS `productline`,`node`.`nid` AS `productline_nid`,`node1`.`title` AS `devicetype`,`content_type_devicetype`.`nid` AS `devicetype_nid`,`content_type_device`.`nid` AS `device_nid`,`content_type_device`.`field_device_owner_nid` AS `device_owner`,`content_type_device`.`field_device_serial_number_value` AS `deviceserial` from (((((`node` join `content_field_device_product_line` on((`content_field_device_product_line`.`field_device_product_line_nid` = `node`.`nid`))) join `content_type_devicetype` on(((`content_type_devicetype`.`nid` = `content_field_device_product_line`.`nid`) and (`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`)))) join `node` `node1` on(((`node1`.`nid` = `content_type_devicetype`.`nid`) and (`node1`.`vid` = `content_type_devicetype`.`vid`)))) join `content_field_device_type` on((`content_field_device_type`.`field_device_type_nid` = `content_type_devicetype`.`nid`))) join `content_type_device` on((`content_type_device`.`nid` = `content_field_device_type`.`nid`)));

/*View structure for view Hardware_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `Hardware_VW` AS select `content_type_hardware`.`nid` AS `hardware_nid`,`content_type_hardware`.`field_hw_part_value` AS `hardware_part`,`content_type_hardware`.`field_hw_version_value` AS `hardware_version`,`content_type_device_component_history`.`field_device_component_nid` AS `hardware_component`,`content_type_device_component_history`.`field_component_device_nid` AS `component_device`,`node`.`title` AS `hardware_name` from (((`content_type_hardware` join `content_type_device_component_history` on((`content_type_device_component_history`.`field_device_component_nid` = `content_type_hardware`.`nid`))) join `node` on(((`node`.`nid` = `content_type_hardware`.`nid`) and (`node`.`vid` = `content_type_hardware`.`vid`)))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_device_component_history`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_device_component_history`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`))));

/*View structure for view Software_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `Software_VW` AS select `content_type_software`.`nid` AS `software_nid`,`content_type_software`.`field_sw_part_value` AS `software_part`,`content_type_software`.`field_sw_version_value` AS `software_version`,`content_type_device_component_history`.`field_device_component_nid` AS `software_component`,`content_type_device_component_history`.`field_component_device_nid` AS `component_device`,max(`content_type_device_service_history`.`field_service_datetime_value`) AS `lastest_sw_update`,`node`.`title` AS `software_name` from (((((((`content_type_software` join `content_type_device_component_history` on((`content_type_device_component_history`.`field_device_component_nid` = `content_type_software`.`nid`))) join `node` on(((`node`.`nid` = `content_type_software`.`nid`) and (`node`.`vid` = `content_type_software`.`vid`)))) join `content_type_device_service_history` on((`content_type_device_service_history`.`field_to_device_component_nid` = `content_type_device_component_history`.`field_device_component_nid`))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_device_component_history`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_device_component_history`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) join `content_field_device_pk` on(((`content_field_device_pk`.`nid` = `content_type_device_service_history`.`nid`) and (`content_field_device_pk`.`vid` = `content_type_device_service_history`.`vid`) and (`content_type_device_component_history`.`field_component_device_nid` = `content_field_device_pk`.`field_device_pk_nid`)))) join `content_type_device_service_type` on((`content_type_device_service_type`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`))) join `node` `node1` on((`node1`.`vid` = `content_type_device_service_type`.`vid`))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`node1`.`title` = 'Configuration Update')) group by `content_type_device_component_history`.`field_component_device_nid`;

/*View structure for view config_hw_sw_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `config_hw_sw_view` AS select `node`.`nid` AS `nid`,`content_type_hardware`.`nid` AS `hw_nid`,`content_field_device_type`.`field_device_type_nid` AS `devicetype_nid`,`content_type_hardware`.`field_hw_version_value` AS `hw_version`,`node2`.`type` AS `hw_type`,`node2`.`vid` AS `hw_vid`,`node2`.`title` AS `hw_name`,`content_type_hardware`.`field_hw_description_value` AS `hw_description`,`content_type_software`.`field_sw_version_value` AS `sw_version`,`node`.`type` AS `sw_type`,`node`.`vid` AS `sw_vid`,`node`.`title` AS `sw_title`,`content_type_software`.`field_sw_description_value` AS `sw_description`,`node1`.`title` AS `sw_status`,`content_field_expiration_datetime`.`field_expiration_datetime_value` AS `sw_expiration` from ((((`content_type_hardware` left join ((((`node` join `content_field_hw_list` on(((`content_field_hw_list`.`nid` = `node`.`nid`) and (`content_field_hw_list`.`vid` = `node`.`vid`)))) join `content_type_software` on(((`content_type_software`.`nid` = `content_field_hw_list`.`nid`) and (`content_type_software`.`vid` = `content_field_hw_list`.`vid`)))) join `node` `node1` on(((`node1`.`nid` = `content_type_software`.`field_sw_status_nid`) and ((`node1`.`title` = 'Limited Release') or (`node1`.`title` = 'In Production'))))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_software`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_software`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) on((`content_type_hardware`.`nid` = `content_field_hw_list`.`field_hw_list_nid`))) join `node` `node2` on(((`node2`.`nid` = `content_type_hardware`.`nid`) and (`node2`.`vid` = `content_type_hardware`.`vid`)))) join `content_field_device_type` on(((`content_field_device_type`.`nid` = `content_type_hardware`.`nid`) and (`content_field_device_type`.`vid` = `content_type_hardware`.`vid`)))) join `content_field_expiration_datetime` `content_field_expiration_datetime1` on(((`content_field_expiration_datetime1`.`nid` = `content_type_hardware`.`nid`) and (`content_field_expiration_datetime1`.`vid` = `content_type_hardware`.`vid`) and isnull(`content_field_expiration_datetime1`.`field_expiration_datetime_value`)))) order by `content_type_hardware`.`nid`;

/*View structure for view device_component_discrepancy_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_component_discrepancy_view` AS select `discrepancy_list_VW`.`discrepancy_nid` AS `discrepancy_nid`,`discrepancy_list_VW`.`productline_nid` AS `productline_nid`,`discrepancy_list_VW`.`productline` AS `productline`,`discrepancy_list_VW`.`devicetype_nid` AS `devicetype_nid`,`discrepancy_list_VW`.`devicetype` AS `devicetype`,`discrepancy_list_VW`.`deviceserial` AS `deviceserial`,`discrepancy_list_VW`.`customer_nid` AS `customer_nid`,`discrepancy_list_VW`.`customername` AS `customername`,`discrepancy_list_VW`.`accountnumber` AS `accountnumber`,`discrepancy_list_VW`.`country_nid` AS `country_nid`,`discrepancy_list_VW`.`country_name` AS `country_name`,`hw_discrepancy_list_VW`.`discrepancy_nid1` AS `discrepancy_nid1`,`hw_discrepancy_list_VW`.`component_name` AS `component_name`,`hw_discrepancy_list_VW`.`component_type` AS `component_type`,`hw_discrepancy_list_VW`.`part_value` AS `part_value`,`hw_discrepancy_list_VW`.`previous_version` AS `previous_version`,`hw_discrepancy_list_VW`.`old_component_description` AS `old_component_description`,`hw_discrepancy_list_VW`.`new_version` AS `new_version`,`hw_discrepancy_list_VW`.`new_component_description` AS `new_component_description` from (`hw_discrepancy_list_VW` left join `discrepancy_list_VW` on((`hw_discrepancy_list_VW`.`discrepancy_nid1` = `discrepancy_list_VW`.`discrepancy_nid`))) union all select `discrepancy_list_VW`.`discrepancy_nid` AS `discrepancy_nid`,`discrepancy_list_VW`.`productline_nid` AS `productline_nid`,`discrepancy_list_VW`.`productline` AS `productline`,`discrepancy_list_VW`.`devicetype_nid` AS `devicetype_nid`,`discrepancy_list_VW`.`devicetype` AS `devicetype`,`discrepancy_list_VW`.`deviceserial` AS `deviceserial`,`discrepancy_list_VW`.`customer_nid` AS `customer_nid`,`discrepancy_list_VW`.`customername` AS `customername`,`discrepancy_list_VW`.`accountnumber` AS `accountnumber`,`discrepancy_list_VW`.`country_nid` AS `country_nid`,`discrepancy_list_VW`.`country_name` AS `country_name`,`sw_discrepancy_list_VW`.`discrepancy_nid1` AS `discrepancy_nid1`,`sw_discrepancy_list_VW`.`component_name` AS `component_name`,`sw_discrepancy_list_VW`.`component_type` AS `component_type`,`sw_discrepancy_list_VW`.`part_value` AS `part_value`,`sw_discrepancy_list_VW`.`previous_version` AS `previous_version`,`sw_discrepancy_list_VW`.`old_component_description` AS `old_component_description`,`sw_discrepancy_list_VW`.`new_version` AS `new_version`,`sw_discrepancy_list_VW`.`new_component_description` AS `new_component_description` from (`sw_discrepancy_list_VW` left join `discrepancy_list_VW` on((`sw_discrepancy_list_VW`.`discrepancy_nid1` = `discrepancy_list_VW`.`discrepancy_nid`)));

/*View structure for view device_emerald_software_version_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_emerald_software_version_view` AS select `Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`deviceserial` AS `deviceserial`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customername` AS `customername`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Hardware_VW`.`hardware_nid` AS `hardware_nid`,`Hardware_VW`.`hardware_part` AS `hardware_part`,`Hardware_VW`.`hardware_name` AS `hardware_name`,`Hardware_VW`.`hardware_version` AS `hardware_version`,`Hardware_VW1`.`hardware_nid` AS `hardware1_nid`,`Hardware_VW1`.`hardware_part` AS `hardware1_part`,`Hardware_VW1`.`hardware_name` AS `hardware1_name`,`Hardware_VW1`.`hardware_version` AS `hardware1_version`,`Software_VW`.`software_nid` AS `software_nid`,`Software_VW`.`software_name` AS `software_name`,`Software_VW`.`software_part` AS `software_part`,`Software_VW`.`software_version` AS `software_version`,`Software_VW`.`software_component` AS `software_component`,`Software_VW`.`lastest_sw_update` AS `lastest_sw_update`,`device_service_history_VW`.`service_person` AS `service_person`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from ((((((`Device_VW` left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`customer_nid`))) join `Hardware_VW` on(((`Hardware_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW`.`hardware_name` = 'Main PCBA')))) join `Hardware_VW` `Hardware_VW1` on(((`Hardware_VW1`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW1`.`hardware_name` = 'VIBE')))) join `Software_VW` on(((`Software_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Software_VW`.`software_name` = 'Host App')))) join `device_service_history_VW` on(((`device_service_history_VW`.`field_to_device_component_nid` = `Software_VW`.`software_component`) and (`device_service_history_VW`.`service_device_nid` = `Device_VW`.`device_nid`) and (`device_service_history_VW`.`field_service_datetime_value` = `Software_VW`.`lastest_sw_update`)))) order by `Device_VW`.`deviceserial`,`Software_VW`.`lastest_sw_update` desc;

/*View structure for view device_scd700_software_version_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_scd700_software_version_view` AS select `Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`deviceserial` AS `deviceserial`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customername` AS `customername`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Hardware_VW`.`hardware_nid` AS `hardware_nid`,`Hardware_VW`.`hardware_part` AS `hardware_part`,`Hardware_VW`.`hardware_name` AS `hardware_name`,`Hardware_VW`.`hardware_version` AS `hardware_version`,`Software_VW`.`software_nid` AS `software_nid`,`Software_VW`.`software_name` AS `software_name`,`Software_VW`.`software_part` AS `software_part`,`Software_VW`.`software_version` AS `software_version`,`Software_VW`.`software_component` AS `software_component`,`Software_VW`.`lastest_sw_update` AS `lastest_sw_update`,`device_service_history_VW`.`service_person` AS `service_person`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from (((((`Device_VW` left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`account_nid`))) join `Hardware_VW` on(((`Hardware_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW`.`hardware_name` = 'Control Board')))) join `Software_VW` on(((`Software_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Software_VW`.`software_name` = 'Control')))) join `device_service_history_VW` on(((`device_service_history_VW`.`field_to_device_component_nid` = `Software_VW`.`software_component`) and (`device_service_history_VW`.`service_device_nid` = `Device_VW`.`device_nid`) and (`device_service_history_VW`.`field_service_datetime_value` = `Software_VW`.`lastest_sw_update`)))) order by `Device_VW`.`deviceserial`,`Software_VW`.`lastest_sw_update` desc;

/*View structure for view device_service_history_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_service_history_VW` AS select concat(`content_type_person`.`field_first_name_value`,'.',`content_type_person`.`field_last_name_value`) AS `service_person`,`content_field_device_pk`.`field_device_pk_nid` AS `service_device_nid`,`content_type_device_service_history`.`field_to_device_component_nid` AS `field_to_device_component_nid`,`content_type_device_service_history`.`field_service_datetime_value` AS `field_service_datetime_value` from ((((`content_type_person` join `content_type_device_service_history` on((`content_type_device_service_history`.`field_service_person_pk_nid` = `content_type_person`.`nid`))) join `content_field_device_pk` on((`content_field_device_pk`.`nid` = `content_type_device_service_history`.`nid`))) join `content_type_device_service_type` on((`content_type_device_service_type`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`))) join `node` on((`node`.`vid` = `content_type_device_service_type`.`vid`))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`node`.`title` = 'Configuration Update'));

/*View structure for view device_service_history_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_service_history_view` AS select `content_type_device_service_history`.`nid` AS `servicehistory_nid`,`node6`.`nid` AS `productline_nid`,`node6`.`title` AS `productline`,`content_field_device_type`.`field_device_type_nid` AS `devicetype_nid`,`node3`.`title` AS `devicetype`,`content_type_device`.`field_device_serial_number_value` AS `deviceserial`,`node2`.`nid` AS `customer_nid`,`node2`.`title` AS `customername`,`content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`content_type_person`.`field_person_username_value` AS `technician_email`,`content_type_device_service_history`.`field_service_datetime_value` AS `service_date`,`node`.`nid` AS `servicetype_nid`,`node`.`title` AS `servicetype`,`content_type_device_service_history`.`field_upgrade_status_value` AS `servicetype_status`,`content_type_device_service_history`.`field_from_device_component_nid` AS `from_component_nid`,`content_type_device_service_history`.`field_to_device_component_nid` AS `to_component_nid`,`node7`.`nid` AS `country_nid`,`node7`.`title` AS `country_name` from ((((((((((((((((((`content_type_device_service_history` join `content_type_device_service_type` on((`content_type_device_service_type`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`))) join `node` on(((`node`.`nid` = `content_type_device_service_type`.`nid`) and (`content_type_device_service_type`.`vid` = `node`.`vid`)))) join `content_type_person` on((`content_type_person`.`nid` = `content_type_device_service_history`.`field_service_person_pk_nid`))) join `content_field_device_pk` on(((`content_field_device_pk`.`nid` = `content_type_device_service_history`.`nid`) and (`content_field_device_pk`.`vid` = `content_type_device_service_history`.`vid`)))) join `content_type_device` on((`content_type_device`.`nid` = `content_field_device_pk`.`field_device_pk_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime2` on(((`content_field_expiration_datetime2`.`nid` = `content_type_device`.`nid`) and (`content_field_expiration_datetime2`.`vid` = `content_type_device`.`vid`)))) left join `content_type_device_installation` on((`content_type_device_installation`.`nid` = `content_type_device_service_history`.`field_device_installation_pk_nid`))) left join `content_type_country` on((`content_type_device_installation`.`field_device_country_nid` = `content_type_country`.`nid`))) join `node` `node7` on((`node7`.`vid` = `content_type_country`.`vid`))) join `content_type_party` on((`content_type_party`.`nid` = `content_type_device`.`field_device_owner_nid`))) join `node` `node2` on(((`node2`.`nid` = `content_type_party`.`nid`) and (`node2`.`vid` = `content_type_party`.`vid`)))) join `content_type_bu_customer` on((`content_type_party`.`nid` = `content_type_bu_customer`.`field_customer_party_pk_nid`))) join `content_field_device_type` on(((`content_field_device_type`.`nid` = `content_type_device`.`nid`) and (`content_field_device_type`.`vid` = `content_type_device`.`vid`)))) join `content_type_devicetype` on((`content_type_devicetype`.`nid` = `content_field_device_type`.`field_device_type_nid`))) join `node` `node3` on(((`node3`.`nid` = `content_type_devicetype`.`nid`) and (`node3`.`vid` = `content_type_devicetype`.`vid`)))) join `content_field_device_product_line` on(((`content_field_device_product_line`.`nid` = `content_type_devicetype`.`nid`) and (`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`)))) join `content_type_product_line` on((`content_type_product_line`.`nid` = `content_field_device_product_line`.`field_device_product_line_nid`))) join `node` `node6` on(((`node6`.`nid` = `content_type_product_line`.`nid`) and (`node6`.`vid` = `content_type_product_line`.`vid`)))) where (not(`content_type_device_service_history`.`nid` in (select `content_type_device_service_history`.`nid` from ((`content_type_device_service_history` join `content_type_hardware` on(((`content_type_hardware`.`nid` = `content_type_device_service_history`.`field_to_device_component_nid`) or ((`content_type_hardware`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`) and (`content_type_hardware`.`nid` = `content_type_device_service_history`.`field_from_device_component_nid`))))) join `node` on(((`node`.`nid` = `content_type_hardware`.`nid`) and (`node`.`vid` = `content_type_hardware`.`vid`)))))));

/*View structure for view device_software_upgrade_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_software_upgrade_view` AS select `Customer_VW`.`customername` AS `customername`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`device_owner` AS `device_owner`,`Device_VW`.`deviceserial` AS `deviceserial`,`select_service_history_VW1`.`service_device_nid` AS `service_device_nid`,`select_service_history_VW1`.`SW_upgrade_status` AS `SW_upgrade_status`,`select_service_history_VW1`.`Attempts` AS `Attempts`,`select_service_history_VW1`.`field_from_device_component_nid` AS `field_from_device_component_nid`,`select_service_history_VW1`.`field_to_device_component_nid` AS `field_to_device_component_nid`,`select_service_history_VW1`.`Event_datetime` AS `Event_datetime`,`select_service_history_VW1`.`service_person` AS `service_person`,`content_type_software`.`field_sw_version_value` AS `Prior_SW_Version`,`content_type_software1`.`field_sw_version_value` AS `New_SW_Version`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from (((((((`Device_VW` join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`customer_nid`))) join `select_service_history_VW1` on((`select_service_history_VW1`.`service_device_nid` = `Device_VW`.`device_nid`))) join `content_type_software` on((`content_type_software`.`nid` = `select_service_history_VW1`.`field_from_device_component_nid`))) join `node` `node1` on(((`node1`.`nid` = `content_type_software`.`nid`) and (`node1`.`vid` = `content_type_software`.`vid`)))) join `content_type_software` `content_type_software1` on((`content_type_software1`.`nid` = `select_service_history_VW1`.`field_to_device_component_nid`))) join `node` on(((`node`.`nid` = `content_type_software1`.`nid`) and (`node`.`vid` = `content_type_software1`.`vid`)))) left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) order by `Device_VW`.`deviceserial`,`select_service_history_VW1`.`Event_datetime` desc;

/*View structure for view device_software_version_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `device_software_version_view` AS select `Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`deviceserial` AS `deviceserial`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customername` AS `customername`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Hardware_VW`.`hardware_nid` AS `hardware_nid`,`Hardware_VW`.`hardware_part` AS `hardware_part`,`Hardware_VW`.`hardware_name` AS `hardware_name`,`Hardware_VW`.`hardware_version` AS `hardware_version`,`Hardware_VW1`.`hardware_nid` AS `hardware1_nid`,`Hardware_VW1`.`hardware_part` AS `hardware1_part`,`Hardware_VW1`.`hardware_name` AS `hardware1_name`,`Hardware_VW1`.`hardware_version` AS `hardware1_version`,`Software_VW`.`software_nid` AS `software_nid`,`Software_VW`.`software_name` AS `software_name`,`Software_VW`.`software_part` AS `software_part`,`Software_VW`.`software_version` AS `software_version`,`Software_VW`.`software_component` AS `software_component`,`Software_VW`.`lastest_sw_update` AS `lastest_sw_update`,`device_service_history_VW`.`service_person` AS `service_person`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from ((((((`Device_VW` left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`customer_nid`))) join `Hardware_VW` on(((`Hardware_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW`.`hardware_name` = 'BdPcba')))) join `Hardware_VW` `Hardware_VW1` on(((`Hardware_VW1`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW1`.`hardware_name` = 'GuiPcba')))) join `Software_VW` on(((`Software_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Software_VW`.`software_name` = 'BdSoftware')))) join `device_service_history_VW` on(((`device_service_history_VW`.`field_to_device_component_nid` = `Software_VW`.`software_component`) and (`device_service_history_VW`.`service_device_nid` = `Device_VW`.`device_nid`) and (`device_service_history_VW`.`field_service_datetime_value` = `Software_VW`.`lastest_sw_update`)))) order by `Device_VW`.`deviceserial`,`Software_VW`.`lastest_sw_update` desc;

/*View structure for view discrepancy_list_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `discrepancy_list_VW` AS select `content_type_device_discrepancy`.`nid` AS `discrepancy_nid`,`node6`.`nid` AS `productline_nid`,`node6`.`title` AS `productline`,`content_field_device_type`.`field_device_type_nid` AS `devicetype_nid`,`node3`.`title` AS `devicetype`,`content_type_device`.`field_device_serial_number_value` AS `deviceserial`,`node2`.`nid` AS `customer_nid`,`node2`.`title` AS `customername`,`content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`node7`.`nid` AS `country_nid`,`node7`.`title` AS `country_name` from (((((((((((((((`content_type_device_discrepancy` join `content_type_device` on((`content_type_device`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_device_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime2` on(((`content_field_expiration_datetime2`.`vid` = `content_type_device`.`vid`) and isnull(`content_field_expiration_datetime2`.`field_expiration_datetime_value`)))) join `content_field_device_pk` on((`content_field_device_pk`.`field_device_pk_nid` = `content_type_device`.`nid`))) join `content_type_device_installation` on(((`content_type_device_installation`.`nid` = `content_field_device_pk`.`nid`) and (`content_type_device_installation`.`vid` = `content_field_device_pk`.`vid`)))) join `content_type_country` on((`content_type_device_installation`.`field_device_country_nid` = `content_type_country`.`nid`))) join `node` `node7` on((`node7`.`vid` = `content_type_country`.`vid`))) join `content_type_party` on((`content_type_party`.`nid` = `content_type_device`.`field_device_owner_nid`))) join `node` `node2` on((`node2`.`vid` = `content_type_party`.`vid`))) join `content_type_bu_customer` on((`content_type_party`.`nid` = `content_type_bu_customer`.`field_customer_party_pk_nid`))) join `node` `node4` on(((`node4`.`nid` = `content_type_bu_customer`.`nid`) and (`node4`.`vid` = `content_type_bu_customer`.`vid`)))) join `content_field_device_type` on((`content_field_device_type`.`vid` = `content_type_device`.`vid`))) join `content_type_devicetype` on((`content_type_devicetype`.`nid` = `content_field_device_type`.`field_device_type_nid`))) join `node` `node3` on((`node3`.`vid` = `content_type_devicetype`.`vid`))) join `content_field_device_product_line` on((`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`))) join `node` `node6` on((`node6`.`nid` = `content_field_device_product_line`.`field_device_product_line_nid`)));

/*View structure for view hw_discrepancy_list_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `hw_discrepancy_list_VW` AS select `content_type_device_discrepancy`.`nid` AS `discrepancy_nid1`,`node`.`title` AS `component_name`,`node`.`type` AS `component_type`,`content_type_hardware`.`field_hw_part_value` AS `part_value`,`content_type_hardware`.`field_hw_version_value` AS `previous_version`,`content_type_hardware`.`field_hw_description_value` AS `old_component_description`,`content_type_hardware1`.`field_hw_version_value` AS `new_version`,`content_type_hardware1`.`field_hw_description_value` AS `new_component_description` from ((((((`content_type_device_discrepancy` join `content_type_hardware` on((`content_type_hardware`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_component_nid`))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`vid` = `content_type_hardware`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) join `node` on((`node`.`vid` = `content_type_hardware`.`vid`))) join `content_type_hardware` `content_type_hardware1` on((`content_type_hardware1`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_old_component_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime1` on(((`content_field_expiration_datetime1`.`vid` = `content_type_hardware1`.`vid`) and isnull(`content_field_expiration_datetime1`.`field_expiration_datetime_value`)))) join `node` `node1` on((`node1`.`vid` = `content_type_hardware1`.`vid`)));

/*View structure for view select_service_history_VW1 */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `select_service_history_VW1` AS select `content_field_device_pk`.`field_device_pk_nid` AS `service_device_nid`,`content_type_device_service_history`.`field_upgrade_status_value` AS `SW_upgrade_status`,count(`content_type_device_service_history`.`field_upgrade_status_value`) AS `Attempts`,`content_type_device_service_history`.`field_from_device_component_nid` AS `field_from_device_component_nid`,`content_type_device_service_history`.`field_to_device_component_nid` AS `field_to_device_component_nid`,`content_type_device_service_history`.`field_service_datetime_value` AS `Event_datetime`,concat(`content_type_person`.`field_last_name_value`,'.',`content_type_person`.`field_first_name_value`) AS `service_person` from ((((`content_type_device_service_history` join `content_type_device_installation` on((`content_type_device_installation`.`nid` = `content_type_device_service_history`.`field_device_installation_pk_nid`))) join `content_field_device_pk` on(((`content_field_device_pk`.`nid` = `content_type_device_installation`.`nid`) and (`content_field_device_pk`.`vid` = `content_type_device_installation`.`vid`)))) join `content_type_person` on((`content_type_device_service_history`.`field_service_person_pk_nid` = `content_type_person`.`nid`))) left join `content_field_device_pk` `content_field_device_pk1` on(((`content_field_device_pk1`.`nid` = `content_type_device_service_history`.`nid`) and (`content_field_device_pk1`.`field_device_pk_nid` = `content_field_device_pk`.`field_device_pk_nid`)))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`content_type_device_service_history`.`field_upgrade_status_value` = 'failed') or (`content_type_device_service_history`.`field_upgrade_status_value` = 'not attempted')) group by `content_field_device_pk`.`field_device_pk_nid`,`content_type_device_service_history`.`field_upgrade_status_value`,`content_type_device_service_history`.`field_to_device_component_nid`;

/*View structure for view sw_discrepancy_list_VW */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `sw_discrepancy_list_VW` AS select `content_type_device_discrepancy`.`nid` AS `discrepancy_nid1`,`node`.`title` AS `component_name`,`node`.`type` AS `component_type`,`content_type_software`.`field_sw_part_value` AS `part_value`,`content_type_software`.`field_sw_version_value` AS `previous_version`,`content_type_software`.`field_sw_description_value` AS `old_component_description`,`content_type_software1`.`field_sw_version_value` AS `new_version`,`content_type_software1`.`field_sw_description_value` AS `new_component_description` from ((((((`content_type_device_discrepancy` join `content_type_software` on((`content_type_software`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_component_nid`))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_software`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_software`.`vid`)))) join `node` on(((`node`.`nid` = `content_type_software`.`nid`) and (`node`.`vid` = `content_type_software`.`vid`)))) join `content_type_software` `content_type_software1` on((`content_type_software1`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_old_component_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime1` on(((`content_field_expiration_datetime1`.`nid` = `content_type_software1`.`nid`) and (`content_field_expiration_datetime1`.`vid` = `content_type_software1`.`vid`)))) join `node` `node1` on(((`node1`.`nid` = `content_type_software1`.`nid`) and (`node1`.`vid` = `content_type_software1`.`vid`))));

/*View structure for view training_record_view */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `training_record_view` AS select `node4`.`title` AS `customername`,`node4`.`nid` AS `customer_nid`,`content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`node5`.`nid` AS `productline_nid`,`node5`.`title` AS `productline`,`content_type_person`.`nid` AS `trainee_nid`,`node`.`title` AS `trainee_name`,`content_type_person1`.`nid` AS `trainer_nid`,`node1`.`title` AS `trainer_name`,`content_type_devicetype`.`nid` AS `devicetype_nid`,`node3`.`title` AS `devicetype`,`content_type_person_training_record`.`field_training_completion_date_value` AS `training_completion_date`,`content_type_person_training_record`.`field_active_flag_value` AS `training_status` from (((((((((((((((`content_type_person_training_record` join `content_type_person` on((`content_type_person_training_record`.`field_trainee_id_nid` = `content_type_person`.`nid`))) join `node` on(((`node`.`nid` = `content_type_person`.`nid`) and (`node`.`vid` = `content_type_person`.`vid`)))) join `content_type_person` `content_type_person1` on((`content_type_person_training_record`.`field_trainer_id_nid` = `content_type_person1`.`nid`))) join `node` `node1` on(((`node1`.`nid` = `content_type_person1`.`nid`) and (`node1`.`vid` = `content_type_person1`.`vid`))))) join `content_type_party` on((`content_type_party`.`nid` = `content_type_person`.`field_person_party_nid`))) join `node` `node2` on(((`node2`.`nid` = `content_type_party`.`nid`) and (`node2`.`vid` = `content_type_party`.`vid`)))) left join `content_type_bu_customer` on((`content_type_bu_customer`.`field_customer_party_pk_nid` = `content_type_person`.`field_company_name_nid`))) left join `node` `node4` on((`node4`.`nid` = `content_type_bu_customer`.`field_customer_party_pk_nid`))) join `content_field_device_type` on(((`content_field_device_type`.`nid` = `content_type_person_training_record`.`nid`) and (`content_field_device_type`.`vid` = `content_type_person_training_record`.`vid`)))) join `content_type_devicetype` on((`content_type_devicetype`.`nid` = `content_field_device_type`.`field_device_type_nid`))) join `node` `node3` on(((`node3`.`nid` = `content_type_devicetype`.`nid`) and (`node3`.`vid` = `content_type_devicetype`.`vid`)))) join `content_field_device_product_line` on(((`content_field_device_product_line`.`nid` = `content_type_devicetype`.`nid`) and (`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`)))) join `content_type_product_line` on((`content_type_product_line`.`nid` = `content_field_device_product_line`.`field_device_product_line_nid`))) join `node` `node5` on(((`node5`.`nid` = `content_type_product_line`.`nid`) and (`node5`.`vid` = `content_type_product_line`.`vid`))));

/*View structure for view view_device_sw_configuration */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_device_sw_configuration` AS select `node_country_name`.`title` AS `country_name`,`node_country_name`.`nid` AS `country_nid`,`node_product_line`.`title` AS `productline`,`node_product_line`.`nid` AS `productline_nid`,`node_customer_name`.`nid` AS `customer_nid`,`node_customer_name`.`title` AS `customername`,`d`.`field_bu_customer_account_number_value` AS `accountnumber`,concat(`k`.`field_postal_address_line2_value`,' ',`k`.`field_postal_address_line1_value`) AS `customer_address`,`k`.`field_postal_address_city_value` AS `customer_city`,`k`.`field_state_province_value` AS `customer_state`,`j`.`field_email_address_value` AS `customer_email`,`node_device_type`.`title` AS `devicetype`,`node_device_type`.`nid` AS `devicetype_nid`,`c`.`nid` AS `device_nid`,`c`.`field_device_serial_number_value` AS `deviceserial`,`a`.`software_nid` AS `software_nid`,`a`.`software_name` AS `software_name`,`a`.`software_part` AS `software_part`,`a`.`software_version` AS `software_version`,`a`.`software_component` AS `software_component`,`a`.`lastest_sw_update` AS `lastest_sw_update` from ((((((((((`Software_VW` `a` join `content_field_device_type` `b`) join `node` `node_device_type`) join `content_type_device` `c`) join `node` `node_customer_name`) join (((`content_type_bu_customer` `d` left join `content_type_party_postal_address` `i` on((`d`.`field_customer_party_pk_nid` = `i`.`field_party_postal_address_nid`))) left join `content_type_postal_address` `k` on((`i`.`field_party_postal_address_ref_nid` = `k`.`nid`))) left join `content_type_party_email_address` `j` on((`d`.`field_customer_party_pk_nid` = `j`.`field_party_email_nid`)))) join `content_field_device_product_line` `e`) join `node` `node_product_line`) join `content_field_device_pk` `f`) join `content_type_device_installation` `g`) join `node` `node_country_name`) where ((`a`.`component_device` = `c`.`nid`) and (`b`.`field_device_type_nid` = `node_device_type`.`nid`) and (`c`.`nid` = `b`.`nid`) and (`node_customer_name`.`nid` = `d`.`field_customer_party_pk_nid`) and (`node_customer_name`.`nid` = `c`.`field_device_owner_nid`) and (`e`.`nid` = `b`.`field_device_type_nid`) and (`e`.`field_device_product_line_nid` = `node_product_line`.`nid`) and (`f`.`field_device_pk_nid` = `c`.`nid`) and (`f`.`nid` = `g`.`nid`) and (`g`.`field_device_country_nid` = `node_country_name`.`nid`));

/*View structure for view view_device_type */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_device_type` AS (select `a`.`nid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_device_type_description_value` AS `description`,`a`.`field_serial_number_regex_value` AS `rule` from (`content_type_devicetype` `a` join `node` `b`) where ((`a`.`nid` = `b`.`nid`) and (`b`.`type` = 'devicetype')));

/*View structure for view view_firmware */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_firmware` AS (select `n`.`nid` AS `nid`,`n`.`title` AS `title`,`f`.`part` AS `part`,`f`.`version` AS `version`,`f`.`device_type_id` AS `device_type_id`,`f`.`description` AS `description`,`f`.`file` AS `file`,`f`.`file_id` AS `file_id`,`f`.`create_time` AS `create_time`,`f`.`update_time` AS `update_time`,`f`.`type_id` AS `type_id`,`f`.`status` AS `status` from (`firmware` `f` join `node` `n` on((`n`.`nid` = `f`.`nid`))));

/*View structure for view view_hardware */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_hardware` AS (select `a`.`nid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_hw_part_value` AS `part`,`a`.`field_hw_version_value` AS `VERSION`,`a`.`field_hw_description_value` AS `description`,`a`.`field_hw_type_nid` AS `hw_type_id` from (`content_type_hardware` `a` join `node` `b`) where (`a`.`vid` = `b`.`vid`));

/*View structure for view view_named_configuration */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_configuration` AS (select `c`.`nid` AS `nid`,`c`.`type_id` AS `type_id`,`n`.`title` AS `title`,`c`.`device_type_id` AS `device_type_id`,`c`.`version` AS `version`,`n`.`created` AS `create_time`,`n`.`changed` AS `update_time`,if((`c`.`obsolete_time` is null or `c`.`obsolete_time`>unix_timestamp()),0,1) AS `is_obsolete`,`c`.`description` AS `description`,`t`.`name` AS `type_name`,`t`.`title` AS `type_title`,`t`.`link_type_id` AS `link_type_id` from ((`named_configuration` `c` join `node` `n` on((`c`.`nid` = `n`.`nid`))) left join `named_configuration_type` `t` on((`c`.`type_id` = `t`.`id`))));

/*View structure for view view_named_configuration_relation */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_configuration_relation` AS (select `r`.`id` AS `id`,`r`.`left_nid` AS `left_nid`,`r`.`left_type` AS `left_type`,`nl`.`title` AS `left_title`,`tl`.`name` AS `left_type_name`,`tl`.`title` AS `left_type_title`,`r`.`right_nid` AS `right_nid`,`r`.`right_type` AS `right_type`,`nr`.`title` AS `right_title`,`tr`.`name` AS `right_type_name`,`tr`.`title` AS `right_type_title`,`r`.`create_time` AS `create_time`,`r`.`update_time` AS `update_time` from ((((`named_configuration_relation` `r` left join `node` `nl` on((`r`.`left_nid` = `nl`.`nid`))) left join `node` `nr` on((`r`.`right_nid` = `nr`.`nid`))) left join `named_configuration_type` `tl` on((`r`.`left_type` = `tl`.`id`))) left join `named_configuration_type` `tr` on((`r`.`right_type` = `tr`.`id`))));

/*View structure for view view_named_firmware_configuration */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_firmware_configuration` AS (select `c`.`nid` AS `nid`,`c`.`type_id` AS `type_id`,`nf`.`title` AS `title`,`c`.`device_type_id` AS `device_type_id`,`d`.`title` AS `device_type_name`,`c`.`version` AS `version`,`c`.`description` AS `description`,`c`.`create_time` AS `create_time`,`c`.`update_time` AS `update_time`,group_concat(distinct `f`.`nid` separator ',') AS `firmware_list` from (((((`named_configuration` `c` join `named_configuration_type` `t` on((`c`.`type_id` = `t`.`id`))) join `node` `nf` on((`c`.`nid` = `nf`.`title`))) left join `named_configuration_relation` `r` on((`c`.`nid` = `r`.`left_nid`))) left join `firmware` `f` on((`r`.`right_nid` = `f`.`nid`))) left join `node` `d` on((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'firmware_configuration') group by `c`.`nid`);

/*View structure for view view_named_hardware_configuration */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_hardware_configuration` AS (select `c`.`nid` AS `nid`,`c`.`type_id` AS `type_id`,`nh`.`title` AS `title`,`c`.`device_type_id` AS `device_type_id`,`d`.`title` AS `device_type_name`,`c`.`version` AS `version`,`c`.`description` AS `description`,`c`.`create_time` AS `create_time`,`c`.`update_time` AS `update_time`,group_concat(distinct `h`.`nid` separator ',') AS `hardware_list` from (((((`named_configuration` `c` join `named_configuration_type` `t` on((`c`.`type_id` = `t`.`id`))) join `node` `nh` on((`c`.`nid` = `nh`.`nid`))) left join `named_configuration_relation` `r` on((`c`.`nid` = `r`.`left_nid`))) left join `content_type_hardware` `h` on((`r`.`right_nid` = `h`.`nid`))) left join `node` `d` on((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'hardware_configuration') group by `c`.`nid`);

/*View structure for view view_named_software_configuration */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_software_configuration` AS (select `c`.`nid` AS `nid`,`c`.`type_id` AS `type_id`,`ns`.`title` AS `title`,`c`.`device_type_id` AS `device_type_id`,`d`.`title` AS `device_type_name`,`c`.`version` AS `version`,`c`.`description` AS `description`,`c`.`create_time` AS `create_time`,`c`.`update_time` AS `update_time`,group_concat(distinct `s`.`nid` separator ',') AS `software_list` from (((((`named_configuration` `c` join `named_configuration_type` `t` on((`c`.`type_id` = `t`.`id`))) join `node` `ns` on((`c`.`nid` = `ns`.`nid`))) left join `named_configuration_relation` `r` on((`c`.`nid` = `r`.`left_nid`))) left join `content_type_software` `s` on((`r`.`right_nid` = `s`.`nid`))) left join `node` `d` on((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'software_configuration') group by `c`.`nid`);

/*View structure for view view_named_system_configuration */

CREATE ALGORITHM = UNDEFINED DEFINER = `covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_system_configuration` AS (select `c`.`nid` AS `nid`,`c`.`type_id` AS `type_id`,`cn`.`title` AS `title`,`c`.`device_type_id` AS `device_type_id`,`d`.`title` AS `device_type_name`,`c`.`version` AS `version`,`c`.`description` AS `description`,`c`.`create_time` AS `create_time`,`c`.`update_time` AS `update_time`,max((case `rt`.`name` when 'hardware_configuration' then `r`.`right_nid` else NULL end)) AS `hw_config_nid`,max((case `rt`.`name` when 'software_configuration' then `r`.`right_nid` else NULL end)) AS `sw_config_nid`, max((case `rt`.`name` when 'firmware_configuration' then `r`.`right_nid` else NULL end)) AS `fw_config_nid` from (((((`named_configuration` `c` join `named_configuration_type` `t` ON ((`c`.`type_id` = `t`.`id`))) join `node` `cn` ON ((`c`.`nid` = `cn`.`nid`))) left join `named_configuration_relation` `r` ON ((`c`.`nid` = `r`.`left_nid`))) left join `named_configuration_type` `rt` ON ((`r`.`right_type` = `rt`.`id`))) left join `node` `d` ON ((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'system_configuration') group by `c`.`nid`);

/*View structure for view view_software */

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_software` AS (select `a`.`vid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_sw_part_value` AS `part`,`a`.`field_sw_version_value` AS `VERSION`,`f`.`filepath` AS `fid`,`a`.`field_sw_description_value` AS `description`,`a`.`field_sw_type_nid` AS `sw_type_id`,`a`.`field_sw_language_nid` AS `language_id`,`a`.`field_sw_status_nid` AS `status_id`,`c`.`title` AS `sw_type_name`,`d`.`title` AS `language_name`,`e`.`title` AS `status_name` from (((((`content_type_software` `a` join `node` `b`) join `node` `c`) join `node` `d`) join `node` `e`) left join `files` `f` on((`f`.`fid` = `a`.`field_sw_file_fid`))) where ((`a`.`vid` = `b`.`vid`) and (`c`.`nid` = `a`.`field_sw_type_nid`) and (`d`.`nid` = `a`.`field_sw_language_nid`) and (`e`.`nid` = `a`.`field_sw_status_nid`)));


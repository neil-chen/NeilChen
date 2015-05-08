/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.1.61 : Database - covidiendb
*********************************************************************
*/

/*!40101 SET NAMES utf8;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';*/

DROP VIEW IF EXISTS `view_device_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_device_type` AS (select `a`.`nid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_device_type_description_value` AS `description`,`a`.`field_serial_number_regex_value` AS `rule` from (`content_type_devicetype` `a` join `node` `b`) where ((`a`.`nid` = `b`.`nid`) and (`b`.`type` = 'devicetype')));

/*!50001 DROP VIEW IF EXISTS `view_device_type` */;
/*!50001 DROP TABLE IF EXISTS `view_device_type` */;

/*Table structure for table `view_firmware` */

DROP TABLE IF EXISTS `view_firmware`;

/*!50001 DROP VIEW IF EXISTS `view_firmware` */;
/*!50001 DROP TABLE IF EXISTS `view_firmware` */;

/*Table structure for table `view_hardware` */

DROP TABLE IF EXISTS `view_hardware`;

/*!50001 DROP VIEW IF EXISTS `view_hardware` */;
/*!50001 DROP TABLE IF EXISTS `view_hardware` */;


/*Table structure for table `view_named_configuration` */

DROP TABLE IF EXISTS `view_named_configuration`;

/*!50001 DROP VIEW IF EXISTS `view_named_configuration` */;
/*!50001 DROP TABLE IF EXISTS `view_named_configuration` */;

/*Table structure for table `view_named_configuration_relation` */

DROP TABLE IF EXISTS `view_named_configuration_relation`;

/*!50001 DROP VIEW IF EXISTS `view_named_configuration_relation` */;
/*!50001 DROP TABLE IF EXISTS `view_named_configuration_relation` */;

/*Table structure for table `view_named_hardware_configuration` */

DROP TABLE IF EXISTS `view_named_hardware_configuration`;

/*!50001 DROP VIEW IF EXISTS `view_named_hardware_configuration` */;
/*!50001 DROP TABLE IF EXISTS `view_named_hardware_configuration` */;

/*Table structure for table `view_named_software_configuration` */

DROP TABLE IF EXISTS `view_named_software_configuration`;

/*!50001 DROP VIEW IF EXISTS `view_named_software_configuration` */;
/*!50001 DROP TABLE IF EXISTS `view_named_software_configuration` */;

/*Table structure for table `view_named_system_configuration` */

DROP TABLE IF EXISTS `view_named_system_configuration`;

/*!50001 DROP VIEW IF EXISTS `view_named_system_configuration` */;
/*!50001 DROP TABLE IF EXISTS `view_named_system_configuration` */;

/*Table structure for table `view_software` */

DROP TABLE IF EXISTS `view_software`;

/*!50001 DROP VIEW IF EXISTS `view_software` */;
/*!50001 DROP TABLE IF EXISTS `view_software` */;

/*View structure for view view_device_type */

/*!50001 DROP TABLE IF EXISTS `view_device_type` */;
/*!50001 DROP VIEW IF EXISTS `view_device_type` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_device_type` AS (select `a`.`nid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_device_type_description_value` AS `description`,`a`.`field_serial_number_regex_value` AS `rule` from (`content_type_devicetype` `a` join `node` `b`) where ((`a`.`nid` = `b`.`nid`) and (`b`.`type` = 'devicetype'))) */;

/*View structure for view view_firmware */

DROP VIEW IF EXISTS `view_firmware`;

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_firmware` AS (select `a`.`id` AS `id`,`a`.`name` AS `name`,`a`.`part` AS `part`,`a`.`version` AS `version`,`a`.`device_type_id` AS `device_type_id`,`a`.`description` AS `description`,`b`.`filepath` AS `file_path`,concat((`b`.`filesize` / 1024),'KB') AS `filesize`,from_unixtime(`b`.`timestamp`) AS `upload_time`,`c`.`name` AS `status` from ((`firmware` `a` left join `files` `b` on((`a`.`file_id` = `b`.`fid`))) left join `firmware_status` `c` on((`a`.`status` = `c`.`id`))));

/*View structure for view view_hardware */

DROP VIEW IF EXISTS `view_hardware`;

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_hardware` AS (select `a`.`nid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_hw_part_value` AS `part`,`a`.`field_hw_version_value` AS `VERSION`,`a`.`field_hw_description_value` AS `description`,`a`.`field_hw_type_nid` AS `hw_type_id` from (`content_type_hardware` `a` join `node` `b`) where (`a`.`vid` = `b`.`vid`));

/*View structure for view view_named_configuration */

DROP VIEW IF EXISTS `view_named_configuration`;

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_configuration` AS (select `named_configuration`.`id` AS `id`,`named_configuration`.`type_id` AS `type_id`,`named_configuration`.`name` AS `name`,`named_configuration`.`device_type_id` AS `device_type_id`,`named_configuration`.`version` AS `version`,`named_configuration`.`create_time` AS `create_time`,`named_configuration`.`update_time` AS `update_time`,`named_configuration`.`description` AS `description` from `named_configuration`);

/*View structure for view view_named_configuration_relation */

/*!50001 DROP TABLE IF EXISTS `view_named_configuration_relation` */;
/*!50001 DROP VIEW IF EXISTS `view_named_configuration_relation` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=``@`` SQL SECURITY DEFINER VIEW `view_named_configuration_relation` AS (select `named_configuration_relation`.`id` AS `id`,`named_configuration_relation`.`config_id` AS `config_id`,`named_configuration_relation`.`ref_type` AS `ref_type`,`named_configuration_relation`.`ref_id` AS `ref_id`,`named_configuration_relation`.`create_time` AS `create_time`,`named_configuration_relation`.`update_time` AS `update_time` from `named_configuration_relation`) */;

/*View structure for view view_named_hardware_configuration */

DROP VIEW IF EXISTS `view_named_hardware_configuration`;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=``@`` SQL SECURITY DEFINER VIEW `view_named_hardware_configuration` AS (select `a`.`id` AS `id`,`a`.`type_id` AS `type_id`,`a`.`name` AS `NAME`,`a`.`device_type_id` AS `device_type_id`,`c`.`title` AS `device_type_name`,`a`.`version` AS `VERSION`,`a`.`create_time` AS `create_time`,`a`.`update_time` AS `update_time`,`a`.`description` AS `description`,group_concat(distinct `e`.`nid` separator ',') AS `hardware_list` from ((((`view_named_configuration` `a` join `node` `b`) join `node` `c`) join `view_named_configuration_relation` `d`) join `content_type_hardware` `e`) where ((`a`.`device_type_id` = `b`.`nid`) and (`b`.`vid` = `c`.`vid`) and (`c`.`type` = 'devicetype') and (`d`.`config_id` = `a`.`id`) and (`e`.`vid` = `d`.`ref_id`) and (`a`.`type_id` = 1)) group by `a`.`id`) */;

/*View structure for view view_named_software_configuration */

DROP VIEW IF EXISTS `view_named_software_configuration`;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=``@`` SQL SECURITY DEFINER VIEW `view_named_software_configuration` AS (select `a`.`id` AS `id`,`a`.`type_id` AS `type_id`,`a`.`name` AS `NAME`,`a`.`device_type_id` AS `device_type_id`,`c`.`title` AS `device_type_name`,`a`.`version` AS `VERSION`,`a`.`create_time` AS `create_time`,`a`.`update_time` AS `update_time`,`a`.`description` AS `description`,group_concat(distinct `e`.`vid` separator ',') AS `software_list` from (((`view_named_configuration` `a` join `node` `c`) join `view_named_configuration_relation` `d`) join `content_type_software` `e`) where ((`d`.`config_id` = `a`.`id`) and (`e`.`vid` = `d`.`ref_id`) and (`a`.`type_id` = 2) and (`c`.`type` = 'devicetype')) group by `a`.`id`) */;

/*View structure for view view_named_firmware_configuration */

DROP VIEW IF EXISTS `view_named_firmware_configuration`;

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_firmware_configuration` AS (select `a`.`id` AS `id`,`a`.`type_id` AS `type_id`,`a`.`name` AS `NAME`,`a`.`device_type_id` AS `device_type_id`,`c`.`title` AS `device_type_name`,`a`.`version` AS `VERSION`,`a`.`create_time` AS `create_time`,`a`.`update_time` AS `update_time`,`a`.`description` AS `description`,group_concat(distinct `e`.`id` separator ',') AS `firmware_list` from (((`view_named_configuration` `a` join `node` `c`) join `view_named_configuration_relations` `d`) join `view_firmware` `e`) where ((`d`.`config_id` = `a`.`id`) and (`e`.`id` = `d`.`ref_id`) and (`a`.`type_id` = 3) and (`c`.`type` = 'devicetype')) group by `a`.`id`);

/*View structure for view view_named_system_configuration */

DROP VIEW IF EXISTS `view_named_system_configuration`;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=``@`` SQL SECURITY DEFINER VIEW `view_named_system_configuration` AS (select `a`.`id` AS `id`,`a`.`type_id` AS `type_id`,`a`.`name` AS `NAME`,`a`.`device_type_id` AS `device_type_id`,`c`.`title` AS `device_type_name`,`a`.`version` AS `VERSION`,`a`.`create_time` AS `create_time`,`a`.`update_time` AS `update_time`,`a`.`description` AS `description`,group_concat(distinct `d`.`ref_id` separator ',') AS `hardware_list`,group_concat(distinct `e`.`ref_id` separator ',') AS `software_list`,group_concat(distinct `f`.`ref_id` separator ',') AS `firmware_list` from ((((`view_named_configuration` `a` join `node` `c`) left join `view_named_configuration_relation` `d` on(((`d`.`config_id` = `a`.`id`) and (`d`.`ref_type` = 3)))) left join `view_named_configuration_relation` `e` on(((`e`.`config_id` = `a`.`id`) and (`e`.`ref_type` = 4)))) left join `view_named_configuration_relation` `f` on(((`f`.`config_id` = `a`.`id`) and (`f`.`ref_type` = 5)))) where ((`a`.`device_type_id` = `c`.`nid`) and (`c`.`type` = 'devicetype') and (`a`.`type_id` = 0)) group by `a`.`id`) */;

/*View structure for view view_software */

DROP VIEW IF EXISTS `view_software`;

CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_software` AS (select `a`.`vid` AS `id`,`b`.`title` AS `NAME`,`a`.`field_sw_part_value` AS `part`,`a`.`field_sw_version_value` AS `VERSION`,`f`.`filepath` AS `fid`,`a`.`field_sw_description_value` AS `description`,`a`.`field_sw_type_nid` AS `sw_type_id`,`a`.`field_sw_language_nid` AS `language_id`,`a`.`field_sw_status_nid` AS `status_id`,`c`.`title` AS `sw_type_name`,`d`.`title` AS `language_name`,`e`.`title` AS `status_name` from (((((`content_type_software` `a` join `node` `b`) join `node` `c`) join `node` `d`) join `node` `e`) left join `files` `f` on((`f`.`fid` = `a`.`field_sw_file_fid`))) where ((`a`.`vid` = `b`.`vid`) and (`c`.`nid` = `a`.`field_sw_type_nid`) and (`d`.`nid` = `a`.`field_sw_language_nid`) and (`e`.`nid` = `a`.`field_sw_status_nid`)));

/*!40101 SET SQL_MODE=@OLD_SQL_MODE;
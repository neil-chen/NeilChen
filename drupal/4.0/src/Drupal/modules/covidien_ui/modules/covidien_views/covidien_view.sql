/*
SQLyog v10.2 
MySQL - 5.1.61 : Database - covidien20
*********************************************************************
*/
SET NAMES utf8;
USE covidiendb;

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/*Table structure for table `Configuration_update_VW` */

DROP TABLE IF EXISTS `Configuration_update_VW`;

/*!50001 DROP VIEW IF EXISTS `Configuration_update_VW` */;
/*!50001 DROP TABLE IF EXISTS `Configuration_update_VW` */;


/*Table structure for table `Country_VW` */

DROP TABLE IF EXISTS `Country_VW`;

/*!50001 DROP VIEW IF EXISTS `Country_VW` */;
/*!50001 DROP TABLE IF EXISTS `Country_VW` */;


/*Table structure for table `Customer_VW` */

DROP TABLE IF EXISTS `Customer_VW`;

/*!50001 DROP VIEW IF EXISTS `Customer_VW` */;
/*!50001 DROP TABLE IF EXISTS `Customer_VW` */;


/*Table structure for table `Device_VW` */

DROP TABLE IF EXISTS `Device_VW`;

/*!50001 DROP VIEW IF EXISTS `Device_VW` */;
/*!50001 DROP TABLE IF EXISTS `Device_VW` */;

/*Table structure for table `Hardware_VW` */

DROP TABLE IF EXISTS `Hardware_VW`;

/*!50001 DROP VIEW IF EXISTS `Hardware_VW` */;
/*!50001 DROP TABLE IF EXISTS `Hardware_VW` */;


/*Table structure for table `Software_VW` */

DROP TABLE IF EXISTS `Software_VW`;

/*!50001 DROP VIEW IF EXISTS `Software_VW` */;
/*!50001 DROP TABLE IF EXISTS `Software_VW` */;


/*Table structure for table `config_hw_sw_view` */

DROP TABLE IF EXISTS `config_hw_sw_view`;

/*!50001 DROP VIEW IF EXISTS `config_hw_sw_view` */;
/*!50001 DROP TABLE IF EXISTS `config_hw_sw_view` */;

/*Table structure for table `device_component_discrepancy_view` */

DROP TABLE IF EXISTS `device_component_discrepancy_view`;

/*!50001 DROP VIEW IF EXISTS `device_component_discrepancy_view` */;
/*!50001 DROP TABLE IF EXISTS `device_component_discrepancy_view` */;


/*Table structure for table `device_emerald_software_version_view` */

DROP TABLE IF EXISTS `device_emerald_software_version_view`;

/*!50001 DROP VIEW IF EXISTS `device_emerald_software_version_view` */;
/*!50001 DROP TABLE IF EXISTS `device_emerald_software_version_view` */;


/*Table structure for table `device_scd700_software_version_view` */

DROP TABLE IF EXISTS `device_scd700_software_version_view`;

/*!50001 DROP VIEW IF EXISTS `device_scd700_software_version_view` */;
/*!50001 DROP TABLE IF EXISTS `device_scd700_software_version_view` */;


/*Table structure for table `device_service_history_VW` */

DROP TABLE IF EXISTS `device_service_history_VW`;

/*!50001 DROP VIEW IF EXISTS `device_service_history_VW` */;
/*!50001 DROP TABLE IF EXISTS `device_service_history_VW` */;

/*Table structure for table `device_service_history_view` */

DROP TABLE IF EXISTS `device_service_history_view`;

/*!50001 DROP VIEW IF EXISTS `device_service_history_view` */;
/*!50001 DROP TABLE IF EXISTS `device_service_history_view` */;


/*Table structure for table `device_software_upgrade_view` */

DROP TABLE IF EXISTS `device_software_upgrade_view`;

/*!50001 DROP VIEW IF EXISTS `device_software_upgrade_view` */;
/*!50001 DROP TABLE IF EXISTS `device_software_upgrade_view` */;


/*Table structure for table `device_software_version_view` */

DROP TABLE IF EXISTS `device_software_version_view`;

/*!50001 DROP VIEW IF EXISTS `device_software_version_view` */;
/*!50001 DROP TABLE IF EXISTS `device_software_version_view` */;


/*Table structure for table `discrepancy_list_VW` */

DROP TABLE IF EXISTS `discrepancy_list_VW`;

/*!50001 DROP VIEW IF EXISTS `discrepancy_list_VW` */;
/*!50001 DROP TABLE IF EXISTS `discrepancy_list_VW` */;


/*Table structure for table `hw_discrepancy_list_VW` */

DROP TABLE IF EXISTS `hw_discrepancy_list_VW`;

/*!50001 DROP VIEW IF EXISTS `hw_discrepancy_list_VW` */;
/*!50001 DROP TABLE IF EXISTS `hw_discrepancy_list_VW` */;


/*Table structure for table `select_service_history_VW1` */

DROP TABLE IF EXISTS `select_service_history_VW1`;

/*!50001 DROP VIEW IF EXISTS `select_service_history_VW1` */;
/*!50001 DROP TABLE IF EXISTS `select_service_history_VW1` */;


/*Table structure for table `sw_discrepancy_list_VW` */

DROP TABLE IF EXISTS `sw_discrepancy_list_VW`;

/*!50001 DROP VIEW IF EXISTS `sw_discrepancy_list_VW` */;
/*!50001 DROP TABLE IF EXISTS `sw_discrepancy_list_VW` */;


/*Table structure for table `training_record_view` */

DROP TABLE IF EXISTS `training_record_view`;

/*!50001 DROP VIEW IF EXISTS `training_record_view` */;
/*!50001 DROP TABLE IF EXISTS `training_record_view` */;

/*View structure for view discrepancy_list_VW */

/*!50001 DROP TABLE IF EXISTS `discrepancy_list_VW` */;
/*!50001 DROP VIEW IF EXISTS `discrepancy_list_VW` */;

/*!50001 CREATE OR REPLACE VIEW `discrepancy_list_VW` AS select `content_type_device_discrepancy`.`nid` AS `discrepancy_nid`,`node6`.`nid` AS `productline_nid`,`node6`.`title` AS `productline`,`content_field_device_type`.`field_device_type_nid` AS `devicetype_nid`,`node3`.`title` AS `devicetype`,`content_type_device`.`field_device_serial_number_value` AS `deviceserial`,`node2`.`nid` AS `customer_nid`,`node2`.`title` AS `customername`,`content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`node7`.`nid` AS `country_nid`,`node7`.`title` AS `country_name` from (((((((((((((((`content_type_device_discrepancy` join `content_type_device` on((`content_type_device`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_device_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime2` on(((`content_field_expiration_datetime2`.`vid` = `content_type_device`.`vid`) and isnull(`content_field_expiration_datetime2`.`field_expiration_datetime_value`)))) join `content_field_device_pk` on((`content_field_device_pk`.`field_device_pk_nid` = `content_type_device`.`nid`))) join `content_type_device_installation` on(((`content_type_device_installation`.`nid` = `content_field_device_pk`.`nid`) and (`content_type_device_installation`.`vid` = `content_field_device_pk`.`vid`)))) join `content_type_country` on((`content_type_device_installation`.`field_device_country_nid` = `content_type_country`.`nid`))) join `node` `node7` on((`node7`.`vid` = `content_type_country`.`vid`))) left join `content_type_bu_customer` on((`content_type_device`.`field_device_owner_nid` = `content_type_bu_customer`.`nid`))) left join `content_type_party` on((`content_type_bu_customer`.`field_customer_party_pk_nid` = `content_type_party`.`nid`))) left join `node` `node2` on((`node2`.`vid` = `content_type_party`.`vid`))) left join `node` `node4` on(((`node4`.`nid` = `content_type_bu_customer`.`nid`) and (`node4`.`vid` = `content_type_bu_customer`.`vid`)))) join `content_field_device_type` on((`content_field_device_type`.`vid` = `content_type_device`.`vid`))) join `content_type_devicetype` on((`content_type_devicetype`.`nid` = `content_field_device_type`.`field_device_type_nid`))) join `node` `node3` on((`node3`.`vid` = `content_type_devicetype`.`vid`))) join `content_field_device_product_line` on((`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`))) join `node` `node6` on((`node6`.`nid` = `content_field_device_product_line`.`field_device_product_line_nid`))) */;

/*View structure for view hw_discrepancy_list_VW */

/*!50001 DROP TABLE IF EXISTS `hw_discrepancy_list_VW` */;
/*!50001 DROP VIEW IF EXISTS `hw_discrepancy_list_VW` */;

/*!50001 CREATE OR REPLACE VIEW `hw_discrepancy_list_VW` AS select `content_type_device_discrepancy`.`nid` AS `discrepancy_nid1`,`node`.`title` AS `component_name`,`node`.`type` AS `component_type`,`content_type_hardware`.`field_hw_part_value` AS `part_value`,`content_type_hardware`.`field_hw_version_value` AS `previous_version`,`content_type_hardware`.`field_hw_description_value` AS `old_component_description`,`content_type_hardware1`.`field_hw_version_value` AS `new_version`,`content_type_hardware1`.`field_hw_description_value` AS `new_component_description` from ((((((`content_type_device_discrepancy` join `content_type_hardware` on((`content_type_hardware`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_component_nid`))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`vid` = `content_type_hardware`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) join `node` on((`node`.`vid` = `content_type_hardware`.`vid`))) join `content_type_hardware` `content_type_hardware1` on((`content_type_hardware1`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_old_component_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime1` on(((`content_field_expiration_datetime1`.`vid` = `content_type_hardware1`.`vid`) and isnull(`content_field_expiration_datetime1`.`field_expiration_datetime_value`)))) join `node` `node1` on((`node1`.`vid` = `content_type_hardware1`.`vid`))) */;

/*View structure for view sw_discrepancy_list_VW */

/*!50001 DROP TABLE IF EXISTS `sw_discrepancy_list_VW` */;
/*!50001 DROP VIEW IF EXISTS `sw_discrepancy_list_VW` */;

/*!50001 CREATE OR REPLACE VIEW `sw_discrepancy_list_VW` AS select `content_type_device_discrepancy`.`nid` AS `discrepancy_nid1`,`node`.`title` AS `component_name`,`node`.`type` AS `component_type`,`content_type_software`.`field_sw_part_value` AS `part_value`,`content_type_software`.`field_sw_version_value` AS `previous_version`,`content_type_software`.`field_sw_description_value` AS `old_component_description`,`content_type_software1`.`field_sw_version_value` AS `new_version`,`content_type_software1`.`field_sw_description_value` AS `new_component_description` from ((((((`content_type_device_discrepancy` join `content_type_software` on((`content_type_software`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_component_nid`))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_software`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_software`.`vid`)))) join `node` on(((`node`.`nid` = `content_type_software`.`nid`) and (`node`.`vid` = `content_type_software`.`vid`)))) join `content_type_software` `content_type_software1` on((`content_type_software1`.`nid` = `content_type_device_discrepancy`.`field_discrepancy_old_component_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime1` on(((`content_field_expiration_datetime1`.`nid` = `content_type_software1`.`nid`) and (`content_field_expiration_datetime1`.`vid` = `content_type_software1`.`vid`)))) join `node` `node1` on(((`node1`.`nid` = `content_type_software1`.`nid`) and (`node1`.`vid` = `content_type_software1`.`vid`)))) */;

/*View structure for view device_service_history_VW */

/*!50001 DROP TABLE IF EXISTS `device_service_history_VW` */;
/*!50001 DROP VIEW IF EXISTS `device_service_history_VW` */;

/*!50001 CREATE OR REPLACE VIEW `device_service_history_VW` AS select concat(`content_type_person`.`field_first_name_value`,'.',`content_type_person`.`field_last_name_value`) AS `service_person`,`content_field_device_pk`.`field_device_pk_nid` AS `service_device_nid`,`content_type_device_service_history`.`field_to_device_component_nid` AS `field_to_device_component_nid`,`content_type_device_service_history`.`field_service_datetime_value` AS `field_service_datetime_value` from ((((`content_type_person` join `content_type_device_service_history` on((`content_type_device_service_history`.`field_service_person_pk_nid` = `content_type_person`.`nid`))) join `content_field_device_pk` on((`content_field_device_pk`.`nid` = `content_type_device_service_history`.`nid`))) join `content_type_device_service_type` on((`content_type_device_service_type`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`))) join `node` on((`node`.`vid` = `content_type_device_service_type`.`vid`))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`node`.`title` = 'Configuration Update')) */;

/*View structure for view select_service_history_VW1 */

/*!50001 DROP TABLE IF EXISTS `select_service_history_VW1` */;
/*!50001 DROP VIEW IF EXISTS `select_service_history_VW1` */;

/* Replace the View query in this function service_history_vw1_qry(). 
Base on Jeffrey the query should be put in this file*/
CREATE OR REPLACE VIEW select_service_history_VW1 as SELECT content_field_device_pk.field_device_pk_nid as service_device_nid,
content_type_device_service_history.field_upgrade_status_value as SW_upgrade_status,
count(content_type_device_service_history.field_upgrade_status_value) as Attempts,
content_type_device_service_history.field_from_device_component_nid,
content_type_device_service_history.field_to_device_component_nid,
content_type_device_service_history.field_service_datetime_value as Event_datetime,
concat(content_type_person.field_last_name_value,'.',
content_type_person.field_first_name_value) as service_person 
FROM content_type_device_service_history
JOIN content_type_device_installation on content_type_device_installation.nid=content_type_device_service_history.field_device_installation_pk_nid
JOIN content_field_device_pk on content_field_device_pk.nid=content_type_device_installation.nid and
content_field_device_pk.vid=content_type_device_installation.vid 
JOIN content_type_person on content_type_device_service_history.field_service_person_pk_nid=content_type_person.nid
LEFT JOIN content_field_device_pk as content_field_device_pk1 on content_field_device_pk1.nid=content_type_device_service_history.nid and content_field_device_pk1.field_device_pk_nid=content_field_device_pk.field_device_pk_nid
where content_type_device_service_history.field_upgrade_status_value='installed' or content_type_device_service_history.field_upgrade_status_value='failed' or 
content_type_device_service_history.field_upgrade_status_value='not attempted' or content_type_device_service_history.field_upgrade_status_value LIKE '%Download%'
GROUP BY content_type_device_service_history.field_service_datetime_value;

/*View structure for view Configuration_update_VW */

/*!50001 DROP TABLE IF EXISTS `Configuration_update_VW` */;
/*!50001 DROP VIEW IF EXISTS `Configuration_update_VW` */;

/*!50001 CREATE OR REPLACE VIEW `Configuration_update_VW` AS select max(`content_type_device_service_history`.`field_service_datetime_value`) AS `lastest_date`,`content_field_device_pk`.`field_device_pk_nid` AS `component_device` from ((`content_type_device_service_history` join `content_field_device_pk` on(((`content_type_device_service_history`.`vid` = `content_field_device_pk`.`vid`) and (`content_type_device_service_history`.`nid` = `content_field_device_pk`.`nid`)))) join `node` on((`content_type_device_service_history`.`field_device_service_type_nid` = `node`.`nid`))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`node`.`title` = 'Configuration Update')) group by `content_field_device_pk`.`field_device_pk_nid` */;

/*View structure for view Country_VW */

/*!50001 DROP TABLE IF EXISTS `Country_VW` */;
/*!50001 DROP VIEW IF EXISTS `Country_VW` */;

/*!50001 CREATE OR REPLACE VIEW `Country_VW` AS select `content_field_device_pk`.`field_device_pk_nid` AS `device_nid`,`node2`.`nid` AS `country_nid`,`node2`.`title` AS `country_name` from (((`content_field_device_pk` join `content_type_device_installation` on((`content_type_device_installation`.`vid` = `content_field_device_pk`.`vid`))) left join `content_type_country` on((`content_type_device_installation`.`field_device_country_nid` = `content_type_country`.`nid`))) left join `node` `node2` on((`node2`.`vid` = `content_type_country`.`vid`))) */;

/*View structure for view Customer_VW */

/*!50001 DROP TABLE IF EXISTS `Customer_VW` */;
/*!50001 DROP VIEW IF EXISTS `Customer_VW` */;

/*!50001 CREATE OR REPLACE VIEW `Customer_VW` AS select `content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`node3`.`title` AS `customername`,`node3`.`nid` AS `customer_nid`,`content_type_bu_customer`.`nid` AS `account_nid` from ((`content_type_party` join `content_type_bu_customer` on((`content_type_bu_customer`.`field_customer_party_pk_nid` = `content_type_party`.`nid`))) join `node` `node3` on((`node3`.`nid` = `content_type_bu_customer`.`field_customer_party_pk_nid`))) */;

/*View structure for view Device_VW */

/*!50001 DROP TABLE IF EXISTS `Device_VW` */;
/*!50001 DROP VIEW IF EXISTS `Device_VW` */;

/*!50001 CREATE OR REPLACE VIEW `Device_VW` AS select `node`.`title` AS `productline`,`node`.`nid` AS `productline_nid`,`node1`.`title` AS `devicetype`,`content_type_devicetype`.`nid` AS `devicetype_nid`,`content_type_device`.`nid` AS `device_nid`,`content_type_device`.`field_device_owner_nid` AS `device_owner`,`content_type_device`.`field_device_serial_number_value` AS `deviceserial` from (((((`node` join `content_field_device_product_line` on((`content_field_device_product_line`.`field_device_product_line_nid` = `node`.`nid`))) join `content_type_devicetype` on(((`content_type_devicetype`.`nid` = `content_field_device_product_line`.`nid`) and (`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`)))) join `node` `node1` on(((`node1`.`nid` = `content_type_devicetype`.`nid`) and (`node1`.`vid` = `content_type_devicetype`.`vid`)))) join `content_field_device_type` on((`content_field_device_type`.`field_device_type_nid` = `content_type_devicetype`.`nid`))) join `content_type_device` on((`content_type_device`.`nid` = `content_field_device_type`.`nid`))) */;

/*View structure for view Hardware_VW */

/*!50001 DROP TABLE IF EXISTS `Hardware_VW` */;
/*!50001 DROP VIEW IF EXISTS `Hardware_VW` */;

/*!50001 CREATE OR REPLACE VIEW `Hardware_VW` AS select `content_type_hardware`.`nid` AS `hardware_nid`,`content_type_hardware`.`field_hw_part_value` AS `hardware_part`,`content_type_hardware`.`field_hw_version_value` AS `hardware_version`,`content_type_device_component_history`.`field_device_component_nid` AS `hardware_component`,`content_type_device_component_history`.`field_component_device_nid` AS `component_device`,`node`.`title` AS `hardware_name` from (((`content_type_hardware` join `content_type_device_component_history` on((`content_type_device_component_history`.`field_device_component_nid` = `content_type_hardware`.`nid`))) join `node` on(((`node`.`nid` = `content_type_hardware`.`nid`) and (`node`.`vid` = `content_type_hardware`.`vid`)))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_device_component_history`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_device_component_history`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) */;

/*View structure for view Software_VW */

/*!50001 DROP TABLE IF EXISTS `Software_VW` */;
/*!50001 DROP VIEW IF EXISTS `Software_VW` */;

/*!50001 CREATE OR REPLACE VIEW `Software_VW` AS select `content_type_software`.`nid` AS `software_nid`,`content_type_software`.`field_sw_part_value` AS `software_part`,`content_type_software`.`field_sw_version_value` AS `software_version`,`content_type_device_component_history`.`field_device_component_nid` AS `software_component`,`content_type_device_component_history`.`field_component_device_nid` AS `component_device`,max(`content_type_device_service_history`.`field_service_datetime_value`) AS `lastest_sw_update`,`node`.`title` AS `software_name` from (((((((`content_type_software` join `content_type_device_component_history` on((`content_type_device_component_history`.`field_device_component_nid` = `content_type_software`.`nid`))) join `node` on(((`node`.`nid` = `content_type_software`.`nid`) and (`node`.`vid` = `content_type_software`.`vid`)))) join `content_type_device_service_history` on((`content_type_device_service_history`.`field_to_device_component_nid` = `content_type_device_component_history`.`field_device_component_nid`))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_device_component_history`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_device_component_history`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) join `content_field_device_pk` on(((`content_field_device_pk`.`nid` = `content_type_device_service_history`.`nid`) and (`content_field_device_pk`.`vid` = `content_type_device_service_history`.`vid`) and (`content_type_device_component_history`.`field_component_device_nid` = `content_field_device_pk`.`field_device_pk_nid`)))) join `content_type_device_service_type` on((`content_type_device_service_type`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`))) join `node` `node1` on((`node1`.`vid` = `content_type_device_service_type`.`vid`))) where ((`content_type_device_service_history`.`field_upgrade_status_value` = 'installed') or (`node1`.`title` = 'Configuration Update')) group by `content_type_device_component_history`.`field_component_device_nid` */;

/*View structure for view config_hw_sw_view */

/*!50001 DROP TABLE IF EXISTS `config_hw_sw_view` */;
/*!50001 DROP VIEW IF EXISTS `config_hw_sw_view` */;

/*!50001 CREATE OR REPLACE VIEW `config_hw_sw_view` AS select `node`.`nid` AS `nid`,`content_type_hardware`.`nid` AS `hw_nid`,`content_field_device_type`.`field_device_type_nid` AS `devicetype_nid`,`content_type_hardware`.`field_hw_version_value` AS `hw_version`,`node2`.`type` AS `hw_type`,`node2`.`vid` AS `hw_vid`,`node2`.`title` AS `hw_name`,`content_type_hardware`.`field_hw_description_value` AS `hw_description`,`content_type_software`.`field_sw_version_value` AS `sw_version`,`node`.`type` AS `sw_type`,`node`.`vid` AS `sw_vid`,`node`.`title` AS `sw_title`,`content_type_software`.`field_sw_description_value` AS `sw_description`,`node1`.`title` AS `sw_status`,`content_field_expiration_datetime`.`field_expiration_datetime_value` AS `sw_expiration` from ((((`content_type_hardware` left join ((((`node` join `content_field_hw_list` on(((`content_field_hw_list`.`nid` = `node`.`nid`) and (`content_field_hw_list`.`vid` = `node`.`vid`)))) join `content_type_software` on(((`content_type_software`.`nid` = `content_field_hw_list`.`nid`) and (`content_type_software`.`vid` = `content_field_hw_list`.`vid`)))) join `node` `node1` on(((`node1`.`nid` = `content_type_software`.`field_sw_status_nid`) and ((`node1`.`title` = 'Limited Release') or (`node1`.`title` = 'In Production'))))) join `content_field_expiration_datetime` on(((`content_field_expiration_datetime`.`nid` = `content_type_software`.`nid`) and (`content_field_expiration_datetime`.`vid` = `content_type_software`.`vid`) and isnull(`content_field_expiration_datetime`.`field_expiration_datetime_value`)))) on((`content_type_hardware`.`nid` = `content_field_hw_list`.`field_hw_list_nid`))) join `node` `node2` on(((`node2`.`nid` = `content_type_hardware`.`nid`) and (`node2`.`vid` = `content_type_hardware`.`vid`)))) join `content_field_device_type` on(((`content_field_device_type`.`nid` = `content_type_hardware`.`nid`) and (`content_field_device_type`.`vid` = `content_type_hardware`.`vid`)))) join `content_field_expiration_datetime` `content_field_expiration_datetime1` on(((`content_field_expiration_datetime1`.`nid` = `content_type_hardware`.`nid`) and (`content_field_expiration_datetime1`.`vid` = `content_type_hardware`.`vid`) and isnull(`content_field_expiration_datetime1`.`field_expiration_datetime_value`)))) order by `content_type_hardware`.`nid` */;

/*View structure for view device_component_discrepancy_view */

/*!50001 DROP TABLE IF EXISTS `device_component_discrepancy_view` */;
/*!50001 DROP VIEW IF EXISTS `device_component_discrepancy_view` */;

/*!50001 CREATE OR REPLACE VIEW `device_component_discrepancy_view` AS select `discrepancy_list_VW`.`discrepancy_nid` AS `discrepancy_nid`,`discrepancy_list_VW`.`productline_nid` AS `productline_nid`,`discrepancy_list_VW`.`productline` AS `productline`,`discrepancy_list_VW`.`devicetype_nid` AS `devicetype_nid`,`discrepancy_list_VW`.`devicetype` AS `devicetype`,`discrepancy_list_VW`.`deviceserial` AS `deviceserial`,`discrepancy_list_VW`.`customer_nid` AS `customer_nid`,`discrepancy_list_VW`.`customername` AS `customername`,`discrepancy_list_VW`.`accountnumber` AS `accountnumber`,`discrepancy_list_VW`.`country_nid` AS `country_nid`,`discrepancy_list_VW`.`country_name` AS `country_name`,`hw_discrepancy_list_VW`.`discrepancy_nid1` AS `discrepancy_nid1`,`hw_discrepancy_list_VW`.`component_name` AS `component_name`,`hw_discrepancy_list_VW`.`component_type` AS `component_type`,`hw_discrepancy_list_VW`.`part_value` AS `part_value`,`hw_discrepancy_list_VW`.`previous_version` AS `previous_version`,`hw_discrepancy_list_VW`.`old_component_description` AS `old_component_description`,`hw_discrepancy_list_VW`.`new_version` AS `new_version`,`hw_discrepancy_list_VW`.`new_component_description` AS `new_component_description` from (`hw_discrepancy_list_VW` left join `discrepancy_list_VW` on((`hw_discrepancy_list_VW`.`discrepancy_nid1` = `discrepancy_list_VW`.`discrepancy_nid`))) union all select `discrepancy_list_VW`.`discrepancy_nid` AS `discrepancy_nid`,`discrepancy_list_VW`.`productline_nid` AS `productline_nid`,`discrepancy_list_VW`.`productline` AS `productline`,`discrepancy_list_VW`.`devicetype_nid` AS `devicetype_nid`,`discrepancy_list_VW`.`devicetype` AS `devicetype`,`discrepancy_list_VW`.`deviceserial` AS `deviceserial`,`discrepancy_list_VW`.`customer_nid` AS `customer_nid`,`discrepancy_list_VW`.`customername` AS `customername`,`discrepancy_list_VW`.`accountnumber` AS `accountnumber`,`discrepancy_list_VW`.`country_nid` AS `country_nid`,`discrepancy_list_VW`.`country_name` AS `country_name`,`sw_discrepancy_list_VW`.`discrepancy_nid1` AS `discrepancy_nid1`,`sw_discrepancy_list_VW`.`component_name` AS `component_name`,`sw_discrepancy_list_VW`.`component_type` AS `component_type`,`sw_discrepancy_list_VW`.`part_value` AS `part_value`,`sw_discrepancy_list_VW`.`previous_version` AS `previous_version`,`sw_discrepancy_list_VW`.`old_component_description` AS `old_component_description`,`sw_discrepancy_list_VW`.`new_version` AS `new_version`,`sw_discrepancy_list_VW`.`new_component_description` AS `new_component_description` from (`sw_discrepancy_list_VW` left join `discrepancy_list_VW` on((`sw_discrepancy_list_VW`.`discrepancy_nid1` = `discrepancy_list_VW`.`discrepancy_nid`))) */;

/*View structure for view device_emerald_software_version_view */

/*!50001 DROP TABLE IF EXISTS `device_emerald_software_version_view` */;
/*!50001 DROP VIEW IF EXISTS `device_emerald_software_version_view` */;

/*!50001 CREATE OR REPLACE VIEW `device_emerald_software_version_view` AS select `Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`deviceserial` AS `deviceserial`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customername` AS `customername`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Hardware_VW`.`hardware_nid` AS `hardware_nid`,`Hardware_VW`.`hardware_part` AS `hardware_part`,`Hardware_VW`.`hardware_name` AS `hardware_name`,`Hardware_VW`.`hardware_version` AS `hardware_version`,`Hardware_VW1`.`hardware_nid` AS `hardware1_nid`,`Hardware_VW1`.`hardware_part` AS `hardware1_part`,`Hardware_VW1`.`hardware_name` AS `hardware1_name`,`Hardware_VW1`.`hardware_version` AS `hardware1_version`,`Software_VW`.`software_nid` AS `software_nid`,`Software_VW`.`software_name` AS `software_name`,`Software_VW`.`software_part` AS `software_part`,`Software_VW`.`software_version` AS `software_version`,`Software_VW`.`software_component` AS `software_component`,`Software_VW`.`lastest_sw_update` AS `lastest_sw_update`,`device_service_history_VW`.`service_person` AS `service_person`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from ((((((`Device_VW` left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`account_nid`))) join `Hardware_VW` on(((`Hardware_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW`.`hardware_name` = 'Main PCBA')))) join `Hardware_VW` `Hardware_VW1` on(((`Hardware_VW1`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW1`.`hardware_name` = 'VIBE')))) join `Software_VW` on((`Software_VW`.`component_device` = `Device_VW`.`device_nid`))) join `device_service_history_VW` on(((`device_service_history_VW`.`field_to_device_component_nid` = `Software_VW`.`software_component`) and (`device_service_history_VW`.`service_device_nid` = `Device_VW`.`device_nid`) and (`device_service_history_VW`.`field_service_datetime_value` = `Software_VW`.`lastest_sw_update`)))) order by `Device_VW`.`deviceserial`,`Software_VW`.`lastest_sw_update` desc */;

/*View structure for view device_scd700_software_version_view */

/*!50001 DROP TABLE IF EXISTS `device_scd700_software_version_view` */;
/*!50001 DROP VIEW IF EXISTS `device_scd700_software_version_view` */;

/*!50001 CREATE OR REPLACE VIEW `device_scd700_software_version_view` AS select `Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`deviceserial` AS `deviceserial`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customername` AS `customername`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Hardware_VW`.`hardware_nid` AS `hardware_nid`,`Hardware_VW`.`hardware_part` AS `hardware_part`,`Hardware_VW`.`hardware_name` AS `hardware_name`,`Hardware_VW`.`hardware_version` AS `hardware_version`,`Software_VW`.`software_nid` AS `software_nid`,`Software_VW`.`software_name` AS `software_name`,`Software_VW`.`software_part` AS `software_part`,`Software_VW`.`software_version` AS `software_version`,`Software_VW`.`software_component` AS `software_component`,`Software_VW`.`lastest_sw_update` AS `lastest_sw_update`,`device_service_history_VW`.`service_person` AS `service_person`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from (((((`Device_VW` left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`account_nid`))) join `Hardware_VW` on(((`Hardware_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW`.`hardware_name` = 'Control Board')))) join `Software_VW` on(((`Software_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Software_VW`.`software_name` = 'Control')))) join `device_service_history_VW` on(((`device_service_history_VW`.`field_to_device_component_nid` = `Software_VW`.`software_component`) and (`device_service_history_VW`.`service_device_nid` = `Device_VW`.`device_nid`) and (`device_service_history_VW`.`field_service_datetime_value` = `Software_VW`.`lastest_sw_update`)))) order by `Device_VW`.`deviceserial`,`Software_VW`.`lastest_sw_update` desc */;


/*View structure for view device_service_history_view */

/*!50001 DROP TABLE IF EXISTS `device_service_history_view` */;
/*!50001 DROP VIEW IF EXISTS `device_service_history_view` */;

/*!50001 CREATE OR REPLACE VIEW `device_service_history_view` AS select `content_type_device_service_history`.`nid` AS `servicehistory_nid`,`node6`.`nid` AS `productline_nid`,`node6`.`title` AS `productline`,`content_field_device_type`.`field_device_type_nid` AS `devicetype_nid`,`node3`.`title` AS `devicetype`,`content_type_device`.`field_device_serial_number_value` AS `deviceserial`,`node2`.`nid` AS `customer_nid`,`node2`.`title` AS `customername`,`content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`content_type_person`.`field_person_username_value` AS `technician_email`,`content_type_device_service_history`.`field_service_datetime_value` AS `service_date`,`node`.`nid` AS `servicetype_nid`,`node`.`title` AS `servicetype`,`content_type_device_service_history`.`field_upgrade_status_value` AS `servicetype_status`,`content_type_device_service_history`.`field_from_device_component_nid` AS `from_component_nid`,`content_type_device_service_history`.`field_to_device_component_nid` AS `to_component_nid`,`node7`.`nid` AS `country_nid`,`node7`.`title` AS `country_name` from ((((((((((((((((((`content_type_device_service_history` join `content_type_device_service_type` on((`content_type_device_service_type`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`))) join `node` on(((`node`.`nid` = `content_type_device_service_type`.`nid`) and (`content_type_device_service_type`.`vid` = `node`.`vid`)))) join `content_type_person` on((`content_type_person`.`nid` = `content_type_device_service_history`.`field_service_person_pk_nid`))) join `content_field_device_pk` on(((`content_field_device_pk`.`nid` = `content_type_device_service_history`.`nid`) and (`content_field_device_pk`.`vid` = `content_type_device_service_history`.`vid`)))) join `content_type_device` on((`content_type_device`.`nid` = `content_field_device_pk`.`field_device_pk_nid`))) join `content_field_expiration_datetime` `content_field_expiration_datetime2` on(((`content_field_expiration_datetime2`.`nid` = `content_type_device`.`nid`) and (`content_field_expiration_datetime2`.`vid` = `content_type_device`.`vid`)))) left join `content_type_device_installation` on((`content_type_device_installation`.`nid` = `content_type_device_service_history`.`field_device_installation_pk_nid`))) left join `content_type_country` on((`content_type_device_installation`.`field_device_country_nid` = `content_type_country`.`nid`))) join `node` `node7` on((`node7`.`vid` = `content_type_country`.`vid`))) join `content_type_bu_customer` on((`content_type_device`.`field_device_owner_nid` = `content_type_bu_customer`.`nid`))) join `content_type_party` on((`content_type_bu_customer`.`field_customer_party_pk_nid` = `content_type_party`.`nid`))) join `node` `node2` on(((`node2`.`nid` = `content_type_party`.`nid`) and (`node2`.`vid` = `content_type_party`.`vid`)))) join `content_field_device_type` on(((`content_field_device_type`.`nid` = `content_type_device`.`nid`) and (`content_field_device_type`.`vid` = `content_type_device`.`vid`)))) join `content_type_devicetype` on((`content_type_devicetype`.`nid` = `content_field_device_type`.`field_device_type_nid`))) join `node` `node3` on(((`node3`.`nid` = `content_type_devicetype`.`nid`) and (`node3`.`vid` = `content_type_devicetype`.`vid`)))) join `content_field_device_product_line` on(((`content_field_device_product_line`.`nid` = `content_type_devicetype`.`nid`) and (`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`)))) join `content_type_product_line` on((`content_type_product_line`.`nid` = `content_field_device_product_line`.`field_device_product_line_nid`))) join `node` `node6` on(((`node6`.`nid` = `content_type_product_line`.`nid`) and (`node6`.`vid` = `content_type_product_line`.`vid`)))) where (not(`content_type_device_service_history`.`nid` in (select `content_type_device_service_history`.`nid` from ((`content_type_device_service_history` join `content_type_hardware` on(((`content_type_hardware`.`nid` = `content_type_device_service_history`.`field_to_device_component_nid`) or ((`content_type_hardware`.`nid` = `content_type_device_service_history`.`field_device_service_type_nid`) and (`content_type_hardware`.`nid` = `content_type_device_service_history`.`field_from_device_component_nid`))))) join `node` on(((`node`.`nid` = `content_type_hardware`.`nid`) and (`node`.`vid` = `content_type_hardware`.`vid`))))))) */;

/*View structure for view device_software_upgrade_view */

/*!50001 DROP TABLE IF EXISTS `device_software_upgrade_view` */;
/*!50001 DROP VIEW IF EXISTS `device_software_upgrade_view` */;

/*!50001 CREATE OR REPLACE VIEW `device_software_upgrade_view` AS select `Customer_VW`.`customername` AS `customername`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`device_owner` AS `device_owner`,`Device_VW`.`deviceserial` AS `deviceserial`,`select_service_history_VW1`.`service_device_nid` AS `service_device_nid`,`select_service_history_VW1`.`SW_upgrade_status` AS `SW_upgrade_status`,`select_service_history_VW1`.`Attempts` AS `Attempts`,`select_service_history_VW1`.`field_from_device_component_nid` AS `field_from_device_component_nid`,`select_service_history_VW1`.`field_to_device_component_nid` AS `field_to_device_component_nid`,`select_service_history_VW1`.`Event_datetime` AS `Event_datetime`,`select_service_history_VW1`.`service_person` AS `service_person`,`content_type_software`.`field_sw_version_value` AS `Prior_SW_Version`,`content_type_software1`.`field_sw_version_value` AS `New_SW_Version`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from (((((((`Device_VW` join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`account_nid`))) join `select_service_history_VW1` on((`select_service_history_VW1`.`service_device_nid` = `Device_VW`.`device_nid`))) join `content_type_software` on((`content_type_software`.`nid` = `select_service_history_VW1`.`field_from_device_component_nid`))) join `node` `node1` on(((`node1`.`nid` = `content_type_software`.`nid`) and (`node1`.`vid` = `content_type_software`.`vid`)))) join `content_type_software` `content_type_software1` on((`content_type_software1`.`nid` = `select_service_history_VW1`.`field_to_device_component_nid`))) join `node` on(((`node`.`nid` = `content_type_software1`.`nid`) and (`node`.`vid` = `content_type_software1`.`vid`)))) left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) order by `Device_VW`.`deviceserial`,`select_service_history_VW1`.`Event_datetime` desc */;
/*Replace View Query for this function device_software_upgrade_view()
Base on Jeffrey the query should be put in this file*/
CREATE OR REPLACE VIEW device_software_upgrade_view AS
SELECT Customer_VW.customername,Customer_VW.accountnumber,Customer_VW.customer_nid,Device_VW.*,select_service_history_VW1.*,
content_type_software.field_sw_version_value as Prior_SW_Version,content_type_software1.field_sw_version_value as New_SW_Version,
Country_VW.country_nid,Country_VW.country_name
FROM Device_VW
JOIN Customer_VW on Device_VW.device_owner = Customer_VW.account_nid
JOIN select_service_history_VW1 on select_service_history_VW1.service_device_nid=Device_VW.device_nid
LEFT JOIN content_type_software on content_type_software.nid = select_service_history_VW1.field_from_device_component_nid
LEFT JOIN content_type_software as content_type_software1 on content_type_software1.nid=select_service_history_VW1.field_to_device_component_nid
LEFT JOIN Country_VW on Country_VW.device_nid=Device_VW.device_nid 
group by select_service_history_VW1.Event_datetime
ORDER BY Device_VW.deviceserial,select_service_history_VW1.Event_datetime DESC;
/*View structure for view device_software_version_view */

/*!50001 DROP TABLE IF EXISTS `device_software_version_view` */;
/*!50001 DROP VIEW IF EXISTS `device_software_version_view` */;

/*!50001 CREATE OR REPLACE VIEW `device_software_version_view` AS select `Device_VW`.`productline` AS `productline`,`Device_VW`.`productline_nid` AS `productline_nid`,`Device_VW`.`devicetype` AS `devicetype`,`Device_VW`.`devicetype_nid` AS `devicetype_nid`,`Device_VW`.`device_nid` AS `device_nid`,`Device_VW`.`deviceserial` AS `deviceserial`,`Customer_VW`.`accountnumber` AS `accountnumber`,`Customer_VW`.`customername` AS `customername`,`Customer_VW`.`customer_nid` AS `customer_nid`,`Hardware_VW`.`hardware_nid` AS `hardware_nid`,`Hardware_VW`.`hardware_part` AS `hardware_part`,`Hardware_VW`.`hardware_name` AS `hardware_name`,`Hardware_VW`.`hardware_version` AS `hardware_version`,`Hardware_VW1`.`hardware_nid` AS `hardware1_nid`,`Hardware_VW1`.`hardware_part` AS `hardware1_part`,`Hardware_VW1`.`hardware_name` AS `hardware1_name`,`Hardware_VW1`.`hardware_version` AS `hardware1_version`,`Software_VW`.`software_nid` AS `software_nid`,`Software_VW`.`software_name` AS `software_name`,`Software_VW`.`software_part` AS `software_part`,`Software_VW`.`software_version` AS `software_version`,`Software_VW`.`software_component` AS `software_component`,`Software_VW`.`lastest_sw_update` AS `lastest_sw_update`,`device_service_history_VW`.`service_person` AS `service_person`,`Country_VW`.`country_nid` AS `country_nid`,`Country_VW`.`country_name` AS `country_name` from ((((((`Device_VW` left join `Country_VW` on((`Country_VW`.`device_nid` = `Device_VW`.`device_nid`))) join `Customer_VW` on((`Device_VW`.`device_owner` = `Customer_VW`.`account_nid`))) join `Hardware_VW` on(((`Hardware_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW`.`hardware_name` = 'BdPcba')))) join `Hardware_VW` `Hardware_VW1` on(((`Hardware_VW1`.`component_device` = `Device_VW`.`device_nid`) and (`Hardware_VW1`.`hardware_name` = 'GuiPcba')))) join `Software_VW` on(((`Software_VW`.`component_device` = `Device_VW`.`device_nid`) and (`Software_VW`.`software_name` = 'BdSoftware')))) join `device_service_history_VW` on(((`device_service_history_VW`.`field_to_device_component_nid` = `Software_VW`.`software_component`) and (`device_service_history_VW`.`service_device_nid` = `Device_VW`.`device_nid`) and (`device_service_history_VW`.`field_service_datetime_value` = `Software_VW`.`lastest_sw_update`)))) order by `Device_VW`.`deviceserial`,`Software_VW`.`lastest_sw_update` desc */;


/*View structure for view training_record_view */

/*!50001 DROP TABLE IF EXISTS `training_record_view` */;
/*!50001 DROP VIEW IF EXISTS `training_record_view` */;

/*!50001 CREATE OR REPLACE VIEW `training_record_view` AS select `node4`.`title` AS `customername`,`node4`.`nid` AS `customer_nid`,`content_type_bu_customer`.`field_bu_customer_account_number_value` AS `accountnumber`,`node5`.`nid` AS `productline_nid`,`node5`.`title` AS `productline`,`content_type_person`.`nid` AS `trainee_nid`,`node`.`title` AS `trainee_name`,`content_type_person1`.`nid` AS `trainer_nid`,`node1`.`title` AS `trainer_name`,`content_type_devicetype`.`nid` AS `devicetype_nid`,`node3`.`title` AS `devicetype`,`content_type_person_training_record`.`field_training_completion_date_value` AS `training_completion_date`,`content_type_person_training_record`.`field_active_flag_value` AS `training_status` from (((((((((((((((`content_type_person_training_record` join `content_type_person` on((`content_type_person_training_record`.`field_trainee_id_nid` = `content_type_person`.`nid`))) join `node` on(((`node`.`nid` = `content_type_person`.`nid`) and (`node`.`vid` = `content_type_person`.`vid`)))) join `content_type_person` `content_type_person1` on((`content_type_person_training_record`.`field_trainer_id_nid` = `content_type_person1`.`nid`))) join `node` `node1` on(((`node1`.`nid` = `content_type_person1`.`nid`) and (`node1`.`vid` = `content_type_person1`.`vid`))))) join `content_type_party` on((`content_type_party`.`nid` = `content_type_person`.`field_person_party_nid`))) join `node` `node2` on(((`node2`.`nid` = `content_type_party`.`nid`) and (`node2`.`vid` = `content_type_party`.`vid`)))) left join `content_type_bu_customer` on((`content_type_bu_customer`.`field_customer_party_pk_nid` = `content_type_person`.`field_company_name_nid`))) left join `node` `node4` on((`node4`.`nid` = `content_type_bu_customer`.`field_customer_party_pk_nid`))) join `content_field_device_type` on(((`content_field_device_type`.`nid` = `content_type_person_training_record`.`nid`) and (`content_field_device_type`.`vid` = `content_type_person_training_record`.`vid`)))) join `content_type_devicetype` on((`content_type_devicetype`.`nid` = `content_field_device_type`.`field_device_type_nid`))) join `node` `node3` on(((`node3`.`nid` = `content_type_devicetype`.`nid`) and (`node3`.`vid` = `content_type_devicetype`.`vid`)))) join `content_field_device_product_line` on(((`content_field_device_product_line`.`nid` = `content_type_devicetype`.`nid`) and (`content_field_device_product_line`.`vid` = `content_type_devicetype`.`vid`)))) join `content_type_product_line` on((`content_type_product_line`.`nid` = `content_field_device_product_line`.`field_device_product_line_nid`))) join `node` `node5` on(((`node5`.`nid` = `content_type_product_line`.`nid`) and (`node5`.`vid` = `content_type_product_line`.`vid`)))) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

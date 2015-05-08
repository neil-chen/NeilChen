USE `covidiendb`;

DROP TABLE IF EXISTS `view_hardware`; 
DROP TABLE IF EXISTS `view_software`; 
DROP TABLE IF EXISTS `view_firmware`; 
DROP TABLE IF EXISTS `view_named_configuration`; 
DROP TABLE IF EXISTS `view_named_configuration_relation`; 
DROP TABLE IF EXISTS `view_named_system_configuration`; 
DROP TABLE IF EXISTS `view_named_hardware_configuration`; 
DROP TABLE IF EXISTS `view_named_software_configuration`; 
DROP TABLE IF EXISTS `view_named_firmware_configuration`; 

/* View structure for view `view_hardware` */
/* --DROP VIEW IF EXISTS `view_hardware`; */
CREATE ALGORITHM=UNDEFINED DEFINER = `covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_hardware` AS (
select  `a`.`nid` AS `id`,  `b`.`title` AS `NAME`,  `a`.`field_hw_part_value` AS `part`,  `a`.`field_hw_version_value` AS `VERSION`,  `a`.`field_hw_description_value` AS `description`,  `a`.`field_hw_type_nid` AS `hw_type_id` from (`content_type_hardware` `a`  join `node` `b`) where (`a`.`vid` = `b`.`vid`));


/* View structure for view `view_software` */
CREATE ALGORITHM=UNDEFINED DEFINER = `covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_software` AS (
select  `a`.`vid` AS `id`,  `b`.`title` AS `NAME`,  `a`.`field_sw_part_value` AS `part`,  `a`.`field_sw_version_value` AS `VERSION`,  `f`.`filepath` AS `fid`,  `a`.`field_sw_description_value` AS `description`,  `a`.`field_sw_type_nid` AS `sw_type_id`,  `a`.`field_sw_language_nid` AS `language_id`,  `a`.`field_sw_status_nid` AS `status_id`,  `c`.`title` AS `sw_type_name`,  `d`.`title` AS `language_name`,  `e`.`title` AS `status_name` from (((((`content_type_software` `a`  join `node` `b`)  join `node` `c`)  join `node` `d`)  join `node` `e`)  left join `files` `f`  on ((`f`.`fid` = `a`.`field_sw_file_fid`))) where ((`a`.`vid` = `b`.`vid`)  and (`c`.`nid` = `a`.`field_sw_type_nid`)  and (`d`.`nid` = `a`.`field_sw_language_nid`)  and (`e`.`nid` = `a`.`field_sw_status_nid`)));


/* View structure for view `view_firmware` */
CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_firmware` AS (
select  `n`.`nid` AS `nid`,  `n`.`title` AS `title`,  `f`.`part` AS `part`,  `f`.`version` AS `version`,  `f`.`device_type_id` AS `device_type_id`,  `f`.`description` AS `description`,  `f`.`file` AS `file`,  `f`.`file_id` AS `file_id`,  `n`.`created` AS `create_time`,  `n`.`changed` AS `update_time`,  `f`.`type_id` AS `type_id`,  `f`.`status` AS `status` from (`firmware` `f`  join `node` `n`  on ((`n`.`nid` = `f`.`nid`))));


/* View structure for view `view_named_configuration` */
CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_configuration` AS (
select `c`.`nid` AS `nid`,`c`.`type_id` AS `type_id`,`n`.`title` AS `title`,`c`.`device_type_id` AS `device_type_id`,`c`.`version` AS `version`,`n`.`created` AS `create_time`,`n`.`changed` AS `update_time`,if(`c`.`obsolete_time`,0,1) AS `is_obsolete`,`c`.`description` AS `description`,`t`.`name` AS `type_name`,`t`.`title` AS `type_title`,`t`.`link_type_id` AS `link_type_id` from ((`named_configuration` `c` join `node` `n` on((`c`.`nid` = `n`.`nid`))) left join `named_configuration_type` `t` on((`c`.`type_id` = `t`.`id`))));


/* View structure for view `view_named_configuration_relation` */
CREATE ALGORITHM=UNDEFINED DEFINER = `covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_configuration_relation` AS (
select  `r`.`id` AS `id`,  `r`.`left_nid` AS `left_nid`,  `r`.`left_type` AS `left_type`,  `nl`.`title` AS `left_title`,  `tl`.`name` AS `left_type_name`,  `tl`.`title` AS `left_type_title`,  `r`.`right_nid` AS `right_nid`,  `r`.`right_type` AS `right_type`,  `nr`.`title` AS `right_title`,  `tr`.`name` AS `right_type_name`,  `tr`.`title` AS `right_type_title`,  `r`.`create_time` AS `create_time`,  `r`.`update_time` AS `update_time` from ((((`named_configuration_relation` `r`  left join `node` `nl`  on ((`r`.`left_nid` = `nl`.`nid`)))  left join `node` `nr`  on ((`r`.`right_nid` = `nr`.`nid`)))  left join `named_configuration_type` `tl`  on ((`r`.`left_type` = `tl`.`id`)))  left join `named_configuration_type` `tr`  on ((`r`.`right_type` = `tr`.`id`))));


/*View structure for view view_named_system_configuration */
CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_system_configuration` AS (
select  `c`.`nid` AS `nid`,  `c`.`type_id` AS `type_id`,  `cn`.`title` AS `title`,  `c`.`device_type_id` AS `device_type_id`,  `d`.`title` AS `device_type_name`,  `c`.`version` AS `version`,  `c`.`description` AS `description`,  `cn`.`created` AS `create_time`,  `cn`.`changed` AS `update_time`,  max((case `rt`.`name` when 'hardware_configuration' then `r`.`right_nid` else NULL end)) AS `hw_config_nid`,  max((case `rt`.`name` when 'software_configuration' then `r`.`right_nid` else NULL end)) AS `sw_config_nid`,  max((case `rt`.`name` when 'firmware_configuration' then `r`.`right_nid` else NULL end)) AS `fw_config_nid` from (((((`named_configuration` `c`  join `named_configuration_type` `t`  on ((`c`.`type_id` = `t`.`id`)))  join `node` `cn`  on ((`c`.`nid` = `cn`.`nid`)))  left join `named_configuration_relation` `r`  on ((`c`.`nid` = `r`.`left_nid`)))  left join `named_configuration_type` `rt`  on ((`r`.`right_type` = `rt`.`id`)))  left join `node` `d`  on ((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'system_configuration') group by `c`.`nid`);


/*View structure for view view_named_hardware_configuration */
CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_hardware_configuration` AS (
select  `c`.`nid` AS `nid`,  `c`.`type_id` AS `type_id`,  `nh`.`title` AS `title`,  `c`.`device_type_id` AS `device_type_id`,  `d`.`title` AS `device_type_name`,  `c`.`version` AS `version`,  `c`.`description` AS `description`,  `nh`.`created` AS `create_time`,  `nh`.`changed` AS `update_time`,  group_concat(distinct `h`.`nid` separator ',') AS `hardware_list` from (((((`named_configuration` `c`  join `named_configuration_type` `t`  on ((`c`.`type_id` = `t`.`id`)))  join `node` `nh`  on ((`c`.`nid` = `nh`.`nid`)))  left join `named_configuration_relation` `r`  on ((`c`.`nid` = `r`.`left_nid`)))  left join `content_type_hardware` `h`  on ((`r`.`right_nid` = `h`.`nid`)))  left join `node` `d`  on ((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'hardware_configuration') group by `c`.`nid`);


/*View structure for view view_named_software_configuration */
CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_software_configuration` AS (
select  `c`.`nid` AS `nid`,  `c`.`type_id` AS `type_id`,  `ns`.`title` AS `title`,  `c`.`device_type_id` AS `device_type_id`,  `d`.`title` AS `device_type_name`,  `c`.`version` AS `version`,  `c`.`description` AS `description`,  `ns`.`created` AS `create_time`,  `ns`.`changed` AS `update_time`,  group_concat(distinct `s`.`nid` separator ',') AS `software_list` from (((((`named_configuration` `c`  join `named_configuration_type` `t`  on ((`c`.`type_id` = `t`.`id`)))  join `node` `ns`  on ((`c`.`nid` = `ns`.`nid`)))  left join `named_configuration_relation` `r`  on ((`c`.`nid` = `r`.`left_nid`)))  left join `content_type_software` `s`  on ((`r`.`right_nid` = `s`.`nid`)))  left join `node` `d`  on ((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'software_configuration') group by `c`.`nid`);


/*View structure for view view_named_firmware_configuration */
CREATE ALGORITHM=UNDEFINED DEFINER=`covidiendbuser`@`localhost` SQL SECURITY DEFINER VIEW `view_named_firmware_configuration` AS (
select  `c`.`nid` AS `nid`,  `c`.`type_id` AS `type_id`,  `nf`.`title` AS `title`,  `c`.`device_type_id` AS `device_type_id`,  `d`.`title` AS `device_type_name`,  `c`.`version` AS `version`,  `c`.`description` AS `description`,  `nf`.`created` AS `create_time`,  `nf`.`changed` AS `update_time`,  group_concat(distinct `f`.`nid` separator ',') AS `firmware_list` from (((((`named_configuration` `c`  join `named_configuration_type` `t`  on ((`c`.`type_id` = `t`.`id`)))  join `node` `nf`  on ((`c`.`nid` = `nf`.`nid`)))  left join `named_configuration_relation` `r`  on ((`c`.`nid` = `r`.`left_nid`)))  left join `firmware` `f`  on ((`r`.`right_nid` = `f`.`nid`)))  left join `node` `d`  on ((`c`.`device_type_id` = `d`.`nid`))) where (`t`.`name` = 'firmware_configuration') group by `c`.`nid`);

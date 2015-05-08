/*
SQLyog Enterprise - MySQL GUI v8.1 
MySQL - 5.1.61 : Database - covidiendb
*********************************************************************
 */

/*!40101 SET NAMES utf8;*/

/*!40101 SET SQL_MODE='';*/

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';*/

/* Trigger structure for table `named_configuration`  */

DELIMITER $$

DROP TRIGGER IF EXISTS `named_configuration_insert_trigger`  $$

CREATE  DEFINER=`covidiendbuser`@`localhost` TRIGGER `named_configuration_insert_trigger` AFTER INSERT ON `named_configuration` FOR EACH ROW BEGIN
  INSERT INTO named_configuration_history(his_id , action, type_id, name , 
  device_type_id , version , create_time , description
  ) VALUES (
   NEW.id , 'INSERT' , NEW.type_id , NEW.name , NEW.device_type_id , 
 NEW.version ,  NEW.create_time , NEW.description
  ) ; 
END  $$


DELIMITER ;

/* Trigger structure for table `named_configuration`  */

DELIMITER $$

DROP TRIGGER IF EXISTS `named_configuration_update_trigger`  $$

CREATE  DEFINER=`covidiendbuser`@`localhost` TRIGGER `named_configuration_update_trigger` AFTER UPDATE ON `named_configuration` FOR EACH ROW BEGIN
  INSERT INTO named_configuration_history( his_id , action, type_id, name , 
  device_type_id , version , create_time , update_time , description
  ) VALUES (
   NEW.id , 'UPDATE' , NEW.type_id , NEW.name , NEW.device_type_id , 
 NEW.version ,  NEW.create_time , NEW.update_time , NEW.description
  ) ; 
END  $$


DELIMITER ;

/* Trigger structure for table `named_configuration`  */

DELIMITER $$

DROP TRIGGER IF EXISTS `named_configuration_delete_trigger`  $$

CREATE  DEFINER=`covidiendbuser`@`localhost` TRIGGER `named_configuration_delete_trigger` AFTER DELETE ON `named_configuration` FOR EACH ROW BEGIN
  INSERT INTO named_configuration_history( his_id , action, type_id, name , 
  device_type_id , version , create_time , update_time , description
  ) VALUES (
   OLD.id , 'DELETE' , OLD.type_id , OLD.name , OLD.device_type_id , 
 OLD.version ,  OLD.create_time ,  NOW() , OLD.description  
  ) ; 
END  $$


DELIMITER ;

/* Trigger structure for table `named_configuration_relation` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `named_configuration_relation_insert_trigger` */$$

/*!50003 CREATE */  /*!50003 TRIGGER `named_configuration_relation_insert_trigger` AFTER INSERT ON `named_configuration_relation` FOR EACH ROW BEGIN
    INSERT INTO named_configuration_relation_history(his_id , action, config_id ,
       ref_id, create_time , ref_type
    ) VALUES (
       NEW.id , 'INSERT' , NEW.config_id ,
       NEW.ref_id , NEW.create_time , NEW.ref_type
    ) ; 
END */$$


DELIMITER ;

/* Trigger structure for table `named_configuration_relation` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `named_configuration_relation_update_trigger` */$$

/*!50003 CREATE */  /*!50003 TRIGGER `named_configuration_relation_update_trigger` AFTER UPDATE ON `named_configuration_relation` FOR EACH ROW BEGIN
    INSERT INTO named_configuration_relation_history(his_id , action, config_id ,
       ref_id, create_time ,update_time,ref_type
    ) VALUES (
       NEW.id , 'UPDATE' , NEW.config_id ,
       NEW.ref_id , NEW.create_time , NEW.update_time ,
       NEW.ref_type
    ) ; 
END */$$


DELIMITER ;

/* Trigger structure for table `named_configuration_relation` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `named_configuration_relation_delete_trigger` */$$

/*!50003 CREATE */  /*!50003 TRIGGER `named_configuration_relation_delete_trigger` AFTER DELETE ON `named_configuration_relation` FOR EACH ROW BEGIN
    INSERT INTO named_configuration_relation_history(his_id , action, config_id ,
       ref_id, create_time ,update_time,ref_type
    ) VALUES (
       OLD.id , 'DELETE' , OLD.config_id ,
       OLD.ref_id , OLD.create_time , OLD.update_time , OLD.ref_type  
    ) ; 
END */$$


DELIMITER ;

/* Trigger structure for table `named_configuration_type`  */

DELIMITER $$

DROP TRIGGER IF EXISTS `named_configuration_type_insert_trigger`  $$

CREATE  DEFINER=`covidiendbuser`@`localhost` TRIGGER `named_configuration_type_insert_trigger` AFTER INSERT ON `named_configuration_type` FOR EACH ROW BEGIN
  INSERT INTO named_configuration_type_history(
	  his_id , action, name , create_time 
  ) VALUES (
   NEW.id , 'INSERT' , NEW.name , NOW()
  ) ; 
END  $$


DELIMITER ;

/* Trigger structure for table `named_configuration_type`  */

DELIMITER $$

DROP TRIGGER IF EXISTS `named_configuration_type_update_trigger`  $$

CREATE  DEFINER=`covidiendbuser`@`localhost` TRIGGER `named_configuration_type_update_trigger` AFTER UPDATE ON `named_configuration_type` FOR EACH ROW BEGIN
  INSERT INTO named_configuration_type_history(
  his_id , action, name ,update_time
  ) VALUES (
   NEW.id , 'UPDATE' , NEW.name , NOW()
  ) ; 
END  $$


DELIMITER ;

/* Trigger structure for table `named_configuration_type`  */

DELIMITER $$

DROP TRIGGER IF EXISTS `named_configuration_type_delete_trigger`  $$

CREATE  DEFINER=`covidiendbuser`@`localhost` TRIGGER `named_configuration_type_delete_trigger` AFTER DELETE ON `named_configuration_type` FOR EACH ROW BEGIN
  INSERT INTO named_configuration_type_history(
	  his_id , action, name , update_time
  ) VALUES (
   OLD.id , 'DELETE' , OLD.name , NOW()
  ) ; 
END  $$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE  ;*/
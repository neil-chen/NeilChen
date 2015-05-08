USE covidiendb ;


/*  ----------------------  named configuration  start   ----------------------------- */
/*
  create named_configuration table
*/
-- DROP table if Exists named_configuration ;
CREATE TABLE IF NOT EXISTS `named_configuration` (                                                                                                                                                                                                                                                                                                                                                                                                                                       
	`id` int(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                    
	`type_id` int(2) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`name` varchar(100) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`device_type_id` int(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                   
	`version` varchar(100) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`create_time` datetime DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`update_time` datetime DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`description` varchar(255) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                         
	`is_obsolete` INT(1) NOT NULL DEFAULT '0'                                                                                                                                                                                                                                                                                                                                                                                                                             
	PRIMARY KEY (`id`)                                                                                                                                                                                                                                                                                                                                                                                                                                                       
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ;

/*
  create named_configuration history table
*/
DROP table if Exists named_configuration_history ;
CREATE TABLE IF NOT EXISTS `named_configuration_history` (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`id` INT(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`his_id` INT(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	`action` VARCHAR(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                       
	`type_id` int(2) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`name` varchar(100) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`device_type_id` int(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                   
	`version` varchar(100) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`create_time` datetime DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`update_time` datetime DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`description` varchar(255) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                     
	PRIMARY KEY (`id`)                                                                                                                                                                                                                                                                                                                                                                                                                                                       
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ;
					 
					 
/*
  create named_configuration_relation table
*/
-- DROP table if Exists named_configuration_relation ;
CREATE TABLE IF NOT EXISTS `named_configuration_relation` (                                                                                                                                                                                                                                                                                                                                                                                                                                            
	`id` INT(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                                   
	`config_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`his_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                              
	`create_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                    
	`update_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`ref_type` INT(1) NOT NULL DEFAULT '0'
   	COMMENT '0:hardware,1:software;2:firmware;3:hardwareConfig,4:softwareConfig;5:firmwareConfig',                                                                                                                                                                                                                                                                                                                                                   
	PRIMARY KEY (`id`)                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8  ;

					 
/*
  create named_configuration_relation history table
*/
DROP table if Exists named_configuration_relation_history ;
CREATE TABLE IF NOT EXISTS `named_configuration_relation_history` (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`id` INT(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`his_id` INT(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	`action` VARCHAR(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                 
	`config_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`ref_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                              
	`create_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                    
	`update_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`ref_type` INT(1) NOT NULL DEFAULT '0'
   	COMMENT '0:hardware,1:software;2:firmware;3:hardwareConfig,4:softwareConfig;5:firmwareConfig',                                                                                                                                                                                                                                                                                                                                                   
	PRIMARY KEY (`id`)                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8  ;



/*
  create named_configuration_type table
*/
CREATE TABLE IF NOT EXISTS `named_configuration_type` (                                                                                                                        
	`id` INT(10) NOT NULL,                                                                                                                                         
	`name` VARCHAR(30) DEFAULT NULL,                                                                                                                               
	PRIMARY KEY (`id`)                                                                                                                                             
) ENGINE=INNODB DEFAULT CHARSET=utf8   ;                                                                                                       


/*
  create named_configuration_type_history table
*/
DROP table if Exists named_configuration_type_history ;
CREATE TABLE IF NOT EXISTS `named_configuration_type_history` (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`id` INT(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`his_id` INT(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	`action` VARCHAR(10) DEFAULT NULL,                                                                                                                              
	`name` VARCHAR(30) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`create_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                    
	`update_time` DATETIME DEFAULT NULL,                                                                                                                       
	PRIMARY KEY (`id`)                                                                                                                                             
) ENGINE=INNODB DEFAULT CHARSET=utf8   ;                                                                                                       


/*
  create named configuration view
*/
DELIMITER //
DROP VIEW IF EXISTS view_named_configuration //
CREATE VIEW view_named_configuration AS (
SELECT
  `id`             AS `id`,
  `type_id`        AS `type_id`,
  `name`           AS `name`,
  `device_type_id` AS `device_type_id`,
  `version`        AS `version`,
  `create_time`    AS `create_time`,
  `update_time`    AS `update_time`,
  `is_obsolete`    AS `is_obsolete`,
  `description`    AS `description`  
FROM named_configuration) //
DELIMITER ;

--  create named configuration relations view
DELIMITER //
DROP VIEW IF EXISTS view_named_configuration_relation //
CREATE VIEW view_named_configuration_relation AS (
	SELECT
	  `id`          AS `id`,
	  `config_id`   AS `config_id`,
	  `ref_type`    AS `ref_type`,
	  `ref_id`      AS `ref_id`,
	  `create_time` AS `create_time`,
	  `update_time` AS `update_time`
	FROM named_configuration_relation
) //
DELIMITER ;


-- named_configuration insert trigger 
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_insert_trigger //
CREATE TRIGGER named_configuration_insert_trigger AFTER INSERT ON named_configuration
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_history(his_id , action, type_id, name , 
	  device_type_id , version , create_time , description
    ) VALUES (
       NEW.id , 'INSERT' , NEW.type_id , NEW.name , NEW.device_type_id , 
	   NEW.version ,  NEW.create_time , NEW.description
    ) ; 
END ; //
DELIMITER ; 

-- named_configuration update trigger
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_update_trigger //
CREATE TRIGGER named_configuration_update_trigger AFTER UPDATE ON named_configuration
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_history( his_id , action, type_id, name , 
	  device_type_id , version , create_time , update_time , description
    ) VALUES (
       NEW.id , 'UPDATE' , NEW.type_id , NEW.name , NEW.device_type_id , 
	   NEW.version ,  NEW.create_time , NEW.update_time , NEW.description
    ) ; 
END ; //
DELIMITER ;  

-- named_configuration delete trigger
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_delete_trigger //
CREATE TRIGGER named_configuration_delete_trigger AFTER DELETE ON named_configuration
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_history( his_id , action, type_id, name , 
	  device_type_id , version , create_time , update_time , description
    ) VALUES (
       OLD.id , 'DELETE' , OLD.type_id , OLD.name , OLD.device_type_id , 
	   OLD.version ,  OLD.create_time ,  NOW() , OLD.description  
    ) ; 
END ; //
DELIMITER ;  

										 
-- named_configuration_relation insert trigger 
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_relation_insert_trigger //
CREATE TRIGGER named_configuration_relation_insert_trigger AFTER INSERT ON named_configuration_relation
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_relation_history(his_id , action, config_id ,
       ref_id, create_time , ref_type
    ) VALUES (
       NEW.id , 'INSERT' , NEW.config_id ,
       NEW.ref_id , NEW.create_time , NEW.ref_type
    ) ; 
END ; //
DELIMITER ; 
         
	 
-- named_configuration_relation update trigger
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_relation_update_trigger //
CREATE TRIGGER named_configuration_relation_update_trigger AFTER UPDATE ON named_configuration_relation
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_relation_history(his_id , action, config_id ,
       ref_id, create_time ,update_time,ref_type
    ) VALUES (
       NEW.id , 'UPDATE' , NEW.config_id ,
       NEW.ref_id , NEW.create_time , NEW.update_time ,
       NEW.ref_type
    ) ; 
END ; //
DELIMITER ;  

-- named_configuration_relation delete trigger
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_relation_delete_trigger //
CREATE TRIGGER named_configuration_relation_delete_trigger AFTER DELETE ON named_configuration_relation
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_relation_history(his_id , action, config_id ,
       ref_id, create_time ,update_time,ref_type
    ) VALUES (
       OLD.id , 'DELETE' , OLD.config_id ,
       OLD.ref_id , OLD.create_time , NOW() , OLD.ref_type     
    ) ; 
END ; //
DELIMITER ;  

									
-- named_configuration_type insert trigger 
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_type_insert_trigger //
CREATE TRIGGER named_configuration_type_insert_trigger AFTER INSERT ON named_configuration_type
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_type_history(
	  his_id , action, name , create_time 
    ) VALUES (
       NEW.id , 'INSERT' , NEW.name , NOW()
    ) ; 
END ; //
DELIMITER ; 
         
	 
-- named_configuration_type update trigger
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_type_update_trigger //
CREATE TRIGGER named_configuration_type_update_trigger AFTER UPDATE ON named_configuration_type
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_type_history(
	  his_id , action, name ,update_time
    ) VALUES (
       NEW.id , 'UPDATE' , NEW.name , NOW()
    ) ; 
END ; //
DELIMITER ;  

-- named_configuration_type delete trigger
DELIMITER //
DROP TRIGGER IF EXISTS named_configuration_type_delete_trigger //
CREATE TRIGGER named_configuration_type_delete_trigger AFTER DELETE ON named_configuration_type
FOR EACH ROW
BEGIN
    INSERT INTO named_configuration_type_history(
	  his_id , action, name , update_time
    ) VALUES (
       OLD.id , 'DELETE' , OLD.name , NOW()
    ) ; 
END ; //
DELIMITER ;  

/*  ----------------------  named configuration  end   ----------------------------- */



/*  ----------------------  firmware  start   ----------------------------- */
/*
  create firmware table 
*/
DROP TABLE IF EXISTS firmware;
CREATE TABLE IF NOT EXISTS `firmware` (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`id` INT(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`name` VARCHAR(100) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
	`part` VARCHAR(50) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
	`version` VARCHAR(50) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
	`device_type_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`description` VARCHAR(255) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
	`file` VARCHAR(255) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
	`file_id` INT(10) DEFAULT NULL,
	`file_integrity_check_value` VARCHAR(50) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
	`create_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
	`update_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`type_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`status` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	PRIMARY KEY (`id`)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*
  create firmware_status table 
*/
DROP TABLE IF EXISTS firmware_status;
CREATE TABLE IF NOT EXISTS `firmware_status` (                                                                                                                                               
   `id` int(10) NOT NULL AUTO_INCREMENT,                                                                                                                                             
   `name` varchar(20) NOT NULL,                                                                                                                                                      
   PRIMARY KEY (`id`)                                                                                                                                                                
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ;
                                                                                                                                           
/*
  create firmware history table
*/
DROP table if Exists firmware_history;
CREATE TABLE IF NOT EXISTS `firmware_history` (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`id` INT(10) NOT NULL AUTO_INCREMENT,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
	`his_id` INT(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
	`action` VARCHAR(10) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`name` VARCHAR(100) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
	`part` VARCHAR(50) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
	`version` VARCHAR(50) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
	`device_type_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
	`description` VARCHAR(255) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
	`file` VARCHAR(255) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         
	`file_id` INT(10) DEFAULT NULL,
	`file_integrity_check_value` VARCHAR(50) DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
	`create_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
	`update_time` DATETIME DEFAULT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
	`type_id` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
	PRIMARY KEY (`id`)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*
  create firmware view
*/
DELIMITER //
DROP VIEW IF EXISTS `view_firmware` //
CREATE VIEW `view_firmware` AS (
SELECT
  `a`.`id`             AS `id`,
  `a`.`name`           AS `name`,
  `a`.`part`           AS `part`,
  `a`.`version`        AS `version`,
  `a`.`device_type_id` AS `device_type_id`,
  `a`.`description`    AS `description`,
  `b`.`filepath`           AS `file_path`,
  CONCAT((`b`.`filesize` / 1024),'KB') AS `filesize`,
  FROM_UNIXTIME(`b`.`timestamp`) AS `upload_time`,
  `c`.`name`           AS `status`
FROM ((`firmware` `a`
    LEFT JOIN `files` `b`
      ON ((`a`.`file_id` = `b`.`fid`)))
   LEFT JOIN `firmware_status` `c`
     ON ((`a`.`status` = `c`.`id`)))) //
DELIMITER;

/*
  create firmware_exception 
*/
DROP TABLE IF EXISTS firmware_exception;
CREATE TABLE IF NOT EXISTS `firmware_exception` (                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
	`firmware_nid` INT(10) NOT NULL,                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
	`country_nid` INT(10) NOT NULL                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8  ;


-- firmware insert trigger 
DELIMITER //
DROP TRIGGER IF EXISTS firmware_insert_trigger //
CREATE TRIGGER firmware_insert_trigger AFTER INSERT ON firmware
FOR EACH ROW
BEGIN
    INSERT INTO firmware_history(his_id , ACTION, NAME ,
       part, VERSION ,device_type_id,description,FILE,
       file_id, create_time,update_time,type_id
    ) VALUES (
       NEW.id , 'INSERT' , NEW.name ,
       NEW.PART , NEW.VERSION , NEW.DEVICE_TYPE_ID ,
       NEW.DESCRIPTION, NEW.FILE ,NEW.FILE_ID ,NEW.CREATE_TIME,
       NULL ,  NEW.TYPE_ID     
    ) ; 
END ; //
DELIMITER; 

-- firmware update trigger
DELIMITER //
DROP TRIGGER IF EXISTS firmware_update_trigger //
CREATE TRIGGER firmware_update_trigger AFTER UPDATE ON firmware
FOR EACH ROW
BEGIN
    INSERT INTO firmware_history(his_id , ACTION, NAME ,
       part, VERSION ,device_type_id,description,FILE,
       file_id,file_integrity_check_value,create_time,update_time,type_id
    ) VALUES (
       NEW.id , 'UPDATE' , NEW.name ,
       NEW.PART , NEW.VERSION , NEW.DEVICE_TYPE_ID ,
       NEW.DESCRIPTION, NEW.FILE ,NEW.FILE_ID ,
       NEW.FILE_INTEGRITY_CHECK_VALUE,
       NEW.CREATE_TIME,NEW.UPDATE_TIME, NEW.TYPE_ID     
    ) ; 
END ; //
DELIMITER;  

-- firmware delete trigger
DELIMITER //
DROP TRIGGER IF EXISTS firmware_delete_trigger //
CREATE TRIGGER firmware_delete_trigger AFTER DELETE ON firmware
FOR EACH ROW
BEGIN
    INSERT INTO firmware_history(his_id , ACTION, NAME ,
       part, VERSION ,device_type_id,description,FILE,
       file_id,file_integrity_check_value,
       create_time,update_time,type_id
    ) VALUES (
       OLD.id , 'DELETE' , OLD.name ,
       OLD.PART , OLD.VERSION , OLD.DEVICE_TYPE_ID ,
       OLD.DESCRIPTION, OLD.FILE ,OLD.FILE_ID ,
       OLD.FILE_INTEGRITY_CHECK_VALUE,
       OLD.CREATE_TIME, NOW(), OLD.TYPE_ID     
    ) ; 
END ; //
DELIMITER;  


/*  ----------------------  firmware   end    -----------------------------  */

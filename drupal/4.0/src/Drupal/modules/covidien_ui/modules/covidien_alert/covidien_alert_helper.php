<?php

global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/alertEmailWidget.php');
require_once ($drupal_abs_path . "/sites/all/modules/smtp/phpmailer/class.phpmailer.php");

function add_new_alert($alertType, $serialNumber) {

  $sql = db_query("select c.title from content_type_device a,content_field_device_type b, node c
  	where a.field_device_serial_number_value='s%'
	and a.nid = b.nid and b.field_device_type_nid = c.nid and c.type='devicetype'");
  $result = db_query($sql, $serialNumber);
  $deviceType = db_fetch_object($result)->title;

  $sql = "select count(1) as total,b.recipient_id from alert_type a, alert b where a.name='s%' and a.id = b.type_id and b.serial_number = 's%'
   and a.status_id in (select id from alert_status where name in('Pending','Send','Acknowledged')) group by b.recipient_id";
  $auditRes = db_query($sql, $alertType, $serialNumber);
  while ($auditItem = db_fetch_object($auditRes)) {
    if ($auditItem->total > 0) {
      //inert alert as duplicate.
      $sql = "select d.id as recipient_id,e.id as type_id from content_type_device a, content_type_person b,
    	users c, alert_recipient d, alert_type e 
    	where a.field_device_serial_number_value='s%'
		and a.field_device_owner_nid = b.field_company_name_nid 
		and b.field_person_username_value = c.name
		and c.uid = d.user_id and d.type_id = e.id 
		and d.enable_flg = 'Y' and e.enable_flg = 'Y'
		and d.id = d% and e.name = 's%'";
      $result = db_query($sql, $serialNumber, $auditItem->recipient_id, $alertType);
      while ($item = db_fetch_object($result)) {
        $sql = "insert alert(recipient_id,type_id,status_id,serial_number,device_type,create_time,update_time) values
      		(%d,d%,(select id from alert_status where name='Duplicate'),'s%','s%',now(),now())";
        db_query($sql, $item->recipient_id, $item->type_id, $serialNumber, $deviceType);
      }
    } else {
      $sql = "select count(1) as total from alert_type a, alert b where a.name='s%' and a.id = b.type_id and b.serial_number = 's%'
   		and a.status_id in (select id from alert_status where name = 'Suppresses') and b.recipient_id = d%";
      $result = db_query($sql, $alertType, $serialNumber, $auditItem->recipient_id);
      $total = db_fetch_object($result)->total;
      //ignore alert when status was Suppresses;
      if ($total < 1) {
        $sql = "select d.id as recipient_id,e.id as type_id from content_type_device a, content_type_person b,
          	users c, alert_recipient d, alert_type e 
          	where a.field_device_serial_number_value='s%'
      		and a.field_device_owner_nid = b.field_company_name_nid 
      		and b.field_person_username_value = c.name
      		and c.uid = d.user_id and d.type_id = e.id 
      		and d.enable_flg = 'Y' and e.enable_flg = 'Y'
      		and d.id = d% and e.name = 's%'";
        $result = db_query($sql, $serialNumber, $auditItem->recipient_id, $alertType);
        while ($item = db_fetch_object($result)) {
          $sql = "insert alert(recipient_id,type_id,status_id,serial_number,device_type,create_time,update_time) values
            		(%d,d%,(select id from alert_status where name='Pending'),'s%','s%',now(),now())";
          db_query($sql, $item->recipient_id, $item->type_id, $serialNumber, $deviceType);
        }
      }
    }
  }
}

function invoke_alert_email($alertType, $templateProps) {
  $tempalteId = get_user_alert_tempalte($alertType);
  if (!empty($tempalteId)) {
    process_alert_email($alertType, $tempalteId, $templateProps);
  }
}

function get_user_alert_tempalte($alertType) {
  global $user;
  $uid = $user->uid;
  $sql = "select a.template_id from alert_type a, alert_email_template b where a.enable_flg='Y' and a.template_id = b.id and a.name='%s'";
  $result = db_query($sql, $alertType);
  $tempalteId = db_fetch_object($result)->template_id;
  if (empty($tempalteId)) {
    watchdog("covidien_alerts", "No email template be found for the alert type: " . $alertType, array(), WATCHDOG_ERROR);
  } else {
    $sql = "select b.template_id from alert_recipient a, alert_type b where a.type_id = b.id and a.enable_flg='Y' and b.enable_flg='Y' and b.name='%s' and a.user_id=%d";
    $result = db_query($sql, $alertType, $uid);
    $tempalteId = db_fetch_object($result)->template_id;
  }
  return $tempalteId;
}

function process_alert_email($alertType, $tempalteId, $templateProps) {
  global $user;
  $name = $user->name;
  $name = 'Tony.Zhang@covidien.com';

  $sql = "select title,template_path from alert_email_template where id ='" . $tempalteId . "'";
  $result = db_query($sql);
  $item = db_fetch_object($result);

  if (!empty($item)) {
    $title = $item->title;
    $templatePath = $item->template_path;
    $pathArr = explode('/', $templatePath);
    $tempalteName = array_pop($pathArr);
    $alertEmailWidget = new AlertEmailWidget();

    $body = $alertEmailWidget->make($tempalteName, $templateProps);

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "10.80.4.119";
    $mailer->FromName = 'Gateway Admin';
    $mail->From = "gateway.admin@covidien.com";
    $mail->AddAddress($name);
    $mail->Subject = $alertType;
    #$mail->Body = $body;
    $mail->Body = "<h1>Hello, Email Tempalte. </h1>";
    if (!$mail->Send()) {
      watchdog('Mailer error', $mail->ErrorInfo, array(), WATCHDOG_ERROR);
    }
  }
}
<?php

/**
 * Class for Mail functions
 */
class Mail {

  public $headers;
  public $content;
  public $from;
  public $footer_name;

  function __construct() {
    global $mail_signature;
    $this->headers = array(
      'MIME-Version' => '1.0',
      'Content-Type' => 'text/html; charset=UTF-8; format=flowed',
      'Content-Transfer-Encoding' => '8Bit',
      'X-Mailer' => 'Drupal',
      'date' => format_date(time(), '', 'D, d M Y H:i:s O')
    );
    $this->from = variable_get('smtp_from', 'admin@covidien.com');
    $this->footer_name = $mail_signature;
  }

  public function changepasswordcofirmation($info = array()) {
    $message['id'] = $info['message_id'];
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - Changed Password Info');
    $body = t("Dear") . ' ' . $info['name'] . ", <p>";
    //GATEWAY-1743 Remove the text which shows the password and make the notification more friendliness.
    $body .= t("Your password was changed on ") . date("D M j G:i:s T Y") . ".</p><p>";
    $body .= t("If you did not change your password, please contact Device Management Portal administration immediately.") . "</p><p>";
    //$body .= t("Password:").' '.$info['password']."</p>";
    $body .= t("Thank you,") . "<br />";
    $body .= $this->footer_name;
    $message['headers'] = $this->headers;
    $message['body'] = $body;
    $status = drupal_mail_send($message);
    if ($status) {
      logUserActivity("Email", "Reset password mail sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
    }
  }

  public function forgotpasswordrequest($info = array()) {
    $message['id'] = $info['message_id'];
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - Forgot Password Reset');
    $body = t("Dear") . ' ' . $info['name'] . ", <p>";
    $body .= t("You recently requested that your Covidien Device Management Portal account password be reset.") . "</p><p>";
    $body .= t("Request received from IP Address") . ' ' . $info['ipaddress'] . ".</p><p>";
    $body .= t("Please click the following link to reset your password. This link is valid for 12 hours and can only be used once:") . "</p><p><a href='" . $info['link'] . "'>" . $info['link'] . "</a></p><p>";
    $body .= t("If you did not request a change to your password or do not need to reset your password any longer, please ignore this email.") . "</p>";
    $body .= t("Thank you,") . "<br />";
    $body .= $this->footer_name;
    $message['body'] = $body;
    $message['headers'] = $this->headers;
    $status = drupal_mail_send($message);
    if ($status) {
      logUserActivity("Email", "Forgot Password Request mail sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
    }
  }

  public function newuserregister($info = array()) {
    global $base_url;
    $message['id'] = 'user_register';
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - New User Register');
    $body = t("Dear") . ' ' . $info['name'] . ", <p>";
    $body .= t("Congratulations!") . ' ' . t("You may now log in to") . " <a href='" . $base_url . "'>" . $base_url . "</a> ";
    $body .= t("using the following user name:") . "</p><p>";
    $body .= t("User name:") . ' ' . $info['username'] . "</p><p>";
    $body .= t("You will receive your password in a separate e-mail.") . "</p></p>";
    $body .= t("Thank you,") . "<br />";
    $body .= $this->footer_name;
    $message['headers'] = $this->headers;
    $message['body'] = $body;
    $status = drupal_mail_send($message);
    if ($status) {
      logUserActivity("Email", "New user register mail with username sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
    }
  }

  public function newuserregisterpwd($info = array()) {
    global $base_url;
    $message['id'] = 'user_password';
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - New User Register');
    $body = t("Dear") . ' ' . $info['name'] . ", <p>";
    $body .= t("You may now log in to") . " <a href='" . $base_url . "'>" . $base_url . "</a> ";
    $body .= t("Please click the following link to reset your password. This link is valid for 12 hours and can only be used once:") . "</p><p><a href='" . $info['link'] . "'>" . $info['link'] . "</a></p><p>";
    $body .= t("You can change your password using the \"Forgot Password\"  link on the login screen.") . "</p></p>";
    $body .= t("Thank you,") . "<br />";
    $body .= $this->footer_name;
    $message['headers'] = $this->headers;
    $message['body'] = $body;
    $status = drupal_mail_send($message);
    if ($status) {
      logUserActivity("Email", "New user register mail with password sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
    }
  }

  public function changepasswordmail($info = array()) {
    $message['id'] = 'change_password';
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - Changed Password Info');
    $body = t("Dear") . ' ' . $info['name'] . ", <p>";
    //GATEWAY-1743 Remove the text which shows the password and make the notification more friendliness.
    $body .= t("Your password was changed on ") . date("D M j G:i:s T Y") . ".</p><p>";
    $body .= t("If you did not change your password, please contact Device Management Portal administration immediately.") . "</p><p>";
    //$body .= t("Password:") . ' ' . $info['password'] . "</p>";
    $body .= t("Thank you,") . "<br />";
    $body .= $this->footer_name;
    $message['headers'] = $this->headers;
    $message['body'] = $body;
    $status = drupal_mail_send($message);
    if ($status) {
      logUserActivity("Email", "Changed password mail sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
    }
  }

  public function updateuserdetailsmail($info = array()) {
    $message['id'] = 'update_profile';
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - Profile Updated');
    $default = array('0' => t('NO'), '1' => t('YES'));
    $privilege = array('0' => t('None'), '1' => t('Latest version only'), '2' => t('All production versions'));
    $body = t("Dear") . ' ' . $info['first'] . ' ' . $info['last'] . ", <p>";
    $body .= t("Your user profile was updated. If you notice any discrepancies please contact your account manager.") . "</p>
		<p>";
    $body .= t("First Name: ") . $info['first'] . "</p><p>";
    $body .= t("Last Name: ") . $info['last'] . "</p><p>";
    $body .= t("Email address: ") . $info['email'] . "</p><p>";
    $body .= t("Country: ") . $info['country'] . "</p><p>";
    $body .= t("Language: ") . $info['user_lang'] . "</p>";
    if ($info['covidien_emp'] == 'Yes') {
      $body .= "<p>" . t("Business Unit: ") . $info['bunit'] . "</p>";
    } else {
      $body .= "<p>" . t("Company Name: ") . $info['customer_name'] . "</p>
			<p>" . t("Account Number: ") . $info['account'] . "</p>";
    }
    $roles = getrolesdetailsformail($info['nid']);
    $body .= "<p>" . t("Roles") . "<table width='400px' border='1' cellpadding='5' cellspacing='0'>
							<tr><td>" . t("Class of Trade") . "</td><td>" . t("Role") . "</td><td>" . t("Default") . "</td><td>" . t("Device Access") . "</td></tr>";
    foreach ($roles as $k => $v) {
      $body .= "<tr><td>" . $v['pl'] . "</td><td>" . $v['role'] . "</td><td>" . $default[$v['default']] . "</td><td>" . $privilege[$v['privilege']] . "</td></tr>";
    }
    $body .= "</table></p>";
    $device = getdeviceprivilegemail($info['nid']);
    if (!empty($device)) {
      $body .= "<p>" . t("Device Type Privileges") . "<table width='400px' border='1' cellpadding='5' cellspacing='0'>
								<tr><td>" . t("Device Type") . "</td><td>" . t("Privilege") . "</td><td>" . t("Authorized") . "</td></tr>";
      foreach ($device as $k => $v) {
        $body .= "<tr><td>" . $v['device_type'] . "</td><td>" . $v['section'] . "</td><td>" . $v['option'] . "</td></tr>";
      }
      $body .= "</table></p>";
    }
    if ($info['training_list']) {
      $body .= "<p>" . t("Training Records") . "<table width='400px' border='1' cellpadding='5' cellspacing='0'>
								<tr><td>" . t("Trainer User ID") . "</td><td>" . t("Date of Training") . "</td><td>" . t("Class of Trade") . "</td><td>" . t("Device Type") . "</td><td>" . t("Status") . "</td></tr>";
      foreach ($info['training_list'] as $trade) {
        $body .= "<tr><td>" . $trade['trainer_user_id'] . "</td><td>" . $trade['date_of_training'] . "</td><td>" . $trade['class_of_trade'] . "</td><td>" . $trade['device_type'] . "</td><td>" . $trade['status'] . "</td></tr>";
      }
      $body .= "</table></p>";
    }
    $body .= '<br />' . t('Thank you,') . '<br />';
    $body .= $this->footer_name;
    $message['body'] = $body;
    $message['headers'] = $this->headers;
    $status = drupal_mail_send($message);
    if ($status) {
      logUserActivity("Email", "Profile details mail sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
    }
  }

  /*
   * send to user password about to expire 
   */

  function password_about_to_expire($info = array()) {
    global $base_url;
    $message['id'] = 'user_password_expire';
    $message['to'] = $info['to'];
    $message['from'] = $this->from;
    $message['language'] = $info['language'];
    $message['subject'] = t('Covidien - Your password is about expire.');
    $body = t("Dear") . ' ' . $info['name'] . ", <p>";
    $body .= $info['body'];
    $body .= '</p>';
    $body .= t("Thank you,") . "<br />";
    $body .= $this->footer_name;
    $message['headers'] = $this->headers;
    $message['body'] = $body;
    $status = drupal_mail_send($message);
    if ($status) {
      //logUserActivity("Email", "User password expire mail sent to user - " . $message['to'], '', '', '', $info['uid'], ip_address(), time());
      return true;
    }
    return false;
  }
	public function generalNotification($info = array()) {
		$message ['id'] = 'General Notification';
		$recipients = $info['to'];// clone recipients
		$message ['from'] = $this->from;
		$message ['language'] = $info ['language'];
		$message ['subject'] = $info ['subject'];
		$body = t ( "Dear" ) . ' ' . $info ['name'] . ", <p>";
		// GATEWAY-1743 Remove the text which shows the password and make the notification more friendliness.
		$body .= $info ['message'];
		// $body .= t("Password:").' '.$info['password']."</p>";
		$body .= "<p>" . t ( "Thank you," ) . "<br />";
		$body .= $this->footer_name;
		$message ['headers'] = $this->headers;
		$message ['body'] = $body;
		$rtn = true;
		while ( $recipients ) {
			$i = 0;
			$list = array ();
			while ( $recipients && $i < 15 ) {
				$list [] = array_shift ( $recipients );
				$i ++;
			}
			$message ['to'] = implode(',', $list);			
			$status = drupal_mail_send ( $message );			
			if ($status) {
				covidien_update_log ( 'Successfully send alert to :' . $message ['to'] . ' successfully. [' . $message ['subject'] . ']' );
				logUserActivity ( "Email", "[Success] General notification mail sent to user - " . $info ['name'], '', '', '', $info ['uid'], ip_address (), time () );
			} else {
				covidien_update_log ( 'Cannot send alert to :' . $message ['to'] . ' due to the mail server returns bad. [' . $message ['subject'] . ']' );
				logUserActivity ( "Email", "[Fail] General notification mail cannot sent to user - " . $info ['name'], '', '', '', $info ['uid'], ip_address (), time () );
				$rtn = false;
			}
		}
		return $rtn;
	}
}

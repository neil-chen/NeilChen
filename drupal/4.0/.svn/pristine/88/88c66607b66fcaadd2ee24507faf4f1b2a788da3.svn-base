<?php
/**
 * download approving manager list.
 */
function download_approving_manager_list() {
	global $approving_manager_sftp;
	if(!$approving_manager_sftp){
		return;
	}
	$today = date ( 'Y-m-d' );
	$last_sync_day = variable_get ( 'approving_list_synced', '' );
	$filename = '/tmp/SelfRegistrationUsers-' . $today . '.txt';
	if ($last_sync_day == $today && file_exists ( $filename )) {
		return;
	}
	if (! file_exists ( dirname ( $filename ) )) {
		mkdir ( dirname ( $filename ), 0777, true );
	}
	@file_put_contents ( $filename, '1' );
	variable_set ( 'approving_list_synced', $today );
	
	$yesterday = date ( 'Y-m-d', strtotime ( $today . ' -1 day' ) );
	$oldname = '/tmp/SelfRegistrationUsers-' . $yesterday . '.txt';
	$fh = @fopen ( $filename, 'w' );
	if ($fh) {
		set_time_limit ( 0 );
		// download file from sftp.
		$c = @curl_init ( $approving_manager_sftp );
		@curl_setopt ( $c, CURLOPT_PROTOCOLS, CURLPROTO_SFTP );
		@curl_setopt ( $c, CURLOPT_FILE, $fh );
		$rtn = @curl_exec ( $c );
		@fclose ( $fh );
		if ($rtn === false) {
			return;
		}
		@curl_close ( $c );
		// read file.
		$handle = @fopen ( $filename, "r" );
		$fullData = array ();
		if ($handle) {
			if (file_exists ( $oldname )) {
				$new_file_md5 = md5_file ( $filename );
				$old_file_md5 = md5_file ( $oldname );
				@unlink ( $oldname );
				// the approving list file dose not change.
				if ($new_file_md5 == $old_file_md5) {
					return;
				}
			}
			$i = 0;
			$time = time ();
			$create_query = 'INSERT INTO {registration_approving_manager}(id,first_name,last_name,user_name,email,cot) VALUES ';
			db_query ( 'truncate table {registration_approving_manager}' );
			$newUsers = array ();
			$ids = array ();
			$duplicates = array ();
			while ( ($line = fgets ( $handle )) !== false ) {
				if ($i > 0) {
					$line = trim ( trim ( $line ), '"' );
					$user = explode ( '"|"', $line );
					list ( $firstname, $lastname, $username, $email ) = $user;
					if ($firstname && $lastname && $username && $email) {
						$firstname = addslashes ( $firstname );
						$lastname = addslashes ( $lastname );
						$username = addslashes ( $username );
						$email = addslashes ( $email );
						$id = md5 ( $email );
						if (! isset ( $ids [$id] )) {
							$ids [$id] = 0;
							$newUsers [] = "('$id','$firstname', '$lastname', '$username', '$email',0)";
						} else {
							$duplicates [] = $email;
						}
					}
					if (count ( $newUsers ) == 50) {
						$values = implode ( ',', $newUsers );
						db_query ( $create_query . $values );
						$newUsers = array ();
					}
				} else {
					$i ++;
				}
			}
			if (count ( $newUsers ) > 0) {
				$values = implode ( ',', $newUsers );
				db_query ( $create_query . $values );
			}
			if (count ( $duplicates )) {
				@file_put_contents ( '/tmp/duplicates-' . $today . '.txt', implode ( "\n", $duplicates ) );
			}
			@fclose ( $handle );
			update_approving_manager_for_pending_registration ();
		}
	}
}
/**
 * update the approving user of the pending registrant if his approving manager is removed from approving manager list.
 */
function update_approving_manager_for_pending_registration() {
	// TODO: get the registrant whos status is 'pending' and his approving user is not found in approving manager list.
	// TODO: reset his approving user and send new approving notification to the approving user.
}

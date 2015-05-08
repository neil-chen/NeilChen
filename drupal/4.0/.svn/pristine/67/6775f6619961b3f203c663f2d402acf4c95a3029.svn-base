<?php
global $drupal_abs_path;
require_once ($drupal_abs_path . '/sites/all/modules/covidien_ui/includes/widget/abstractWidget.php');

class AlertEmailWidget extends AbstractWidget {
    /**
     * get the email body.
     * @param unknown_type $tempalteName
     * @param unknown_type $keyInfo
     */
	public function make($tempalteName,$keyInfo) {
		$this->smarty->assign ( "keyInfo", $keyInfo );
		$this->smarty->display ( $tempalteName );
	}
}

?>
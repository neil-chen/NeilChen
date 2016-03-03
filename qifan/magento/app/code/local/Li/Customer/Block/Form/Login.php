<?php

class Li_Customer_Block_Form_Login extends Mage_Customer_Block_Form_Login
{
   // override existing method
  //write new function
   /**
     * Retrieve create new Whole sale account url
     *
     * @return string
     */
    public function getCreateWholesaleAccountUrl()
    {
        $url = $this->getData('create_account_url');
        if (is_null($url)) {
            $url = $this->helper('customer')->getWholesaleRegisterUrl();
        }
        return $url;
    }
}

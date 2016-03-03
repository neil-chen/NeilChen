<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Paypal
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Payflow Checkout Controller
 *
 * @category   Mage
 * @package    Mage_Paypal
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Paypal_PayflowController extends Mage_Core_Controller_Front_Action
{
    /**
     * When a customer cancel payment from payflow gateway.
     */
    public function cancelPaymentAction()
    {
        $gotoSection = $this->_cancelPayment();
        $redirectBlock = $this->_getIframeBlock()
            ->setGotoSection($gotoSection)
            ->setTemplate('paypal/payflowlink/redirect.phtml');
        $this->getResponse()->setBody($redirectBlock->toHtml());
    }

    /**
     * When a customer return to website from payflow gateway.
     */
    public function returnUrlAction()
    {
        $redirectBlock = $this->_getIframeBlock()
            ->setTemplate('paypal/payflowlink/redirect.phtml');

        $session = $this->_getCheckout();
        $quote = $session->getQuote();
        /** @var $payment Mage_Sales_Model_Quote_Payment */
        $payment = $quote->getPayment();
        $gotoSection = 'payment';
        if ($payment->getAdditionalInformation('authorization_id')) {
            $gotoSection = 'review';
        } else {
            $gotoSection = 'payment';
            $redirectBlock->setErrorMsg($this->__('Payment has been declined. Please try again.'));
        }
        $redirectBlock->setGotoSection($gotoSection);
        $this->getResponse()->setBody($redirectBlock->toHtml());
    }

    /**
     * Cancel order, return quote to customer
     *
     * @param string $errorMsg
     * @return mixed
     */
    protected function _cancelPayment($errorMsg = '')
    {
        $gotoSection = false;
        $session = $this->_getCheckout();
        if ($session->getLastRealOrderId()) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($session->getLastRealOrderId());
            if ($order->getId()) {
                //Cancel order
                if ($order->getState() != Mage_Sales_Model_Order::STATE_CANCELED) {
                    $order->registerCancellation($errorMsg)->save();
                }
                $quote = Mage::getModel('sales/quote')
                    ->load($order->getQuoteId());
                //Return quote
                if ($quote->getId()) {
                    $quote->setIsActive(1)
                        ->setReservedOrderId(NULL)
                        ->save();
                    $session->replaceQuote($quote);
                }
                //Unset data
                $session->unsLastRealOrderId();
                //Redirect to payment step
                $gotoSection = 'payment';
            }
        }

        return $gotoSection;
    }

    /**
     * Submit transaction to Payflow getaway into iframe
     */
    public function formAction()
    {
        $quote = $this->_getCheckout()->getQuote();
        $payment = $quote->getPayment();

        try {
            $method = Mage::helper('payment')->getMethodInstance(Mage_Paypal_Model_Config::METHOD_PAYFLOWLINK);
            $method->setData('info_instance', $payment);
            $method->initialize($method->getConfigData('payment_action'), new Varien_Object());

            $quote->save();
        } catch (Mage_Core_Exception $e) {
            $this->loadLayout('paypal_payflow_link_iframe');

            $block = $this->getLayout()->getBlock('payflow.link.info');
            $block->setErrorMessage($e->getMessage());

            $this->getResponse()->setBody(
                $block->toHtml()
            );
            return;
        } catch (Exception $e) {
            Mage::logException($e);
        }
        $this->getResponse()
            ->setBody($this->_getIframeBlock()->toHtml());
    }

    /**
     * Get response from PayPal by silent post method
     */
    public function silentPostAction()
    {
        $data = $this->getRequest()->getPost();
        if (isset($data['INVNUM'])) {
            $paymentModel = Mage::getModel('paypal/payflowlink');
            try {
                $paymentModel->process($data);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }

    /**
     * Get frontend checkout session object
     *
     * @return Mage_Checkout_Model_Session
     */
    protected function _getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Get iframe block
     *
     * @return Mage_Paypal_Block_Payflow_Link_Iframe
     */
    protected function _getIframeBlock()
    {
        $this->loadLayout('paypal_payflow_link_iframe');
        return $this->getLayout()
            ->getBlock('payflow.link.iframe');
    }
}

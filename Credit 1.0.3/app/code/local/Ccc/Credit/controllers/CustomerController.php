<?php

class Ccc_Credit_CustomerController extends Mage_Core_Controller_Front_Action
{

    public function preDispatch()
    {
        parent::preDispatch();

        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', 'no-dispatch', true);

            Mage::getSingleton('core/session')
                ->addSuccess(Mage::helper('credit')->__('Please sign in or create a new account'));
        }
    }

    public function viewAction()
    {

        $this->loadLayout();
        $this->renderLayout();
    }
}

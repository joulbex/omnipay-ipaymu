<?php

	namespace Omnipay\iPaymu\Message;

	// use Omnipay\Common\Message\AbstractResponse;

	class PurchaseDirectResponse extends IPaymuResponse
	{
		/**
	     *
	     * {@inheritdoc}
	     */
	    public function isSuccessful()
	    {
	        return isset($this->data['Status']) && $this->data['Status'] == 200;
	    }
	}
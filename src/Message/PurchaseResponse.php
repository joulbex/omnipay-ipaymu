<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\AbstractResponse;

	class PurchaseResponse extends AbstractResponse
	{
		/**
	     * When you do a `purchase` the request is never successful because
	     * you need to redirect off-site to complete the purchase.
	     *
	     * {@inheritdoc}
	     */
	    public function isSuccessful()
	    {
	        return false;
	    }
	}
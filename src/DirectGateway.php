<?php

	namespace Omnipay\iPaymu;

	use Omnipay\iPaymu\Message\PurchaseDirectRequest;

	/**
	 * Gateway for iPaymu Direct payment method
	 */
	class DirectGateway extends Gateway
	{
		/**
	     * Get gateway display name
	     */
	    public function getName()
	    {
	        return 'iPaymu_Direct';
	    }

        /**
	     * The purchase transaction
	     */
	    public function purchase(array $parameters = array())
	    {
	        $request = $this->createRequest(PurchaseDirectRequest::class, $parameters);

        	return $request;
	    }
	}
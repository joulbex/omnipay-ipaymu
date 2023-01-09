<?php

	namespace Omnipay\iPaymu;

	use Omnipay\iPaymu\Message\PurchaseDirectRequest;
	use Omnipay\iPaymu\Message\PurchaseDirectResponse; // not needed?
	use Omnipay\iPaymu\Message\CompletePurchaseRequest;
	use Omnipay\iPaymu\Message\CompletePurchaseResponse; // not needed?
	use Omnipay\iPaymu\Message\IPaymuResponse; // not needed?

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

	    /**
	     * @param  array $parameters
	     * @return CompletePurchaseRequest
	     */
	    public function completePurchase(array $parameters = array())
	    {
	        /** @var CompletePurchaseRequest $request */
	        $request = $this->createRequest(CompletePurchaseRequest::class, $parameters);

	        return $request;
	    }
	}
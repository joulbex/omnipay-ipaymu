<?php

	// TODO: Add 2nd method "Direct Payment"

	namespace Omnipay\iPaymu;

	use Omnipay\Common\AbstractGateway;
	use Omnipay\iPaymu\Message\PurchaseRequest;
	use Omnipay\iPaymu\Message\PurchaseResponse; // not needed?
	use Omnipay\iPaymu\Message\CompletePurchaseRequest;
	use Omnipay\iPaymu\Message\CompletePurchaseResponse; // not needed?
	use Omnipay\iPaymu\Message\CheckTransactionRequest;
	use Omnipay\iPaymu\Message\CheckBalanceRequest;
	use Omnipay\iPaymu\Message\IPaymuResponse; // not needed?

	class Gateway extends AbstractGateway
	{
		/**
	     * Get gateway display name
	     */
	    public function getName()
	    {
	        return 'iPaymu';
	    }

	    /**
         * @param array $parameters
         * @return $this|Gateway
         * @throws
         */
        public function initialize(array $parameters = array())
        {
            parent::initialize($parameters);

            return $this;
        }

        /**
	     * The purchase transaction (Type 1: Redirect Payment).
	     */
	    public function purchase(array $parameters = array())
	    {
	        $request = $this->createRequest(PurchaseRequest::class, $parameters);

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

	    /**
	     * NOTE: Is the name correct? Does Omnipay have any suggestions about this?
	     * This part based on https://github.com/pay-now/omnipay-paynow/
	     * @param  array $parameters
	     * @return CheckTransactionRequest
	     */
	    public function checkTransaction(array $parameters = array())
	    {
	        /** @var CheckTransactionRequest $request */
	        $request = $this->createRequest(CheckTransactionRequest::class, $parameters);

	        return $request;
	    }

	    /**
	     * @param  array $parameters
	     * @return CheckBalanceRequest
	     */
	    public function checkBalance(array $parameters = array())
	    {
	        /** @var CheckBalanceRequest $request */
	        $request = $this->createRequest(CheckBalanceRequest::class, $parameters);

	        return $request;
	    }

	    public function getDefaultParameters()
	    {
	        return array(
	        	'accountId' => '', // aka "va"
	            'apiKey'    => '',
	            'testMode'  => true
	        );
	    }

	    // TEST: getter maybe not needed
	    public function getAccountId()
	    {
	    	return $this->getParameter('accountId');
	    }

	    public function setAccountId($accountId)
	    {
	    	return $this->setParameter('accountId', $accountId);
	    }

	    // TEST: getter maybe not needed
	    public function getApiKey()
	    {
	    	return $this->getParameter('apiKey');
	    }

	    public function setApiKey($apiKey)
	    {
	    	return $this->setParameter('apiKey', $apiKey);
	    }
	}
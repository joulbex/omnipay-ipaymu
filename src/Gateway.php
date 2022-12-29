<?php

	// TODO: Add 2nd method "Direct Payment"

	namespace Omnipay\iPaymu;

	use Omnipay\Common\AbstractGateway;
	use Omnipay\iPaymu\Message\PurchaseRequest;
	use Omnipay\iPaymu\Message\PurchaseResponse;

	class Gateway extends AbstractGateway
	{
		/**
	     * Get gateway display name
	     */
	    public function getName(): string
	    {
	        return 'iPaymu';
	    }

	    /**
         * @param array $parameters
         * @return $this|Gateway
         * @throws
         */
        public function initialize(array $parameters = []): self
        {
            parent::initialize($parameters);

            return $this;
        }

        /**
	     * The purchase transaction (Type 1: Redirect Payment).
	     */
	    public function purchase(array $parameters = [])
	    {
	        $request = $this->createRequest(PurchaseRequest::class, $parameters);

        	return $request;
	    }

	    public function getDefaultParameters(): array
	    {
	        return [
	            'accountId' => '', // aka "va"
	            'apiKey'    => '',
	            'testMode'  => true
	        ];
	    }

	    // TEST: getter maybe not needed
	    public function getAccountId()
	    {
	    	return $this->getParameter('accountId');
	    }

	    public function setAccountId(string $accountId)
	    {
	    	return $this->setParameter('accountId', $accountId);
	    }

	    // TEST: getter maybe not needed
	    public function getApiKey()
	    {
	    	return $this->getParameter('apiKey');
	    }

	    public function setApiKey(string $apiKey)
	    {
	    	return $this->setParameter('apiKey', $apiKey);
	    }
	}
<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Common\AbstractGateway;

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

            // here initialize

            return $this;
        }

        /**
	     * The purchase transaction.
	     */
	    public function purchase(array $parameters = [])
	    {
	        
	    }

	    public function getDefaultParameters(): array
	    {
	        return [
	            'accountId' => '',
	            'apiKey'    => '',
	            'testMode'  => true
	        ];
	    }
	}
<?php

	// TODO: Add 2nd method "Direct Payment"

	namespace Omnipay\iPaymu;

	use Omnipay\Common\AbstractGateway;
	use Omnipay\iPaymu\Message\PurchaseRequest;
	use Omnipay\iPaymu\Message\PurchaseResponse;

	// use Guzzle\Http\HandlerStack;
	// use Guzzle\Http\Middleware;
	use Guzzle\Http\ClientInterface;
	use Guzzle\Http\Client as HttpClient;

	class Gateway extends AbstractGateway
	{
		private $container = [];

		// tried to overwrite guzzle with custom instance
		// https://github.com/guzzle/guzzle/issues/1688
		/*public function __construct(ClientInterface $httpClient = null, HttpRequest $httpRequest = null)
	    {
			$history = Middleware::history($this->container);

			$stack = HandlerStack::create();
			// Add the history middleware to the handler stack.
			$stack->push($history);

	    	// pass custom Guzzle instance
	        $httpClient = new HttpClient(
	            '',
	            array(
	                'curl.options' => array(CURLOPT_CONNECTTIMEOUT => 60),
	                'debug' => true,
	                'handler' => $stack
	            )
	        );
	        
	        parent::__construct($httpClient, $httpRequest);
	    }*/

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
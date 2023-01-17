<?php

	namespace Omnipay\iPaymu;

	use Omnipay\Common\AbstractGateway;
	use Omnipay\iPaymu\Message\PurchaseRequest;
	use Omnipay\iPaymu\Message\CompletePurchaseRequest;
	use Omnipay\iPaymu\Message\CheckTransactionRequest;
	use Omnipay\iPaymu\Message\CheckBalanceRequest;

	/**
	 * Gateway for iPaymu off-site payment method (with redirect).
	 * 
	 * ### Example
	 *
	 * #### Initialize Gateway
	 *
	 * <code>
	 *   // Create a gateway
	 *   $gateway = Omnipay::create('iPaymu');
	 * 
	 * 	 $gateway->initialize([
	 *	      'va' => 'my_va_number',
	 *		  'apiKey'    => 'my_api_key',
	 *		  'testMode'  => true
	 *	 ]); 
	 * 
	 * </code>
	 *
	 * #### Purchase
	 * 
	 * $params = [
	 *      'product' => 'Test product',
	 *      'qty' => '1',
	 *      'price' => '10000.00',
	 *      'description' => 'Test description',
	 *      'notifyUrl' => 'http://localhost:8000/notify.php',
	 *      'returnUrl' => 'http://localhost:8000/return.php',
	 *      'cancelUrl' => 'http://localhost:8000/cancel.php',
	 *      'buyerName' => 'John Doe', // optional
	 *      'buyerEmail' => 'johndoe@example.com', // optional
	 *      'buyerPhone' => '123456789', // optional
	 *      'transactionId' => 'ABC1234', // optional
	 *      'paymentMethod' => 'cod', // optional
	 *      'weight' => '1', // optional, COD only
	 *      'dimension' => '1:1:1', // optional, COD only
	 *      'pickupArea' => '55555', // nullable, COD only
	 *      'pickupAddress' => 'Jakarta', // nullable, COD only
	 *   ];
	 *
	 *   $response = $gateway->purchase($params)->send();
	 *
	 *   if ($response->isRedirect()) {
	 *   	// success
	 *      $response->redirect(); 
	 *   } else { 
	 *		// error
	 *      var_dump($response->getData());
	 *      var_dump($response->getMessage());
	 *      var_dump($response->getCode());
	 *   }
	 * 
	 * @see https://documenter.getpostman.com/view/7508947/SWLfanD1?version=latest#0fe32da7-3bb8-43a3-8f7d-af1cee1ecaa3
	 */
	class Gateway extends AbstractGateway
	{
		/**
	     * Get gateway display name
	     */
	    public function getName()
	    {
	        return 'iPaymu';
	    }

	    public function getDefaultParameters()
	    {
	        return array(
	        	'va' => '',
	            'apiKey'    => '',
	            'testMode'  => true
	        );
	    }

	    public function getVa()
	    {
	    	return $this->getParameter('va');
	    }

	    public function setVa($va)
	    {
	    	return $this->setParameter('va', $va);
	    }

	    public function getApiKey()
	    {
	    	return $this->getParameter('apiKey');
	    }

	    public function setApiKey($apiKey)
	    {
	    	return $this->setParameter('apiKey', $apiKey);
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
	     * The purchase transaction.
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
	}
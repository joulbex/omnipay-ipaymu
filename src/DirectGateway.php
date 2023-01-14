<?php

	namespace Omnipay\iPaymu;

	use Omnipay\iPaymu\Message\PurchaseDirectRequest;
	use Omnipay\iPaymu\Message\CompletePurchaseRequest;

	/**
	 * Gateway for iPaymu on-site payment method (without redirect).
	 * This gateway does not support credit card payment.
	 * 
	 * ### Example
	 *
	 * #### Initialize Gateway
	 *
	 * <code>
	 *   // Create a gateway
	 *   $gateway = Omnipay::create('iPaymu_Direct');
	 * 
	 * 	 $gateway->initialize([
	 *	      'accountId' => 'my_account_id', // aka "va"
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
	 * 	    'paymentMethod' => 'qris',
	 * 		'paymentChannel' => 'qris',
	 *      'notifyUrl' => 'http://localhost:8000/notify.php',
	 *      'name' => 'John Doe',
	 *      'email' => 'johndoe@example.com',
	 *      'phone' => '123456789',
	 *      'referenceId' => 'ABC1234', // optional
	 *      'weight' => '1', // optional, COD only
	 *      'dimension' => '1:1:1', // optional, COD only
	 *      'pickupArea' => '55555', // nullable, COD only
	 *      'pickupAddress' => 'Jakarta', // nullable, COD only
	 *   ];
	 *
	 *   $response = $gateway->purchase($params)->send();
	 *
	 *   if ($response->isSuccess()) {
	 *   	// success
	 *      $data = $response->getData(); 
	 *   } else { 
	 *		// error
	 *      var_dump($response->getData());
	 *      var_dump($response->getMessage());
	 *      var_dump($response->getCode());
	 *   }
	 * 
	 * @see https://documenter.getpostman.com/view/7508947/SWLfanD1?version=latest#79e948f6-66b0-4d45-be63-6320f020c834
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
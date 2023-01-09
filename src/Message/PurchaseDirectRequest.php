<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\iPaymu\Message\AbstractIPaymuRequest;

	class PurchaseDirectRequest extends AbstractIPaymuRequest
	{
		/**
	     * Get the raw data array for this message. The format of this varies from gateway to
	     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	     *
	     * @return mixed
	     */
	    public function getData()
	    {
	    	$this->validate(
	    		'name', 
	    		'phone', 
	    		'email', 
	    		'price', 
	    		'qty', 
	    		'product', 
	    		'description', 
	    		'notifyUrl', 
	    		'paymentMethod', 
	    		'paymentChannel'
	    	);

	    	if ($this->isCOD())
	        {
	        	$this->validate('weight', 'dimension', 'pickupArea', 'pickupAddress');
	        }

	        $data = array();

	        $data['price'] = array($this->getPrice());
	        $data['qty'] = array($this->getQty());
	        $data['amount'] = $this->getPrice() * $this->getQty();

	        $data['product']     = array($this->getProduct());
	        $data['description'] = array($this->getDescription());
	        // $data['returnUrl'] = $this->getReturnUrl();
	        // $data['cancelUrl'] = $this->getCancelUrl();
	        $data['notifyUrl'] = $this->getNotifyUrl();

	        if ($this->getName()) 
	        {
	            $data['name'] = $this->getName();
	        }

	        if ($this->getEmail()) 
	        {
	            $data['email'] = $this->getEmail();
	        }

	        if ($this->getPhone()) 
	        {
	            $data['phone'] = $this->getPhone();
	        }

	        if ($this->getReferenceId()) 
	        {
	            $data['referenceId'] = $this->getReferenceId();
	        }

	        if ($this->getPaymentMethod()) 
	        {
	            $data['paymentMethod'] = $this->getPaymentMethod();
	        }

	        if ($this->getPaymentChannel()) 
	        {
	            $data['paymentChannel'] = $this->getPaymentChannel();
	        }

	        // for COD
	        if ($this->isCOD())
	        {
	        	if ($this->getWeight()) 
		        {
		            $data['weight'] = array($this->getWeight());
		        }

		        if ($this->getDimension()) 
		        {
		            $data['dimension'] = array($this->getDimension());
		        }

		        if ($this->getPickupArea()) 
		        {
		            $data['pickupArea'] = $this->getPickupArea();
		        }

		        if ($this->getPickupAddress()) 
		        {
		            $data['pickupAddress'] = $this->getPickupAddress();
		        }
	        }

	        return $data;
	    }
	    
	    /**
	     * Send the request with specified data
	     *
	     * @param  mixed $data The data to send
	     * @return ResponseInterface
	     */
	    public function sendData($data)
	    {
	    	$httpResponse = $this->sendRequest('POST', '/payment/direct', $data);

	    	// var_dump($httpResponse->json());
	    	// exit;

        	return $this->response = new PurchaseDirectResponse($this, $httpResponse->json());
	    }
	}
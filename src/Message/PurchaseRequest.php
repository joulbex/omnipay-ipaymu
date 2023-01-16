<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\iPaymu\Message\AbstractIPaymuRequest;

	class PurchaseRequest extends AbstractIPaymuRequest
	{
		/**
	     * Get the raw data array for this message. The format of this varies from gateway to
	     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	     *
	     * @return mixed
	     */
	    public function getData()
	    {
	    	$this->validate('price', 'qty', 'product', 'description', 'returnUrl', 'cancelUrl', 'notifyUrl');

	    	if ($this->isCOD())
	        {
	        	$this->validate('weight', 'dimension', 'pickupArea', 'pickupAddress');
	        }

	        $data = array();

	        $data['price'] = array($this->getPrice());
	        $data['qty'] = array($this->getQty());

	        $data['product'] = array($this->getProduct());
	        $data['description'] = array($this->getDescription());
	        $data['returnUrl'] = $this->getReturnUrl();
	        $data['cancelUrl'] = $this->getCancelUrl();
	        $data['notifyUrl'] = $this->getNotifyUrl();

	        if ($this->getBuyerName()) 
	        {
	            $data['buyerName'] = $this->getBuyerName();
	        }

	        if ($this->getBuyerEmail()) 
	        {
	            $data['buyerEmail'] = $this->getBuyerEmail();
	        }

	        if ($this->getBuyerPhone()) 
	        {
	            $data['buyerPhone'] = $this->getBuyerPhone();
	        }

	        if ($this->getTransactionId()) 
	        {
	            $data['referenceId'] = $this->getTransactionId();
	        }

	        if ($this->getPaymentMethod()) 
	        {
	            $data['paymentMethod'] = $this->getPaymentMethod();
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
	    	$httpResponse = $this->sendRequest('POST', '/payment', $data);

        	return $this->response = new PurchaseResponse($this, $httpResponse->json());
	    }
	}
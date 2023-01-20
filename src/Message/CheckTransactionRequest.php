<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\iPaymu\Message\AbstractIPaymuRequest;

	class CheckTransactionRequest extends AbstractIPaymuRequest
	{
		/**
	     * Get the raw data array for this message. The format of this varies from gateway to
	     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	     *
	     * @return mixed
	     */
	    public function getData()
	    {
	    	return [
	    		'transactionId' => $this->getTransactionReference()
	    	];
	    }
	    
	    /**
	     * Send the request with specified data
	     *
	     * @param  mixed $data The data to send
	     * @return ResponseInterface
	     */
	    public function sendData($data)
	    {
	    	$httpResponse = $this->sendRequest('POST', '/transaction', $data);

        	return $this->response = new IPaymuResponse($this, $httpResponse);
	    }
	}
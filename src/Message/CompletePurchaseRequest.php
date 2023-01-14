<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\iPaymu\Message\AbstractIPaymuRequest;

	class CompletePurchaseRequest extends AbstractIPaymuRequest
	{
		/**
	     * Get the raw data array for this message. The format of this varies from gateway to
	     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
	     *
	     * @return mixed
	     */
	    public function getData()
	    {
	        return $this->httpRequest->request->all();
	    }
	    
	    /**
	     * Send the request with specified data
	     *
	     * @param  mixed $data The data to send
	     * @return ResponseInterface
	     */
	    public function sendData($data)
	    {
        	return $this->response = new CompletePurchaseResponse($this, $data);
	    }
	}
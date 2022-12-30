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

	        $data                = array();
	        // $data['amount']      = $this->getAmount();
	        $data['account']      = $this->getAccountId();
	        $data['price']      = [$this->getPrice()];
	        $data['qty']      = [$this->getQty()];

	        $data['product']     = [$this->getProduct()];
	        $data['description'] = [$this->getDescription()];
	        $data['returnUrl'] = $this->getReturnUrl();
	        $data['cancelUrl'] = $this->getCancelUrl();
	        $data['notifyUrl'] = $this->getNotifyUrl();
	        // $data['method']      = $this->getPaymentMethod(); // ?
	        // $data['metadata']    = $this->getMetadata();
	        // if ($this->getTransactionId()) {
	        //     $data['metadata']['transactionId'] = $this->getTransactionId();
	        // }
	        // $issuer = $this->getIssuer();
	        // if ($issuer) {
	        //     $data['issuer'] = $issuer;
	        // }

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
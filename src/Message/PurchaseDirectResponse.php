<?php

	namespace Omnipay\iPaymu\Message;

	class PurchaseDirectResponse extends IPaymuResponse
	{
	    public function isSuccessful()
	    {
	        return isset($this->data['Status']) && $this->data['Status'] == 200;
	    }

	    /**
	     * Only for QRIS payment method. Returns url for QR code generated by iPaymu API.
	     * Only image, without additional elements.
	     * 
	     * @return mixed
	     */
	    public function getQRCodeUrl()
	    {
	    	if (isset($this->data['Data']['QrImage']))
	    	{
	    		return $this->data['Data']['QrImage'];
	    	}

	    	return null;
	    }

	    /**
	     * Only for QRIS payment method. Returns url for QR code template generated by iPaymu API.
	     * Contains QR code with some additional markup.
	     * 
	     * @return mixed
	     */
	    public function getQRTemplateUrl()
	    {
	    	if (isset($this->data['Data']['QrTemplate']))
	    	{
	    		return $this->data['Data']['QrTemplate'];
	    	}

	    	return null;
	    }

	    /**
	     * Returns expiration date for payment request generated via iPaymu API.
	     * 
	     * @return mixed
	     */
	    public function getExpiryDate()
	    {
	    	if (isset($this->data['Data']['Expired']))
	    	{
	    		return $this->data['Data']['Expired'];
	    	}

	    	return null;
	    }

	    /**
	     * Returns payment code generated by iPaymu.
	     * 
	     * @return mixed
	     */
	    public function getPaymentCode()
	    {
	    	if (isset($this->data['Data']['PaymentNo']))
	    	{
	    		return $this->data['Data']['PaymentNo'];
	    	}

	    	return null;
	    }

	    /**
	     * Returns payment name generated by iPaymu.
	     * Cstore only.
	     * 
	     * @return mixed
	     */
	    public function getCStorePaymentName()
	    {
	    	if (isset($this->data['Data']['PaymentName']))
	    	{
	    		return $this->data['Data']['PaymentName'];
	    	}

	    	return null;
	    }

	    /**
	     * Returns payment note generated by iPaymu.
	     * Cstore only.
	     * 
	     * @return mixed
	     */
	    public function getCStorePaymentNote()
	    {
	    	if (isset($this->data['Data']['Note']))
	    	{
	    		return $this->data['Data']['Note'];
	    	}

	    	return null;
	    }
	}
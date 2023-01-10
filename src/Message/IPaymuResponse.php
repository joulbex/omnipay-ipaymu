<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\AbstractResponse;

	class IPaymuResponse extends AbstractResponse
	{
		/**
	     *
	     * {@inheritdoc}
	     */
	    public function isSuccessful()
	    {
	        return isset($this->data['Status']) && $this->data['Status'] == 200;
	    }

	    /**
	     * Response Message
	     *
	     * @return null|string A response message from the payment gateway
	     */
	    public function getMessage()
	    {
	    	if (isset($this->data['Message']))
	    	{
	    		return $this->data['Message'];
	    	}
	        
	        return null;
	    }

	    /**
	     * Response code
	     *
	     * @return null|string A response code from the payment gateway
	     */
	    public function getCode()
	    {
	        if (isset($this->data['Status']))
	    	{
	    		return $this->data['Status'];
	    	}
	        
	        return null;
	    }
	}
<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\RedirectResponseInterface;

	class PurchaseResponse extends IPaymuResponse implements RedirectResponseInterface
	{
	    public function isSuccessful()
	    {
	        return isset($this->data['Status']) && $this->data['Status'] == 200;
	    }

	    public function isRedirect()
	    {
	        return isset($this->data['Data']['Url']);
	    }

	    /**
	     * Gets the redirect target url.
	     *
	     * @return string
	     */
	    public function getRedirectUrl()
	    {
	    	if ($this->isRedirect()) {
	            return $this->data['Data']['Url'];
	        }
	    }

	    /**
	     * Get the required redirect method (either GET or POST).
	     *
	     * @return string
	     */
	    public function getRedirectMethod()
	    {
	    	return 'GET';
	    }

	    /**
	     * Gets the redirect form data array, if the redirect method is POST.
	     *
	     * @return array
	     */
	    public function getRedirectData()
	    {
	    	return [];
	    }
	}
<?php

	namespace Omnipay\iPaymu\Message;

	use Omnipay\Common\Message\AbstractResponse;
	use Omnipay\Common\Message\RedirectResponseInterface;

	class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
	{
		/**
	     * When you do a `purchase` the request is never successful because
	     * you need to redirect off-site to complete the purchase.
	     * TODO: Is this correct?
	     *
	     * {@inheritdoc}
	     */
	    public function isSuccessful()
	    {
	        return false;
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